<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-02-24 16:35:00
 */

namespace Diepxuan\Catalog\Services;

use Diepxuan\Catalog\Models\NavigationMenu;
use Illuminate\Support\Collection;

class MenuTreeBuilder
{
    /**
     * Load all menus and build flattened tree structure.
     * 
     * @return Collection<int, object>
     */
    public function buildFlattenedTree(): Collection
    {
        $allMenus = NavigationMenu::orderBy('parent_id')
            ->orderBy('order')
            ->get();

        // Build parent-child mapping
        $childrenMap = $allMenus->groupBy('parent_id')->map(function ($items) {
            return $items->sortBy('order')->values();
        });

        // Build flattened tree with level information
        $result = collect();
        $this->flattenTreeRecursive($childrenMap, null, 0, $result);
        
        return $result;
    }

    /**
     * Recursively flatten tree with level information.
     */
    private function flattenTreeRecursive(
        Collection $childrenMap,
        ?int $parentId,
        int $level,
        Collection &$result
    ): void {
        $children = $childrenMap->get($parentId, collect());

        foreach ($children as $menu) {
            $result->push((object) [
                'id'           => $menu->id,
                'parent_id'    => $menu->parent_id,
                'name'         => $menu->name,
                'route'        => $menu->route,
                'order'        => $menu->order,
                'level'        => $level,
                'has_children' => $childrenMap->has($menu->id),
                'is_expanded'  => true, // Default expanded
            ]);

            // Add children if expanded
            if (true) { // Will implement lazy expand later
                $this->flattenTreeRecursive($childrenMap, $menu->id, $level + 1, $result);
            }
        }
    }

    /**
     * Update menu position after drag & drop.
     */
    public function updateMenuPosition(int $menuId, ?int $newParentId, int $newOrder): array
    {
        $menu = NavigationMenu::findOrFail($menuId);
        
        // Prevent circular reference
        if ($newParentId && $this->isDescendant($newParentId, $menuId)) {
            throw new \InvalidArgumentException('Cannot move menu to its own descendant.');
        }

        $oldParentId = $menu->parent_id;
        
        // Update the menu
        $menu->parent_id = $newParentId;
        $menu->order = $newOrder;
        $menu->save();

        // Reorder siblings in both old and new parent
        $this->reorderSiblings($oldParentId);
        $this->reorderSiblings($newParentId);

        return [
            'id' => $menu->id,
            'parent_id' => $menu->parent_id,
            'order' => $menu->order,
        ];
    }

    /**
     * Check if a menu is descendant of another.
     */
    private function isDescendant(int $potentialParentId, int $nodeId): bool
    {
        $node = NavigationMenu::find($nodeId);
        while ($node && $node->parent_id) {
            if ($node->parent_id === $potentialParentId) {
                return true;
            }
            $node = NavigationMenu::find($node->parent_id);
        }
        return false;
    }

    /**
     * Reorder siblings to maintain consistent order.
     */
    private function reorderSiblings(?int $parentId): void
    {
        $siblings = NavigationMenu::where('parent_id', $parentId)
            ->orderBy('order')
            ->get();

        $order = 0;
        foreach ($siblings as $sibling) {
            if ($sibling->order !== $order) {
                $sibling->order = $order;
                $sibling->save();
            }
            $order++;
        }
    }

    /**
     * Update menu name and route.
     */
    public function updateMenu(int $menuId, string $name, ?string $route): array
    {
        $menu = NavigationMenu::findOrFail($menuId);
        $menu->name = $name;
        $menu->route = $route;
        $menu->save();

        return [
            'id' => $menu->id,
            'name' => $menu->name,
            'route' => $menu->route,
        ];
    }

    /**
     * Delete menu and its children.
     */
    public function deleteMenu(int $menuId): void
    {
        // Delete children recursively
        $this->deleteChildrenRecursive($menuId);
        
        // Delete the menu itself
        NavigationMenu::where('id', $menuId)->delete();
    }

    /**
     * Recursively delete children.
     */
    private function deleteChildrenRecursive(int $parentId): void
    {
        $children = NavigationMenu::where('parent_id', $parentId)->get();
        
        foreach ($children as $child) {
            $this->deleteChildrenRecursive($child->id);
            $child->delete();
        }
    }

    /**
     * Get tree for parent selection dropdown.
     */
    public function getTreeForDropdown(): Collection
    {
        $allMenus = NavigationMenu::orderBy('parent_id')
            ->orderBy('order')
            ->get();

        $childrenMap = $allMenus->groupBy('parent_id')->map(function ($items) {
            return $items->sortBy('order')->values();
        });

        return $this->buildDropdownTree($childrenMap, null);
    }

    /**
     * Build hierarchical tree for dropdown.
     */
    private function buildDropdownTree(Collection $childrenMap, ?int $parentId): Collection
    {
        $children = $childrenMap->get($parentId, collect());

        return $children->map(function ($menu) use ($childrenMap) {
            return (object) [
                'id'       => $menu->id,
                'name'     => $menu->name,
                'route'    => $menu->route,
                'children' => $this->buildDropdownTree($childrenMap, $menu->id),
            ];
        });
    }
}