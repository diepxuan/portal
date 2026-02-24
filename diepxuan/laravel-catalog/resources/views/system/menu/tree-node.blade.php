@php
    $nodeId = $node->id;
    $isEditing = $this->editingNodeId === $nodeId;
    $isDragging = $this->draggingNodeId === $nodeId;
    $isDropTarget = $this->dropTargetId === $nodeId;
    $dropPosition = $this->dropPosition;
    $isRecentlyUpdated = $this->recentlyUpdated[$nodeId] ?? false;
    $hasChildren = !empty($node->children);
    $isExpanded = $this->isExpanded($nodeId);
@endphp

<!-- Drop Zone Before -->
@if(!$isDragging)
<div class="my-1"
     @dragover="if ($wire.draggingNodeId && $wire.draggingNodeId !== {{ $nodeId }}) { 
         $wire.setDropTarget({{ $nodeId }}, 'before'); 
         event.dataTransfer.dropEffect = 'move';
     }"
     @dragleave="if ($wire.dropTargetId === {{ $nodeId }} && $wire.dropPosition === 'before') { 
         $wire.clearDropTarget(); 
     }"
     :class="{ 'border-t-2 border-blue-400': $wire.dropTargetId === {{ $nodeId }} && $wire.dropPosition === 'before' }">
</div>
@endif

<!-- Node Container -->
<div class="group relative flex items-center rounded-lg border transition-all duration-200 hover:border-gray-300 hover:bg-gray-50 {{ $isRecentlyUpdated ? 'border-green-300 bg-green-50' : 'border-gray-200' }} {{ $isDragging ? 'opacity-50' : '' }} {{ $isDropTarget && $dropPosition === 'inside' ? 'border-2 border-dashed border-blue-400 bg-blue-50' : '' }}"
     draggable="true"
     @dragstart="$wire.startDrag({{ $nodeId }})"
     @dragend="$wire.clearDragState()"
     :style="{ 'margin-left': '{{ $level * 24 }}px' }">
    
    <!-- Expand/Collapse Toggle -->
    @if($hasChildren)
        <button type="button"
                class="ml-2 flex h-6 w-6 items-center justify-center text-gray-500 hover:text-gray-700"
                wire:click="toggleNode({{ $nodeId }})">
            <svg class="h-4 w-4 transition-transform duration-200 {{ $isExpanded ? 'rotate-90' : '' }}" 
                 fill="none" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    @else
        <div class="ml-8 w-2"></div> <!-- Spacer for alignment -->
    @endif

    <!-- Drag Handle -->
    <div class="ml-1 cursor-move text-gray-400 hover:text-gray-600"
         title="Kéo để di chuyển">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
        </svg>
    </div>

    <!-- Node Content -->
    <div class="flex flex-1 items-center px-3 py-2">
        <!-- Name Column -->
        <div class="col-span-6 w-1/2">
            @if($isEditing)
                <div class="flex items-center space-x-2">
                    <input type="text"
                           class="w-full rounded-md border-gray-300 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           wire:model="editingName"
                           wire:keydown.enter="saveEdit"
                           wire:keydown.escape="cancelEdit"
                           autofocus />
                    
                    <button type="button"
                            class="rounded-md bg-green-100 p-1 text-green-700 hover:bg-green-200"
                            wire:click="saveEdit"
                            wire:loading.attr="disabled"
                            wire:target="saveEdit">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    
                    <button type="button"
                            class="rounded-md bg-gray-100 p-1 text-gray-700 hover:bg-gray-200"
                            wire:click="cancelEdit">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @else
                <button type="button"
                        class="text-left font-medium text-gray-900 hover:text-blue-600"
                        wire:click="startEdit({{ $nodeId }})">
                    {{ $node->name }}
                </button>
            @endif
        </div>

        <!-- Route Column -->
        <div class="col-span-4 w-1/3">
            @if($isEditing)
                <input type="text"
                       class="w-full rounded-md border-gray-300 py-1 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       wire:model="editingRoute"
                       wire:keydown.enter="saveEdit"
                       wire:keydown.escape="cancelEdit"
                       placeholder="route.name" />
            @else
                <span class="text-sm text-gray-600">
                    {{ $node->route ?? '—' }}
                </span>
            @endif
        </div>

        <!-- ID Column -->
        <div class="col-span-1 w-16 text-center">
            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-mono text-gray-700">
                {{ $nodeId }}
            </span>
        </div>

        <!-- Order Column -->
        <div class="col-span-1 w-16 text-center">
            <span class="text-sm font-medium text-gray-700">
                {{ $node->order ?? 0 }}
            </span>
        </div>

        <!-- Actions -->
        <div class="ml-4 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
            @if(!$isEditing)
                <button type="button"
                        class="rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                        wire:click="startEdit({{ $nodeId }})"
                        title="Chỉnh sửa">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            @endif
            
            <button type="button"
                    class="rounded-md p-1 text-red-500 hover:bg-red-100 hover:text-red-700"
                    wire:click="deleteNode({{ $nodeId }})"
                    title="Xóa">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Children -->
@if($hasChildren && $isExpanded)
    <div class="space-y-1">
        @foreach($node->children as $child)
            @include('catalog::system.menu.tree-node', [
                'node' => $child,
                'level' => $level + 1,
                'parentId' => $nodeId
            ])
        @endforeach
        
        <!-- Drop Zone Inside (for empty children area) -->
        @if(!$isDragging)
        <div class="my-1 rounded border-2 border-dashed border-gray-300 p-2"
             :style="{ 'margin-left': '{{ ($level + 1) * 24 }}px' }"
             @dragover="if ($wire.draggingNodeId && $wire.draggingNodeId !== {{ $nodeId }}) { 
                 $wire.setDropTarget({{ $nodeId }}, 'inside'); 
                 event.dataTransfer.dropEffect = 'move';
             }"
             @dragleave="if ($wire.dropTargetId === {{ $nodeId }} && $wire.dropPosition === 'inside') { 
                 $wire.clearDropTarget(); 
             }"
             :class="{ 'border-blue-400 bg-blue-50': $wire.dropTargetId === {{ $nodeId }} && $wire.dropPosition === 'inside' }">
            @if($this->dropTargetId === $nodeId && $this->dropPosition === 'inside')
                <div class="text-center text-sm text-blue-600">
                    Thả vào đây để chuyển thành menu con
                </div>
            @else
                <div class="text-center text-sm text-gray-400">
                    Kéo menu vào đây để thêm làm menu con
                </div>
            @endif
        </div>
        @endif
    </div>
@endif

<!-- Drop Zone After -->
@if(!$isDragging)
<div class="my-1"
     @dragover="if ($wire.draggingNodeId && $wire.draggingNodeId !== {{ $nodeId }}) { 
         $wire.setDropTarget({{ $nodeId }}, 'after'); 
         event.dataTransfer.dropEffect = 'move';
     }"
     @dragleave="if ($wire.dropTargetId === {{ $nodeId }} && $wire.dropPosition === 'after') { 
         $wire.clearDropTarget(); 
     }"
     :class="{ 'border-t-2 border-blue-400': $wire.dropTargetId === {{ $nodeId }} && $wire.dropPosition === 'after' }">
</div>
@endif