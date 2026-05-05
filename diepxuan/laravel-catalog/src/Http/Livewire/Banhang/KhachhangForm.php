<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-05 20:11:15
 */

namespace Diepxuan\Catalog\Http\Livewire\Banhang;

use Diepxuan\Catalog\Models\ArDmKh;
use Diepxuan\Catalog\Models\ArDmNhKh;
use Diepxuan\Catalog\Models\ArDmPlKh;
use Diepxuan\Simba\Models\ArDmKh as SimbaArDmKh;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Component KhachhangForm.
 *
 * Form tạo mới / chỉnh sửa khách hàng.
 */
class KhachhangForm extends Component
{
    /**
     * Chế độ: 'create' hoặc 'edit'.
     */
    public string $mode = 'create';

    /**
     * Mã khách hàng (dùng cho edit mode).
     */
    public ?string $ma_kh = null;

    // Form fields
    public string $ten_kh     = '';
    public string $dia_chi    = '';
    public string $ma_so_thue = '';
    public string $dien_thoai = '';
    public string $fax        = '';
    public string $email      = '';
    public string $ma_nt      = 'VND';
    public ?string $tk_cn     = null;
    public ?string $ma_plkh1  = null;
    public ?string $ma_plkh2  = null;
    public ?string $ma_plkh3  = null;
    public ?string $ma_nhkh   = null;
    public bool $isKh         = true;

    /**
     * Flag: có giao dịch liên quan.
     */
    public bool $hasTransactions = false;

    /**
     * Danh sách nhóm KH cho dropdown.
     */
    public Collection $nhomKhOptions;

    /**
     * Danh sách phân loại KH cho dropdown.
     *
     * @var array<int, Collection>
     */
    public array $plkhOptions = [];

    /**
     * Validation messages.
     *
     * @var array<string, string>
     */
    protected $messages = [
        'ma_kh.required'  => 'Mã khách hàng không được để trống.',
        'ma_kh.unique'    => 'Mã khách hàng đã tồn tại.',
        'ten_kh.required' => 'Tên khách hàng không được để trống.',
        'email.email'     => 'Email không đúng định dạng.',
    ];

    /**
     * Khởi tạo component.
     *
     * @param null|string $id mã khách hàng (edit mode)
     */
    public function mount(?string $id = null): void
    {
        $this->loadDropdowns();

        if ($id) {
            $this->mode = 'edit';
            $this->loadKhachHang($id);
        }
    }

    /**
     * Tải thông tin khách hàng để chỉnh sửa.
     *
     * @param string $maKh mã khách hàng
     */
    public function loadKhachHang(string $maKh): void
    {
        $khachHang = ArDmKh::withoutGlobalScopes()
            ->where('ma_kh', $maKh)
            ->first()
        ;

        if (!$khachHang) {
            $this->dispatch('error', message: 'Không tìm thấy khách hàng.');

            return;
        }

        $this->ma_kh           = $khachHang->ma_kh;
        $this->ten_kh          = $khachHang->ten_kh ?? '';
        $this->dia_chi         = $khachHang->dia_chi ?? '';
        $this->ma_so_thue      = $khachHang->ma_so_thue ?? '';
        $this->dien_thoai      = $khachHang->tel ?? '';
        $this->fax             = $khachHang->fax ?? '';
        $this->email           = $khachHang->email ?? '';
        $this->ma_nt           = $khachHang->ma_nt ?? 'VND';
        $this->tk_cn           = $khachHang->tk_cn;
        $this->ma_plkh1        = $khachHang->ma_plkh1;
        $this->ma_plkh2        = $khachHang->ma_plkh2;
        $this->ma_plkh3        = $khachHang->ma_plkh3;
        $this->ma_nhkh         = $khachHang->ma_nhkh;
        $this->isKh            = (bool) $khachHang->isKh;
        $this->hasTransactions = $khachHang->hasTransactions();
    }

    /**
     * Lưu khách hàng.
     */
    public function save(): void
    {
        $this->validate();

        if ('create' === $this->mode) {
            $this->createKhachHang();
        } else {
            $this->updateKhachHang();
        }
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('catalog::banhang.khachhang-form', [
            'nhomKhOptions' => $this->nhomKhOptions,
            'plkhOptions'   => $this->plkhOptions,
        ])->layout('catalog::layouts.app');
    }

    /**
     * Validation rules.
     *
     * @var array<string, string>
     */
    protected function rules(): array
    {
        $rules = [
            'ten_kh'     => 'required|string|max:200',
            'dia_chi'    => 'nullable|string|max:500',
            'ma_so_thue' => 'nullable|string|max:50',
            'dien_thoai' => 'nullable|string|max:50',
            'fax'        => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:100',
            'ma_nt'      => 'nullable|string|max:10',
            'tk_cn'      => 'nullable|string|max:20',
            'ma_plkh1'   => 'nullable|string|max:50',
            'ma_plkh2'   => 'nullable|string|max:50',
            'ma_plkh3'   => 'nullable|string|max:50',
            'ma_nhkh'    => 'nullable|string|max:50',
            'isKh'       => 'boolean',
        ];

        if ('create' === $this->mode) {
            $rules['ma_kh'] = 'required|string|max:50|unique:' . (new SimbaArDmKh())->getTable() . ',ma_kh';
        } else {
            $rules['ma_kh'] = 'required|string|max:50';
        }

        return $rules;
    }

    /**
     * Tải danh sách dropdown.
     */
    protected function loadDropdowns(): void
    {
        $this->nhomKhOptions = ArDmNhKh::orderBy('ma_nhkh')->get();

        $this->plkhOptions[1] = ArDmPlKh::loai(1)->orderBy('ma_plkh')->get();
        $this->plkhOptions[2] = ArDmPlKh::loai(2)->orderBy('ma_plkh')->get();
        $this->plkhOptions[3] = ArDmPlKh::loai(3)->orderBy('ma_plkh')->get();
    }

    /**
     * Tạo mới khách hàng.
     */
    protected function createKhachHang(): void
    {
        $khachHang             = new SimbaArDmKh();
        $khachHang->ma_kh      = strtoupper(trim($this->ma_kh));
        $khachHang->ma_cty     = SModel::CTY;
        $khachHang->ten_kh     = $this->ten_kh;
        $khachHang->dia_chi    = $this->dia_chi;
        $khachHang->ma_so_thue = $this->ma_so_thue;
        $khachHang->tel        = $this->dien_thoai;
        $khachHang->fax        = $this->fax;
        $khachHang->email      = $this->email;
        $khachHang->ma_nt      = $this->ma_nt;
        $khachHang->tk_cn      = $this->tk_cn;
        $khachHang->ma_plkh1   = $this->ma_plkh1;
        $khachHang->ma_plkh2   = $this->ma_plkh2;
        $khachHang->ma_plkh3   = $this->ma_plkh3;
        $khachHang->ma_nhkh    = $this->ma_nhkh;
        $khachHang->isKh       = $this->isKh;
        $khachHang->ksd        = true;
        $khachHang->cuser      = auth()->user()->name ?? 'system';
        $khachHang->cdate      = now();
        $khachHang->luser      = auth()->user()->name ?? 'system';
        $khachHang->ldate      = now();

        if ($khachHang->save()) {
            $this->dispatch('success', message: 'Đã thêm khách hàng ' . $khachHang->ma_kh);
            $this->dispatch('khachhang-saved');
            $this->redirect(route('ar.khachhang'), navigate: true);
        } else {
            $this->dispatch('error', message: 'Không thể thêm khách hàng.');
        }
    }

    /**
     * Cập nhật khách hàng.
     */
    protected function updateKhachHang(): void
    {
        $khachHang = ArDmKh::withoutGlobalScopes()
            ->where('ma_kh', $this->ma_kh)
            ->first()
        ;

        if (!$khachHang) {
            $this->dispatch('error', message: 'Không tìm thấy khách hàng.');

            return;
        }

        // Không cho sửa ma_kh khi đã có giao dịch
        if ($this->hasTransactions && $this->ma_kh !== $khachHang->ma_kh) {
            $this->dispatch('error', message: 'Không được sửa mã khách hàng khi đã có giao dịch.');

            return;
        }

        $khachHang->ten_kh     = $this->ten_kh;
        $khachHang->dia_chi    = $this->dia_chi;
        $khachHang->ma_so_thue = $this->ma_so_thue;
        $khachHang->tel        = $this->dien_thoai;
        $khachHang->fax        = $this->fax;
        $khachHang->email      = $this->email;
        $khachHang->ma_nt      = $this->ma_nt;
        $khachHang->tk_cn      = $this->tk_cn;
        $khachHang->ma_plkh1   = $this->ma_plkh1;
        $khachHang->ma_plkh2   = $this->ma_plkh2;
        $khachHang->ma_plkh3   = $this->ma_plkh3;
        $khachHang->ma_nhkh    = $this->ma_nhkh;
        $khachHang->isKh       = $this->isKh;
        $khachHang->luser      = auth()->user()->name ?? 'system';
        $khachHang->ldate      = now();

        if ($khachHang->save()) {
            $this->dispatch('success', message: 'Đã cập nhật khách hàng ' . $khachHang->ma_kh);
            $this->dispatch('khachhang-saved');
            $this->redirect(route('ar.khachhang'), navigate: true);
        } else {
            $this->dispatch('error', message: 'Không thể cập nhật khách hàng.');
        }
    }
}
