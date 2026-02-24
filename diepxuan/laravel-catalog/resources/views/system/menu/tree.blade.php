<div class="space-y-2"
     x-data="{
        init() {
            // Clear highlight after delay
            Livewire.on('clear-highlight', (event) => {
                setTimeout(() => {
                    this.$wire.set('recentlyUpdated.' + event.nodeId, false);
                }, 2000);
            });
        }
     }">
    
    <!-- Drag & Drop Instructions -->
    <div class="mb-4 rounded-lg border border-blue-100 bg-blue-50 p-3 text-sm text-blue-800">
        <div class="flex items-center">
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong class="font-medium">Hướng dẫn:</strong> 
                Kéo menu để thay đổi thứ tự hoặc chuyển làm menu con. 
                Click vào tên để chỉnh sửa.
            </div>
        </div>
    </div>

    <!-- Tree Container -->
    <div class="rounded-lg border border-gray-200 bg-white">
        <!-- Tree Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
            <div class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-700">
                <div class="col-span-6">Tên menu</div>
                <div class="col-span-4">Route</div>
                <div class="col-span-1 text-center">ID</div>
                <div class="col-span-1 text-center">Thứ tự</div>
            </div>
        </div>

        <!-- Tree Body -->
        <div class="min-h-[200px] p-2"
             @dragover.prevent="
                if (!$wire.draggingNodeId) return;
                event.dataTransfer.dropEffect = 'move';
             "
             @drop.prevent="$wire.handleDrop()">
            
            @if($tree->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-gray-500">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <p class="mt-2">Chưa có menu nào</p>
                </div>
            @else
                <div class="space-y-1">
                    @foreach($tree as $node)
                        @include('catalog::system.menu.tree-node', [
                            'node' => $node,
                            'level' => 0,
                            'parentId' => null
                        ])
                    @endforeach
                </div>
            @endif

            <!-- Drop Zone for root level -->
            <div class="mt-2"
                 @dragover="if ($wire.draggingNodeId) { $wire.setDropTarget(null, 'after'); }"
                 @dragleave="if ($wire.dropTargetId === null) { $wire.clearDropTarget(); }"
                 :class="{ 'border-2 border-dashed border-blue-400 bg-blue-50': $wire.dropTargetId === null && $wire.draggingNodeId }">
                @if($this->dropTargetId === null && $this->draggingNodeId)
                    <div class="p-4 text-center text-sm text-blue-600">
                        Thả vào đây để chuyển thành menu gốc
                    </div>
                @endif
            </div>
        </div>

        <!-- Saving Indicator -->
        @if($isSaving)
            <div class="border-t border-gray-200 bg-gray-50 px-4 py-2">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="mr-2 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Đang lưu thay đổi...
                </div>
            </div>
        @endif
    </div>
</div>