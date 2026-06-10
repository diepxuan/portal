<?php

declare(strict_types=1);

/*
 * @copyright  © 2025 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 *
 * @lastupdate 2026-06-10 00:00:00
 */

namespace Diepxuan\Catalog\Http\Livewire\System;

use Diepxuan\Catalog\Config\SimbaRouteRegistry;
use Diepxuan\Catalog\Services\SimbaMenuRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Persistent left sidebar — SimbaERP menu tree.
 *
 * Built from sysMenu (SQL Server) with SimbaRouteRegistry mapping.
 * Shows active route highlight and expand/collapse groups.
 */
class SidebarMenu extends Component
{
    /** @var array<int, array{menuid:string,name:string,moduleid:string,depth:int,route:?string,isActive:bool,isLeaf:bool,hasRoute:bool,children:array}> */
    public array $tree = [];

    protected SimbaMenuRepository $menus;

    protected array $routeMap;

    public function boot(SimbaMenuRepository $menus): void
    {
        $this->menus    = $menus;
        $this->routeMap = SimbaRouteRegistry::menuidToRouteMap();
    }

    public function mount(): void
    {
        $this->tree = $this->buildTree();
    }

    /**
     * Build sidebar tree.
     *
     * Structure: type=5 roots (module root) → depth 0
     *   → groups XX.YY.00 → depth 1
     *   → items XX.YY.ZZ  → depth 2
     *
     * @return array<int, array{menuid:string,name:string,moduleid:string,depth:int,route:?string,isActive:bool,isLeaf:bool,hasRoute:bool,children:array}>
     */
    protected function buildTree(): array
    {
        $active   = $this->menus->activeMenus();
        $byParent = $active
            ->groupBy(fn ($sm) => $sm->getParentMenuId() ?? '')
            ->map(fn ($items) => $items->sortBy('stt')->values());

        // Only include routes that are actually registered in Laravel
        $this->routeMap = array_filter(
            $this->routeMap,
            static fn ($routeName) => Route::has($routeName),
        );

        // Start from type=5 roots (module entry points)
        $roots = $active
            ->filter(fn ($sm) => '5' === (string) $sm->type)
            ->sortBy(fn ($sm) => (int) str_replace('.', '', (string) $sm->stt))
            ->values();

        return $roots
            ->map(fn ($sm) => $this->buildNode($sm, $byParent, 0))
            ->all();
    }

    /**
     * Recursively build one node and its children.
     *
     * @param Collection<string, Collection> $byParent
     * @return array{menuid:string,name:string,moduleid:string,depth:int,route:?string,isActive:bool,isLeaf:bool,hasRoute:bool,children:array}
     */
    protected function buildNode($sm, Collection $byParent, int $depth): array
    {
        $route      = $this->routeMap[$sm->menuid] ?? null;
        $isActive   = $route && request()->routeIs($route);
        $children   = $byParent->get($sm->menuid, collect());
        $hasRoute   = $route !== null;

        // Only build children up to depth 2 (module → group → item)
        $childNodes = [];
        if ($children->isNotEmpty() && $depth < 2) {
            $childNodes = $children
                ->map(fn ($child) => $this->buildNode($child, $byParent, $depth + 1))
                ->all();
        }

        return [
            'menuid'     => $sm->menuid,
            'name'       => $sm->getDisplayName(),
            'moduleid'   => $sm->moduleid,
            'depth'      => $depth,
            'route'      => $route,
            'isActive'   => $isActive,
            'isLeaf'     => empty($childNodes),
            'hasRoute'   => $hasRoute,
            'children'   => $childNodes,
        ];
    }

    public function render(): View
    {
        return view('catalog::system.sidebar-menu');
    }
}