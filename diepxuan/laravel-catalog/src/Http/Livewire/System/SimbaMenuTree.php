<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-11 23:13:19
 */

namespace Diepxuan\Catalog\Http\Livewire\System;

use Diepxuan\Simba\Models\SysMenu;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Displays the SimbaERP sysMenu tree for reference.
 * Decoupled from the Portal Menu management component.
 */
class SimbaMenuTree extends Component
{
    public string $search = '';

    /**
     * Build the SimbaERP menu tree.
     *
     * @return Collection<int, object>
     */
    public function getTreeProperty(): Collection
    {
        try {
            $allMenus = SysMenu::where('active', 1)
                ->orderBy('stt')
                ->get()
            ;

            if ($this->search) {
                $search   = strtolower($this->search);
                $allMenus = $allMenus->filter(
                    static fn ($sm) => str_contains(strtolower($sm->menuid), $search)
                        || str_contains(strtolower($sm->getDisplayName()), $search)
                        || str_contains(strtolower($sm->dllName ?? ''), $search),
                );
            }

            $childrenMap = $allMenus
                ->groupBy(static fn ($sm) => $sm->getParentMenuId() ?? '')
                ->map(static fn ($items) => $items->sortBy('stt')->values())
            ;

            return $this->buildRecursive($childrenMap, '');
        } catch (\Throwable) {
            return collect();
        }
    }

    /**
     * Total active menu count for stats.
     */
    public function getTotalProperty(): int
    {
        try {
            return SysMenu::where('active', 1)->count();
        } catch (\Throwable) {
            return 0;
        }
    }

    public function render(): View
    {
        return view('catalog::system.simba-menu-tree');
    }

    /**
     * Recursive tree builder.
     *
     * @param Collection<string, Collection> $childrenMap
     */
    protected function buildRecursive(Collection $childrenMap, ?string $parentId, int $depth = 0): Collection
    {
        $result = collect();

        foreach ($childrenMap->get($parentId ?? '', collect()) as $sm) {
            $result->push((object) [
                'menuid'       => $sm->menuid,
                'name'         => $sm->getDisplayName(),
                'dllName'      => $sm->dllName,
                'depth'        => $depth,
                'type'         => $sm->type,
                'isRoot'       => $sm->isRoot(),
                'isGroup'      => $sm->isGroup(),
                'isVoucher'    => $sm->isVoucher(),
                'isMasterData' => $sm->isMasterData(),
                'isReport'     => $sm->isReport(),
                'isSetup'      => $sm->isSetup(),
                'hasChildren'  => $childrenMap->has($sm->menuid),
            ]);
            $result = $result->merge($this->buildRecursive($childrenMap, $sm->menuid, $depth + 1));
        }

        return $result;
    }
}
