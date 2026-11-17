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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chỉ cho phép truy cập route debug khi môi trường bật debug.
 *
 * Dùng cho các route chẩn đoán nội bộ (`/check-proxy`, `test/*`...) vốn
 * KHÔNG dành cho người dùng cuối: nếu để public trên production, chúng
 * làm lộ thông tin hạ tầng (APP_URL, scheme, header proxy, cấu hình...).
 *
 * Thiết kế nhiều lớp điều kiện, giống `CorpAutoLogin`:
 *   1. APP_DEBUG = true  (config `app.debug`, nguồn sự thật của Laravel)
 *   2. APP_ENV không phải `production`  (chặn cả trường hợp ai đó bật
 *      APP_DEBUG=true nhầm trên production)
 *
 * Bất kỳ điều kiện nào false → 404 (không phải 403): route coi như KHÔNG
 * TỒN TẠI, để không tiết lộ sự hiện diện của endpoint chẩn đoán.
 *
 * Biến môi trường liên quan: `APP_DEBUG`, `APP_ENV`.
 */
class DebugOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->allowed($request)) {
            return $this->deny($request);
        }

        return $next($request);
    }

    /**
     * Tập điều kiện quyết định route debug có được truy cập hay không.
     *
     * Public để unit test kiểm tra từng nhánh mà không cần HTTP request thật.
     *
     * @return array<string, bool>
     */
    public function accessChecks(?Request $request = null): array
    {
        return [
            'debug_enabled'      => $this->debugEnabled(),
            'not_production_env' => !$this->isProductionEnvironment(),
        ];
    }

    public function allowed(?Request $request = null): bool
    {
        $checks = $this->accessChecks($request);

        $allowed = !\in_array(false, $checks, true);

        if (!$allowed && $this->debugEnabled()) {
            // Debug bật nhưng vẫn chặn (thường do APP_ENV=production):
            // ghi warning để biết cấu hình đang mâu thuẫn.
            Log::warning('Debug-only route bị chặn vì môi trường production.', [
                'checks' => $checks,
                'host'   => $request?->getHost(),
                'path'   => $request?->path(),
            ]);
        }

        return $allowed;
    }

    /**
     * APP_DEBUG có bật không.
     *
     * Đọc `config('app.debug')` (nguồn sự thật của Laravel) thay vì `env()`
     * trực tiếp, để tôn trọng config cache khi deploy.
     */
    public function debugEnabled(): bool
    {
        return (bool) config('app.debug', false);
    }

    public function isProductionEnvironment(): bool
    {
        return app()->environment('production');
    }

    /**
     * Từ chối truy cập: trả 404 để ẩn sự tồn tại của route debug.
     */
    protected function deny(Request $request): Response
    {
        abort(404);
    }
}
