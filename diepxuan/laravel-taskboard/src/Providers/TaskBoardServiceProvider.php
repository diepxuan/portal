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

namespace Diepxuan\TaskBoard\Providers;

use Diepxuan\TaskBoard\Services\TaskRepository;
use Illuminate\Support\ServiceProvider;

class TaskBoardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/taskboard.php', 'taskboard');

        $this->publishes([
            __DIR__ . '/../../config/taskboard.php' => config_path('taskboard.php'),
        ], 'taskboard-config');
    }

    public function register(): void
    {
        $this->app->singleton(TaskRepository::class, static fn ($app) => new TaskRepository(
            base_path((string) config('taskboard.tasks_path', 'docs/tasks'))
        ));
    }
}
