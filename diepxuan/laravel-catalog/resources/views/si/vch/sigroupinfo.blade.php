<div class="w-full">
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

    {{-- Thanh cong cu: tim kiem + nut theo form goc --}}
    <div class="mt-4 flex flex-wrap items-center gap-3">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Tìm theo tên nhóm, tên đầy đủ..."
            class="w-full max-w-md rounded-md border-gray-300 py-2 pl-3 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />

        <button type="button" wire:click="openCreate"
            class="rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">
            Mới
        </button>

        {{-- 3 nut thao tac len DONG DANG CHON (giong thanh cong cu SimbaERP) --}}
        <button type="button" wire:click="openEdit('{{ $selectedGroupName }}')"
            @disabled(null === $selectedGroupName)
            class="rounded-md bg-gray-600 px-3 py-1.5 text-sm text-white hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-40">
            Sửa
        </button>

        <button type="button" wire:click="delete('{{ $selectedGroupName }}')"
            wire:confirm="Xoá nhóm {{ $selectedGroupName }}?"
            @disabled(null === $selectedGroupName)
            class="rounded-md bg-red-600 px-3 py-1.5 text-sm text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-40">
            Xoá
        </button>

        @if (null !== $this->selectedRightsUrl())
            <a href="{{ $this->selectedRightsUrl() }}"
                class="rounded-md bg-emerald-600 px-3 py-1.5 text-sm text-white hover:bg-emerald-700">
                Phân quyền
            </a>
        @else
            <span class="rounded-md bg-emerald-600 px-3 py-1.5 text-sm text-white opacity-40">
                Phân quyền
            </span>
        @endif

        <span class="text-xs text-gray-500">
            {{ $groups->total() }} nhóm
            @if (null !== $selectedGroupName)
                · đang chọn <span class="font-mono font-medium text-gray-700">{{ $selectedGroupName }}</span>
            @endif
        </span>
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
                        wire:click="selectGroup('{{ $group['groupname'] }}')"
                        @class([
                            'cursor-pointer hover:bg-sky-50',
                            'bg-sky-100' => $selectedGroupName === $group['groupname'],
                        ])>
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
                        <td colspan="5" class="px-3 py-8 text-center text-gray-500">
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
