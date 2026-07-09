<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-07-09
 */

namespace Diepxuan\Catalog\Http\Livewire\Component;

use Diepxuan\Simba\StoredProcedures\AsARGetDMKH;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;

/**
 * Input autocomplete đối tượng (khách hàng, nhà cung cấp, nhân viên).
 *
 * Hỗ trợ nhiều mode (single hoặc multi-mode, OR logic):
 *   - khachhang  -> SP asARGetDMKH(pModuleId = 'AR')
 *   - nhacungcap -> SP asARGetDMKH(pModuleId = 'AP')
 *   - nhanvien   -> SP asARGetDMKH(pModuleId = 'CA')
 *   - all        -> tổng hợp cả 3 module
 *
 * Nguồn tra cứu:
 *   - simba-docs/data/sysDictionaryInfo.md (MA_KH, MA_NCC -> ARDMKH)
 *   - simba-docs/data/sysDAOInfo.md        (ARDMKH -> asARGetDMKH)
 *   - simba-docs/procedures/AR/procedures.md (asARGetDMKH signature)
 *
 * Lưu ý: Component này chỉ lookup/chọn; thêm/sửa/xóa thuộc task nghiệp vụ.
 */
class InputKhachhang extends Component
{
    /** Mode lọc đối tượng. */
    public string $mode = 'khachhang';

    /** Giá trị selected (mã đối tượng). */
    #[Modelable]
    public ?string $value = null;

    /** Text hiển thị (tên đối tượng). */
    public string $search = '';

    /** Danh sách kết quả tìm kiếm. */
    public array $results = [];

    /** Có đang tìm kiếm không. */
    public bool $searching = false;

    /** Có đang hiển thị dropdown không. */
    public bool $showDropdown = false;

    /** Placeholder text. */
    public string $placeholder = '';

    /** Cache lookup theo module để tránh gọi SP lặp lại. */
    protected array $dmCache = [];

    /**
     * Mount component.
     */
    public function mount(?string $value = null, string $mode = 'khachhang'): void
    {
        $this->value       = $value;
        $this->mode        = $mode;
        $this->placeholder = $this->getPlaceholderByMode();

        if ($value) {
            // Load tên đối tượng qua cùng nguồn SP/wrapper
            $row = $this->findOneByMaKh($value);
            if ($row) {
                $this->search = $row['ten_kh'] ?? '';
            }
        }
    }

    /**
     * Xử lý khi search input thay đổi.
     */
    public function updatedSearch(): void
    {
        $this->searching = true;

        $search = trim($this->search);

        if ($this->value) {
            $this->value = null;
            $this->dispatch('value-updated', null);
        }

        if ('' === $search) {
            $this->results   = [];
            $this->searching = false;

            return;
        }

        $modules = $this->resolveModules();
        $seen    = [];
        $merged  = [];

        foreach ($modules as $moduleId) {
            $rows = $this->fetchDmKhByModule($moduleId);
            foreach ($rows as $row) {
                $maKh = $row['ma_kh'] ?? null;
                if (null === $maKh || isset($seen[$maKh])) {
                    continue;
                }
                if (!$this->matchesSearch($row, $search)) {
                    continue;
                }
                $seen[$maKh] = true;
                $merged[]    = [
                    'ma_kh'   => $maKh,
                    'ten_kh'  => $row['ten_kh']  ?? '',
                    'dia_chi' => $row['dia_chi'] ?? '',
                    'tel'     => $row['tel']     ?? '',
                ];
                if (\count($merged) >= 20) {
                    break 2;
                }
            }
        }

        $this->results      = $merged;
        $this->searching    = false;
        $this->showDropdown = true;
    }

    /**
     * Chọn đối tượng từ dropdown.
     */
    public function selectCustomer(string $ma_kh, string $ten_kh): void
    {
        $this->value        = $ma_kh;
        $this->search       = $ten_kh;
        $this->showDropdown = false;
        $this->results      = [];

        $this->dispatch('value-updated', $ma_kh);
    }

    /**
     * Đóng dropdown.
     */
    public function blur(): void
    {
        $this->dispatch('close-dropdown');
    }

    /**
     * Xóa selection.
     */
    public function clear(): void
    {
        $this->value        = null;
        $this->search       = '';
        $this->results      = [];
        $this->showDropdown = false;
        $this->dispatch('value-updated', null);
    }

    /**
     * Render component.
     */
    public function render(): View
    {
        return view('catalog::components.input-khachhang');
    }

    /**
     * Map mode -> danh sách pModuleId.
     *
     * @return array<int, string>
     */
    protected function resolveModules(): array
    {
        $modes = array_map('trim', preg_split('/[,.|]/', $this->mode) ?: []);

        if (\in_array('all', $modes, true)) {
            return ['AR', 'AP', 'CA'];
        }

        $map = [
            'khachhang'  => 'AR',
            'nhacungcap' => 'AP',
            'nhanvien'   => 'CA',
        ];

        $modules = [];
        foreach ($modes as $m) {
            if (isset($map[$m])) {
                $modules[] = $map[$m];
            }
        }

        return [] === $modules ? ['AR'] : array_values(array_unique($modules));
    }

    /**
     * Gọi SP asARGetDMKH cho 1 module, có cache trong vòng đời component.
     */
    protected function fetchDmKhByModule(string $moduleId): array
    {
        if (isset($this->dmCache[$moduleId])) {
            return $this->dmCache[$moduleId];
        }

        $rows = AsARGetDMKH::call([
            'pMa_cty'   => \CatalogService::company()->id,
            'pMa_kh'    => null,
            'pStruct'   => '0',
            'pModuleId' => $moduleId,
        ])->all();

        // Chuẩn hóa key thường gặp: ma_kh, ten_kh, dia_chi, tel
        return $this->dmCache[$moduleId] = array_map(
            static function ($row) {
                if (\is_array($row)) {
                    return $row;
                }
                $obj = (array) $row;
                $lower = [];
                foreach ($obj as $k => $v) {
                    $lower[strtolower((string) $k)] = $v;
                }

                return $lower;
            },
            $rows
        );
    }

    /**
     * Tìm 1 record theo mã đối tượng, dùng cùng SP để tránh nguồn khác.
     */
    protected function findOneByMaKh(string $maKh): ?array
    {
        foreach ($this->resolveModules() as $moduleId) {
            $rows = AsARGetDMKH::call([
                'pMa_cty'   => \CatalogService::company()->id,
                'pMa_kh'    => $maKh,
                'pStruct'   => '0',
                'pModuleId' => $moduleId,
            ])->all();
            foreach ($rows as $row) {
                $obj = \is_array($row) ? $row : (array) $row;
                $lower = [];
                foreach ($obj as $k => $v) {
                    $lower[strtolower((string) $k)] = $v;
                }
                if (($lower['ma_kh'] ?? null) === $maKh) {
                    return $lower;
                }
            }
        }

        return null;
    }

    /**
     * Match từ khóa với mã/tên/địa chỉ/tel.
     */
    protected function matchesSearch(array $row, string $search): bool
    {
        $hay = strtolower(implode(' ', [
            (string) ($row['ma_kh']   ?? ''),
            (string) ($row['ten_kh']  ?? ''),
            (string) ($row['dia_chi'] ?? ''),
            (string) ($row['tel']     ?? ''),
        ]));

        return str_contains($hay, strtolower($search));
    }

    /**
     * Lấy placeholder theo mode.
     */
    protected function getPlaceholderByMode(): string
    {
        $modes = array_map('trim', preg_split('/[,.|]/', $this->mode) ?: []);

        if (\count($modes) > 1 || \in_array('all', $modes, true)) {
            return 'Chọn đối tượng...';
        }

        return match ($modes[0]) {
            'khachhang'  => 'Chọn khách hàng...',
            'nhacungcap' => 'Chọn nhà cung cấp...',
            'nhanvien'   => 'Chọn nhân viên...',
            default      => 'Chọn đối tượng...',
        };
    }
}
