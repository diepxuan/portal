<div class="menu-item transition-all duration-200">
    <div class="group flex items-center justify-between rounded-lg border border-gray-200 bg-white p-3 hover:border-gray-300 hover:bg-gray-50">
        <div class="flex items-center space-x-3">
            <!-- Drag handle -->
            <div class="cursor-move text-gray-400 hover:text-gray-600" title="Kéo để sắp xếp">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                </svg>
            </div>
            
            <!-- Menu info -->
            <div class="flex items-center space-x-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-100 text-sm font-medium text-blue-700">
                    {{ substr($menu->name, 0, 2) }}
                </div>
                
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="font-medium text-gray-900">{{ $menu->name }}</span>
                        @if($menu->route)
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">
                                {{ $menu->route }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="mt-1 flex items-center space-x-3 text-xs text-gray-500">
                        <span class="font-mono" title="ID">ID: {{ $menu->id }}</span>
                        <span title="Thứ tự">Thứ tự: {{ $menu->order ?? 0 }}</span>
                        <span title="Loại menu">
                            @if($menu->route == 'space')
                                <span class="text-amber-600">Khoảng cách</span>
                            @elseif(empty($menu->route))
                                <span class="text-purple-600">Thư mục</span>
                            @else
                                <span class="text-green-600">Liên kết</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <!-- Parent selector -->
            <div class="relative">
                <select class="rounded-md border-gray-300 py-1.5 pr-8 pl-3 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        wire:model="parentId" 
                        wire:change="updateMenu"
                        title="Thay đổi menu cha">
                    <option value="">-- Menu gốc --</option>
                    @include('catalog::system.menu.option-tree', ['items' => $availableParents])
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            
            <!-- Delete button -->
            <button wire:click="deleteMenu" 
                    onclick="return confirm('Bạn có chắc chắn muốn xóa menu \"{{ $menu->name }}\"?')"
                    class="inline-flex items-center rounded-md bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 hover:bg-red-100"
                    title="Xóa menu">
                <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Xóa
            </button>
        </div>
    </div>
    
    <!-- Children -->
    @if(count($childIds) > 0)
    <div class="ml-8 mt-2 space-y-2 border-l border-gray-200 pl-4">
        @foreach ($childIds as $id)
            @livewire('catalog::system.menu.item', ['menuId' => $id], key("menu-item-$id"))
        @endforeach
    </div>
    @endif
</div>
