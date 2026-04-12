<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-12 17:13:42
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\Helper\ParamHelper;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * Class AsCAGetPH2.
 *
 * Stored procedure: `asCAGetPH2`
 *
 * ## Mục đích
 *
 * Lấy danh sách phiếu hàng 2 (PH2) từ hệ thống Simba.
 * Procedure trả về danh sách các phiếu hàng loại 2 được sử dụng trong kế toán công nợ phải trả (Nhà cung cấp).
 *
 * ## Nhóm chứng từ
 *
 * | Mã CT | Diễn giải | Loại |
 * |-------|-----------|------|
 * | CA4   | Phiếu báo nợ | Công nợ phải trả |
 *
 * ## Fields trả về
 *
 * Procedure trả về Collection với các fields sau (từ bảng `CaPh2`):
 *
 * | Field | Kiểu | Diễn giải |
 * |-------|------|-----------|
 * | `ma_cty` | string(3) | Mã công ty |
 * | `stt_rec` | string(20) | Số thứ tự bản ghi (PK) |
 * | `ma_ct` | string(3) | Mã chứng từ (ví dụ: CA4) |
 * | `so_ct` | string(20) | Số chứng từ |
 * | `ngay_ct` | datetime | Ngày chứng từ |
 * | `ngay_lct` | datetime | Ngày lập chứng từ |
 * | `kht_tain` | boolean | Kế hoạch tài chính |
 * | `ma_kh` | string(20) | Mã khách hàng/Nhà cung cấp |
 * | `dia_chi` | string(255) | Địa chỉ |
 * | `nguoi_gd` | string(30) | Người giao dịch |
 * | `dien_giai` | string(255) | Diễn giải |
 * | `tk_co` | string(20) | Tài khoản Có |
 * | `ma_nt` | string(3) | Mã ngoại tệ |
 * | `ty_gia` | float | Tỷ giá |
 * | `t_tien` | float | Tổng tiền VNĐ |
 * | `t_tien_nt` | float | Tổng tiền ngoại tệ |
 * | `t_thue_nt` | float | Thuế ngoại tệ |
 * | `t_thue` | float | Thuế VNĐ |
 * | `t_tt` | float | Tổng thanh toán VNĐ |
 * | `t_tt_nt` | float | Tổng thanh toán ngoại tệ |
 * | `stt_rec_hd` | string(20) | STT rec hóa đơn (nếu có) |
 * | `trang_thai` | string | Trạng thái |
 * | `post2gl` | string | Đã post GL chưa |
 * | `cdate` | datetime | Ngày tạo |
 * | `cuser` | string | Người tạo |
 * | `ldate` | datetime | Ngày sửa |
 * | `luser` | string | Người sửa |
 *
 * ## Phương thức
 *
 * | Method | Mô tả | Trả về |
 * |--------|-------|--------|
 * | `call(array $params)` | Gọi procedure với tham số | `Collection` |
 * | `callWithParams()` | Gọi procedure với named parameters | `Collection` |
 * | `getAll()` | Lấy tất cả phiếu | `Collection` |
 *
 * ## Ví dụ sử dụng
 *
 * ```php
 * use Diepxuan\Simba\StoredProcedures\AsCAGetPH2;
 *
 * // 1. Lấy 1 phiếu theo stt_rec
 * $phieu = AsCAGetPH2::call(['pStt_rec' => 'CA420240101001'])->first();
 * if ($phieu) {
 *     echo $phieu->so_ct; // Số chứng từ
 *     echo $phieu->ma_kh; // Mã khách hàng
 *     echo $phieu->t_tt;  // Tổng thanh toán
 * }
 *
 * // 2. Lấy tất cả phiếu
 * $allPhieu = AsCAGetPH2::call([]);
 *
 * // 3. Gọi với callWithParams()
 * $result = AsCAGetPH2::callWithParams(pStt_rec: 'CA420240101001');
 *
 * // 4. Lọc kết quả sau khi gọi
 * $phieuCA4 = AsCAGetPH2::call([])
 *     ->where('ma_ct', 'CA4')
 *     ->where('ma_kh', 'KH001')
 *     ->first();
 * ```
 *
 * ## Lưu ý
 *
 * - Procedure thuộc nhóm Get (`asCAGet*`), không có output parameter.
 * - Kết quả trả về là Laravel Collection, có thể dùng các method `filter()`, `first()`, `where()`, v.v.
 * - Để lấy 1 phiếu cụ thể, dùng `call(['pStt_rec' => '...'])->first()`.
 * - Các field datetime (`ngay_ct`, `ngay_lct`, `cdate`, `ldate`) được cast thành `\DateTime` object.
 *
 * ## Tham chiếu
 *
 * - Model: `Diepxuan\\Simba\\SModel\\CaPh2Model`
 * - Bảng: `CaPh2`
 * - Procedure liên quan: `asCAGetCT2` (lấy chi tiết phiếu)
 */
class AsCAGetPH2
{
    /**
     * Gọi stored procedure asCAGetPH2.
     *
     * @param array $params Mảng tham số với các khóa tương ứng tên tham số.
     *                      Các parameters có thể thiếu, sẽ dùng giá trị default.
     *
     * @return Collection kết quả từ procedure
     */
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('asCAGetPH2', [
            'pMa_cty'  => $paramObj->pMa_cty ?? null,
            'pStt_rec' => $paramObj->pStt_rec ?? null,
            'pLUser'   => $paramObj->pLUser ?? null,
        ], $connection);
    }

    /**
     * Call stored procedure asCAGetPH2 with named parameters (helper method).
     *
     * @param null|string $Ma_cty  Mã công ty
     * @param null|string $Stt_rec Số tham chiếu
     * @param null|string $LUser   Người dùng
     *
     * @return Collection Kết quả từ procedure
     */
    public static function callWithParams(
        ?string $Ma_cty = null,
        ?string $Stt_rec = null,
        ?string $LUser = null,
    ): Collection {
        return self::call([
            'pMa_cty'  => $Ma_cty,
            'pStt_rec' => $Stt_rec,
            'pLUser'   => $LUser,
        ]);
    }
}
