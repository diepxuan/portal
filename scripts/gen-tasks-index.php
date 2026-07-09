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
        $tasks[] = [
            'id'     => $id,
            'file'   => $entry,
            'dll'    => $dll,
            'module' => $module ?: 'SYS',
            'status' => $status,
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
    $out .= "## Tổng quan\n\n";
    $out .= '| Module | Files | DONE | PENDING | Khác |' . "\n";
    $out .= '|---|---:|---:|---:|---:|' . "\n";
    foreach ($byModule as $mod => $items) {
        $done    = 0;
        $pending = 0;
        $other   = 0;
        foreach ($items as $t) {
            $s = $t['status'];
            if ($s === 'DONE' || $s === 'IMPLEMENTED' || $s === 'FIXED' || $s === 'MERGED') {
                $done++;
            } elseif ($s === 'PENDING') {
                $pending++;
            } else {
                $other++;
            }
        }
        $name     = $moduleNames[$mod] ?? $mod;
        $out .= "| {$name} | " . count($items) . " | {$done} | {$pending} | {$other} |\n";
    }
    $total = count($tasks);
    $out .= "| **Tổng** | **{$total}** | | | |\n\n";

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
    $rootNote = '**Lưu ý:** Task đã xong phase hiện tại được tách riêng trong `phase 1/` — xem [`phase 1/_index.md`](phase%201/_index.md). Phase 1 sẽ tiếp tục hoàn thiện chức năng và UI theo task cụ thể.';
}
$rootMd = renderIndex('Tasks Index', $rootTasks, $rootNote);
$phaseMd = $phase1Tasks
    ? renderIndex('Phase 1 Tasks', $phase1Tasks, 'Các task đã xong phase hiện tại và được chuyển sang phase 1 để tiếp tục hoàn thiện chức năng nghiệp vụ và UI.')
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
