<?php

declare(strict_types=1);

/*
 * Audit behavior trong `diepxuan/laravel-simba/src/Models`.
 *
 * Mục tiêu: phân loại method hiện có theo trách nhiệm 3 lớp:
 * - keep_simba : scope/relation/accessor sát bảng Simba, dùng field thuần Simba
 * - move_catalog: business logic, tính toán, UI helper, use-case
 * - review     : mơ hồ, cần đọc caller mới chốt được
 *
 * Cách dùng:
 *   php scripts/audit-model-layer-responsibility.php            # in bảng ra STDOUT
 *   php scripts/audit-model-layer-responsibility.php --json     # in JSON
 *   php scripts/audit-model-layer-responsibility.php --filter=ApCt1
 *
 * Xem bảng baseline (28 file) và policy 3 lớp tại:
 *   docs/project/simba-model-layer-refactor-plan.md
 *
 * Không phụ thuộc composer autoload; chỉ parse file.
 */

$root      = dirname(__DIR__);
$modelDir  = $root . '/diepxuan/laravel-simba/src/Models';
$asJson    = in_array('--json', $argv, true);
$filter    = null;
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--filter=')) {
        $filter = substr($arg, 9);
    }
}

$RELATION_METHODS = ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany', 'morphOne', 'morphMany', 'morphTo', 'morphedByMany', 'hasOneThrough', 'hasManyThrough'];

$rows = [];
foreach (scandir($modelDir) as $name) {
    if (!str_ends_with($name, '.php')) continue;
    if ($name === 'for.php') continue;
    if ($filter && stripos($name, $filter) === false) continue;
    $path = $modelDir . '/' . $name;
    $src  = (string) file_get_contents($path);
    if (!preg_match('/\bclass\s+\w+\s+extends\b/', $src)) {
        continue;
    }
    $scopes    = array_values(array_unique(preg_match_all('/public function scope([A-Za-z0-9_]+)/', $src, $m) ? $m[1] : []));
    $accessors = array_values(array_unique(preg_match_all('/public function get([A-Za-z0-9_]+)Attribute/', $src, $m) ? $m[1] : []));
    $mutators  = array_values(array_unique(preg_match_all('/public function set([A-Za-z0-9_]+)Attribute/', $src, $m) ? $m[1] : []));
    $boot      = (bool) preg_match('/protected static function boot\(/', $src);

    $relations = [];
    if (preg_match_all('/public function ([a-z][A-Za-z0-9_]*)\s*\(\s*\)[^{]*?{\s*return\s+\$this->(' . implode('|', $RELATION_METHODS) . ')\s*\(/', $src, $m, PREG_SET_ORDER)) {
        foreach ($m as $row) {
            $relations[] = ['name' => $row[1], 'type' => $row[2]];
        }
    }

    $publicMethods = [];
    if (preg_match_all('/public function ([A-Za-z0-9_]+)\s*\(/', $src, $m)) {
        foreach ($m[1] as $fn) {
            if (in_array($fn, ['__construct', 'scope', 'boot', 'booted'], true)) continue;
            $publicMethods[] = $fn;
        }
    }
    $publicMethods = array_values(array_unique($publicMethods));

    $nonRelationMethods = [];
    $relationNames = array_column($relations, 'name');
    foreach ($publicMethods as $fn) {
        if (str_starts_with($fn, 'scope')) continue;
        if (str_starts_with($fn, 'get') && str_ends_with($fn, 'Attribute')) continue;
        if (str_starts_with($fn, 'set') && str_ends_with($fn, 'Attribute')) continue;
        if (in_array($fn, $relationNames, true)) continue;
        $nonRelationMethods[] = $fn;
    }

    $rows[] = [
        'file'             => $name,
        'scopes_count'     => count($scopes),
        'relations_count'  => count($relations),
        'accessors_count'  => count($accessors),
        'mutators_count'   => count($mutators),
        'methods_count'    => count($nonRelationMethods),
        'has_boot'         => $boot,
        'scopes'           => $scopes,
        'relations'        => $relations,
        'accessors'        => $accessors,
        'mutators'         => $mutators,
        'methods'          => $nonRelationMethods,
        'classification'   => classify($scopes, $relations, $accessors, $mutators, $nonRelationMethods),
    ];
}

usort($rows, fn ($a, $b) => strcmp($a['file'], $b['file']));

if ($asJson) {
    echo json_encode([
        'generated_at' => date('c'),
        'model_dir'    => 'diepxuan/laravel-simba/src/Models',
        'total'        => count($rows),
        'with_behavior'=> count(array_filter($rows, fn ($r) => $r['scopes_count'] + $r['relations_count'] + $r['accessors_count'] + $r['mutators_count'] + $r['methods_count'] + ($r['has_boot'] ? 1 : 0) > 0)),
        'rows'         => $rows,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
    exit(0);
}

printf("Audit behavior in laravel-simba Models (%d file, %d có behavior)\n\n",
    count($rows),
    count(array_filter($rows, fn ($r) => $r['scopes_count'] + $r['relations_count'] + $r['accessors_count'] + $r['mutators_count'] + $r['methods_count'] + ($r['has_boot'] ? 1 : 0) > 0))
);
printf("%-32s %5s %5s %5s %5s %5s %5s  %-40s\n", 'file', 'scop', 'rel', 'acc', 'mut', 'meth', 'boot', 'classification');
echo str_repeat('-', 110) . "\n";
foreach ($rows as $r) {
    $behavior = $r['scopes_count'] + $r['relations_count'] + $r['accessors_count'] + $r['mutators_count'] + $r['methods_count'] + ($r['has_boot'] ? 1 : 0);
    if ($behavior === 0) continue;
    printf("%-32s %5d %5d %5d %5d %5d %5s  %-40s\n",
        $r['file'],
        $r['scopes_count'],
        $r['relations_count'],
        $r['accessors_count'],
        $r['mutators_count'],
        $r['methods_count'],
        $r['has_boot'] ? 'Y' : '-',
        $r['classification']
    );
}

exit(0);

function classify(array $scopes, array $relations, array $accessors, array $mutators, array $methods): string
{
    // Business/UI helpers: tính toán, quyết định nghiệp vụ, mở service
    $businessMethodKeywords = '(InventoryByProduct|InventoryValue|InventoryList|ReceiptRate|resxByLanguage)';

    if ($methods) {
        foreach ($methods as $fn) {
            if (preg_match('/' . $businessMethodKeywords . '/i', $fn)) {
                return 'move_catalog';
            }
        }
    }

    // Accessor kèm ngữ nghĩa nghiệp vụ: khách hàng / NCC / nhân viên
    if ($accessors) {
        foreach ($accessors as $fn) {
            if (preg_match('/(KhachHang|NhaCungCap|NhanVien)/i', $fn)) {
                return 'move_catalog';
            }
        }
    }

    // Chỉ có scope + relation Simba-Simba + field-parser Simba → giữ Simba
    return 'keep_simba';
}