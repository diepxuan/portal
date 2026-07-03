<div>
    <x-nav-tabs default-tab="filter">
        <x-slot:nav>
            <li class="mr-2">
                <a href="#" x-on:click.prevent="activeTab = 'filter'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'filter', 'border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'filter' }"
                    class="inline-block rounded-t-lg border-b-2 p-4">
                    Điều kiện lọc
                </a>
            </li>
            <li class="mr-2">
                <a href="#" x-on:click.prevent="activeTab = 'content'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'content', 'border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'content' }"
                    class="inline-block rounded-t-lg border-b-2 p-4">
                    Kết quả
                </a>
            </li>
        </x-slot:nav>

        <x-slot:content>
            <div x-show="activeTab === 'filter'" class="space-y-3 pt-2">
                <div class="grid grid-cols-3 items-center gap-4">
                    <label class="text-right text-sm text-gray-700">Tiêu đề</label>
                    <input class="col-span-2 rounded-md border-gray-300 py-1 text-sm shadow-sm" wire:model="pTieu_de" />
                </div>

                <div class="grid grid-cols-3 items-center gap-4">
                    <label class="text-right text-sm text-gray-700">Thời gian</label>
                    <div class="col-span-2">
                        @livewire('catalog::component.timer', key('arrptbccn01-timer'))
                        <x-input-error for="pNgay1" class="mt-1" />
                        <x-input-error for="pNgay2" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-3 items-center gap-4">
                    <label class="text-right text-sm text-gray-700">Tài khoản</label>
                    <div class="col-span-2">
                        <livewire:catalog::component.input-taikhoan wire:model="pTk" />
                        <x-input-error for="pTk" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-3 items-center gap-4">
                    <label class="text-right text-sm text-gray-700">Mã khách hàng</label>
                    <div class="col-span-2">
                        <livewire:catalog::component.input-khachhang mode="khachhang" wire:model="pMa_kh" />
                        <x-input-error for="pMa_kh" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-3 items-center gap-4">
                    <label class="text-right text-sm text-gray-700">Mã ngoại tệ</label>
                    <div class="col-span-2">
                        <input class="w-full rounded-md border-gray-300 py-1 text-sm shadow-sm" wire:model="pMa_nt" placeholder="Để trống = VND" />
                        <x-input-error for="pMa_nt" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-3 items-center gap-4 pt-1">
                    <span></span>
                    <div class="col-span-2">
                        <x-button-loading class="rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700"
                            wire:click="submit" x-on:click="activeTab = 'content'">
                            Thực hiện
                        </x-button-loading>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'content'" class="w-full overflow-x-auto py-2">
                @if ($errorMessage)
                    <div class="mb-3 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        {{ $errorMessage }}
                    </div>
                @endif

                @if ([] === $rows)
                    <div class="rounded border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600">
                        Chưa có dữ liệu. Nhập điều kiện lọc rồi bấm Thực hiện.
                    </div>
                @else
                    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                        <table class="min-w-max text-left text-xs">
                            <thead class="sticky top-0 z-10 bg-gray-50 text-gray-500">
                                <tr>
                                    <th class="border-b border-gray-200 px-2 py-2 text-right font-medium">#</th>
                                    @foreach ($columns as $column)
                                        <th class="whitespace-nowrap border-b border-gray-200 px-2 py-2 font-medium {{ $this->isNumericColumn($column) ? 'text-right' : 'text-left' }}">
                                            {{ $column }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($rows as $row)
                                    <tr class="hover:bg-sky-50">
                                        <td class="whitespace-nowrap px-2 py-2 text-right font-mono text-gray-400 tabular-nums">
                                            {{ $loop->iteration }}
                                        </td>
                                        @foreach ($columns as $column)
                                            <td class="whitespace-nowrap px-2 py-2 text-gray-800 {{ $this->isNumericColumn($column) ? 'text-right font-mono tabular-nums' : '' }}">
                                                {{ $this->displayValue(data_get($row, $column)) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </x-slot:content>
    </x-nav-tabs>
</div>
