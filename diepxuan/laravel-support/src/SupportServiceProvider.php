<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-22 16:12:32
 */

namespace Diepxuan\Support;

use Diepxuan\Support\Commands\GenerateDockerfileSqlsrvCommand;
use Diepxuan\Support\Utils\DockerfileGenerator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DockerfileGenerator::class, static fn ($app) => new DockerfileGenerator());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole() && $this->shouldForceHttps()) {
            URL::forceScheme('https');
        }

        $this->commands([
            GenerateDockerfileSqlsrvCommand::class,
        ]);
    }

    /**
     * Có ép scheme https cho URL generate không.
     *
     * Ngoài môi trường local luôn ép https. Trong local, đọc `DX_FORCE_HTTPS`
     * (mặc định true). Biến cũ `DX_CORP_AUTO_LOGIN_HTTPS` vẫn được đọc để
     * không phá cấu hình hiện có, nhưng tên đó gây nhầm với CorpAutoLogin nên
     * đã được đổi tên.
     */
    private function shouldForceHttps(): bool
    {
        if (!app()->environment('local')) {
            return true;
        }

        $default = env('DX_CORP_AUTO_LOGIN_HTTPS'); // legacy fallback

        return filter_var(env('DX_FORCE_HTTPS', $default ?? true), FILTER_VALIDATE_BOOL);
    }
}
