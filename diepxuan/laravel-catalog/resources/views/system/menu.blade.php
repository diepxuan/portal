<div class="space-y-6">
    <x-head-title>{{ 'Quản lý Menu' }}</x-head-title>
    
    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-lg font-semibold text-gray-800">Thêm menu mới</h3>
        
        <form wire:submit.prevent="addMenu" class="space-y-3">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Tên menu</label>
                    <input type="text" 
                           class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           wire:model="newMenu.name" 
                           placeholder="Ví dụ: Hệ thống" 
                           required />
                </div>
                
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Đường dẫn (route)</label>
                    <input type="text" 
                           class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           wire:model="newMenu.route" 
                           placeholder="Ví dụ: system.menu" />
                </div>
                
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Menu cha</label>
                    <select class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            wire:model="newMenu.parent_id">
                        <option value="">-- Không có (menu gốc) --</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}">
                                {{ $menu->name }} @if($menu->route) ({{ $menu->route }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Thêm menu
                </button>
            </div>
        </form>
    </div>
    
    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Danh sách menu (Tree View)</h3>
            <div class="text-sm text-gray-500">
                {{ count($menus) }} menu • 
                <button type="button" 
                        class="text-blue-600 hover:text-blue-800"
                        onclick="alert('Tất cả menu đã được mở rộng. Click vào icon ▶ để thu gọn.')">
                    Tất cả đã mở rộng
                </button>
            </div>
        </div>
        
        @livewire('catalog::system.menu.tree')
    </div>
</div>
