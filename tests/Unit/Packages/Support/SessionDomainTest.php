<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Support;

use Diepxuan\Support\Http\Middleware\SessionDomain;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Cookie;
use Tests\TestCase;

final class SessionDomainTest extends TestCase
{
    #[DataProvider('hostProvider')]
    public function testDomainForHostMapsZoneSuffix(string $host, ?string $expected): void
    {
        self::assertSame($expected, (new SessionDomain())->domainForHost($host));
    }

    /**
     * @return iterable<string, array{string, string|null}>
     */
    public static function hostProvider(): iterable
    {
        yield 'dev corp' => ['portal.diepxuan.corp', '.diepxuan.corp'];
        yield 'test io.vn' => ['portaldev.diepxuan.io.vn', '.diepxuan.io.vn'];
        yield 'public io.vn' => ['portal.diepxuan.io.vn', '.diepxuan.io.vn'];
        yield 'subdomain io.vn' => ['mcc.diepxuan.io.vn', '.diepxuan.io.vn'];
        yield 'uppercase host' => ['PORTAL.DIEPXUAN.CORP', '.diepxuan.corp'];
        yield 'localhost' => ['localhost', null];
        yield 'ip' => ['10.0.0.122', null];
        yield 'external domain' => ['example.com', null];
    }

    public function testSessionCookieUsesCorpDomainOnDevHost(): void
    {
        $response = $this->get('http://portal.diepxuan.corp/login');

        $response->assertOk();
        self::assertSame('.diepxuan.corp', $this->cookieDomain($response->headers->getCookies(), 'portal_session'));
        self::assertSame('.diepxuan.corp', $this->cookieDomain($response->headers->getCookies(), 'XSRF-TOKEN'));
    }

    public function testSessionCookieUsesIoVnDomainOnTestHost(): void
    {
        $response = $this->get('http://portaldev.diepxuan.io.vn/login');

        $response->assertOk();
        self::assertSame('.diepxuan.io.vn', $this->cookieDomain($response->headers->getCookies(), 'portal_session'));
        self::assertSame('.diepxuan.io.vn', $this->cookieDomain($response->headers->getCookies(), 'XSRF-TOKEN'));
    }

    public function testSessionCookieUsesIoVnDomainOnPublicHost(): void
    {
        $response = $this->get('https://portal.diepxuan.io.vn/login');

        $response->assertOk();
        self::assertSame('.diepxuan.io.vn', $this->cookieDomain($response->headers->getCookies(), 'portal_session'));
    }

    /**
     * @param list<Cookie> $cookies
     */
    private function cookieDomain(array $cookies, string $name): ?string
    {
        foreach ($cookies as $cookie) {
            if ($cookie->getName() === $name) {
                return $cookie->getDomain();
            }
        }

        self::fail("Cookie {$name} khong ton tai trong response.");
    }
}
