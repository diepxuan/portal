<x-app-layout>
    <x-head-title>{{ __('Hệ Thống') }}</x-head-title>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hệ Thống') }}
        </h2>
        <p>{{ __('Quản lý người dùng') }}</p>
    </x-slot>

    <table class="table-auto w-full border border-gray-200 divide-y divide-gray-200 text-left text-sm">
        <tr class="border border-gray-200">
            <th class="px-4">Tên đăng nhập</th>
            <th class="px-4">Tên đầy đủ</th>
            <th class="px-4">Quản trị</th>
            <th class="px-4">Không sử dụng</th>
        </tr>
        @foreach ($sysUsers as $sysUser)
            <tr class="border border-gray-200">
                <td class="px-4">{{ $sysUser->username }}</td>
                <td class="px-4">{{ $sysUser->fullname }}</td>
                <td class="text-center">
                    <x-checkbox :checked="$sysUser->isadmin" />
                </td>
                <td class="text-center">
                    <x-checkbox :checked="$sysUser->disabled" />
                </td>
                <td class="text-center">
                    <x-select :placeholder="__('None')" :options="$users" class="py-1" />
                    {{-- <x-catalog::select :placeholder="__('Select User')" :options="$users" /> --}}
                    {{-- :selected="$sysUser->id"  --}}
                </td>
            </tr>
        @endforeach
    </table>
</x-app-layout>
