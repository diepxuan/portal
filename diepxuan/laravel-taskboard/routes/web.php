<?php

declare(strict_types=1);

use Diepxuan\Support\Http\Middleware\CorpAutoLogin;
use Diepxuan\TaskBoard\Http\Livewire\TaskBoard;
use Illuminate\Support\Facades\Route;

/*
| Route tự động được load bởi Diepxuan\Core\Providers\RouteServiceProvider
| (glob diepxuan slash routes slash php), không cần đăng ký trong routes/web.php.
|
| Prefix `hethong` + name `system.` để khớp nhóm "Hệ thống" có sẵn trong menu
| (xem diepxuan/laravel-catalog/routes/web.php mục Route::prefix('hethong')).
*/
Route::middleware([CorpAutoLogin::class])->group(static function (): void {
    Route::prefix('hethong')->name('system.')->group(static function (): void {
        Route::get('tasks', TaskBoard::class)->name('tasks.index');
    });
});
