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

return [
    'name'      => 'diepxuan/laravel-taskboard',
    'namespace' => 'Diepxuan\\TaskBoard',

    /*
     * Đường dẫn thư mục chứa task docs, tính từ base_path().
     * Task board đọc trực tiếp file markdown — không dùng database.
     */
    'tasks_path' => env('TASKBOARD_TASKS_PATH', 'docs/tasks'),

    /*
     * Bật/tắt khả năng ghi (cập nhật status vào file .md).
     * Mặc định tắt: chỉ đọc. Bật khi Sếp muốn thao tác trực tiếp trên UI.
     */
    'writable' => (bool) env('TASKBOARD_WRITABLE', false),
];
