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

namespace Diepxuan\Support\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CorpAutoLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldAutoLogin($request)) {
            $user = User::query()
                ->where('email', $this->email())
                ->first();

            if ($user !== null) {
                Auth::login($user);

                Log::info('Corp auto-login authenticated request.', [
                    'user_id'     => $user->getKey(),
                    'email'       => $user->email,
                    'host'        => $request->getHost(),
                    'server_addr' => $request->server('SERVER_ADDR'),
                    'path'        => $request->path(),
                ]);
            }
        }

        return $next($request);
    }

    private function shouldAutoLogin(Request $request): bool
    {
        return $this->isLocalEnvironment()
            && $this->enabled()
            && Auth::guest()
            && $this->email() !== ''
            && $this->isAllowedHost($request)
            && $this->isAllowedServerAddress($request);
    }

    private function isLocalEnvironment(): bool
    {
        return app()->environment('local');
    }

    private function enabled(): bool
    {
        return filter_var(env('DX_CORP_AUTO_LOGIN_ENABLED', false), FILTER_VALIDATE_BOOL);
    }

    private function email(): string
    {
        return trim((string) env('DX_CORP_AUTO_LOGIN_EMAIL', ''));
    }

    private function isAllowedHost(Request $request): bool
    {
        $suffix = strtolower(trim((string) env('DX_CORP_AUTO_LOGIN_HOST_SUFFIX', '.diepxuan.corp')));
        $host   = strtolower($request->getHost());

        return $suffix !== '' && str_ends_with($host, $suffix);
    }

    private function isAllowedServerAddress(Request $request): bool
    {
        $expectedAddress = trim((string) env('DX_CORP_AUTO_LOGIN_SERVER_ADDR', '10.0.0.122'));
        $serverAddress   = (string) $request->server('SERVER_ADDR', '');

        return $expectedAddress !== '' && $serverAddress === $expectedAddress;
    }
}
