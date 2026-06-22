<?php

declare(strict_types=1);

/*
 * Audit behavior trong `diepxuan/laravel-catalog/src/Models`.
 *
 * Mục tiêu: phân loại method theo vai trò lớp 3 (Catalog):
 * - concern_business: thuộc concern nghiệp vụ (HasArDmKhCategories, HasInDmKhoInventoryOperations,
 *                     HasPoCt1PurchaseMetrics, HasSoCt1SalesMetrics, HasSysCompanyLocalizedResx).
 * - inline_business : business method inline trong Model (không qua concern).
 * - catalog_utility : relation Portal/Catalog, scope nghiệp vụ, accessor nghiệp vụ, custom cast.
 * - passthrough     : Model rỗng/chỉ kế thừa, không có behavior (OK).
 *
 * Cách dùng:
 *   php scripts/audit-catalog-model-layer.php            # in bảng ra STDOUT
 *   php scripts/audit-catalog-model-layer.php --json     # in JSON
 *   php scripts/audit-catalog-model-layer.php --filter=Ar
 *
 * Không phụ thuộc composer autoload; chỉ parse file.
 */

$root      = dirname(__DIR__);
$modelDir  = $root . '/diepxuan/laravel-catalog/src/Models';
$asJson    = in_array('--json', $argv, true);
$filter    = null;
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--filter=')) {
        $filter = substr($arg, 9);
    }
}

$RELATION_METHODS = ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany', 'morphOne', 'morphMany', 'morphTo', 'morphedByMany', 'hasOneThrough', 'hasManyThrough'];

$CONCERN_TRAITS = [
    'HasArDmKhCategories',
    'HasInDmKhoInventoryOperations',
    'HasPoCt1PurchaseMetrics',
    'HasSoCt1SalesMetrics',
    'HasSysCompanyLocalizedResx',
];

$BUSINESS_METHOD_KEYWORDS = '(getInventory|getReceiptRate|getTotal|getPORpt|getSORpt|getINRpt|getInventoryByProduct|getInventoryList|getInventoryValue|getTotalRevenue|getTotalQuantity|getTotalPurchase|resxByLanguage)';

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

    $usedTraits = [];
    if (preg_match_all('/use\s+([A-Z][A-Za-z0-9_\\\\]+);/', $src, $m)) {
        foreach ($m[1] as $t) {
            $short = substr($t, (int) strrpos('\\' . $t, '\\'));
            if (in_array($short, $CONCERN_TRAITS, true)) {
                $usedTraits[] = $short;
            }
        }
    }

    $scopes    = array_values(array_unique(preg_match_all('/public function scope([A-Za-z0-9_]+)/', $src, $m) ? $m[1] : []));
    $accessors = array_values(array_unique(preg_match_all('/public function get([A-Za-z0-9_]+)Attribute/', $src, $m) ? $m[1] : []));
    $mutators  = array_values(array_unique(preg_match_all('/public function set([A-Za-z0-9_]+)Attribute/', $src, $m) ? $m[1] : []));
    $boot      = (bool) preg_match('/protected static function boot\(/', $src);
    $booted    = (bool) preg_match('/protected static function booted\(/', $src);

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
        if (str_ends_with($fn, 'Attribute')) continue;
        if (in_array($fn, $relationNames, true)) continue;
        $nonRelationMethods[] = $fn;
    }

    $dbMetadata = [
        'table'        => (bool) preg_match('/protected\s+\$table\s*=/', $src),
        'primaryKey'   => (bool) preg_match('/protected\s+\$primaryKey\s*=/', $src),
        'connection'   => (bool) preg_match('/protected\s+\$connection\s*=/', $src),
        'fillable'     => (bool) preg_match('/protected\s+\$fillable\s*=/', $src),
        'guarded'      => (bool) preg_match('/protected\s+\$guarded\s*=/', $src),
        'casts'        => (bool) preg_match('/protected\s+\$casts\s*=/', $src),
        'incrementing' => (bool) preg_match('/public\s+\$incrementing\s*=/', $src),
        'timestamps'   => (bool) preg_match('/public\s+\$timestamps\s*=/', $src),
    ];

    $parentClass = null;
    if (preg_match('/class\s+\w+\s+extends\s+([A-Z][A-Za-z0-9_\\\\]+)/', $src, $m)) {
        $parentClass = $m[1];
    }

    $rows[] = [
        'file'                => $name,
        'parent'              => $parentClass,
        'concern_traits'      => $usedTraits,
        'scopes_count'        => count($scopes),
        'relations_count'     => count($relations),
        'accessors_count'     => count($accessors),
        'mutators_count'      => count($mutators),
        'methods_count'       => count($nonRelationMethods),
        'has_boot'            => $boot,
        'has_booted'          => $booted,
        'db_metadata'         => $dbMetadata,
        'scopes'              => $scopes,
        'relations'           => $relations,
        'accessors'           => $accessors,
        'mutators'            => $mutators,
        'methods'             => $nonRelationMethods,
        'classification'      => classify($usedTraits, $scopes, $relations, $accessors, $mutators, $nonRelationMethods, $dbMetadata, $parentClass, $BUSINESS_METHOD_KEYWORDS),
    ];
}

usort($rows, fn ($a, $b) => strcmp($a['file'], $b['file']));

if ($asJson) {
    echo json_encode([
        'generated_at'    => date('c'),
        'model_dir'       => 'diepxuan/laravel-catalog/src/Models',
        'total'           => count($rows),
        'with_behavior'   => count(array_filter($rows, fn ($r) => $r['scopes_count'] + $r['relations_count'] + $r['accessors_count'] + $r['mutators_count'] + $r['methods_count'] + ($r['has_boot'] ? 1 : 0) + ($r['has_booted'] ? 1 : 0) > 0)),
        'rows'            => $rows,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
    exit(0);
}

$withBehavior = count(array_filter($rows, fn ($r) => $r['scopes_count'] + $r['relations_count'] + $r['accessors_count'] + $r['mutators_count'] + $r['methods_count'] + ($r['has_boot'] ? 1 : 0) + ($r['has_booted'] ? 1 : 0) > 0));
printf("Audit behavior in laravel-catalog Models (%d file, %d có behavior)\n\n", count($rows), $withBehavior);
printf("%-32s %-40s %5s %5s %5s %5s %5s %6s %6s  %-24s\n", 'file', 'parent', 'scop', 'rel', 'acc', 'mut', 'meth', 'boot', 'booted', 'classification');
echo str_repeat('-', 145) . "\n";
foreach ($rows as $r) {
    $behavior = $r['scopes_count'] + $r['relations_count'] + $r['accessors_count'] + $r['mutators_count'] + $r['methods_count'] + ($r['has_boot'] ? 1 : 0) + ($r['has_booted'] ? 1 : 0);
    if ($behavior === 0 && !$r['concern_traits']) continue;
    printf("%-32s %-40s %5d %5d %5d %5d %5d %6s %6s  %-24s\n",
        $r['file'],
        $r['parent'] ?? '-',
        $r['scopes_count'],
        $r['relations_count'],
        $r['accessors_count'],
        $r['mutators_count'],
        $r['methods_count'],
        $r['has_boot'] ? 'Y' : '-',
        $r['has_booted'] ? 'Y' : '-',
        $r['classification']
    );
}

exit(0);

function classify(array $usedTraits, array $scopes, array $relations, array $accessors, array $mutators, array $methods, array $dbMetadata, ?string $parentClass, string $businessKeywords): string
{
    if (!empty($usedTraits)) {
        return 'concern_business';
    }

    $hasBehavior = count($scopes) + count($relations) + count($accessors) + count($mutators) + count($methods) > 0;
    if (!$hasBehavior) {
        return 'passthrough';
    }

    foreach ($methods as $fn) {
        if (preg_match('/' . $businessKeywords . '/i', $fn)) {
            return 'inline_business';
        }
    }

    foreach ($accessors as $fn) {
        if (preg_match('/(KhachHang|NhaCungCap|NhanVien)/i', $fn)) {
            return 'inline_business';
        }
    }

    return 'catalog_utility';
}
