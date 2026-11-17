<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Support;

use Diepxuan\Support\Http\Middleware\CorpAutoLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * Unit test cho middleware CorpAutoLogin.
 *
 * Kiểm tra từng điều kiện trong `loginChecks()` độc lập: bất kỳ điều kiện nào
 * false thì `shouldAutoLogin()` phải trả false (fail-safe). Không chạm DB.
 */
final class CorpAutoLoginTest extends TestCase
{
    private function middleware(): CorpAutoLogin
    {
        return new CorpAutoLogin();
    }

    private function request(string $host = 'portal.diepxuan.corp', string $serverAddr = '10.0.0.122'): Request
    {
        return Request::create('http://'.$host.'/simba', 'GET', server: [
            'SERVER_ADDR' => $serverAddr,
            'LOCAL_ADDR'  => $serverAddr,
        ]);
    }

    /** Set toàn bộ env để "tất cả điều kiện đều true". */
    private function configureHappyPath(): void
    {
        app()->detectEnvironment(static fn (): string => 'local');

        putenv('DX_CORP_AUTO_LOGIN_ENABLED=true');
        $_ENV['DX_CORP_AUTO_LOGIN_ENABLED'] = 'true';
        $_SERVER['DX_CORP_AUTO_LOGIN_ENABLED'] = 'true';

        putenv('DX_CORP_AUTO_LOGIN_EMAIL=dev@diepxuan.corp');
        $_ENV['DX_CORP_AUTO_LOGIN_EMAIL'] = 'dev@diepxuan.corp';
        $_SERVER['DX_CORP_AUTO_LOGIN_EMAIL'] = 'dev@diepxuan.corp';

        putenv('DX_CORP_AUTO_LOGIN_HOST_SUFFIX=.diepxuan.corp');
        $_ENV['DX_CORP_AUTO_LOGIN_HOST_SUFFIX'] = '.diepxuan.corp';
        $_SERVER['DX_CORP_AUTO_LOGIN_HOST_SUFFIX'] = '.diepxuan.corp';

        putenv('DX_CORP_AUTO_LOGIN_SERVER_ADDR=10.0.0.122');
        $_ENV['DX_CORP_AUTO_LOGIN_SERVER_ADDR'] = '10.0.0.122';
        $_SERVER['DX_CORP_AUTO_LOGIN_SERVER_ADDR'] = '10.0.0.122';
    }

    private function setEnv(string $key, string $value): void
    {
        putenv("{$key}={$value}");
        $_ENV[$key]    = $value;
        $_SERVER[$key] = $value;
    }

    protected function tearDown(): void
    {
        foreach ([
            'DX_CORP_AUTO_LOGIN_ENABLED',
            'DX_CORP_AUTO_LOGIN_EMAIL',
            'DX_CORP_AUTO_LOGIN_HOST_SUFFIX',
            'DX_CORP_AUTO_LOGIN_SERVER_ADDR',
        ] as $key) {
            putenv($key);
            unset($_ENV[$key], $_SERVER[$key]);
        }

        parent::tearDown();
    }

    public function testLoginChecksReturnsAllSixKeys(): void
    {
        $checks = $this->middleware()->loginChecks($this->request());

        foreach ([
            'local_environment',
            'enabled',
            'guest',
            'email_configured',
            'allowed_host',
            'allowed_server',
        ] as $key) {
            self::assertArrayHasKey($key, $checks, "Thiếu key {$key} trong loginChecks().");
            self::assertIsBool($checks[$key], "Key {$key} phải là bool.");
        }
    }

    public function testShouldAutoLoginIsFalseWhenDisabled(): void
    {
        $this->configureHappyPath();
        $this->setEnv('DX_CORP_AUTO_LOGIN_ENABLED', 'false');

        Auth::shouldReceive('guest')->andReturn(true);

        self::assertFalse($this->middleware()->shouldAutoLogin($this->request()));
    }

    public function testShouldAutoLoginIsFalseWhenEmailMissing(): void
    {
        $this->configureHappyPath();
        $this->setEnv('DX_CORP_AUTO_LOGIN_EMAIL', '');

        Auth::shouldReceive('guest')->andReturn(true);

        self::assertFalse($this->middleware()->shouldAutoLogin($this->request()));
    }

    public function testShouldAutoLoginIsFalseWhenHostNotAllowed(): void
    {
        $this->configureHappyPath();

        Auth::shouldReceive('guest')->andReturn(true);

        // Host ngoài zone .diepxuan.corp
        self::assertFalse($this->middleware()->shouldAutoLogin(
            $this->request('evil.example.com', '10.0.0.122')
        ));
    }

    public function testShouldAutoLoginIsFalseWhenServerAddressNotAllowed(): void
    {
        $this->configureHappyPath();

        // Dùng host KHÔNG resolve được DNS để cô lập điều kiện allowed_server.
        // (Với host resolve được, gethostbyname() fallback sẽ pass — xem test
        // testAllowedServerAddressDnsFallbackCanPassEvenWhenServerAddrDiffers.)
        Auth::shouldReceive('guest')->andReturn(true);

        self::assertFalse($this->middleware()->shouldAutoLogin(
            $this->request('khong-ton-tai.diepxuan.corp', '192.168.99.99')
        ));
    }

    public function testShouldAutoLoginIsFalseWhenAlreadyAuthenticated(): void
    {
        $this->configureHappyPath();

        Auth::shouldReceive('guest')->andReturn(false);

        self::assertFalse($this->middleware()->shouldAutoLogin($this->request()));
    }

    public function testShouldAutoLoginIsFalseOutsideLocalEnvironment(): void
    {
        $this->configureHappyPath();
        app()->detectEnvironment(static fn (): string => 'production');

        Auth::shouldReceive('guest')->andReturn(true);

        self::assertFalse(
            $this->middleware()->shouldAutoLogin($this->request()),
            'Auto-login không được bật ngoài môi trường local.'
        );
    }

    public function testShouldAutoLoginIsTrueWhenAllChecksPass(): void
    {
        $this->configureHappyPath();

        Auth::shouldReceive('guest')->andReturn(true);

        self::assertTrue(
            $this->middleware()->shouldAutoLogin($this->request()),
            'Khi cả 6 điều kiện đều đúng, auto-login phải bật.'
        );
    }

    public function testAllowedHostAcceptsSubdomainOfConfiguredSuffix(): void
    {
        $this->configureHappyPath();
        $middleware = $this->middleware();

        self::assertTrue($middleware->isAllowedHost($this->request('portal.diepxuan.corp')));
        self::assertTrue($middleware->isAllowedHost($this->request('dev.portal.diepxuan.corp')));
        self::assertFalse($middleware->isAllowedHost($this->request('portal.diepxuan.com')));
    }

    public function testAllowedServerAddressAcceptsCommaSeparatedList(): void
    {
        $this->configureHappyPath();
        $this->setEnv('DX_CORP_AUTO_LOGIN_SERVER_ADDR', '10.0.0.1, 10.0.0.122');

        $middleware = $this->middleware();

        self::assertTrue($middleware->isAllowedServerAddress($this->request('portal.diepxuan.corp', '10.0.0.122')));
        self::assertTrue($middleware->isAllowedServerAddress($this->request('portal.diepxuan.corp', '10.0.0.1')));
    }

    /**
     * GIỚI HẠN ĐÃ BIẾT của thiết kế hiện tại: khi host resolve được DNS nội bộ,
     * `gethostbyname()` trả về IP thật của máy chủ và điều kiện `allowed_server`
     * có thể pass dù SERVER_ADDR truyền vào không nằm trong danh sách cho phép.
     *
     * Đây là lý do điều kiện này chỉ là lớp phụ; lớp bảo vệ chính là
     * `APP_ENV=local` + `enabled` + `allowed_host`. Nếu cần siết chặt, phải bỏ
     * fallback DNS và cấu hình proxy truyền đúng SERVER_ADDR.
     */
    public function testAllowedServerAddressDnsFallbackCanPassEvenWhenServerAddrDiffers(): void
    {
        $this->configureHappyPath();
        $this->setEnv('DX_CORP_AUTO_LOGIN_SERVER_ADDR', '10.0.0.122');

        $resolved = gethostbyname('portal.diepxuan.corp');
        if ($resolved === 'portal.diepxuan.corp') {
            self::markTestSkipped('Host không resolve được DNS trong môi trường này.');
        }

        // Ghi nhận hành vi thật: DNS fallback làm điều kiện pass.
        self::assertTrue(
            $this->middleware()->isAllowedServerAddress($this->request('portal.diepxuan.corp', '192.168.99.99')),
            'DNS fallback khiến allowed_server pass dù SERVER_ADDR khác — giới hạn đã biết.'
        );
    }

    /**
     * Regression: khi request đi qua proxy, SERVER_ADDR/LOCAL_ADDR có thể null.
     * Middleware vẫn phải nhận diện được server qua fallback resolve hostname,
     * nếu không auto-login sẽ chết trên môi trường web server thật.
     */
    public function testDetectedServerAddressesFallsBackToHostResolutionWhenServerAddrMissing(): void
    {
        $this->configureHappyPath();

        $request = Request::create('http://portal.diepxuan.corp/simba', 'GET');

        self::assertSame('', (string) $request->server('SERVER_ADDR', ''));
        self::assertSame('', (string) $request->server('LOCAL_ADDR', ''));

        $detected = $this->middleware()->detectedServerAddresses($request);

        self::assertNotEmpty(
            $detected,
            'Phải fallback resolve hostname khi SERVER_ADDR/LOCAL_ADDR rỗng, nếu không auto-login chết qua proxy.'
        );
    }

    public function testFindUserByEmailReturnsNullForEmptyEmail(): void
    {
        self::assertNull(
            $this->middleware()->findUserByEmail(''),
            'Email rỗng phải trả null, không gọi auth provider.'
        );
    }
}
