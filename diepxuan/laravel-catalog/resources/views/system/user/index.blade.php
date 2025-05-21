<x-catalog::app-layout>
    <x-catalog::head-title>{{ __('Hệ Thống') }}</x-catalog::head-title>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hệ Thống') }}
        </h2>
        <p>{{ __('Quản lý người dùng') }}</p>
    </x-slot>

    <table class="table-auto w-full border border-gray-200 divide-y divide-gray-200">
        <tr class="border border-gray-200">
            <th class="text-left">Tên đăng nhập</th>
            <th class="text-left">Tên đầy đủ</th>
            <th>Quản trị</th>
            <th>Không sử dụng</th>
        </tr>
        @foreach ($users as $user)
            <tr class="border border-gray-200">
                <td>{{ $user->username }}</td>
                <td>{{ $user->fullname }}</td>
                <td class="text-center">
                    <input class="appearance-none" type="checkbox" {{ $user->isadmin ? 'checked' : '' }} />
                </td>
                <td class="text-center">
                    <input class="appearance-none" type="checkbox" {{ $user->disabled ? 'checked' : '' }} />
                </td>
            </tr>
        @endforeach
    </table>

</x-catalog::app-layout>
