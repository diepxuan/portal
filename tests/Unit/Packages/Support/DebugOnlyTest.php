<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Support;

use Diepxuan\Support\Http\Middleware\DebugOnly;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

/**
 * Unit test cho middleware DebugOnly.
 *
 * Middleware này bảo vệ các route chẩn đoán (`/check-proxy`, `test/*`) khỏi
 * bị truy cập trên production. Kiểm tra từng nhánh của `accessChecks()`:
 * bất kỳ điều kiện nào false thì route phải coi như không tồn tại (404).
 *
 * Không chạm DB.
 */
final class DebugOnlyTest extends TestCase
{
    private function middleware(): DebugOnly
    {
        return new DebugOnly();
    }

    private function request(string $path = 'check-proxy'): Request
    {
        return Request::create('https://portal.diepxuan.io.vn/'.$path, 'GET');
    }

    /** Bật APP_DEBUG và đặt môi trường cho trước. */
    private function configure(bool $debug, string $env): void
    {
        config(['app.debug' => $debug]);
        app()->detectEnvironment(static fn (): string => $env);
    }

    public function testAccessChecksReturnsBothKeys(): void
    {
        $checks = $this->middleware()->accessChecks($this->request());

        foreach (['debug_enabled', 'not_production_env'] as $key) {
            self::assertArrayHasKey($key, $checks, "Thiếu key {$key} trong accessChecks().");
            self::assertIsBool($checks[$key], "Key {$key} phải là bool.");
        }
    }

    public function testAllowedInLocalWhenDebugEnabled(): void
    {
        $this->configure(true, 'local');

        self::assertTrue(
            $this->middleware()->allowed($this->request()),
            'Local + APP_DEBUG=true phải cho phép route debug.'
        );
    }

    public function testDeniedWhenDebugDisabled(): void
    {
        $this->configure(false, 'local');

        self::assertFalse(
            $this->middleware()->allowed($this->request()),
            'APP_DEBUG=false phải chặn route debug kể cả ở local.'
        );
    }

    public function testDeniedInProductionEvenWhenDebugEnabled(): void
    {
        $this->configure(true, 'production');

        self::assertFalse(
            $this->middleware()->allowed($this->request()),
            'Production phải chặn route debug DÙ APP_DEBUG=true — tránh lộ hạ tầng.'
        );
    }

    public function testDeniedInProductionWhenDebugDisabled(): void
    {
        $this->configure(false, 'production');

        self::assertFalse($this->middleware()->allowed($this->request()));
    }

    public function testDebugEnabledReadsConfigNotEnv(): void
    {
        config(['app.debug' => true]);
        self::assertTrue($this->middleware()->debugEnabled());

        config(['app.debug' => false]);
        self::assertFalse($this->middleware()->debugEnabled());
    }

    public function testIsProductionEnvironmentDetection(): void
    {
        app()->detectEnvironment(static fn (): string => 'production');
        self::assertTrue($this->middleware()->isProductionEnvironment());

        app()->detectEnvironment(static fn (): string => 'local');
        self::assertFalse($this->middleware()->isProductionEnvironment());
    }

    public function testHandlePassesThroughWhenAllowed(): void
    {
        $this->configure(true, 'local');

        $expected = new Response('reached-controller');

        $response = $this->middleware()->handle(
            $this->request(),
            static fn (): Response => $expected
        );

        self::assertSame($expected, $response);
        self::assertSame('reached-controller', $response->getContent());
    }

    public function testHandleAbortsWith404WhenDenied(): void
    {
        $this->configure(false, 'production');

        $this->expectException(NotFoundHttpException::class);

        $this->middleware()->handle(
            $this->request(),
            static fn (): string => 'must-not-reach'
        );
    }

    public function testDeniedRouteReturns404NotForbidden(): void
    {
        // 404 chứ không phải 403: không tiết lộ sự tồn tại của endpoint chẩn đoán.
        $this->configure(true, 'production');

        try {
            $this->middleware()->handle($this->request(), static fn (): string => 'x');
            self::fail('Phải ném NotFoundHttpException.');
        } catch (NotFoundHttpException $exception) {
            self::assertSame(404, $exception->getStatusCode());
        }
    }
}
