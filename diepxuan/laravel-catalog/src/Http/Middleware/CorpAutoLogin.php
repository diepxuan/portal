<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-06-09 00:00:00
 */

namespace Diepxuan\Catalog\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CorpAutoLogin
{
    private const CORP_HOST_SUFFIX = '.diepxuan.corp';

    private const CORP_TARGET_IP = '10.0.0.122';

    private const CORP_AUTO_LOGIN_EMAIL = 'ductn@diepxuan.com';

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAllowedCorpTarget($request) && Auth::guest()) {
            $user = User::query()
                ->where('email', self::CORP_AUTO_LOGIN_EMAIL)
                ->first();

            if ($user !== null) {
                Auth::login($user);
            }
        }

        return $next($request);
    }

    private function isAllowedCorpTarget(Request $request): bool
    {
        $host = strtolower($request->getHost());
        $serverAddress = (string) $request->server('SERVER_ADDR', '');

        return str_ends_with($host, self::CORP_HOST_SUFFIX)
            && $serverAddress === self::CORP_TARGET_IP;
    }
}
