<div>
    <x-head-title>Task Manager</x-head-title>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Task Manager</h2>
                <p class="mt-0.5 text-sm text-gray-500">
                    Đọc trực tiếp từ <code class="rounded bg-gray-100 px-1 py-0.5 text-xs">docs/tasks/</code>
                    — {{ number_format($stats['total']) }} task
                    @if ($stats['checklists']['total'] > 0)
                        · checklist {{ $stats['checklists']['done'] }}/{{ $stats['checklists']['total'] }}
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('simba.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                    ← Simba ERP
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Toolbar: search + filter + view switch --}}
    <div class="mb-4 rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-56 flex-1">
                <label class="mb-1 block text-xs font-medium text-gray-500">Tìm kiếm</label>
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="ID, tên task, module, DLL..."
                    class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Module</label>
                <select wire:model.live="module"
                    class="rounded-md border border-gray-300 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tất cả</option>
                    @foreach ($modules as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Phase</label>
                <select wire:model.live="phase"
                    class="rounded-md border border-gray-300 px-3 py-1.5 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tất cả</option>
                    @foreach ($phases as $p)
                        <option value="{{ $p }}">{{ $p === 'root' ? 'Hiện tại' : $p }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Hiển thị</label>
                <div class="inline-flex overflow-hidden rounded-md border border-gray-300">
                    <button type="button" wire:click="setView('kanban')"
                        class="px-3 py-1.5 text-xs font-medium {{ $view === 'kanban' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        Kanban
                    </button>
                    <button type="button" wire:click="setView('list')"
                        class="border-l border-gray-300 px-3 py-1.5 text-xs font-medium {{ $view === 'list' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        Danh sách
                    </button>
                </div>
            </div>

            @if ($search !== '' || $module !== '' || $phase !== '')
                <button type="button" wire:click="clearFilters"
                    class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                    Xóa lọc
                </button>
            @endif
        </div>

        {{-- Stats theo cột --}}
        <div class="mt-3 flex flex-wrap gap-2 border-t border-gray-100 pt-3">
            @foreach ($columnLabels as $key => $label)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                    <span class="h-1.5 w-1.5 rounded-full {{ [
                        'pending' => 'bg-gray-400',
                        'in_progress' => 'bg-yellow-500',
                        'done' => 'bg-green-500',
                        'other' => 'bg-indigo-400',
                    ][$key] ?? 'bg-gray-300' }}"></span>
                    {{ $label }}
                    <span class="font-semibold text-gray-900">{{ $stats['columns'][$key] ?? 0 }}</span>
                </span>
            @endforeach
        </div>
    </div>

    @if ($view === 'kanban')
        {{-- ============ KANBAN ============ --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($columns as $key => $cards)
                <div class="flex flex-col rounded-lg border border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between border-b border-gray-200 bg-white px-3 py-2 rounded-t-lg">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full {{ [
                                'pending' => 'bg-gray-400',
                                'in_progress' => 'bg-yellow-500',
                                'done' => 'bg-green-500',
                                'other' => 'bg-indigo-400',
                            ][$key] ?? 'bg-gray-300' }}"></span>
                            <h3 class="text-sm font-semibold text-gray-700">{{ $columnLabels[$key] }}</h3>
                        </div>
                        <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">
                            {{ $cards->count() }}
                        </span>
                    </div>

                    <div class="max-h-[calc(100vh-360px)] space-y-2 overflow-y-auto p-2">
                        @forelse ($cards as $task)
                            <button type="button" wire:click="selectTask('{{ $task['id'] }}')"
                                wire:key="kanban-{{ $task['phase'] }}-{{ $task['file'] }}"
                                class="w-full rounded-md border bg-white p-2.5 text-left shadow-sm transition hover:border-blue-400 hover:shadow
                                    {{ $selectedId === $task['id'] ? 'border-blue-500 ring-1 ring-blue-500' : 'border-gray-200' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="font-mono text-xs font-semibold text-gray-500">
                                        {{ $task['id'] !== '' ? $task['id'] : '—' }}
                                    </span>
                                    <span class="shrink-0 rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-600">
                                        {{ $task['module'] }}
                                    </span>
                                </div>

                                <p class="mt-1 line-clamp-2 text-sm font-medium text-gray-800">{{ $task['title'] }}</p>

                                @if ($task['progress'] !== null)
                                    <div class="mt-2">
                                        <div class="flex items-center justify-between text-[10px] text-gray-500">
                                            <span>checklist</span>
                                            <span>{{ $task['check_done'] }}/{{ $task['check_total'] }}</span>
                                        </div>
                                        <div class="mt-0.5 h-1 w-full overflow-hidden rounded-full bg-gray-200">
                                            <div class="h-full rounded-full bg-blue-500"
                                                style="width: {{ $task['progress'] }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                @if ($task['status_raw'] !== '')
                                    <p class="mt-1.5 truncate text-[11px] text-gray-500" title="{{ $task['status_raw'] }}">
                                        {{ \Illuminate\Support\Str::limit($task['status_raw'], 60) }}
                                    </p>
                                @endif
                            </button>
                        @empty
                            <p class="px-2 py-6 text-center text-xs text-gray-400">Không có task</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- ============ LIST ============ --}}
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="max-h-[calc(100vh-320px)] overflow-x-auto overflow-y-auto">
                <table class="min-w-max w-full text-left text-xs">
                    <thead class="sticky top-0 z-10 bg-gray-50 text-gray-500">
                        <tr>
                            <th class="border-b border-gray-200 px-3 py-2 font-medium">ID</th>
                            <th class="border-b border-gray-200 px-3 py-2 font-medium">Task</th>
                            <th class="border-b border-gray-200 px-3 py-2 font-medium">Module</th>
                            <th class="border-b border-gray-200 px-3 py-2 font-medium">Phase</th>
                            <th class="border-b border-gray-200 px-3 py-2 font-medium">Trạng thái</th>
                            <th class="border-b border-gray-200 px-3 py-2 font-medium">Checklist</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->filtered as $task)
                            <tr wire:key="row-{{ $task['phase'] }}-{{ $task['file'] }}"
                                wire:click="selectTask('{{ $task['id'] }}')"
                                class="cursor-pointer border-b border-gray-100 hover:bg-sky-50
                                    {{ $selectedId === $task['id'] ? 'bg-sky-50' : '' }}">
                                <td class="px-3 py-1.5 font-mono text-gray-500">{{ $task['id'] !== '' ? $task['id'] : '—' }}</td>
                                <td class="px-3 py-1.5 font-medium text-gray-800">{{ $task['title'] }}</td>
                                <td class="px-3 py-1.5">
                                    <span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-gray-600">
                                        {{ $task['module'] }}
                                    </span>
                                </td>
                                <td class="px-3 py-1.5 text-gray-600">{{ $task['phase'] === 'root' ? 'Hiện tại' : $task['phase'] }}</td>
                                <td class="px-3 py-1.5">
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-medium {{ [
                                        'pending' => 'bg-gray-100 text-gray-700',
                                        'in_progress' => 'bg-yellow-100 text-yellow-700',
                                        'done' => 'bg-green-100 text-green-800',
                                        'other' => 'bg-indigo-100 text-indigo-700',
                                    ][$task['column']] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $columnLabels[$task['column']] ?? $task['column'] }}
                                    </span>
                                </td>
                                <td class="px-3 py-1.5 text-gray-600">
                                    @if ($task['check_total'] > 0)
                                        {{ $task['check_done'] }}/{{ $task['check_total'] }}
                                        <span class="text-gray-400">({{ $task['progress'] }}%)</span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-6 text-center text-gray-400">Không có task khớp điều kiện</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ============ DETAIL PANEL ============ --}}
    @if ($selectedTask !== null)
        <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-3 py-2">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">
                        #{{ $selectedTask['id'] !== '' ? $selectedTask['id'] : '—' }} · {{ $selectedTask['title'] }}
                    </h3>
                    <p class="font-mono text-xs text-gray-500">{{ $selectedTask['relative_path'] }}</p>
                </div>
                <button type="button" wire:click="selectTask(null)"
                    class="rounded border border-gray-300 px-2 py-1 text-xs text-gray-600 hover:bg-gray-100">
                    Đóng
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-3">
                <div class="space-y-2 text-xs">
                    <div class="flex gap-2">
                        <span class="w-20 shrink-0 text-gray-500">Module</span>
                        <span class="font-medium text-gray-800">{{ $selectedTask['module'] }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-20 shrink-0 text-gray-500">Phase</span>
                        <span class="font-medium text-gray-800">{{ $selectedTask['phase'] === 'root' ? 'Hiện tại' : $selectedTask['phase'] }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-20 shrink-0 text-gray-500">Trạng thái</span>
                        <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-medium {{ [
                            'pending' => 'bg-gray-100 text-gray-700',
                            'in_progress' => 'bg-yellow-100 text-yellow-700',
                            'done' => 'bg-green-100 text-green-800',
                            'other' => 'bg-indigo-100 text-indigo-700',
                        ][$selectedTask['column']] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $columnLabels[$selectedTask['column']] ?? $selectedTask['column'] }}
                        </span>
                    </div>
                    @if ($selectedTask['dll'] !== '')
                        <div class="flex gap-2">
                            <span class="w-20 shrink-0 text-gray-500">DLL</span>
                            <span class="font-mono text-gray-800">{{ $selectedTask['dll'] }}</span>
                        </div>
                    @endif
                    <div class="flex gap-2">
                        <span class="w-20 shrink-0 text-gray-500">Status gốc</span>
                        <span class="text-gray-700">{{ $selectedTask['status_raw'] !== '' ? $selectedTask['status_raw'] : '—' }}</span>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h4 class="mb-2 text-xs font-semibold text-gray-700">
                        Checklist
                        @if ($selectedTask['check_total'] > 0)
                            <span class="font-normal text-gray-500">
                                ({{ $selectedTask['check_done'] }}/{{ $selectedTask['check_total'] }} · {{ $selectedTask['progress'] }}%)
                            </span>
                        @endif
                    </h4>

                    @if ($selectedTask['check_total'] > 0)
                        <div class="mb-2 h-1.5 w-full overflow-hidden rounded-full bg-gray-200">
                            <div class="h-full rounded-full bg-blue-500" style="width: {{ $selectedTask['progress'] }}%"></div>
                        </div>
                        <ul class="max-h-64 space-y-1 overflow-y-auto text-xs">
                            @foreach ($selectedTask['checklist'] as $item)
                                <li class="flex items-start gap-1.5">
                                    <span class="mt-0.5 shrink-0 {{ $item['done'] ? 'text-green-600' : 'text-gray-300' }}">
                                        {{ $item['done'] ? '✓' : '○' }}
                                    </span>
                                    <span class="{{ $item['done'] ? 'text-gray-400 line-through' : 'text-gray-700' }}">
                                        {{ $item['text'] }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-gray-400">Task này không có checklist.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
