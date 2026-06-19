<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$componentMap = [
    'gl.dict.gldmtk' => 'Diepxuan\\Catalog\\Http\\Livewire\\Gl\\Taikhoan',
    'so.dict.ardmkh' => 'Diepxuan\\Catalog\\Http\\Livewire\\Banhang\\Khachhang',
    'so.dict.ardmplkh' => 'Diepxuan\\Catalog\\Http\\Livewire\\AR\\Danhmuc\\Phanloaikhachhang',
    'so.dict.ardmnhkh' => 'Diepxuan\\Catalog\\Http\\Livewire\\AR\\Danhmuc\\Nhomkhachhang',
    'in.dict.indmvt' => 'Diepxuan\\Catalog\\Http\\Livewire\\In\\Dmvt',
    'in.dict.indmnhvt' => 'Diepxuan\\Catalog\\Http\\Livewire\\In\\Dmnhvt',
    'in.dict.indmkho' => 'Diepxuan\\Catalog\\Http\\Livewire\\In\\Dmkho',
    'ca.dict.ardmkh' => 'Diepxuan\\Catalog\\Http\\Livewire\\Cash\\Danhmuc\\Nhanvien',
    'ca.vch.cavchca1' => 'Diepxuan\\Catalog\\Http\\Livewire\\Cash\\Tienmat\\Phieuthu',
    'ca.vch.cavchca2' => 'Diepxuan\\Catalog\\Http\\Livewire\\Cash\\Tienmat\\Phieuchi',
    'ca.vch.cavchca4' => 'Diepxuan\\Catalog\\Http\\Livewire\\Cash\\Nganhang\\Baoco',
    'ca.vch.cavchca5' => 'Diepxuan\\Catalog\\Http\\Livewire\\Cash\\Nganhang\\Baono',
    'so.vch.sovchso1' => 'Diepxuan\\Catalog\\Http\\Livewire\\Banhang\\Hoadonbanhang',
    'po.dict.ardmkh' => 'Diepxuan\\Catalog\\Http\\Livewire\\Muahang\\Cungcap',
    'po.dict.podmcp' => 'Diepxuan\\Catalog\\Http\\Livewire\\Muahang\\PoDmCpIndex',
    'co.dict.bomdm' => 'Diepxuan\\Catalog\\Http\\Livewire\\Co\\Danhmuc\\Dmbom',
    'co.dict.bomdmct' => 'Diepxuan\\Catalog\\Http\\Livewire\\Co\\Danhmuc\\Dinhmucchitiet',
];

$modules = array_flip(['GL', 'CA', 'SO', 'AP', 'AR', 'FA', 'IN', 'PO', 'CO']);
$kindMap = ['1' => 'vch', '2' => 'dict', '4' => 'rpt', '6' => 'proc'];

$menus = [];
foreach (['sysMenu.md', 'zsysmenu.md'] as $file) {
    foreach (readMarkdownTable("{$root}/simba-docs/data/{$file}") as $row) {
        $menuid = trim($row['menuid'] ?? '');
        if ('' === $menuid) {
            continue;
        }

        // sysMenu is read first; zsysmenu should override/add metadata for same menuid.
        $menus[$menuid] = $row + ['source_file' => $file];
    }
}

$routes = [];
$conflicts = [];
foreach ($menus as $menuid => $row) {
    $active = trim((string) ($row['active'] ?? ''));
    $moduleid = strtoupper(trim((string) ($row['moduleid'] ?? '')));
    $type = trim((string) ($row['type'] ?? ''));
    $dllName = trim((string) ($row['dllName'] ?? ''));
    $codeName = trim((string) ($row['code_name'] ?? ''));

    if ('1' !== $active || !isset($modules[$moduleid]) || !isset($kindMap[$type])) {
        continue;
    }

    $slugBase = '' !== $dllName ? $dllName : $codeName;
    if ('' === trim($slugBase)) {
        continue;
    }

    $module = strtolower($moduleid);
    $kind = $kindMap[$type];
    $slug = slug($slugBase);
    $routeName = "{$module}.{$kind}.{$slug}";

    if (isset($routes[$routeName])) {
        $conflicts[$routeName][] = $menuid;
        $conflicts[$routeName][] = $routes[$routeName]['menuid'];
        continue;
    }

    $routes[$routeName] = [
        'moduleid' => $moduleid,
        'menuid' => $menuid,
        'type' => $type,
        'dllName' => $dllName,
        'code_name' => $codeName,
        'slug' => $slug,
        'kind' => $kind,
        'routeName' => $routeName,
        'url' => "/_simba-source/{$module}/{$kind}/{$slug}",
        'hasComponent' => isset($componentMap[$routeName]) ? 'yes' : 'no',
        'component' => $componentMap[$routeName] ?? 'SimbaPage shell',
        'source_file' => $row['source_file'] ?? '',
        'title' => trim(html_entity_decode((string) ($row['bar'] ?: $row['short_name'] ?: ''), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
    ];
}
ksort($routes);
ksort($conflicts);

$out = [];
$out[] = '# Simba Source Route Coverage';
$out[] = '';
$out[] = 'Ngày sinh: 2026-06-19';
$out[] = '';
$out[] = 'Nguồn: `simba-docs/data/sysMenu.md` + `simba-docs/data/zsysmenu.md`.';
$out[] = '';
$out[] = '- Filter: `active=1`, `moduleid in (GL, CA, SO, AP, AR, FA, IN, PO, CO)`, `type in (1,2,4,6)`, có `dllName` hoặc `code_name`.';
$out[] = '- Kind map: `1 -> vch`, `2 -> dict`, `4 -> rpt`, `6 -> proc`.';
$out[] = '- URL pattern: `/_simba-source/{module}/{kind}/{slug}`.';
$out[] = '- Route name pattern: `{module}.{kind}.{slug}`.';
$out[] = '';
$out[] = '## Summary';
$out[] = '';
$out[] = '- Total source routes: ' . count($routes);
$out[] = '- Routes with concrete Livewire component: ' . count(array_filter($routes, static fn (array $r): bool => 'yes' === $r['hasComponent']));
$out[] = '- Routes using `SimbaPage` shell: ' . count(array_filter($routes, static fn (array $r): bool => 'no' === $r['hasComponent']));
$out[] = '- Route name conflicts skipped: ' . count($conflicts);
$out[] = '';

if ([] !== $conflicts) {
    $out[] = '## Conflicts';
    $out[] = '';
    $out[] = '| routeName | menuids |';
    $out[] = '|---|---|';
    foreach ($conflicts as $routeName => $menuids) {
        $out[] = sprintf('| `%s` | `%s` |', $routeName, implode('`, `', array_values(array_unique($menuids))));
    }
    $out[] = '';
}

$out[] = '## Routes';
$out[] = '';
$out[] = '| moduleid | menuid | type | dllName | code_name | slug | kind | routeName | hasComponent | component |';
$out[] = '|---|---:|---:|---|---|---|---|---|---|---|';
foreach ($routes as $route) {
    $out[] = sprintf(
        '| %s | `%s` | `%s` | `%s` | `%s` | `%s` | `%s` | `%s` | %s | `%s` |',
        $route['moduleid'],
        $route['menuid'],
        $route['type'],
        escapeCell($route['dllName']),
        escapeCell($route['code_name']),
        $route['slug'],
        $route['kind'],
        $route['routeName'],
        $route['hasComponent'],
        $route['component']
    );
}

if (in_array('--json', $argv, true)) {
    echo json_encode(['routes' => array_values($routes), 'conflicts' => $conflicts], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), PHP_EOL;
    exit(0);
}

echo implode(PHP_EOL, $out), PHP_EOL;

function readMarkdownTable(string $path): array
{
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (false === $lines || count($lines) < 3) {
        return [];
    }

    $headers = parseMarkdownRow($lines[0]);
    $rows = [];
    foreach (array_slice($lines, 2) as $line) {
        if (!str_starts_with(trim($line), '|')) {
            continue;
        }
        $values = parseMarkdownRow($line);
        $values = array_pad($values, count($headers), '');
        $rows[] = array_combine($headers, array_slice($values, 0, count($headers)));
    }

    return $rows;
}

function parseMarkdownRow(string $line): array
{
    return array_map(
        static fn (string $cell): string => html_entity_decode(trim($cell), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        explode('|', trim(trim($line), '|'))
    );
}

function slug(string $value): string
{
    return trim(strtolower((string) preg_replace('/[^A-Za-z0-9]+/', '-', $value)), '-');
}

function escapeCell(string $value): string
{
    return str_replace('|', '\\|', $value);
}
