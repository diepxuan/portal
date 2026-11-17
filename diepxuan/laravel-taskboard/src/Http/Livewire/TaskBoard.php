<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-11-17
 */

namespace Diepxuan\TaskBoard\Http\Livewire;

use Diepxuan\TaskBoard\Services\TaskRepository;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Bảng quản lý task dạng Kanban.
 *
 * Đọc trực tiếp `docs/tasks/**` (file markdown), không dùng database — nên màn
 * hình chạy được trên máy dev nơi không có kết nối DB trực tiếp.
 *
 * Route: `/simba/system/tasks` (route name `system.tasks.index`).
 */
class TaskBoard extends Component
{
    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'module', except: '')]
    public string $module = '';

    #[Url(as: 'phase', except: '')]
    public string $phase = '';

    #[Url(as: 'view', except: 'kanban')]
    public string $view = 'kanban';

    /** Task đang mở panel chi tiết. */
    public ?string $selectedId = null;

    protected TaskRepository $repo;

    public function boot(TaskRepository $repo): void
    {
        $this->repo = $repo;
    }

    public function setView(string $view): void
    {
        $this->view = in_array($view, ['kanban', 'list'], true) ? $view : 'kanban';
    }

    public function selectTask(?string $id): void
    {
        $this->selectedId = $this->selectedId === $id ? null : $id;
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->module = '';
        $this->phase  = '';
    }

    /**
     * Task sau khi áp filter.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function getFilteredProperty(): Collection
    {
        $tasks = $this->repo->all();

        if ($this->phase !== '') {
            $tasks = $tasks->where('phase', $this->phase);
        }

        if ($this->module !== '') {
            $tasks = $tasks->where('module', $this->module);
        }

        $needle = $this->normalize($this->search);

        if ($needle !== '') {
            $tasks = $tasks->filter(function (array $t) use ($needle): bool {
                foreach (['id', 'title', 'dll', 'file', 'status_raw', 'module'] as $field) {
                    if (str_contains($this->normalize((string) $t[$field]), $needle)) {
                        return true;
                    }
                }

                return false;
            });
        }

        return $tasks->values();
    }

    /**
     * Task gom theo cột Kanban.
     *
     * @return array<string, Collection<int, array<string, mixed>>>
     */
    public function getColumnsProperty(): array
    {
        $filtered = $this->filtered;
        $columns  = [];

        foreach (array_keys(TaskRepository::COLUMN_LABELS) as $key) {
            $columns[$key] = $filtered->where('column', $key)->values();
        }

        return $columns;
    }

    /**
     * @return array<string, mixed>
     */
    public function getStatsProperty(): array
    {
        return $this->repo->stats($this->filtered);
    }

    /**
     * @return array<string, string>
     */
    public function getColumnLabelsProperty(): array
    {
        return TaskRepository::COLUMN_LABELS;
    }

    /**
     * @return array<int, string>
     */
    public function getModulesProperty(): array
    {
        return $this->repo->all()->pluck('module')->filter()
            ->unique()->sort()->values()->all()
        ;
    }

    /**
     * @return array<int, string>
     */
    public function getPhasesProperty(): array
    {
        return $this->repo->phases();
    }

    /**
     * @return null|array<string, mixed>
     */
    public function getSelectedTaskProperty(): ?array
    {
        if ($this->selectedId === null || $this->selectedId === '') {
            return null;
        }

        return $this->repo->find($this->selectedId);
    }

    public function render(): View
    {
        return view('taskboard::taskboard.index', [
            'columns'      => $this->columns,
            'columnLabels' => $this->columnLabels,
            'stats'        => $this->stats,
            'modules'      => $this->modules,
            'phases'       => $this->phases,
            'selectedTask' => $this->selectedTask,
        ])->layout('catalog::layouts.app');
    }

    /**
     * Chuẩn hóa để so khớp: bỏ dấu NFD, quy đ/Đ về d, lowercase
     * (cùng quy tắc filter khác trong Portal — PROJECT_CONVENTIONS §5).
     */
    public function normalize(string $value): string
    {
        $value = \Normalizer::normalize($value, \Normalizer::FORM_D) ?: $value;
        $value = (string) preg_replace('/[\x{0300}-\x{036F}]/u', '', $value);
        $value = (string) preg_replace('/[đĐ]/u', 'd', $value);

        return mb_strtolower(trim($value));
    }
}
