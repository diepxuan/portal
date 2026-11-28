<div class="w-full"
    x-data="sigroupinfoList(@js($groups->pluck('groupname')->values()))"
    x-init="init()">
    <x-head-title>{{ 'Quản lý nhóm người sử dụng - Hệ thống' }}</x-head-title>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ 'Quản lý nhóm người sử dụng' }}
            </h2>
            <p class="text-sm text-gray-600">GROUPNAME - SIGroupInfo - menu 90.20.05</p>
        </div>
    </x-slot>

    @if ($errorMessage)
        <div class="mb-3 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            {{ $errorMessage }}
        </div>
    @endif

    @if ($successMessage)
        <div class="mb-3 rounded border border-green-200 bg-green-50 p-3 text-sm text-green-700">
            {{ $successMessage }}
        </div>
    @endif

    {{-- Thanh cong cu: [search + dem nho] ... [Moi Sua Xoa Phan quyen] --}}
    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        {{-- TRAI: search + dem nho (nho, ngay sau search) --}}
        <div class="flex items-center gap-2">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Tìm theo tên nhóm, tên đầy đủ..."
                class="w-full max-w-md rounded-md border-gray-300 py-2 pl-3 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />

            <span class="whitespace-nowrap text-xs text-gray-500">
                {{ $groups->total() }} nhóm<span x-show="selected.length > 0"> · đã chọn <span x-text="selected.length"></span></span>
            </span>
        </div>

        {{-- PHAI: cac nut thao tac, Phan quyen CUOI CUNG --}}
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" wire:click="openCreate"
                class="rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">
                Mới
            </button>

            <button type="button" @click="editSelected()" :disabled="!isSingleSelected()"
                class="rounded-md bg-gray-600 px-3 py-1.5 text-sm text-white hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-40">
                Sửa
            </button>

            <button type="button" @click="deleteSelected($wire)" :disabled="selected.length === 0"
                class="rounded-md bg-red-600 px-3 py-1.5 text-sm text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-40">
                Xoá
            </button>

            {{-- Phan quyen: LUON bam duoc, khong can chon dong --}}
            <a href="{{ url('/simba/si/vch/sigroupinfo/rights') }}"
                class="rounded-md bg-green-600 px-3 py-1.5 text-sm text-white hover:bg-green-700">
                Phân quyền
            </a>
        </div>
    </div>

    {{-- Form them/sua --}}
    @if ($showForm)
        <div class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-4">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-sm font-medium text-blue-900">
                    {{ $isEdit ? 'Sửa nhóm ' . $groupName : 'Thêm nhóm mới' }}
                </h3>
                <button type="button" wire:click="cancel" class="text-xs text-blue-700 hover:text-blue-900">
                    Đóng
                </button>
            </div>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-medium text-gray-700">Tên nhóm</label>
                    <input type="text" wire:model="groupName" @disabled($isEdit)
                        maxlength="20"
                        class="mt-1 w-full rounded-md border-gray-300 font-mono text-sm uppercase shadow-sm disabled:bg-gray-100" />
                    @error('groupName')
                        <span class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700">Tên đầy đủ</label>
                    <input type="text" wire:model="fullName" maxlength="50"
                        class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm" />
                    @error('fullName')
                        <span class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model="grand" class="rounded border-gray-300" />
                        Phân lại quyền
                    </label>

                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model="ksd" class="rounded border-gray-300" />
                        KSD
                    </label>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <button type="button" wire:click="save"
                    class="rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">
                    Lưu
                </button>
                <button type="button" wire:click="cancel"
                    class="rounded-md bg-gray-200 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-300">
                    Huỷ
                </button>
            </div>
        </div>
    @endif

    {{-- Bang danh sach: 4 cot theo form goc --}}
    <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-10 border-b border-gray-200 px-3 py-2 text-center font-medium text-gray-500">
                        <input type="checkbox"
                            @change="toggleAll($event.target.checked, @js($groups->pluck('groupname')->values()))"
                            :checked="allSelected()"
                            title="Chọn tất cả trang này"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    </th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">#</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">Tên nhóm</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">Tên đầy đủ</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-center font-medium text-gray-500">Phân lại quyền</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-center font-medium text-gray-500">KSD</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($groups as $index => $group)
                    <tr wire:key="si-groupinfo-{{ $group['groupname'] }}"
                        @click="toggleRow(@js($group['groupname']))"
                        :class="isSelected(@js($group['groupname'])) ? 'bg-sky-100' : 'cursor-pointer hover:bg-sky-50'">
                        <td class="border-b border-gray-100 px-3 py-2 text-center">
                            <input type="checkbox"
                                @click.stop="toggleRow(@js($group['groupname']))"
                                :checked="isSelected(@js($group['groupname']))"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                        </td>
                        <td class="border-b border-gray-100 px-3 py-2 text-gray-500">
                            {{ $groups->firstItem() + $index }}
                        </td>
                        <td class="border-b border-gray-100 px-3 py-2 font-mono text-xs font-medium text-gray-900">
                            {{ $group['groupname'] }}
                        </td>
                        <td class="border-b border-gray-100 px-3 py-2 text-gray-700">{{ $group['fullname'] }}</td>
                        <td class="border-b border-gray-100 px-3 py-2 text-center">
                            {{ $group['grand'] ? 'x' : '' }}
                        </td>
                        <td class="border-b border-gray-100 px-3 py-2 text-center">
                            {{ $group['ksd'] ? 'x' : '' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-8 text-center text-gray-500">
                            Không tìm thấy nhóm nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $groups->links() }}
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            if (typeof window.sigroupinfoList !== 'undefined') {
                return;
            }

            /**
             * Selection NHIEU DONG do CLIENT (Alpine) quan ly.
             *
             * Moi lan click KHONG round-trip len server -> chon nhanh, khong giat.
             * Chi khi bam Sua / Xoa / Phan quyen moi goi $wire.
             */
            window.sigroupinfoList = function(pageGroups) {
                return {
                    /** @type {string[]} ma cac nhom dang chon */
                    selected: [],
                    pageGroups: (pageGroups || []).map((g) => String(g)),

                    init() {
                        // Khi Livewire re-render (sau save/delete), bo chon nhung
                        // nhom khong con tren trang.
                        this.$watch('pageGroups', () => {
                            this.selected = this.selected.filter((g) => this.pageGroups.includes(g));
                        });
                    },

                    isSelected(name) {
                        return this.selected.includes(String(name));
                    },

                    toggleRow(name) {
                        const key = String(name);
                        const i = this.selected.indexOf(key);

                        if (i >= 0) {
                            this.selected.splice(i, 1);
                        } else {
                            this.selected.push(key);
                        }
                    },

                    toggleAll(checked, names) {
                        const list = (names || []).map((n) => String(n));

                        if (checked) {
                            // Gop them, khong mat lua chon cu
                            const merged = new Set([...this.selected, ...list]);
                            this.selected = Array.from(merged);
                        } else {
                            this.selected = this.selected.filter((n) => !list.includes(n));
                        }
                    },

                    allSelected() {
                        return this.pageGroups.length > 0
                            && this.pageGroups.every((n) => this.selected.includes(n));
                    },

                    isSingleSelected() {
                        return this.selected.length === 1;
                    },

                    /** Chi cho Sua khi chon dung 1 dong (giong SimbaERP). */
                    editSelected() {
                        if (this.selected.length !== 1) {
                            return;
                        }

                        this.$wire.call('openEdit', this.selected[0]);
                    },

                    /** Xoa 1 hoac nhieu dong — qua confirm cua trinh duyet. */
                    deleteSelected(wire) {
                        if (this.selected.length === 0) {
                            return;
                        }

                        const names = [...this.selected];
                        const msg = 1 === names.length
                            ? 'Xoá nhóm ' + names[0] + '?'
                            : 'Xoá ' + names.length + ' nhóm: ' + names.join(', ') + '?';

                        if (!window.confirm(msg)) {
                            return;
                        }

                        wire.call('deleteMany', names);
                        this.selected = [];
                    },

                };
            };
        })();
    </script>
@endpush
