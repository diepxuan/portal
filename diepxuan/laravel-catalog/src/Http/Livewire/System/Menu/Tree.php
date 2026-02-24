<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-02-24 15:47:00
 */

namespace Diepxuan\Catalog\Http\Livewire\System\Menu;

use Diepxuan\Catalog\Models\NavigationMenu;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Tree extends Component
{
    public Collection $tree;
    public array $expandedNodes = [];
    public ?int $editingNodeId = null;
    public string $editingName = '';
    public string $editingRoute = '';
    public ?int $draggingNodeId = null;
    public ?int $dropTargetId = null;
    public string $dropPosition = 'inside'; // 'inside', 'before', 'after'
    public bool $isSaving = false;
    public array $recentlyUpdated = [];

    protected $listeners = [
        'menuAdded' => 'refreshTree',
        'menuDeleted' => 'refreshTree',
        'menuUpdated' => 'refreshTree',
    ];

    public function mount(): void
    {
        $this->refreshTree();
        // Mở tất cả nodes mặc định
        $this->expandedNodes = $this->getAllNodeIds($this->tree)->toArray();
    }

    public function refreshTree(): void
    {
        $this->tree = \CatalogService::menuTree();
    }

    public function toggleNode(int $nodeId): void
    {
        if (in_array($nodeId, $this->expandedNodes)) {
            $this->expandedNodes = array_diff($this->expandedNodes, [$nodeId]);
        } else {
            $this->expandedNodes[] = $nodeId;
        }
    }

    public function isExpanded(int $nodeId): bool
    {
        return in_array($nodeId, $this->expandedNodes);
    }

    public function startEdit(int $nodeId): void
    {
        $node = $this->findNode($this->tree, $nodeId);
        if ($node) {
            $this->editingNodeId = $nodeId;
            $this->editingName = $node['name'];
            $this->editingRoute = $node['route'] ?? '';
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

        $this->isSaving = true;

        try {
            $menu = NavigationMenu::findOrFail($this->editingNodeId);
            $menu->name = $this->editingName;
            $menu->route = $this->editingRoute;
            $menu->save();

            // Highlight recently updated
            $this->recentlyUpdated[$this->editingNodeId] = true;

            // Clear after 2 seconds
            $this->dispatch('clear-highlight', nodeId: $this->editingNodeId)->delay(2000);

            $this->cancelEdit();
            $this->refreshTree();
            
            $this->dispatch('menuUpdated');
        } finally {
            $this->isSaving = false;
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

    public function handleDrop(): void
    {
        if (!$this->draggingNodeId || !$this->dropTargetId) {
            return;
        }

        $draggingMenu = NavigationMenu::findOrFail($this->draggingNodeId);
        $targetMenu = NavigationMenu::findOrFail($this->dropTargetId);

        // Prevent dropping into itself or its descendants
        if ($this->dropPosition === 'inside' && $this->isDescendant($targetMenu->id, $draggingMenu->id)) {
            $this->clearDragState();
            return;
        }

        $this->isSaving = true;

        try {
            if ($this->dropPosition === 'inside') {
                // Move as child
                $draggingMenu->parent_id = $targetMenu->id;
                // Get max order of children and add 1
                $maxOrder = NavigationMenu::where('parent_id', $targetMenu->id)
                    ->max('order') ?? -1;
                $draggingMenu->order = $maxOrder + 1;
            } else {
                // Move as sibling (before/after)
                $draggingMenu->parent_id = $targetMenu->parent_id;
                
                if ($this->dropPosition === 'before') {
                    // Move before target
                    NavigationMenu::where('parent_id', $targetMenu->parent_id)
                        ->where('order', '>=', $targetMenu->order)
                        ->increment('order');
                    $draggingMenu->order = $targetMenu->order;
                } else {
                    // Move after target
                    NavigationMenu::where('parent_id', $targetMenu->parent_id)
                        ->where('order', '>', $targetMenu->order)
                        ->increment('order');
                    $draggingMenu->order = $targetMenu->order + 1;
                }
            }

            $draggingMenu->save();
            $this->reorderSiblings($draggingMenu);

            $this->refreshTree();
            $this->dispatch('menuUpdated');
        } finally {
            $this->isSaving = false;
            $this->clearDragState();
        }
    }

    private function reorderSiblings(NavigationMenu $menu): void
    {
        $siblings = NavigationMenu::where('parent_id', $menu->parent_id)
            ->where('id', '!=', $menu->id)
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

        // Ensure the dragged menu has correct order
        if ($menu->order !== $order) {
            $menu->order = $order;
            $menu->save();
        }
    }

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

    public function clearDragState(): void
    {
        $this->draggingNodeId = null;
        $this->dropTargetId = null;
        $this->dropPosition = 'inside';
    }

    public function deleteNode(int $nodeId): void
    {
        if (!confirm('Bạn có chắc chắn muốn xóa menu này và tất cả menu con?')) {
            return;
        }

        $this->isSaving = true;

        try {
            NavigationMenu::where('id', $nodeId)->delete();
            $this->refreshTree();
            $this->dispatch('menuDeleted');
        } finally {
            $this->isSaving = false;
        }
    }

    private function findNode(Collection $tree, int $nodeId): ?object
    {
        foreach ($tree as $node) {
            if ($node->id === $nodeId) {
                return $node;
            }
            if (!empty($node->children)) {
                $found = $this->findNode($node->children, $nodeId);
                if ($found) {
                    return $found;
                }
            }
        }
        return null;
    }

    private function getAllNodeIds(Collection $tree): Collection
    {
        $ids = collect();
        
        foreach ($tree as $node) {
            $ids->push($node->id);
            if (!empty($node->children)) {
                $ids = $ids->merge($this->getAllNodeIds($node->children));
            }
        }
        
        return $ids;
    }

    public function render(): View
    {
        return view('catalog::system.menu.tree');
    }
}