<?php

declare(strict_types=1);

namespace Diepxuan\Catalog\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

final class SourceRouteCoverageTest extends TestCase
{
    public function testSourceRoutesExistForActiveSysMenuRows(): void
    {
        foreach ($this->sourceRoutes() as $route) {
            self::assertTrue(Route::has($route['routeName']), "Missing route name {$route['routeName']}");
            self::assertSame(
                ltrim($route['url'], '/'),
                Route::getRoutes()->getByName($route['routeName'])?->uri(),
                "Route URI mismatch for {$route['routeName']}"
            );
        }
    }

    public function testSourceRouteUrlsResolveToExpectedRouteNames(): void
    {
        foreach ($this->sourceRoutes() as $route) {
            $resolved = Route::getRoutes()->match(request()->create($route['url'], 'GET'));

            self::assertSame($route['routeName'], $resolved->getName(), "Route resolve mismatch for {$route['url']}");
            self::assertSame($route['module'], $resolved->defaults['module'] ?? null);
            self::assertSame($route['kind'], $resolved->defaults['kind'] ?? null);
            self::assertSame($route['slug'], $resolved->defaults['slug'] ?? null);
        }
    }

    public function testLegacyUrlsStillResolve(): void
    {
        foreach ([
            '/gl/taikhoan',
            '/cash/tienmat/thu',
            '/cash/tienmat/chi',
            '/cash/tienmat/quy',
            '/cash/nganhang/baoco',
            '/cash/nganhang/baono',
            '/cash/nganhang/quy',
            '/cash/thu',
            '/cash/chi',
            '/cash/quy',
            '/cash/nhanvien',
            '/cash/nhanvien/create',
            '/cash/nhanvien/edit/1',
            '/banhang/hoadonbanhang',
            '/co/danhmuc/dinh-muc-bom',
            '/co/danhmuc/dinh-muc-chi-tiet',
            '/muahang/cungcap',
            '/muahang/nhacungcap',
            '/muahang/nhacungcap/create',
            '/muahang/nhacungcap/edit/1',
            '/muahang/chiphimuahang/danhmuc',
        ] as $url) {
            $resolved = Route::getRoutes()->match(request()->create($url, 'GET'));

            self::assertNotNull($resolved->getName(), "Legacy URL {$url} did not resolve to a named route");
        }
    }

    /**
     * @return list<array{module:string,kind:string,slug:string,routeName:string,url:string}>
     */
    private function sourceRoutes(): array
    {
        $rows = [];
        foreach (array_replace($this->readMenuRows('sysMenu.md'), $this->readMenuRows('zsysmenu.md')) as $menuid => $row) {
            $active = trim((string) ($row['active'] ?? ''));
            $moduleid = strtoupper(trim((string) ($row['moduleid'] ?? '')));
            $type = trim((string) ($row['type'] ?? ''));
            $dllName = trim((string) ($row['dllName'] ?? ''));
            $codeName = trim((string) ($row['code_name'] ?? ''));

            $kindMap = ['1' => 'vch', '2' => 'dict', '4' => 'rpt', '6' => 'proc'];
            if ('1' !== $active || !in_array($moduleid, ['GL', 'CA', 'SO', 'AP', 'AR', 'FA', 'IN', 'PO', 'CO'], true) || !isset($kindMap[$type])) {
                continue;
            }

            $slugBase = '' !== $dllName ? $dllName : $codeName;
            if ('' === $slugBase) {
                continue;
            }

            $module = strtolower($moduleid);
            $kind = $kindMap[$type];
            $slug = $this->slug($slugBase);
            $routeName = "{$module}.{$kind}.{$slug}";

            if (isset($rows[$routeName])) {
                continue;
            }

            $rows[$routeName] = [
                'module' => $module,
                'kind' => $kind,
                'slug' => $slug,
                'routeName' => $routeName,
                'url' => "/_simba-source/{$module}/{$kind}/{$slug}",
            ];
        }

        return array_values($rows);
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function readMenuRows(string $fileName): array
    {
        $path = base_path("simba-docs/data/{$fileName}");
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        self::assertIsArray($lines, "Cannot read {$path}");

        $headers = $this->parseMarkdownRow($lines[0]);
        $rows = [];
        foreach (array_slice($lines, 2) as $line) {
            if (!str_starts_with(trim($line), '|')) {
                continue;
            }

            $values = array_pad($this->parseMarkdownRow($line), count($headers), '');
            $row = array_combine($headers, array_slice($values, 0, count($headers)));
            $menuid = trim((string) ($row['menuid'] ?? ''));
            if ('' !== $menuid) {
                $rows[$menuid] = $row;
            }
        }

        return $rows;
    }

    /**
     * @return list<string>
     */
    private function parseMarkdownRow(string $line): array
    {
        return array_map(
            static fn (string $cell): string => html_entity_decode(trim($cell), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            explode('|', trim(trim($line), '|'))
        );
    }

    private function slug(string $value): string
    {
        return trim(strtolower((string) preg_replace('/[^A-Za-z0-9]+/', '-', $value)), '-');
    }
}
