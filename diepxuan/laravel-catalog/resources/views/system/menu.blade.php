<x-catalog::head-title>{{ __('Quản lý Menu') }}</x-catalog::head-title>

<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Hệ Thống') }}
            </h2>
            <p>{{ __('Quản lý Menu') }}</p>
        </div>
    </div>
</x-slot>

<div class="space-y-6" x-data="{
    errorMessage: null,
    showError(message) {
        this.errorMessage = message;
        setTimeout(() => { this.errorMessage = null; }, 5000);
    },
    init() {
        Livewire.on('clear-highlight', (event) => {
            setTimeout(() => { this.$wire.set('recentlyUpdated.' + event.nodeId, false); }, 2000);
        });
        Livewire.on('show-error', (event) => { this.showError(event.message); });
    }
}">

    {{-- Error Notification --}}
    <div x-show="errorMessage" x-transition
        class="rounded-lg border border-red-300 bg-red-50 p-4 text-red-800">
        <div class="flex items-center">
            <svg class="mr-3 h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="errorMessage"></span>
        </div>
    </div>

    {{-- Main flex layout --}}
    <div class="flex gap-4">
        {{-- Portal Menu Tree (left) --}}
        <div class="flex-1">
            {{-- Add Menu Form --}}
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <h3 class="mb-3 text-lg font-semibold text-gray-800">Thêm menu mới</h3>
                <form wire:submit.prevent="addMenu" class="space-y-3">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Tên menu</label>
                            <input type="text"
                                class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                wire:model="newMenu.name" placeholder="Ví dụ: Hệ thống" required />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Đường dẫn (route)</label>
                            <input type="text"
                                class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                wire:model="newMenu.route" placeholder="Ví dụ: system.menu" />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Menu cha</label>
                            <select
                                class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                wire:model="newMenu.parent_id">
                                <option value="">-- Không có (menu gốc) --</option>
                                @foreach ($this->parentOptions as $menu)
                                    <option value="{{ $menu->id }}">
                                        {{ $menu->name }} @if ($menu->route)
                                            ({{ $menu->route }})
                                        @endif
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

            {{-- Tree Container --}}
            <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 py-3 ps-3">
                    <div class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-700">
                        <div class="col-span-5">Tên menu</div>
                        <div class="col-span-4">Route</div>
                        <div class="col-span-1 text-center">ID</div>
                        <div class="col-span-1 text-center">Thứ tự</div>
                        <div></div>
                    </div>
                </div>

                <div class="min-h-[200px] p-2"
                    @dragover.prevent="if (!$wire.draggingNodeId) return; event.dataTransfer.dropEffect = 'move';"
                    @drop.prevent="$wire.handleDrop()">

                    @if ($nodes->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-gray-500">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <p class="mt-2">Chưa có menu nào</p>
                        </div>
                    @else
                        @include('catalog::system.menu-node', ['nodes' => $nodes])
                    @endif

                    {{-- Root drop zone --}}
                    <div class="mt-2"
                        @dragover="if ($wire.draggingNodeId) { $wire.setDropTarget(null, 'after'); }"
                        @dragleave="if ($wire.dropTargetId === null) { $wire.clearDropTarget(); }"
                        :class="{ 'border-2 border-dashed border-blue-400 bg-blue-50': $wire.dropTargetId === null && $wire.draggingNodeId }">
                        @if ($this->dropTargetId === null && $this->draggingNodeId)
                            <div class="p-4 text-center text-sm text-blue-600">Thả vào đây để chuyển thành menu gốc</div>
                        @endif
                    </div>
                </div>

                @if ($isSaving)
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

        {{-- SimbaERP Tree Panel (right) --}}
        @livewire('catalog::system.simba-menu-tree')
    </div>
</div>
