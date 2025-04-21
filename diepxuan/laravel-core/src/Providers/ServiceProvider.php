<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2025-04-21 10:18:41
 */

namespace Diepxuan\Core\Providers;

use Diepxuan\Core\Models\Package;
use Illuminate\Console\Scheduling\Schedule;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // @todo
        // dd(Diepxuan::test());
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->singleton(Package::class, static fn () => new Package());
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(RegisterServiceProvider::class);

        $this->registerCommands()
            ->registerCommandSchedules()
        ;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * Register Commands.
     */
    protected function registerCommands()
    {
        if (!$this->app->runningInConsole()) {
            return $this;
        }

        $this->commands(
            $this->packages()
                ->map(static function (string $package, string $code) {
                    // @todo: check if package has command
                    return Package::getCommands($code);
                })
                ->flatten()
                ->filter()
                ->toArray() // @todo: filter out empty commands
        );

        return $this;
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules()
    {
        $this->app->booted(function (): void {
            $schedule = $this->app->make(Schedule::class);

            $this->packages()
                ->map(static function (string $package, string $code) {
                    // @todo: check if package has command
                    return Package::getCommands($code);
                })
                ->flatten()
                ->filter()
                ->each(static function (string $command) use ($schedule): void {
                    if (method_exists($command, 'schedule') && \is_callable([$command, 'schedule'])) {
                        $command::schedule($schedule);
                    }
                })
            ;

            // schedule
            // $schedule->command('inspire')->hourly();
        });

        return $this;
    }
}
