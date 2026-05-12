<div class="w-[360px] flex-shrink-0 rounded-lg border border-gray-200 bg-white shadow-sm"
     x-data="{
         simbaSelectMode: false,
         simbaSelectNodeId: null,
         init() {
             window.addEventListener('simba-select-mode-enter', (e) => {
                 this.simbaSelectMode = true;
                 this.simbaSelectNodeId = e.detail.nodeId;
             });
             window.addEventListener('simba-select-mode-exit', () => {
                 this.simbaSelectMode = false;
                 this.simbaSelectNodeId = null;
             });
         },
         selectMenuId(menuId) {
             if (!this.simbaSelectMode) return;
             window.dispatchEvent(new CustomEvent('simba-menu-selected', { detail: { menuId } }));
         }
     }">

    {{-- Panel Header --}}
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">SimbaERP Menus</h3>
                <p class="text-xs text-gray-500">Tham khảo sysMenu</p>
            </div>
            @if ($this->total > 0)
                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $this->total }}</span>
            @endif
        </div>

        {{-- Search --}}
        <div class="mt-2">
            <div class="relative">
                <svg class="pointer-events-none absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Tìm menu..."
                       class="w-full rounded-md border-gray-300 py-1.5 pl-8 pr-3 text-xs shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>
        </div>
    </div>

    {{-- Tree --}}
    <div class="max-h-[calc(100vh-280px)] overflow-y-auto"
         :class="{ 'simba-select-active': simbaSelectMode }">
        @forelse ($this->tree as $item)
            @include('catalog::system.simba-node', ['item' => $item])
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6" />
                </svg>
                <p class="mt-1 text-xs">
                    @if ($search) Không tìm thấy kết quả
                    @else Không có dữ liệu @endif
                </p>
            </div>
        @endforelse
    </div>

    {{-- Footer stats --}}
    <div class="border-t border-gray-200 bg-gray-50 px-4 py-2 text-xs text-gray-500">
        {{ $this->tree->count() }} menu / {{ $this->total }} total
    </div>
</div>
