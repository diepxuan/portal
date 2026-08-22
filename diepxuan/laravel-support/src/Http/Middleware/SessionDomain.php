<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-08-22 08:00:00
 */

namespace Diepxuan\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tinh domain cookie session theo host cua request.
 *
 * Portal chay dong thoi tren 3 host: test `portaldev.diepxuan.io.vn`,
 * dev `portal.diepxuan.corp` va public `portal.diepxuan.io.vn`. Mot gia tri
 * `SESSION_DOMAIN` co dinh (vd `.diepxuan.io.vn`) khien browser tu choi
 * cookie tren host khac zone (`portal.diepxuan.corp`): session khong duoc
 * giu, moi Livewire POST bi 419 CSRF.
 *
 * Middleware dat `session.domain` theo zone cua host TRUOC khi
 * StartSession / VerifyCsrfToken tao cookie (hai middleware nay doc
 * `config('session')` luc ghi response), nen cookie session va XSRF-TOKEN
 * luon co domain khop voi host dang phuc vu.
 */
class SessionDomain
{
    /**
     * Cookie domain theo zone — chia se session giua cac subdomain trong
     * cung zone (vd portaldev/portal/mcc cua diepxuan.io.vn).
     */
    private const ZONE_SUFFIXES = [
        '.diepxuan.io.vn',
        '.diepxuan.corp',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        config(['session.domain' => $this->domainForHost($request->getHost())]);

        return $next($request);
    }

    /**
     * Host thuoc zone nao tra ve cookie domain cua zone do; host khac
     * (localhost, IP, domain ngoai...) tra ve null de cookie chi ap dung
     * cho chinh host do (host-only cookie).
     */
    public function domainForHost(?string $host): ?string
    {
        $host = mb_strtolower(trim((string) $host));

        foreach (self::ZONE_SUFFIXES as $suffix) {
            if (str_ends_with($host, $suffix)) {
                return $suffix;
            }
        }

        return null;
    }
}
