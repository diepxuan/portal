<div class="phieuthu-container w-full">
    <x-head-title>{{ 'Phiếu chi - Tiền tệ' }}</x-head-title>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ 'Tiền mặt' }}
        </h2>
        <p>{{ 'Phiếu chi' }}</p>
    </x-slot>

    <div class="grid grid-cols-3 items-center gap-4 pt-1">
        <label class="text-right">Kỳ báo cáo</label>
        <div class="col-span-2">
            @livewire('catalog::component.timer')
        </div>
    </div>

    <div class="grid grid-cols-3 items-center gap-4 pt-1">
        <label class="text-right">Danh sách tài khoản nợ</label>
        <input class="col-span-2 rounded-md border-gray-300 py-1 shadow-sm" wire:model="pTk_List" />
    </div>

    <div class="grid grid-cols-3 items-center gap-4 pt-1">
        <label class="text-right">Danh sách tài khoản có</label>
        <input class="col-span-2 rounded-md border-gray-300 py-1 shadow-sm" wire:model="pTkdu_List" />
    </div>

    <div class="grid grid-cols-3 items-center gap-4 pt-1">
        <label class="text-right">Mã bộ phận</label>
        <input class="col-span-2 rounded-md border-gray-300 py-1 shadow-sm" wire:model="pMa_Bp" />
    </div>

    <div class="grid grid-cols-3 items-center gap-4 pt-1">
        <label class="text-right">Mã ngoại tệ</label>
        <input class="col-span-2 rounded-md border-gray-300 py-1 shadow-sm" wire:model="pMa_Nt" />
    </div>

    <div class="flex justify-end pt-1">
        <button class="rounded-md bg-blue-600 px-2 py-1 text-white hover:bg-blue-700" wire:click="submit">
            Thực hiện
        </button>
    </div>

    @isset($glCts)
        <table class="mt-3 w-full border border-gray-200 text-xs">
            <thead>
                <tr>
                    <th class="border border-gray-200 px-1 text-left">Ngày chứng từ</th>
                    <th class="border border-gray-200 px-1 text-left">Số chứng từ</th>
                    {{-- <th class="border border-gray-200 text-left px-1">Ngày lập</th> --}}
                    <th class="border border-gray-200 px-1 text-left">Diễn giải</th>
                    <th class="border border-gray-200 px-1 text-left">Khách hàng</th>
                    <th class="border border-gray-200 px-1 text-left">TK ghi nợ</th>
                    <th class="border border-gray-200 px-1 text-left">TK ghi có</th>
                    <th class="border border-gray-200 px-1 text-left">Số phát sinh</th>
                    <th class="border border-gray-200 px-1 text-left">Mã CT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($glCts ?? [] as $glCt)
                    <tr @class([
                        'hover:bg-sky-100',
                        'text-blue-700 hover:bg-sky-100 border border-gray-200' => $glCt->bold,
                    ])>
                        <td class="border border-gray-200 px-1">{{ $glCt->ngay_ct }}</td>
                        <td class="border border-gray-200 px-1">{{ $glCt->so_ct }}</td>
                        {{-- <td class="border border-gray-200 px-1">{{ $glCt->ngay_lct }}</td> --}}
                        <td class="border border-gray-200 px-1">
                            <pre>{{ $glCt->dien_giai }}</pre>
                        </td>
                        <td class="border border-gray-200 px-1">{{ $glCt->arDmKh?->ten_kh }}</td>
                        <td class="border border-gray-200 px-1">{{ $glCt->tk }}</td>
                        <td class="border border-gray-200 px-1">{{ $glCt->tk_du }}</td>
                        <td class="border border-gray-200 px-1 text-right">@currency($glCt->ps_no)</td>
                        <td class="border border-gray-200 px-1">{{ $glCt->ma_ct }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset

</div>
