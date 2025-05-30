<div class="phieuthu-container w-full">
    <x-head-title>{{ __('Tiền tệ') }}</x-head-title>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiền mặt') }}
        </h2>
        <p>{{ __('Phiếu thu') }}</p>
    </x-slot>

    <div class="grid grid-cols-3 gap-4 items-center pt-1">
        <label class="text-right">Kỳ báo cáo</label>
        <div class="col-span-2">
            @livewire('catalog::component.timer')
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 items-center pt-1">
        <label class="text-right">Danh sách tài khoản nợ</label>
        <input class="col-span-2 border-gray-300 rounded-md shadow-sm py-1" wire:model="pTk_List" />
    </div>

    <div class="grid grid-cols-3 gap-4 items-center pt-1">
        <label class="text-right">Danh sách tài khoản có</label>
        <input class="col-span-2 border-gray-300 rounded-md shadow-sm py-1" wire:model="pTkdu_List" />
    </div>

    <div class="grid grid-cols-3 gap-4 items-center pt-1">
        <label class="text-right">Mã bộ phận</label>
        <input class="col-span-2 border-gray-300 rounded-md shadow-sm py-1" wire:model="pMa_Bp" />
    </div>

    <div class="grid grid-cols-3 gap-4 items-center pt-1">
        <label class="text-right">Mã ngoại tệ</label>
        <input class="col-span-2 border-gray-300 rounded-md shadow-sm py-1" wire:model="pMa_Nt" />
    </div>

    <div class="flex justify-end pt-1">
        <button class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700" wire:click="submit">
            Thực hiện
        </button>
    </div>
</div>
