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

use Diepxuan\Catalog\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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

        if (Auth::guest()) {
            return Redirect::guest(route('login'));
        }

        return $next($request);
    }

    private function shouldAutoLogin(Request $request): bool
    {
        $checks = [
            'local_environment' => $this->isLocalEnvironment(),
            'enabled'           => $this->enabled(),
            'guest'             => Auth::guest(),
            'email_configured'  => $this->email() !== '',
            'allowed_host'      => $this->isAllowedHost($request),
            'allowed_server'    => $this->isAllowedServerAddress($request),
        ];

        $shouldAutoLogin = !\in_array(false, $checks, true);

        if (!$shouldAutoLogin && $this->isLocalEnvironment() && $this->enabled()) {
            Log::debug('Corp auto-login skipped request.', [
                'checks'               => $checks,
                'email'                => $this->email(),
                'host'                 => $request->getHost(),
                'host_suffix'          => $this->hostSuffix(),
                'server_addr'          => $request->server('SERVER_ADDR'),
                'detected_addrs'       => $this->detectedServerAddresses($request),
                'allowed_server_addrs' => $this->allowedServerAddresses(),
                'path'                 => $request->path(),
                'url'                  => $request->fullUrl(),
            ]);
        }

        return $shouldAutoLogin;
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
        $suffix = $this->hostSuffix();
        $host   = strtolower($request->getHost());

        return $suffix !== '' && str_ends_with($host, $suffix);
    }

    private function hostSuffix(): string
    {
        return strtolower(trim((string) env('DX_CORP_AUTO_LOGIN_HOST_SUFFIX', '.diepxuan.corp')));
    }

    private function isAllowedServerAddress(Request $request): bool
    {
        $detectedAddresses = $this->detectedServerAddresses($request);

        return array_intersect($detectedAddresses, $this->allowedServerAddresses()) !== [];
    }

    /**
     * @return array<int, string>
     */
    private function detectedServerAddresses(Request $request): array
    {
        $addresses = array_filter([
            (string) $request->server('SERVER_ADDR', ''),
            (string) $request->server('LOCAL_ADDR', ''),
            gethostbyname($request->getHost()),
        ], static fn (string $address) => $address !== '');

        return array_values(array_unique($addresses));
    }

    /**
     * @return array<int, string>
     */
    private function allowedServerAddresses(): array
    {
        $addresses = (string) env('DX_CORP_AUTO_LOGIN_SERVER_ADDR', '10.0.0.122');

        return array_values(array_filter(array_map(
            static fn (string $address) => trim($address),
            explode(',', $addresses)
        ), static fn (string $address) => $address !== ''));
    }
}
