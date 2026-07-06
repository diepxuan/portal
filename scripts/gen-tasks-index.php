<?php

declare(strict_types=1);

/*
 * Generate task index files từ docs/tasks/.
 *
 * Tạo 2 file:
 *   docs/tasks/_index.md         — tổng index các task ở root + sub-folder
 *   docs/tasks/phase 1/_index.md — index riêng cho phase 1 (nếu có)
 *
 * Parse metadata từ mỗi file:
 *   - ID: từ "# Task {ID}:" ở dòng đầu
 *   - DLL: từ "**DLL:**" trong section "## Chi tiet"
 *   - Module: từ "## Nhom:" → prefix (AR/AP/CA/CO/SO/PO/SI/IN/FA/GL)
 *   - Status: từ "**Kết quả:**", "**Status:**", hoặc "**Trạng thái:**"
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
 * @return array<int, array{id:string, file:string, dll:string, module:string, status:string, title:string}>
 */
function parseTaskFiles(string $dir): array
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
        if (preg_match('/^#\s+Task\s+(\d+):\s*(.+)$/m', $content, $m)) {
            $id    = $m[1];
            $title = trim($m[2]);
        } else {
            // Fallback: lấy ID từ tên file (vd: 008-ar-...)
            if (preg_match('/^(\d+)-/', $entry, $m)) {
                $id = $m[1];
            }
            $title = pathinfo($entry, PATHINFO_FILENAME);
        }
        $dll = '';
        if (preg_match('/\*\*DLL:\*\*\s*(.+)$/m', $content, $m)) {
            $dll = trim($m[1]);
        }
        $module = '';
        if (preg_match('/^##\s+Nhom:\s+(\w+)/miu', $content, $m)) {
            $module = strtoupper($m[1]);
            if ($module === 'SYSTEM') {
                $module = 'SYS';
            }
        } else {
            // Heuristic từ prefix file (AR-, AP-, ...) - check cả vi tri sau số
            $upper = strtoupper($entry);
            // Bỏ phần số ID đầu (vd "021-ca-..." → "CA-...")
            $stripped = preg_replace('/^\d+-/', '', $upper);
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
        $status = 'PENDING';
        if (preg_match('/\*\*Kết quả:\*\*\s*([A-Z_]+)/u', $content, $m)) {
            $status = strtoupper($m[1]);
        } elseif (preg_match('/\*\*Ket qua:\*\*\s*([A-Z_]+)/u', $content, $m)) {
            $status = strtoupper($m[1]);
        } elseif (preg_match('/\*\*Status:\*\*\s*([A-Z_]+)/u', $content, $m)) {
            $status = strtoupper($m[1]);
        } elseif (preg_match('/\*\*Trạng thái:\*\*\s*([A-Z_]+)/u', $content, $m)) {
            $status = strtoupper($m[1]);
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
    usort($tasks, fn ($a, $b) => str_pad((string) $a['id'], 10, '0', STR_PAD_LEFT) <=> str_pad((string) $b['id'], 10, '0', STR_PAD_LEFT));
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

$rootTasks = parseTaskFiles($tasksDir);
$phase1Tasks = is_dir($phase1Dir) ? parseTaskFiles($phase1Dir) : [];

$rootNote = '';
if (count($phase1Tasks) > 0) {
    $rootNote = '**Lưu ý:** Task phase 1 (đã hoàn thành triển khai giai đoạn đầu) được tách riêng trong `phase 1/` — xem [`phase 1/_index.md`](phase%201/_index.md).';
}
$rootMd = renderIndex('Tasks Index', $rootTasks, $rootNote);
$phaseMd = $phase1Tasks
    ? renderIndex('Phase 1 Tasks', $phase1Tasks, 'Các task đã hoàn thành phase 1 và được tách riêng để dễ theo dõi.')
    : '';

if ($dryRun) {
    echo "=== docs/tasks/_index.md ===\n";
    echo $rootMd;
    if ($phaseMd !== '') {
        echo "\n=== docs/tasks/phase 1/_index.md ===\n";
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