@props([
    'rows'      => [],
    'module'    => 'PO',
    'createUrl' => null,
    'editUrl'   => 'po.dict.ardmkh.edit',
    'emptyMsg'  => 'Không tìm thấy đối tượng nào.',
    'pageSize'  => 50,
])

@php
    $rowsJson = json_encode($rows, JSON_UNESCAPED_UNICODE);
    // Tạo URL từ route name + module để edit; view cha truyền 'editUrl'.
    $placeholder = match ($module) {
        'SO' => 'Tìm theo mã, tên, địa chỉ, điện thoại...',
        'CA' => 'Tìm theo mã, tên, địa chỉ, điện thoại, mã số thuế...',
        default => 'Tìm theo mã, tên, địa chỉ, điện thoại, mã số thuế...',
    };
    $createLabel = match ($module) {
        'SO' => '+ Thêm khách hàng',
        'CA' => '+ Thêm nhân viên',
        default => '+ Thêm nhà cung cấp',
    };
@endphp

<div class="ardmkh-list-container w-full"
     x-data="ardmkhListComponent(@js($rowsJson), @js($editUrl), @js($pageSize))"
     x-init="initComponent()">
    <div class="mt-4 flex flex-wrap items-center gap-4">
        <div class="relative w-full max-w-md">
            <input type="text" x-model="search" @input.debounce.150ms="onSearch()"
                placeholder="{{ $placeholder }}"
                class="w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            <button type="button" x-show="search.length > 0" @click="clearSearch()"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 hover:text-gray-600"
                style="display: none;">Xóa</button>
        </div>
        <span class="text-xs text-gray-500" x-text="resultLabel"></span>
    </div>

    <div class="mb-3 flex justify-end">
        @if ($createUrl)
            <a href="{{ $createUrl }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">{{ $createLabel }}</a>
        @endif
    </div>

    <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">#</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">
                        @if ($module === 'CA') Mã NV @elseif ($module === 'SO') Mã KH @else Mã NCC @endif
                    </th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">
                        @if ($module === 'CA') Tên nhân viên @elseif ($module === 'SO') Tên khách hàng @else Tên nhà cung cấp @endif
                    </th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">Địa chỉ</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">Điện thoại</th>
                    <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">Người GD</th>
                    @if ($module !== 'CA')
                        <th class="border-b border-gray-200 px-3 py-2 text-left font-medium text-gray-500">
                            @if ($module === 'SO') Nhóm KH @else HTTT mua @endif
                        </th>
                    @endif
                    <th class="border-b border-gray-200 px-3 py-2 text-right font-medium text-gray-500">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(row, index) in paginated" :key="row.ma_kh">
                    <tr class="hover:bg-sky-50">
                        <td class="border-b border-gray-100 px-3 py-2 text-gray-500" x-text="(page - 1) * pageSize + index + 1"></td>
                        <td class="border-b border-gray-100 px-3 py-2 font-mono text-xs" x-text="row.ma_kh"></td>
                        <td class="border-b border-gray-100 px-3 py-2"><span class="font-medium text-gray-900" x-text="row.ten_kh"></span></td>
                        <td class="border-b border-gray-100 px-3 py-2 text-gray-600" x-text="truncate(row.dia_chi, 40)"></td>
                        <td class="border-b border-gray-100 px-3 py-2 text-gray-600" x-text="row.tel"></td>
                        <td class="border-b border-gray-100 px-3 py-2 text-gray-600" x-text="row.nguoi_gd"></td>
                        @if ($module !== 'CA')
                            <td class="border-b border-gray-100 px-3 py-2 text-gray-600" x-text="row.{{ $module === 'SO' ? 'ma_nhkh' : 'ma_httt_po' }}"></td>
                        @endif
                        <td class="border-b border-gray-100 px-3 py-2 text-right">
                            <div class="flex justify-end gap-2">
                                <a :href="editUrlFor(row)" class="rounded bg-yellow-100 px-2 py-1 text-xs text-yellow-700 hover:bg-yellow-200">Sửa</a>
                                <button type="button"
                                    @click="$wire.deleteDoiTuong(row.ma_kh)"
                                    :wire:confirm="'Bạn có chắc chắn muốn xóa ' + row.ten_kh + ' (' + row.ma_kh + ')?'"
                                    class="rounded bg-red-100 px-2 py-1 text-xs text-red-700 hover:bg-red-200">Xóa</button>
                            </div>
                        </td>
                    </tr>
                </template>
                <template x-if="filtered.length === 0">
                    <tr><td colspan="{{ $module === 'CA' ? 7 : 8 }}" class="px-3 py-8 text-center text-gray-500">{{ $emptyMsg }}</td></tr>
                </template>
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
        <span>Trang <span x-text="page"></span> / <span x-text="totalPages"></span></span>
        <div class="flex gap-2">
            <button type="button" @click="prevPage()" :disabled="page <= 1"
                class="rounded border border-gray-300 px-3 py-1 disabled:cursor-not-allowed disabled:opacity-50 hover:bg-gray-50">Trước</button>
            <button type="button" @click="nextPage()" :disabled="page >= totalPages"
                class="rounded border border-gray-300 px-3 py-1 disabled:cursor-not-allowed disabled:opacity-50 hover:bg-gray-50">Sau</button>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    (function () {
        if (typeof window.ardmkhListComponent !== 'undefined') {
            return;
        }

        window.ardmkhListComponent = function (rows, editRouteName, pageSize) {
            return {
                rows: Array.isArray(rows) ? rows : [],
                editRouteName: editRouteName || 'po.dict.ardmkh.edit',
                pageSize: parseInt(pageSize, 10) || 50,
                search: '',
                page: 1,
                filtered: [],
                paginated: [],
                totalPages: 1,
                resultLabel: '0 kết quả',
                routeCache: {}, // ma_kh -> href

                initComponent() {
                    this.recompute();
                },

                onSearch() {
                    this.page = 1;
                    this.recompute();
                },

                clearSearch() {
                    this.search = '';
                    this.onSearch();
                },

                prevPage() {
                    if (this.page > 1) {
                        this.page -= 1;
                        this.recompute(true);
                    }
                },

                nextPage() {
                    if (this.page < this.totalPages) {
                        this.page += 1;
                        this.recompute(true);
                    }
                },

                recompute(skipSlice) {
                    const needle = this.normalize(this.search);
                    this.filtered = !needle
                        ? this.rows.slice()
                        : this.rows.filter((row) => {
                            const haystack = [
                                row.ma_kh, row.ten_kh, row.dia_chi,
                                row.tel, row.ma_so_thue, row.nguoi_gd,
                            ].map((v) => this.normalize(v || '')).join(' \x1f ');
                            return haystack.indexOf(needle) !== -1;
                        });

                    this.totalPages = Math.max(1, Math.ceil(this.filtered.length / this.pageSize));
                    if (this.page > this.totalPages) {
                        this.page = this.totalPages;
                    }

                    const start = (this.page - 1) * this.pageSize;
                    this.paginated = skipSlice
                        ? this.filtered.slice(start, start + this.pageSize)
                        : this.filtered.slice(0, start + this.pageSize);

                    const total = this.rows.length;
                    this.resultLabel = this.filtered.length === total
                        ? total + ' kết quả'
                        : this.filtered.length + ' / ' + total + ' kết quả';
                },

                normalize(value) {
                    if (!value) return '';
                    return String(value)
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '')
                        .replace(/[đĐ]/g, (c) => c === 'đ' ? 'd' : 'D')
                        .toLowerCase()
                        .replace(/\s+/g, ' ')
                        .trim();
                },

                truncate(value, max) {
                    const v = String(value || '');
                    return v.length > max ? v.slice(0, max - 1) + '…' : v;
                },

                editUrlFor(row) {
                    if (!row || !row.ma_kh) return '#';
                    if (this.routeCache[row.ma_kh]) return this.routeCache[row.ma_kh];
                    const base = (typeof window.Ziggy !== 'undefined' && window.Ziggy.routes
                        ? window.Ziggy.routes[this.editRouteName]
                        : null);
                    const href = (typeof window.route === 'function')
                        ? window.route(this.editRouteName, { id: row.ma_kh })
                        : (base ? base.uri.replace(/\/+$/, '').replace(/\{.*?\}/g, encodeURIComponent(row.ma_kh)) : '#');
                    this.routeCache[row.ma_kh] = href;
                    return href;
                },
            };
        };
    })();
</script>
@endpush
@endonce
