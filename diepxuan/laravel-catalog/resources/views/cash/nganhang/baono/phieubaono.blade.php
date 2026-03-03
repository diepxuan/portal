<div class="grid grid-cols-1 items-start gap-1 pb-3 md:grid-cols-3">
    <div class="">
        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Mã KH</label>
            <div class="col-span-3">
                <div class="relative">
                    <input type="text"
                        class="block w-full rounded-md border-gray-300 py-0 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        list="ArDmKh-suggestions" wire:model="pMa_Kh" wire:change="updateKhachHang" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Diễn giải</label>
            <input class="col-span-3 rounded-md border-gray-300 py-0 text-sm shadow-sm" wire:model="pDien_Giai" />
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Địa chỉ</label>
            <input class="col-span-3 rounded-md border-gray-300 py-0 text-sm shadow-sm" wire:model="pDia_Chi" />
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Người GD</label>
            <input class="col-span-3 rounded-md border-gray-300 py-0 text-sm shadow-sm" wire:model="pNguoi_Gd" />
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">TK có</label>
            <div class="col-span-3">
                <livewire:catalog::component.input-taikhoan wire:model="pTk_Co" />
            </div>
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Số CTừ</label>
            <input class="col-span-3 rounded-md border-gray-300 py-0 text-sm shadow-sm" wire:model="pSo_Ct" />
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Ngày CTừ</label>
            <div class="col-span-3">
                <x-input-date class="block w-full px-2 py-0 text-sm" wire:model="pNgay_Ct" />
            </div>
        </div>

        <div class="grid grid-cols-4 items-center gap-4 pt-1">
            <label class="text-right">Ngày lập</label>
            <div class="col-span-3">
                <x-input-date class="block w-full px-2 py-0 text-sm" wire:model="pNgay_Lap" />
            </div>
        </div>
    </div>

    <div class="mt-4 md:col-span-2">
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 36v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                TK Nợ
                            </div>
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Diễn giải
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Số dư
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Số tiền
                        </th>
                        <th scope="col"
                            class="w-12 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($pCts as $index => $row)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3">
                                <livewire:catalog::component.input-taikhoan
                                    wire:model="pCts.{{ $index }}.ma_tk"
                                    :key="'tk-no-' . $index" />
                            </td>
                            <td class="px-4 py-3">
                                <input type="text"
                                    class="block w-full rounded-md border-gray-200 bg-gray-50 px-3 py-1.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                    wire:model="pCts.{{ $index }}.dien_giai" readonly>
                            </td>
                            <td class="px-4 py-3 text-right">
                                @php
                                    $soDuDong = $pSoDuCts[$index] ?? 0;
                                @endphp
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $soDuDong >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ number_format($soDuDong, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number"
                                    class="block w-full rounded-md border-gray-200 px-3 py-1.5 text-right text-sm shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                    wire:model.lazy="pCts.{{ $index }}.ps_no"
                                    wire:keydown.enter="handleEnter({{ $index }})"
                                    placeholder="0">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="removeRow({{ $index }})"
                                    class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-150"
                                    title="Xóa dòng">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <td colspan="3"
                            class="px-4 py-3 text-right text-sm font-bold uppercase tracking-wider text-gray-700">
                            Tổng cộng:
                        </td>
                        <td class="px-4 py-3 text-right">
                            <span class="text-lg font-bold text-indigo-600">
                                {{ number_format($pTong_Ps_No, 0, ',', '.') }}
                            </span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <button wire:click="addRow"
                class="inline-flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-medium text-blue-700 shadow-sm hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm dòng
            </button>

            <div class="flex items-center gap-3">
                @if (session()->has('message'))
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1.5 text-sm font-medium text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('message') }}
                    </span>
                @endif

                <button wire:click="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Lưu phiếu
                </button>
            </div>
        </div>

        @error('pCts')
            <div class="mt-3 rounded-md bg-red-50 border border-red-200 p-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @enderror
    </div>

    <datalist id="ArDmKh-suggestions">
        @foreach ($arDmKhs as $arDmKh)
            <option value="{{ $arDmKh->ma_kh }}">{{ $arDmKh->ten_kh }}</option>
        @endforeach
    </datalist>
</div>
