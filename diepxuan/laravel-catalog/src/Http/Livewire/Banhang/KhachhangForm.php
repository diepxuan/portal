<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-08-01 00:00:00
 */

namespace Diepxuan\Catalog\Http\Livewire\Banhang;

use Diepxuan\Catalog\Http\Livewire\Po\Dict\ArdmkhForm as BaseForm;
use Diepxuan\Catalog\Models\Simba\ArDmNhKh;
use Diepxuan\Catalog\Models\Simba\ArDmPlKh;
use Diepxuan\Simba\StoredProcedures\AsARGetDMKH;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Component KhachhangForm — ARDMKH khách hàng (SO).
 * Kế thừa Po\Dict\ArdmkhForm để reuse field() helper và canonical pattern.
 */
class KhachhangForm extends BaseForm
{
    public ?string $ma_plkh1 = null;
    public ?string $ma_plkh2 = null;
    public ?string $ma_plkh3 = null;
    public ?string $ma_nhkh = null;
    public ?string $ma_nt = 'VND';
    public bool $isKh = true;
    public bool $ksd = false;

    /** @var Collection */
    public Collection $nhomKhOptions;
    /** @var array<int, Collection> */
    public array $plkhOptions = [];

    protected $messages = [
        'ma_kh.required' => 'Mã khách hàng không được để trống.',
        'ten_kh.required' => 'Tên khách hàng không được để trống.',
        'email.email' => 'Email không đúng định dạng.',
    ];

    public function mount(?string $id = null): void
    {
        $this->loadDropdowns();
        if ($id) {
            $this->mode = 'edit';
            $this->loadDoiTuong($id);
        }
    }

    public function loadDoiTuong(string $maKh): void
    {
        try {
            $result = AsARGetDMKH::getCustomers(search: $maKh);

            if ($result->isEmpty()) {
                $this->dispatch('error', message: 'Không tìm thấy khách hàng.');
                return;
            }

            $row = $result->first();
            // Dùng field() helper từ parent (case-insensitive row access)
            $this->ma_kh = $this->field($row, 'ma_kh', 'MA_KH', $maKh);
            $this->ten_kh = $this->field($row, 'ten_kh', 'TEN_KH', '');
            $this->dia_chi = $this->field($row, 'dia_chi', 'DIA_CHI', '');
            $this->ma_so_thue = $this->field($row, 'ma_so_thue', 'MA_SO_THUE', '');
            $this->dien_thoai = $this->field($row, 'tel', 'TEL', '');
            $this->fax = $this->field($row, 'fax', 'FAX', '');
            $this->email = $this->field($row, 'email', 'EMAIL', '');
            $this->ma_nt = $this->field($row, 'ma_nt', 'MA_NT', 'VND');
            $this->tk_cn = $this->field($row, 'tk', 'TK');
            $this->ma_plkh1 = $this->field($row, 'ma_plkh1', 'MA_PLKH1');
            $this->ma_plkh2 = $this->field($row, 'ma_plkh2', 'MA_PLKH2');
            $this->ma_plkh3 = $this->field($row, 'ma_plkh3', 'MA_PLKH3');
            $this->ma_nhkh = $this->field($row, 'ma_nhkh', 'MA_NHKH');
            $this->nguoi_gd = $this->field($row, 'nguoi_gd', 'NGUOI_GD');
            $this->ghi_chu = $this->field($row, 'ghi_chu', 'GHI_CHU');
            $this->isKh = (bool) ($this->field($row, 'iskh', 'ISKH', true));
            $this->ksd = (bool) ($this->field($row, 'ksd', 'KSD', false));
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Không thể tải thông tin khách hàng: ' . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('catalog::banhang.khachhang-form', [
            'nhomKhOptions' => $this->nhomKhOptions,
            'plkhOptions' => $this->plkhOptions,
        ])->layout('catalog::layouts.app');
    }

    protected function rules(): array
    {
        return array_merge(parent::rules(), [
            'ma_plkh1' => 'nullable|string|max:8',
            'ma_plkh2' => 'nullable|string|max:8',
            'ma_plkh3' => 'nullable|string|max:8',
            'ma_nhkh' => 'nullable|string|max:8',
            'ma_nt' => 'nullable|string|max:10',
            'isKh' => 'boolean',
            'ksd' => 'boolean',
        ]);
    }

    protected function persist(string $procedureClass): void
    {
        $maKh = strtoupper(trim((string) $this->ma_kh));
        $user = auth()->user()->name ?? 'system';

        try {
            $procedureClass::call([
                'pMa_cty' => \Diepxuan\Simba\SModel\SModel::CTY,
                'pMa_kh' => $maKh,
                'pLoai' => '1',
                'pTen_kh' => $this->ten_kh,
                'pMa_so_thue' => $this->ma_so_thue,
                'pDia_chi' => $this->dia_chi,
                'pTel' => $this->dien_thoai,
                'pFax' => $this->fax,
                'pEmail' => $this->email,
                'pTk' => $this->tk_cn,
                'pMa_plkh1' => $this->ma_plkh1,
                'pMa_plkh2' => $this->ma_plkh2,
                'pMa_plkh3' => $this->ma_plkh3,
                'pMa_nhkh' => $this->ma_nhkh,
                'pGhi_chu' => $this->ghi_chu,
                'pIskh' => 1,
                'pIsncc' => 0,
                'pIsnv' => 0,
                'pKsd' => $this->ksd ? 1 : 0,
                'pLUser' => $user,
            ]);

            $this->dispatch('success', message: 'Đã lưu khách hàng ' . $maKh);
            $this->dispatch('khachhang-saved');
            $this->redirect(simbaroute('so.dict.ardmkh'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Không thể lưu khách hàng: ' . $e->getMessage());
        }
    }

    protected function loadDropdowns(): void
    {
        $this->nhomKhOptions = ArDmNhKh::orderBy('ma_nhkh')->get();
        $this->plkhOptions[1] = ArDmPlKh::loai(1)->orderBy('ma_plkh')->get();
        $this->plkhOptions[2] = ArDmPlKh::loai(2)->orderBy('ma_plkh')->get();
        $this->plkhOptions[3] = ArDmPlKh::loai(3)->orderBy('ma_plkh')->get();
    }
}
