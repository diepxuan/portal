<div class="w-full">
    <x-head-title>{{ 'Phân quyền nhóm người sử dụng - Hệ thống' }}</x-head-title>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Phân quyền</h2>
            <p class="text-sm text-gray-600">
                Nhóm <span class="font-mono font-medium">{{ $groupName }}</span> — menu 90.20.05 — frmSiSetRights
            </p>
        </div>
    </x-slot>

    @if ($errorMessage)
        <div class="mb-3 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">{{ $errorMessage }}</div>
    @endif

    @if ($successMessage)
        <div class="mb-3 rounded border border-green-200 bg-green-50 p-3 text-sm text-green-700">{{ $successMessage }}</div>
    @endif

    {{-- 2 combo: Phan he + So lieu (theo form goc) --}}
    <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-[160px_minmax(0,520px)] md:items-center">
        <label class="text-sm text-gray-700">Phân hệ</label>
        <select wire:model.live="mainMenuId"
            class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @foreach ($mainMenus as $menu)
                <option value="{{ $menu['MenuID'] }}">{{ $menu['bar'] }}</option>
            @endforeach
        </select>

        <label class="text-sm text-gray-700">Số liệu</label>
        <select wire:model.live="subMenuId"
            class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @forelse ($subMenuOptions as $menu)
                <option value="{{ $menu['MenuID'] }}">{{ $menu['bar'] }}</option>
            @empty
                <option value="">— không có —</option>
            @endforelse
        </select>
    </div>

    {{-- Bang chuc nang + 4 quyen --}}
    <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="max-h-[calc(100vh-380px)] overflow-auto">
            <table class="w-full text-sm">
                <thead class="sticky top-0 bg-gray-50">
                    <tr>
                        <th class="border-b border-gray-200 px-3 py-2 text-right font-medium text-gray-500">#</th>
                        <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">Chức năng</th>
                        <th class="border-b border-gray-200 px-2 py-2 text-center font-medium text-gray-500">Xem</th>
                        <th class="border-b border-gray-200 px-2 py-2 text-center font-medium text-gray-500">Thêm</th>
                        <th class="border-b border-gray-200 px-2 py-2 text-center font-medium text-gray-500">Sửa</th>
                        <th class="border-b border-gray-200 px-2 py-2 text-center font-medium text-gray-500">Xoá</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filteredRights as $index => $row)
                        <tr class="hover:bg-sky-50" wire:key="right-{{ $row['MenuID'] }}">
                            <td class="border-b border-gray-100 px-3 py-1.5 text-right text-xs text-gray-400">
                                {{ $index + 1 }}
                            </td>
                            <td class="border-b border-gray-100 px-3 py-1.5">
                                <span class="font-medium text-gray-800">{{ $row['Bar'] }}</span>
                                <span class="ml-2 font-mono text-xs text-gray-400">{{ $row['MenuID'] }}</span>
                            </td>
                            @foreach (['ViewRight', 'InsertRight', 'UpdateRight', 'DeleteRight'] as $column)
                                <td class="border-b border-gray-100 px-2 py-1.5 text-center">
                                    <input type="checkbox"
                                        wire:click="toggleRight('{{ $row['MenuID'] }}', '{{ $column }}')"
                                        @checked($row[$column])
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-8 text-center text-gray-500">
                                Không có chức năng nào cho phân hệ / số liệu đang chọn.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-3 py-2">
            <span class="text-xs text-gray-500">{{ count($filteredRights) }} chức năng</span>
            <div class="flex items-center gap-2">
                <button type="button" wire:click="save"
                    class="rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">
                    Lưu
                </button>
                <a href="{{ url('/simba/si/vch/sigroupinfo') }}"
                    class="rounded-md bg-gray-200 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-300">
                    Thoát
                </a>
            </div>
        </div>
    </div>
</div>
