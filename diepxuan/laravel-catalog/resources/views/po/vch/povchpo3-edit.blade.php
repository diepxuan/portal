<div>
    <x-head-title>{{ ($mode === 'create' ? 'Them' : 'Sua') . ' hoa don mua hang (PO3)' }}</x-head-title>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ ($mode === 'create' ? 'Them moi' : 'Sua') . ' hoa don mua hang' }}
                </h2>
                <p>Chung tu: PO3 - Hoa don mua hang trong nuoc</p>
            </div>
            <a href="{{ route('po.vch.povchpo3') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                Quay lai
            </a>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-xs">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-xs">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <x-nav-tabs :default-tab="'chitiet'">
            <x-slot:nav>
                <li class="mr-2">
                    <a href="#" x-on:click.prevent="activeTab = 'chitiet'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'chitiet', 'border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'chitiet' }"
                        class="inline-block rounded-t-lg border-b-2 p-4">
                        Thong tin chung + Chi tiet
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#" x-on:click.prevent="activeTab = 'chiphi'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'chiphi', 'border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'chiphi' }"
                        class="inline-block rounded-t-lg border-b-2 p-4">
                        Chi phi
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#" x-on:click.prevent="activeTab = 'hachtoan'"
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'hachtoan', 'border-transparent hover:text-gray-600 hover:border-gray-300': activeTab !== 'hachtoan' }"
                        class="inline-block rounded-t-lg border-b-2 p-4">
                        Hach toan (deferred)
                    </a>
                </li>
            </x-slot:nav>

            <x-slot:content>
                <div x-show="activeTab === 'chitiet'" class="space-y-3 pt-2">
                    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">Thong tin chung</h3>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ngay chung tu <span class="text-red-500">*</span></label>
                        <div class="col-span-2">
                            <input type="date" wire:model="pNgay_ct" required
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error for="pNgay_ct" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ngay lap CT</label>
                        <div class="col-span-2">
                            <input type="date" wire:model="pNgay_lct"
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error for="pNgay_lct" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">So chung tu</label>
                        <div class="col-span-2">
                            <input type="text" wire:model="pSo_ct"
                                class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm shadow-sm" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ma ngoai te</label>
                        <div class="col-span-2">
                            <input wire:model="pMa_nt"
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="VND" />
                            <x-input-error for="pMa_nt" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ty gia</label>
                        <div class="col-span-2">
                            <input type="number" step="0.0001" wire:model="pTy_gia"
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">So hoa don <span class="text-red-500">*</span></label>
                        <div class="col-span-2">
                            <input type="text" wire:model="pSo_hd" required
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error for="pSo_hd" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ngay hoa don <span class="text-red-500">*</span></label>
                        <div class="col-span-2">
                            <input type="date" wire:model="pNgay_hd" required
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error for="pNgay_hd" class="mt-1" />
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2 pt-4">Nha cung cap</h3>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ma NCC <span class="text-red-500">*</span></label>
                        <div class="col-span-2">
                            <livewire:catalog::component.input-khachhang mode="nhacungcap" wire:model.live="pMa_kh" />
                            <x-input-error for="pMa_kh" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ten NCC</label>
                        <div class="col-span-2">
                            <input wire:model="pTen_kh"
                                class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm shadow-sm" readonly />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Dia chi</label>
                        <div class="col-span-2">
                            <input wire:model="pDia_chi"
                                class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm shadow-sm" readonly />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Ma so thue</label>
                        <div class="col-span-2">
                            <input wire:model="pMa_so_thue"
                                class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm shadow-sm" readonly />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Nguoi giao dich</label>
                        <div class="col-span-2">
                            <input wire:model="pNguoi_gd"
                                class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm shadow-sm" readonly />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Hinh thuc TT</label>
                        <div class="col-span-2">
                            <input wire:model="pMa_httt" class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ma HTTT (deferred lookup)"/>
                            <x-input-error for="pMa_httt" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">TK phai tra</label>
                        <div class="col-span-2">
                            <livewire:catalog::component.input-taikhoan wire:model="pTk_pt" />
                            <x-input-error for="pTk_pt" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">TK thue</label>
                        <div class="col-span-2">
                            <livewire:catalog::component.input-taikhoan wire:model="pTk_thue" />
                            <x-input-error for="pTk_thue" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-right text-sm text-gray-700">Dien giai</label>
                        <div class="col-span-2">
                            <textarea wire:model="pDien_giai" rows="2"
                                class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2 pt-4">Chi tiet vat tu</h3>
                    @include('catalog::po.vch._grid-chitiet')
                </div>

                <div x-show="activeTab === 'chiphi'" class="space-y-3 pt-2">
                    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">Chi phi mua hang</h3>
                    @include('catalog::po.vch._grid-chiphi')
                </div>

                <div x-show="activeTab === 'hachtoan'" class="space-y-3 pt-2">
                    <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">Hach toan (deferred)</h3>
                    <p class="text-sm text-gray-600">Tab hach toan se duoc bo sung o phase tiep theo. Tham khao POVchPO3.md section 6.3 de xac dinh auto-gen logic.</p>
                </div>
            </x-slot:content>
        </x-nav-tabs>

        <div class="mt-4 flex justify-end gap-2 border-t border-gray-200 pt-3">
            <a href="{{ route('po.vch.povchpo3') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                Huy
            </a>
            <x-button-loading
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                wire:click="submit">
                Luu hoa don
            </x-button-loading>
        </div>
    </form>
</div>
