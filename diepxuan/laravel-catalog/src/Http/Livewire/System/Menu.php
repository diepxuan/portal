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

namespace Diepxuan\Catalog\Http\Livewire\System;

use Diepxuan\Catalog\Models\NavigationMenu;
use Diepxuan\Catalog\Services\MenuTreeBuilder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Menu extends Component
{
    public Collection $nodes;
    public array $expandedNodes = [];
    public array $visibleNodes = [];
    public ?int $editingNodeId = null;
    public string $editingName = '';
    public string $editingRoute = '';
    public ?int $draggingNodeId = null;
    public ?int $dropTargetId = null;
    public string $dropPosition = 'inside';
    public bool $isSaving = false;
    public array $recentlyUpdated = [];
    public array $nodeSaving = [];

    public array $newMenu = [
        'parent_id' => null,
        'name'      => '',
        'route'     => '',
    ];

    protected MenuTreeBuilder $treeBuilder;

    protected $listeners = [
        'refresh-menu' => 'refreshTree',
    ];

    public function boot(MenuTreeBuilder $treeBuilder): void
    {
        $this->treeBuilder = $treeBuilder;
    }

    public function mount(): void
    {
        $this->refreshTree();
        // Expand all nodes by default
        $this->expandedNodes = $this->nodes->pluck('id')->toArray();
        $this->updateVisibleNodes();
    }

    public function refreshTree(): void
    {
        $this->nodes = $this->treeBuilder->buildFlattenedTree();
        $this->updateVisibleNodes();
    }

    private function updateVisibleNodes(): void
    {
        $visible = [];
        $parentVisibility = [null => true]; // Root is always visible
        
        foreach ($this->nodes as $node) {
            // Check if parent is expanded
            $isVisible = $parentVisibility[$node->parent_id] ?? false;
            
            if ($isVisible) {
                $visible[] = $node->id;
                // Children of this node are visible if this node is expanded
                $parentVisibility[$node->id] = in_array($node->id, $this->expandedNodes);
            } else {
                $parentVisibility[$node->id] = false;
            }
        }
        
        $this->visibleNodes = $visible;
    }

    public function toggleNode(int $nodeId): void
    {
        if (in_array($nodeId, $this->expandedNodes)) {
            $this->expandedNodes = array_diff($this->expandedNodes, [$nodeId]);
        } else {
            $this->expandedNodes[] = $nodeId;
        }
        
        $this->updateVisibleNodes();
    }

    public function isExpanded(int $nodeId): bool
    {
        return in_array($nodeId, $this->expandedNodes);
    }

    public function isVisible(int $nodeId): bool
    {
        return in_array($nodeId, $this->visibleNodes);
    }

    public function startEdit(int $nodeId): void
    {
        $node = $this->nodes->firstWhere('id', $nodeId);
        if ($node) {
            $this->editingNodeId = $nodeId;
            $this->editingName = $node->name;
            $this->editingRoute = $node->route ?? '';
        }
    }

    public function cancelEdit(): void
    {
        $this->editingNodeId = null;
        $this->editingName = '';
        $this->editingRoute = '';
    }

    public function saveEdit(): void
    {
        if (!$this->editingNodeId) {
            return;
        }

        $this->nodeSaving[$this->editingNodeId] = true;

        try {
            $updated = $this->treeBuilder->updateMenu(
                $this->editingNodeId,
                $this->editingName,
                $this->editingRoute
            );

            // Update local node data
            $node = $this->nodes->firstWhere('id', $this->editingNodeId);
            if ($node) {
                $node->name = $updated['name'];
                $node->route = $updated['route'];
            }

            // Highlight recently updated
            $this->recentlyUpdated[$this->editingNodeId] = true;

            // Clear highlight after 2 seconds
            $this->dispatch('clear-highlight', nodeId: $this->editingNodeId)->delay(2000);

            $this->cancelEdit();
        } finally {
            unset($this->nodeSaving[$this->editingNodeId]);
        }
    }

    public function startDrag(int $nodeId): void
    {
        $this->draggingNodeId = $nodeId;
    }

    public function setDropTarget(?int $nodeId, string $position = 'inside'): void
    {
        $this->dropTargetId = $nodeId;
        $this->dropPosition = $position;
    }

    public function clearDropTarget(): void
    {
        $this->dropTargetId = null;
        $this->dropPosition = 'inside';
    }

    public function clearDragState(): void
    {
        $this->draggingNodeId = null;
        $this->dropTargetId = null;
        $this->dropPosition = 'inside';
    }

    public function handleDrop(): void
    {
        if (!$this->draggingNodeId) {
            return;
        }

        $this->isSaving = true;

        try {
            // Calculate new order based on drop position
            $newOrder = 0;
            $newParentId = $this->dropTargetId;
            
            if ($this->dropPosition === 'before' || $this->dropPosition === 'after') {
                $targetNode = $this->nodes->firstWhere('id', $this->dropTargetId);
                if ($targetNode) {
                    $newParentId = $targetNode->parent_id;
                    $newOrder = $targetNode->order;
                    
                    if ($this->dropPosition === 'after') {
                        $newOrder++;
                    }
                }
            }

            // Special case: dropping to root level (null parent)
            if ($this->dropTargetId === null) {
                $newParentId = null;
                // Find max order among root menus
                $maxOrder = $this->nodes->where('parent_id', null)->max('order') ?? -1;
                $newOrder = $maxOrder + 1;
            }

            // Update menu position in database
            $updated = $this->treeBuilder->updateMenuPosition(
                $this->draggingNodeId,
                $newParentId,
                $newOrder
            );

            // Refresh tree to get updated structure
            $this->refreshTree();
            
            // Dispatch event for other components
            $this->dispatch('refresh-menu');
        } finally {
            $this->isSaving = false;
            $this->clearDragState();
        }
    }

    /**
     * Reorder root menus manually.
     */
    public function reorderRootMenu(int $menuId, string $direction): void
    {
        $menu = $this->nodes->firstWhere('id', $menuId);
        if (!$menu || $menu->parent_id !== null) {
            return; // Not a root menu
        }

        $rootMenus = $this->nodes->where('parent_id', null)->sortBy('order')->values();
        $currentIndex = $rootMenus->search(function ($item) use ($menuId) {
            return $item->id === $menuId;
        });

        if ($currentIndex === false) {
            return;
        }

        if ($direction === 'up' && $currentIndex > 0) {
            $targetIndex = $currentIndex - 1;
        } elseif ($direction === 'down' && $currentIndex < $rootMenus->count() - 1) {
            $targetIndex = $currentIndex + 1;
        } else {
            return;
        }

        // Swap orders
        $currentMenu = $rootMenus[$currentIndex];
        $targetMenu = $rootMenus[$targetIndex];

        $tempOrder = $currentMenu->order;
        $currentMenu->order = $targetMenu->order;
        $targetMenu->order = $tempOrder;

        // Save both menus
        $this->treeBuilder->updateRootMenuOrder($currentMenu->id, $currentMenu->order);
        $this->treeBuilder->updateRootMenuOrder($targetMenu->id, $targetMenu->order);

        $this->refreshTree();
        $this->dispatch('refresh-menu');
    }

    public function deleteNode(int $nodeId): void
    {
        if (!confirm('Bạn có chắc chắn muốn xóa menu này và tất cả menu con?')) {
            return;
        }

        $this->nodeSaving[$nodeId] = true;

        try {
            $this->treeBuilder->deleteMenu($nodeId);
            
            // Remove from local nodes
            $this->nodes = $this->nodes->reject(function ($node) use ($nodeId) {
                return $node->id === $nodeId;
            });
            
            // Update visible nodes
            $this->updateVisibleNodes();
            
            // Dispatch event
            $this->dispatch('refresh-menu');
        } finally {
            unset($this->nodeSaving[$nodeId]);
        }
    }

    public function addMenu(): void
    {
        $this->validate([
            'newMenu.name' => 'required|string|max:255',
            'newMenu.route' => 'nullable|string|max:255',
            'newMenu.parent_id' => 'nullable|exists:menus,id',
        ]);

        $menu = NavigationMenu::create($this->newMenu);
        
        // Reset form
        $this->newMenu = [
            'parent_id' => null,
            'name'      => '',
            'route'     => '',
        ];

        // Refresh tree
        $this->refreshTree();
        $this->dispatch('refresh-menu');
    }

    public function getParentOptionsProperty(): Collection
    {
        return $this->treeBuilder->getTreeForDropdown();
    }

    public function render(): View
    {
        return view('catalog::system.menu-optimized')->layout('catalog::layouts.app');
    }
}