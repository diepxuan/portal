<?php

declare(strict_types=1);

/*
 * Generate task index files từ docs/tasks/.
 *
 * Tạo 2 file:
 *   docs/tasks/_index.md         — index phase hiện tại ở root docs/tasks/
 *   docs/tasks/phase 1/_index.md — index riêng cho phase 1 (nếu có)
 *
 * Parse metadata từ mỗi file:
 *   - ID: từ "# Task {ID}:" ở dòng đầu, giữ nguyên range dạng 032-038
 *   - DLL: từ bảng thông tin, "**DLL:**", "**Nhom DLL:**" hoặc "**DLL chinh:**"
 *   - Module: từ "## Nhom:", bảng "**Module**" hoặc prefix filename
 *   - Status: mặc định từ phase hiện tại; root luôn PENDING, phase 1 luôn DONE
 *
 * Cách dùng:
 *   php scripts/gen-tasks-index.php            # generate cả 2 index
 *   php scripts/gen-tasks-index.php --dry-run  # chỉ in ra STDOUT
 *   php scripts/gen-tasks-index.php --root-only
 *   php scripts/gen-tasks-index.php --phase-only
 *
 * Không phụ thuộc composer autoload; chỉ parse file.
 */

$root         = dirname(__DIR__);
$tasksDir     = $root . '/docs/tasks';
$rootIndex    = $tasksDir . '/_index.md';
$phase1Dir    = $tasksDir . '/phase 1';
$phase1Index  = $phase1Dir . '/_index.md';
$dryRun       = in_array('--dry-run', $argv, true);
$rootOnly     = in_array('--root-only', $argv, true);
$phaseOnly    = in_array('--phase-only', $argv, true);

/**
 * @return array{0:int, 1:int, 2:string}
 */
function taskIdSortKey(string $id): array
{
    if (preg_match('/^(\d+)(?:-(\d+))?$/', $id, $m)) {
        $start = (int) $m[1];
        $end = isset($m[2]) ? (int) $m[2] : $start;

        return [$start, $end, $id];
    }

    return [0, 0, $id];
}

/**
 * @return array<int, array{id:string, file:string, dll:string, module:string, status:string, title:string}>
 */
function parseTaskFiles(string $dir, string $status): array
{
    $tasks = [];
    if (! is_dir($dir)) {
        return $tasks;
    }
    foreach (scandir($dir) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..' || $entry[0] === '.') {
            continue;
        }
        $path = $dir . '/' . $entry;
        if (! is_file($path) || ! str_ends_with($entry, '.md')) {
            continue;
        }
        if (basename($path) === 'README.md' || basename($path) === '_index.md') {
            continue;
        }
        $content = (string) file_get_contents($path);
        $id      = '';
        $title   = '';
        if (preg_match('/^#\s+Task\s+(\d+(?:-\d+)?):\s*(.+)$/m', $content, $m)) {
            $id    = $m[1];
            $title = trim($m[2]);
        } else {
            // Fallback: lấy ID từ tên file (vd: 008-ar-..., 032-038-ca-...)
            if (preg_match('/^(\d+(?:-\d+)?)-/', $entry, $m)) {
                $id = $m[1];
            }
            $title = pathinfo($entry, PATHINFO_FILENAME);
        }
        $dll = '';
        if (preg_match('/^\|\s*\*\*DLL\*\*\s*\|\s*([^|]+?)\s*\|/miu', $content, $m)) {
            $dll = trim($m[1]);
        } elseif (preg_match('/\*\*[^*\n]*DLL[^*\n]*:\*\*\s*(.+)$/miu', $content, $m)) {
            $dll = trim($m[1]);
        }
        $module = '';
        if (preg_match('/^##\s+Nhom:\s+(\w+)/miu', $content, $m)) {
            $module = strtoupper($m[1]);
            if ($module === 'SYSTEM') {
                $module = 'SYS';
            }
        } elseif (preg_match('/^\|\s*\*\*Module\*\*\s*\|\s*([A-Z]{2,6})\b/miu', $content, $m)) {
            $module = strtoupper($m[1]);
            if ($module === 'SYSTEM') {
                $module = 'SYS';
            }
        } else {
            // Heuristic từ prefix file (AR-, AP-, ...) - check cả vi tri sau số
            $upper = strtoupper($entry);
            // Bỏ phần số ID đầu (vd "021-ca-..." → "CA-...", "032-038-ca-..." → "CA-...")
            $stripped = preg_replace('/^\d+(?:-\d+)?-/', '', $upper);
            foreach (['AR', 'AP', 'CA', 'CO', 'SO', 'PO', 'SI', 'IN', 'FA', 'GL'] as $prefix) {
                if (str_starts_with($stripped, $prefix . '-') || str_starts_with($stripped, $prefix . '_')) {
                    $module = $prefix;
                    break;
                }
            }
            if ($module === '' && str_contains($stripped, 'BAN-HANG')) {
                $module = 'SO';
            }
            if ($module === '' && (str_contains($stripped, 'SIMBA-LOGIN') || str_contains($stripped, 'ADMIN-DASHBOARD') || str_contains($stripped, 'DEVELOPER-SUPPORT') || str_contains($stripped, 'TONG-HOP') || str_contains($stripped, 'HANG-TON-KHO'))) {
                $module = 'SYS';
            }
        }
        // Status thuc te lay tu field `**Status:**` trong task doc (nguon su that).
        // Chi fallback ve status theo phase khi task khong khai bao.
        $actualStatus = $status;
        if (preg_match('/^[-*]\s+\*\*Status:\*\*\s*([^\n]+)/m', $content, $sm)) {
            $line = trim($sm[1]);
            if (str_starts_with($line, 'SHELL_ONLY')) {
                $actualStatus = 'SHELL_ONLY';
            } elseif (str_contains($line, 'DONE')) {
                $actualStatus = 'DONE';
            } elseif (str_contains($line, 'PENDING') || str_contains($line, 'CẦN MAP')) {
                $actualStatus = 'PENDING';
            } elseif (str_contains($line, 'DOCUMENTATION')) {
                $actualStatus = 'DOC_ONLY';
            } else {
                $actualStatus = $line;
            }
        }

        $tasks[] = [
            'id'     => $id,
            'file'   => $entry,
            'dll'    => $dll,
            'module' => $module ?: 'SYS',
            'status' => $actualStatus,
            'title'  => $title,
        ];
    }
    usort($tasks, function ($a, $b): int {
        $byId = taskIdSortKey((string) $a['id']) <=> taskIdSortKey((string) $b['id']);

        return $byId !== 0 ? $byId : strcmp((string) $a['file'], (string) $b['file']);
    });
    return $tasks;
}

function renderIndex(string $title, array $tasks, string $note = ''): string
{
    $byModule = [];
    foreach ($tasks as $task) {
        $byModule[$task['module']][] = $task;
    }
    ksort($byModule);
    $moduleNames = [
        'AR'  => 'AR — Công nợ phải thu',
        'AP'  => 'AP — Công nợ phải trả',
        'CA'  => 'CA — Tiền mặt & Ngân hàng',
        'CO'  => 'CO — Sản xuất',
        'SO'  => 'SO — Đơn hàng bán',
        'PO'  => 'PO — Đơn hàng mua',
        'SI'  => 'SI — System Integration',
        'IN'  => 'IN — Tồn kho',
        'FA'  => 'FA — Tài sản cố định',
        'GL'  => 'GL — Sổ cái tổng hợp',
        'SYS' => 'System — Framework & cross-link',
    ];

    $out = "# {$title}\n\n";
    $out .= "> Tự động sinh bởi `scripts/gen-tasks-index.php`. **Không sửa tay** — sửa script rồi chạy lại.\n\n";
    if ($note !== '') {
        $out .= $note . "\n\n";
    }
    // Dem theo status thuc te. SHELL_ONLY = co route anchor/shell nhung CHUA co
    // man hinh CRUD -- khong duoc tinh la DONE (xem PROJECT_CONVENTIONS muc 2.4).
    $sum = ['total' => 0, 'done' => 0, 'shell' => 0, 'pending' => 0, 'other' => 0];
    $out .= "## Tổng quan\n\n";
    $out .= '| Module | Files | DONE | SHELL_ONLY | PENDING | Khác |' . "\n";
    $out .= '|---|---:|---:|---:|---:|---:|' . "\n";
    foreach ($byModule as $mod => $items) {
        $done    = 0;
        $shell   = 0;
        $pending = 0;
        $other   = 0;
        foreach ($items as $t) {
            $s = strtoupper(trim((string) $t['status']));
            if ($s === 'SHELL_ONLY' || str_starts_with($s, 'SHELL_ONLY')) {
                $shell++;
            } elseif ($s === 'DONE' || $s === 'IMPLEMENTED' || $s === 'FIXED' || $s === 'MERGED') {
                $done++;
            } elseif ($s === 'PENDING') {
                $pending++;
            } else {
                $other++;
            }
        }
        $sum['total'] += count($items);
        $sum['done'] += $done;
        $sum['shell'] += $shell;
        $sum['pending'] += $pending;
        $sum['other'] += $other;
        $name     = $moduleNames[$mod] ?? $mod;
        $out .= "| {$name} | " . count($items) . " | {$done} | {$shell} | {$pending} | {$other} |\n";
    }
    $out .= "| **Tổng** | **{$sum['total']}** | **{$sum['done']}** | **{$sum['shell']}** | **{$sum['pending']}** | **{$sum['other']}** |\n\n";
    $out .= "> **SHELL_ONLY** = có route anchor/metadata shell nhưng **chưa có màn hình CRUD**, không tính là DONE.\n\n";

    foreach ($byModule as $mod => $items) {
        $name     = $moduleNames[$mod] ?? $mod;
        $out .= "## {$name}\n\n";
        $out .= '| ID | File | DLL | Status |' . "\n";
        $out .= '|---|---|---|---|' . "\n";
        foreach ($items as $t) {
            $out .= "| {$t['id']} | `{$t['file']}` | {$t['dll']} | {$t['status']} |\n";
        }
        $out .= "\n";
    }
    return $out;
}

$rootTasks = parseTaskFiles($tasksDir, 'PENDING');
$phase1Tasks = is_dir($phase1Dir) ? parseTaskFiles($phase1Dir, 'DONE') : [];

$rootNote = '';
if (count($phase1Tasks) > 0) {
    $rootNote = implode("\n", [
        '**Lưu ý:** Task đã xong phase port được tách riêng trong `phase 1/` — xem [`phase 1/_index.md`](phase%201/_index.md)',
        '(giai đoạn phát triển thêm chức năng cho Portal).',
        '',
        'Task **hạ tầng/công cụ nội bộ Portal** (đăng nhập, dashboard, task board...) nằm riêng trong',
        '[`portaltask/_index.md`](portaltask/_index.md), không trộn với task port SimbaERP.',
    ]);
}
$rootMd = renderIndex('Tasks Index', $rootTasks, $rootNote);
$phase1Note = implode("\n", [
    '**Đây là phase 1** — giai đoạn phát triển thêm và hoàn thiện chức năng **cho Portal**',
    'sau khi đã port xong từ SimbaERP .NET.',
    '',
    '| Phase | Ý nghĩa | Thư mục |',
    '|---|---|---|',
    '| **Phase hiện tại (port)** | Chuyển đổi chức năng từ SimbaERP .NET sang PHP Laravel | `docs/tasks/*.md` |',
    '| **Phase 1 (mở rộng)** | Phát triển thêm chức năng, hoàn thiện UI/UX, tối ưu cho Portal | `docs/tasks/phase 1/*.md` |',
    '',
    'Task trong phase 1 xuất phát từ task đã xong ở phase port, sau đó tiếp tục được phát',
    'triển thêm: bổ sung tính năng, chuẩn hóa UI theo `docs/DESIGN.md`, tối ưu hiệu năng,',
    'sửa lỗi phát sinh trong quá trình vận hành Portal.',
    '',
    '**Quy ước:** ID giữ nguyên từ task gốc; mỗi task chỉ tồn tại **một bản** trong phase 1.',
]);
$phaseMd = $phase1Tasks
    ? renderIndex('Phase 1 — Phát triển thêm chức năng cho Portal', $phase1Tasks, $phase1Note)
    : '';

if ($dryRun) {
    $printedRoot = false;
    if (! $phaseOnly) {
        echo "=== docs/tasks/_index.md ===\n";
        echo $rootMd;
        $printedRoot = true;
    }
    if (! $rootOnly && $phaseMd !== '') {
        echo $printedRoot ? "\n" : '';
        echo "=== docs/tasks/phase 1/_index.md ===\n";
        echo $phaseMd;
    }
    return;
}

if (! $phaseOnly) {
    file_put_contents($rootIndex, $rootMd);
    echo "Wrote {$rootIndex} (" . count($rootTasks) . " tasks)\n";
}
if (! $rootOnly && $phaseMd !== '') {
    if (! is_dir($phase1Dir)) {
        mkdir($phase1Dir, 0755, true);
    }
    file_put_contents($phase1Index, $phaseMd);
    echo "Wrote {$phase1Index} (" . count($phase1Tasks) . " tasks)\n";
}
