<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 */

namespace Diepxuan\Catalog\Http\Livewire\Gl\Rpt;

use Diepxuan\Simba\StoredProcedures\AsGLRptBCT03;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Tờ khai giá trị gia tăng (GTGT) — mẫu BCT03.
 *
 * Port từ GLRptBCT03.dll. Gọi SP `asGLRptBCT03` qua wrapper `AsGLRptBCT03`.
 * Tham số SP (theo simba-docs/procedures/GL/procedures.md):
 *   - pMa_cty NVARCHAR(3)    Mã công ty
 *   - pNgay1  SMALLDATETIME  Từ ngày
 *   - pNgay2  SMALLDATETIME  Đến ngày
 *
 * Form gốc `frmGLRptBCT03.LoadData()` chỉ truyền 3 tham số: CompanyID, txtNgay1, txtNgay2.
 */
class Glrptbct03 extends Component
{
    public ?string $module = null;

    public ?string $kind = null;

    public ?string $slug = null;

    public ?string $pNgay1 = null;

    public ?string $pNgay2 = null;

    public ?string $errorMessage = null;

    /** @var list<array<string,mixed>> */
    public array $rows = [];

    /** @var list<string> */
    public array $columns = [];

    public ?int $selectedRowIndex = null;

    /** @var array<string,mixed> */
    public array $selectedRow = [];

    public function mount(?string $module = null, ?string $kind = null, ?string $slug = null): void
    {
        $this->module = $module;
        $this->kind = $kind;
        $this->slug = $slug;

        $this->pNgay1 ??= now()->startOfMonth()->toDateString();
        $this->pNgay2 ??= now()->toDateString();
        $this->rows = [];
    }

    public function submit(): void
    {
        $this->validate([
            'pNgay1' => ['required', 'date'],
            'pNgay2' => ['required', 'date', 'after_or_equal:pNgay1'],
        ], [
            'pNgay1.required' => 'Phải nhập từ ngày.',
            'pNgay2.required' => 'Phải nhập đến ngày.',
            'pNgay2.after_or_equal' => 'Đến ngày phải lớn hơn hoặc bằng từ ngày.',
        ]);

        $this->errorMessage = null;

        try {
            $rows = AsGLRptBCT03::call($this->procedurePayload());
        } catch (\Throwable $exception) {
            report($exception);
            $this->rows = [];
            $this->columns = [];
            $this->clearSelectedRow();
            $this->errorMessage = 'Không tải được dữ liệu báo cáo từ SP asGLRptBCT03.';

            return;
        }

        $this->rows = $rows->map(fn (mixed $row): array => $this->rowToArray($row))->values()->all();
        $this->columns = [] !== $this->rows ? array_keys($this->rows[0]) : [];
        $this->clearSelectedRow();
        $this->dispatch('switch-tab', 'content');
    }

    public function selectRow(int $index): void
    {
        if (!isset($this->rows[$index])) {
            $this->clearSelectedRow();

            return;
        }

        $this->selectedRowIndex = $index;
        $this->selectedRow = $this->rows[$index];
    }

    public function clearSelectedRow(): void
    {
        $this->selectedRowIndex = null;
        $this->selectedRow = [];
    }

    public function exportCsv(): ?StreamedResponse
    {
        if ([] === $this->rows || [] === $this->columns) {
            $this->errorMessage = 'Chưa có dữ liệu để xuất.';

            return null;
        }

        $rows = $this->rows;
        $columns = $this->columns;
        $filename = 'glrptbct03-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(static function () use ($rows, $columns): void {
            $handle = fopen('php://output', 'wb');
            if (false === $handle) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $columns);

            foreach ($rows as $row) {
                fputcsv($handle, array_map(
                    static fn (string $column): string => self::csvValue($row[$column] ?? null),
                    $columns
                ));
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function render(): View
    {
        return view('catalog::gl.rpt.glrptbct03', [
            'rows' => $this->rows,
            'columns' => $this->columns,
        ]);
    }

    public function displayValue(mixed $value): string
    {
        return self::csvValue($value);
    }

    public static function csvValue(mixed $value): string
    {
        $stringValue = match (\gettype($value)) {
            'boolean' => $value ? '1' : '0',
            'NULL' => '',
            'array' => '',
            'object' => method_exists($value, '__toString') ? (string) $value : '',
            default => (string) $value,
        };

        return (string) normalize_to_utf8($stringValue);
    }

    public function isNumericColumn(string $column): bool
    {
        $column = mb_strtolower($column);

        if (str_starts_with($column, 'ma_')
            || str_starts_with($column, 'ten_')
            || str_starts_with($column, 'ngay')
            || \in_array($column, ['tk', 'so_ct', 'stt_rec', 'dien_giai', 'chi_tieu'], true)
        ) {
            return false;
        }

        return str_contains($column, 'tien')
            || str_contains($column, 'amount')
            || str_starts_with($column, 'ps_')
            || str_starts_with($column, 'du_')
            || str_ends_with($column, '_nt');
    }

    /**
     * @return array<string,mixed>
     */
    public function procedurePayload(): array
    {
        return [
            'pMa_cty' => (string) \CatalogService::company()->id,
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function rowToArray(mixed $row): array
    {
        if (\is_array($row)) {
            return $row;
        }

        if ($row instanceof \JsonSerializable) {
            $data = $row->jsonSerialize();

            return \is_array($data) ? $data : [];
        }

        if ($row instanceof \stdClass) {
            return get_object_vars($row);
        }

        return (array) $row;
    }
}
