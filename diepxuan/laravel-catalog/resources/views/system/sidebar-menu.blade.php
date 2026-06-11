<div x-data="{ collapsed: false }" class="fixed left-0 top-0 z-40 h-screen w-16 transition-all duration-200 print:hidden md:w-64">

    {{-- Toggle handle --}}
    <button type="button"
            @click="collapsed = !collapsed"
            class="absolute -right-3 top-8 flex h-6 w-6 items-center justify-center rounded-full border border-gray-700 bg-gray-900 text-gray-400 shadow-sm hover:bg-gray-800 hover:text-white transition-all"
            aria-label="{{ __('Toggle Sidebar') }}">
        <svg class="h-4 w-4 transition-transform duration-150" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    {{-- Main navigation --}}
    <nav class="flex h-full flex-col overflow-y-auto overflow-x-hidden"
         :class="{ 'w-16': collapsed, 'w-64': !collapsed }">

        {{-- Collapse indicator (left only) --}}
        <div class="sticky top-0 z-10 flex items-center px-3 py-2"
             x-show="collapsed"
             x-transition.opacity.duration.150ms>
            <span class="text-xs font-medium text-gray-500">{{ __('Simba') }}</span>
        </div>

        {{-- Modules tree --}}
        @foreach ($tree as $module)
            @php
                // Single item module or group container?
                $firstChild = empty($module['children']) ? null : $module['children'][0] ?? null;
                $childHasRoute = isset($firstChild) && isset($firstChild['hasRoute']) && $firstChild['hasRoute'];
                $isActiveModule = isset($module['isActive']) && $module['isActive'];
            @endphp
            @if (empty($module['children']))
                {{-- Single-item module (no children) --}}
                @if ($module['hasRoute'])
                    <a href="{{ route($module['route']) }}"
                       data-sidebar-module="{{ $module['menuid'] }}"
                       :class="{ 'bg-blue-900/60 border-r-2 border-blue-400': $isActiveModule, 'text-gray-400 hover:bg-gray-800 hover:text-gray-200': !$isActiveModule }"
                       class="group flex items-center gap-2 rounded-r-md px-2 py-1.5 text-sm transition-colors"
                       title="{{ __($module['name']) }} ({{ $module['moduleid'] }})">
                        <span class="text-[10px] text-gray-600">{{ Str::substr($module['moduleid'], 0, 1) }}</span>
                        <span x-show="!collapsed" class="truncate text-xs">{{ __($module['name']) }}</span>
                    </a>
                @endif
            @else
                {{-- Module with children – expandable group --}}
                <div>
                    {{-- Module root button --}}
                    <button type="button"
                            data-sidebar-group="{{ $module['menuid'] }}"
                            class="flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-left text-sm transition-colors hover:bg-gray-800"
                            :class="{ 'bg-blue-900/40 text-blue-300': $isActiveModule, 'text-gray-300 hover:text-gray-100': !$isActiveModule }"
                            x-on:click="$dispatch('sidebar-expand', '{{ $module['menuid'] }}')">
                        <svg class="h-3.5 w-3.5 flex-shrink-0 text-gray-500 transition-transform duration-150"
                             style="transform: rotate(90deg)"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span x-show="!collapsed" class="flex-1 truncate font-semibold tracking-wide uppercase text-gray-300">
                            {{ __($module['name']) }}
                        </span>
                        <span x-show="!collapsed" class="hidden md:inline-flex rounded bg-gray-700 px-1.5 py-0.5 text-[10px] font-mono text-gray-400">
                            {{ substr($module['moduleid'], 0, 2) }}
                        </span>
                    </button>

                    {{-- Children groups/items (collapsible) --}}
                    <div x-data="{ expanded: false }"
                         x-init="$watch('expanded', val => { localStorage.setItem('{{ $module["menuid"] }}SidebarExpanded', String(val)); expanded = JSON.parse(localStorage.getItem('{{ $module["menuid"] }}SidebarExpanded') || false); })"
                         x-show="collapsed || expanded"
                         x-collapse
                         class="ml-0 pl-2">

                        @foreach ($module['children'] as $group)
                            @php
                                $isFirstChildInGroup = $group === array_values($module['children'])[0];
                                $firstItem = empty($group['children']) ? null : $group['children'][0] ?? null;
                                $itemHasChildren = isset($firstItem) && !empty($firstItem['children']);
                                $itemHasRoute = isset($firstItem) && isset($firstItem['hasRoute']) && $firstItem['hasRoute'];
                                $itemIsActive = isset($firstItem['isActive']) && $firstItem['isActive'];
                            @endphp
                            @if (!empty($group['children']))
                                {{-- Group container (XX.YY.00) --}}
                                <div class="mb-1 last:mb-0">
                                    <div x-data="{ expanded: false }"
                                         x-init="$watch('expanded', val => { localStorage.setItem('{{ $group["menuid"] }}SidebarExpanded', String(val)); expanded = JSON.parse(localStorage.getItem('{{ $group["menuid"] }}SidebarExpanded') || false); })"
                                         class="border-l-2 border-gray-700 pl-1">
                                        <button type="button"
                                                class="flex w-full items-center gap-1.5 rounded-md px-2 py-1 text-xs transition-colors hover:bg-gray-800"
                                                :class="{ 'text-blue-300': $itemIsActive, 'text-gray-400 hover:text-gray-200': !$itemIsActive }"
                                                x-on:click.stop="$event.target.closest('[x-data]').expanded = !$event.target.closest('[x-data]').expanded">
                                            <svg class="h-3 w-3 text-gray-500 transition-transform duration-150"
                                                 style="transform: {{ $itemHasChildren ? 'rotate(0deg)' : 'rotate(-90deg)' }}"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                            <span x-show="!collapsed" class="truncate font-medium text-gray-400">
                                                {{ __($group['name']) }}
                                            </span>
                                        </button>

                                        <div x-show="collapsed || {{ $itemHasRoute ? 'true' : 'false' }}"
                                             x-collapse>
                                            @foreach ($group['children'] as $item)
                                                @if ($item['hasRoute'])
                                                    <a href="{{ route($item['route']) }}"
                                                       data-sidebar-active="{{ isset($item['isActive']) && $item['isActive'] ? $item['menuid'] : '' }}"
                                                       class="block flex items-center gap-2 rounded px-3 py-1 text-xs transition-colors"
                                                       :class="{ 'bg-blue-900/30 text-blue-300': isset($item['isActive']) && $item['isActive'], 'border-l-2 border-blue-400': isset($item['isActive']) && $item['isActive'], 'text-gray-400 hover:bg-gray-800 hover:text-gray-200': !(isset($item['isActive']) && $item['isActive']) }"
                                                       title="{{ __($item['name']) }} ({{ $item['moduleid'] }})">
                                                        <span x-show="!collapsed" class="truncate">{{ __($item['name']) }}</span>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @elseif ($group['hasRoute'])
                                {{-- Direct leaf under module --}}
                                <a href="{{ route($group['route']) }}"
                                   data-sidebar-active="{{ isset($group['isActive']) && $group['isActive'] ? $group['menuid'] : '' }}"
                                   class="flex items-center gap-2 rounded-md px-3 py-1.5 text-xs transition-colors"
                                   :class="{ 'bg-blue-900/30 text-blue-300': isset($group['isActive']) && $group['isActive'], 'border-l-2 border-blue-400': isset($group['isActive']) && $group['isActive'], 'text-gray-400 hover:bg-gray-800 hover:text-gray-200': !(isset($group['isActive']) && $group['isActive']) }"
                                   title="{{ __($group['name']) }} ({{ $group['menuid'] }})">
                                    <span x-show="!collapsed" class="truncate">{{ __($group['name']) }}</span>
                                </a>
                            @endif
                        @endforeach

                    </div>
                </div>
            @endif
        @endforeach

    </nav>

    {{-- Footer link --}}
    <div class="mt-auto border-t border-gray-800 pb-2">
        <a href="{{ route('system.menu') }}"
           class="flex items-center gap-2 rounded-lg px-3 py-2 text-xs text-gray-500 transition-colors hover:bg-gray-800 hover:text-gray-300"
           x-show="!collapsed"
           title="{{ __('Quản lý Menu') }}">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>{{ __('Quản lý Menu') }}</span>
        </a>
        <div x-show="collapsed" class="mx-2 mt-2 flex items-center justify-center rounded bg-gray-800 p-1" title="{{ __('Quản lý Menu') }}">
            <a href="{{ route('system.menu') }}" class="flex h-6 w-6 items-center justify-center text-gray-400 hover:text-gray-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </a>
        </div>
    </div>

</div>