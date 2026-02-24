<div class="ms-4 mt-1 bg-transparent">

    <div class="flex items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-1 hover:bg-gray-50">
        <div class="flex items-center space-x-2">
            @if ($menu->route == 'space')
                <span class="text-xs text-gray-500">{{ $menu->name }}</span>
            @else
                <span class="font-medium text-gray-800">{{ $menu->name }}</span>
            @endif
            
            @if($menu->route)
                <span class="text-xs text-gray-500">({{ $menu->route }})</span>
            @endif
        </div>
        
        <div class="flex items-center space-x-2">
            <select class="rounded-md border-gray-300 py-0 text-xs shadow-sm" wire:model="parentId" wire:change="updateMenu">
                <option value="">-- Di chuyển đến --</option>
                @include('catalog::system.menu.option-tree', ['items' => $availableParents])
            </select>
            
            <span class="text-xs text-gray-400">#{{ $menu->order ?? 0 }}</span>
            
            <button wire:click="deleteMenu" 
                    onclick="return confirm('Xóa menu này?')"
                    class="rounded-md bg-red-100 px-2 py-0 text-xs text-red-600 hover:bg-red-200">
                Xóa
            </button>
        </div>
    </div>
    
    @if(count($childIds) > 0)
    <div class="ml-4 mt-1 border-l-2 border-gray-200 pl-2">
        @foreach ($childIds as $id)
            @livewire('catalog::system.menu.item', ['menuId' => $id], key("menu-item-$id"))
        @endforeach
    </div>
    @endif
</div>
