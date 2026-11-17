<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-11-17
 */

namespace Diepxuan\Support\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tự động đăng nhập trên môi trường dev nội bộ (.diepxuan.corp).
 *
 * Thiết kế nhiều lớp điều kiện để KHÔNG BAO GIỜ kích hoạt ngoài môi trường dev:
 *   1. APP_ENV phải là `local`
 *   2. DX_CORP_AUTO_LOGIN_ENABLED = true
 *   3. Request hiện tại là guest (chưa đăng nhập)
 *   4. DX_CORP_AUTO_LOGIN_EMAIL có giá trị
 *   5. Host khớp DX_CORP_AUTO_LOGIN_HOST_SUFFIX
 *   6. Địa chỉ server khớp DX_CORP_AUTO_LOGIN_SERVER_ADDR
 *
 * Bất kỳ điều kiện nào false → bỏ qua auto-login (fail-safe), chuyển về trang login.
 *
 * Biến môi trường: xem `diepxuan/laravel-support/README.md` §Auto-login.
 */
class CorpAutoLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldAutoLogin($request)) {
            $email = $this->email();
            $user  = $this->findUserByEmail($email);

            if ($user !== null) {
                // remember = true: giữ session qua nhiều request, tránh phải
                // auto-login lại mỗi lần session hết hạn.
                Auth::login($user, true);

                Log::info('Corp auto-login authenticated request.', [
                    'user_id'     => $user->getAuthIdentifier(),
                    'email'       => $email,
                    'host'        => $request->getHost(),
                    'server_addr' => $request->server('SERVER_ADDR'),
                    'path'        => $request->path(),
                ]);
            } else {
                // Không tìm thấy user theo email cấu hình — log warning thay vì
                // thất bại âm thầm, để biết cấu hình sai/chưa đồng bộ DB.
                Log::warning('Corp auto-login cannot find user by configured email.', [
                    'email'       => $email,
                    'host'        => $request->getHost(),
                    'path'        => $request->path(),
                    'hint'        => 'Kiểm tra DX_CORP_AUTO_LOGIN_EMAIL có trùng email user trong DB không.',
                ]);
            }
        }

        if (Auth::guest()) {
            return Redirect::guest(route('login'));
        }

        return $next($request);
    }

    /**
     * Tập điều kiện quyết định có auto-login hay không.
     *
     * Public để unit test kiểm tra từng nhánh mà không cần HTTP request thật.
     *
     * @return array<string, bool>
     */
    public function loginChecks(Request $request): array
    {
        return [
            'local_environment' => $this->isLocalEnvironment(),
            'enabled'           => $this->enabled(),
            'guest'             => Auth::guest(),
            'email_configured'  => $this->email() !== '',
            'allowed_host'      => $this->isAllowedHost($request),
            'allowed_server'    => $this->isAllowedServerAddress($request),
        ];
    }

    public function shouldAutoLogin(Request $request): bool
    {
        $checks = $this->loginChecks($request);

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

    public function isLocalEnvironment(): bool
    {
        return app()->environment('local');
    }

    public function enabled(): bool
    {
        return filter_var(env('DX_CORP_AUTO_LOGIN_ENABLED', false), FILTER_VALIDATE_BOOL);
    }

    public function email(): string
    {
        return trim((string) env('DX_CORP_AUTO_LOGIN_EMAIL', ''));
    }

    public function findUserByEmail(?string $email = null): ?Authenticatable
    {
        $email = $email ?? $this->email();

        if ($email === '') {
            return null;
        }

        return Auth::getProvider()->retrieveByCredentials([
            'email' => $email,
        ]);
    }

    public function isAllowedHost(Request $request): bool
    {
        $suffix = $this->hostSuffix();
        $host   = strtolower($request->getHost());

        return $suffix !== '' && str_ends_with($host, $suffix);
    }

    public function hostSuffix(): string
    {
        return strtolower(trim((string) env('DX_CORP_AUTO_LOGIN_HOST_SUFFIX', '.diepxuan.corp')));
    }

    public function isAllowedServerAddress(Request $request): bool
    {
        $detectedAddresses = $this->detectedServerAddresses($request);

        return array_intersect($detectedAddresses, $this->allowedServerAddresses()) !== [];
    }

    /**
     * Địa chỉ IP của máy chủ đang phục vụ request.
     *
     * `SERVER_ADDR`/`LOCAL_ADDR` thường null khi request đi qua proxy (PHP-FPM
     * không thấy socket server), nên fallback resolve hostname của chính
     * request — giữ lại hành vi cũ để auto-login vẫn hoạt động qua web server.
     *
     * @return array<int, string>
     */
    public function detectedServerAddresses(Request $request): array
    {
        $addresses = array_filter([
            (string) $request->server('SERVER_ADDR', ''),
            (string) $request->server('LOCAL_ADDR', ''),
            (string) gethostbyname($request->getHost()),
        ], static fn (string $address) => $address !== '');

        return array_values(array_unique($addresses));
    }

    /**
     * @return array<int, string>
     */
    public function allowedServerAddresses(): array
    {
        $addresses = (string) env('DX_CORP_AUTO_LOGIN_SERVER_ADDR', '10.0.0.122');

        return array_values(array_filter(array_map(
            static fn (string $address) => trim($address),
            explode(',', $addresses)
        ), static fn (string $address) => $address !== ''));
    }
}
