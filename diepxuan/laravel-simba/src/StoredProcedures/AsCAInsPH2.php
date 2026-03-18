<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-03-18 23:50:00
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * Class AsCAInsPH2.
 *
 * Stored procedure: asCAInsPH2
 * Mục đích: Thêm mới phiếu thu/chi (bảng CAPH2 - Cash Phiếu 2).
 * Procedure thực hiện insert bản ghi mới vào bảng CAPH2 với đầy đủ thông tin chứng từ thu/chi tiền mặt.
 *
 * Tham số:
 * - @pMa_cty (nvarchar(3)): Mã công ty. Bắt buộc.
 * - @pStt_rec (nvarchar(20)): Số tham chiếu (stt_rec). Bắt buộc.
 * - @pMa_ct (nvarchar(3)): Mã chứng từ (loại chứng từ). Bắt buộc.
 * - @pSo_ct (nvarchar(12)): Số chứng từ. Bắt buộc.
 * - @pStt_rec_dh (nvarchar(20)): Số tham chiếu đơn hàng (nếu có). Optional, default ''.
 * - @pSo_dh (nvarchar(12)): Số đơn hàng (nếu có). Optional, default ''.
 * - @pNgay_ct (smalldatetime): Ngày chứng từ. Bắt buộc.
 * - @pNgay_lct (smalldatetime): Ngày lập chứng từ. Bắt buộc.
 * - @pMa_kh (nvarchar(20)): Mã khách hàng (nếu có). Optional, default ''.
 * - @pDia_chi (nvarchar(255)): Địa chỉ. Optional, default ''.
 * - @pNguoi_gd (nvarchar(30)): Người giao dịch. Optional, default ''.
 * - @pDien_giai (nvarchar(255)): Diễn giải nội dung. Bắt buộc.
 * - @pTk_co (nvarchar(20)): Tài khoản có (đối với phiếu thu). Bắt buộc.
 * - @pTk_no (nvarchar(20)): Tài khoản nợ (đối với phiếu chi). Bắt buộc.
 * - @pMa_gd (nvarchar(1)): Mã giao dịch. Bắt buộc.
 * - @pMa_nt (nvarchar(3)): Mã ngoại tệ. Bắt buộc.
 * - @pTy_gia (decimal(19,4)): Tỷ giá. Default 1.0.
 * - @pT_tien_nt (decimal(19,4)): Tổng tiền nguyên tệ. Default 0.0.
 * - @pT_tien (decimal(19,4)): Tổng tiền quy đổi. Default 0.0.
 * - @pDu (decimal(19,4)): Số dư. Default 0.0.
 * - @pDu_nt (decimal(19,4)): Số dư nguyên tệ. Default 0.0.
 * - @pTrang_thai (nvarchar(1)): Trạng thái chứng từ. Default '1' (hoạt động).
 * - @pPost2gl (nvarchar(1)): Đã post sang GL. Default '0' (chưa post).
 * - @pLUser (nvarchar(20)): Người dùng thực hiện. Bắt buộc.
 * - @pRet (int, OUTPUT): Tham số đầu ra chứa mã lỗi (@@error).
 *   - 0: Thành công.
 *   - Khác 0: Mã lỗi SQL Server.
 *
 * Giá trị trả về:
 * - Procedure không trả về result set.
 * - Kết quả được trả về qua output parameter @pRet.
 * - Để lấy giá trị @pRet, cần đọc từ result của ProcedureCaller (có SELECT @pRet).
 *
 * Ví dụ gọi:
 * ```php
 * $result = AsCAInsPH2::call([
 *     'pMa_cty' => '001',
 *     'pStt_rec' => 'CA202600001',
 *     'pMa_ct' => 'PT',
 *     'pSo_ct' => '000001',
 *     'pNgay_ct' => '2026-03-18',
 *     'pNgay_lct' => '2026-03-18',
 *     'pDien_giai' => 'Thu tiền bán hàng',
 *     'pTk_co' => '111',
 *     'pTk_no' => '131',
 *     'pMa_gd' => '1',
 *     'pMa_nt' => 'VND',
 *     'pLUser' => 'admin',
 * ]);
 *
 * // Lấy giá trị output parameter
 * $ret = $result->first()->pRet ?? null;
 * if ($ret === 0) {
 *     // Insert thành công
 * } else {
 *     // Có lỗi xảy ra, $ret chứa mã lỗi
 * }
 * ```
 *
 * Lưu ý:
 * - Procedure chỉ thực hiện insert, không kiểm tra trùng số chứng từ.
 * - Cần gọi `asChkSoCt` trước để đảm bảo số chứng từ không trùng.
 * - Tài khoản Tk_co/Tk_no tùy thuộc vào loại phiếu (thu hay chi).
 * - Output parameter @pRet được xử lý tự động bởi ProcedureCaller.
 *
 * @see AsChkSoCt::call() - Kiểm tra trùng số chứng từ trước khi insert
 */
class AsCAInsPH2
{
    /**
     * Gọi stored procedure asCAInsPH2.
     *
     * @param array $params Mảng tham số với các khóa tương ứng tên tham số.
     *                      Các parameters có thể thiếu, sẽ dùng giá trị default.
     *
     * @return Collection Kết quả từ procedure (chứa output parameter pRet).
     */
    public static function call(array $params): Collection
    {
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('asCAInsPH2', [
            'pMa_cty'      => $params['pMa_cty'] ?? null,
            'pStt_rec'     => $params['pStt_rec'] ?? null,
            'pMa_ct'       => $params['pMa_ct'] ?? null,
            'pSo_ct'       => $params['pSo_ct'] ?? null,
            'pStt_rec_dh'  => $params['pStt_rec_dh'] ?? '',
            'pSo_dh'       => $params['pSo_dh'] ?? '',
            'pNgay_ct'     => $params['pNgay_ct'] ?? null,
            'pNgay_lct'    => $params['pNgay_lct'] ?? null,
            'pMa_kh'       => $params['pMa_kh'] ?? '',
            'pDia_chi'     => $params['pDia_chi'] ?? '',
            'pNguoi_gd'    => $params['pNguoi_gd'] ?? '',
            'pDien_giai'   => $params['pDien_giai'] ?? null,
            'pTk_co'       => $params['pTk_co'] ?? null,
            'pTk_no'       => $params['pTk_no'] ?? null,
            'pMa_gd'       => $params['pMa_gd'] ?? null,
            'pMa_nt'       => $params['pMa_nt'] ?? null,
            'pTy_gia'      => $params['pTy_gia'] ?? 1.0,
            'pT_tien_nt'   => $params['pT_tien_nt'] ?? 0.0,
            'pT_tien'      => $params['pT_tien'] ?? 0.0,
            'pDu'          => $params['pDu'] ?? 0.0,
            'pDu_nt'       => $params['pDu_nt'] ?? 0.0,
            'pTrang_thai'  => $params['pTrang_thai'] ?? '1',
            'pPost2gl'     => $params['pPost2gl'] ?? '0',
            'pLUser'       => $params['pLUser'] ?? null,
            'pRet'         => ['type' => 'INT', 'output' => true],
        ], $connection);
    }

    /**
     * Call stored procedure asCAInsPH2 with named parameters (helper method).
     *
     * @param string|null      $Ma_cty    Mã công ty
     * @param string|null      $Stt_rec   Số tham chiếu
     * @param string|null      $Ma_ct     Mã chứng từ
     * @param string|null      $So_ct     Số chứng từ
     * @param string|null      $Stt_rec_dh Số tham chiếu đơn hàng
     * @param string|null      $So_dh     Số đơn hàng
     * @param string|null      $Ngay_ct   Ngày chứng từ
     * @param string|null      $Ngay_lct  Ngày lập chứng từ
     * @param string|null      $Ma_kh     Mã khách hàng
     * @param string|null      $Dia_chi   Địa chỉ
     * @param string|null      $Nguoi_gd  Người giao dịch
     * @param string|null      $Dien_giai Diễn giải
     * @param string|null      $Tk_co     Tài khoản có
     * @param string|null      $Tk_no     Tài khoản nợ
     * @param string|null      $Ma_gd     Mã giao dịch
     * @param string|null      $Ma_nt     Mã ngoại tệ
     * @param float|null       $Ty_gia    Tỷ giá
     * @param float|null       $T_tien_nt Tổng tiền nguyên tệ
     * @param float|null       $T_tien    Tổng tiền quy đổi
     * @param float|null       $Du        Số dư
     * @param float|null       $Du_nt     Số dư nguyên tệ
     * @param string|null      $Trang_thai Trạng thái
     * @param string|null      $Post2gl   Đã post GL
     * @param string|null      $LUser     Người dùng
     *
     * @return Collection Kết quả từ procedure
     */
    public static function callWithParams(
        ?string $Ma_cty = null,
        ?string $Stt_rec = null,
        ?string $Ma_ct = null,
        ?string $So_ct = null,
        ?string $Stt_rec_dh = null,
        ?string $So_dh = null,
        ?string $Ngay_ct = null,
        ?string $Ngay_lct = null,
        ?string $Ma_kh = null,
        ?string $Dia_chi = null,
        ?string $Nguoi_gd = null,
        ?string $Dien_giai = null,
        ?string $Tk_co = null,
        ?string $Tk_no = null,
        ?string $Ma_gd = null,
        ?string $Ma_nt = null,
        ?float $Ty_gia = null,
        ?float $T_tien_nt = null,
        ?float $T_tien = null,
        ?float $Du = null,
        ?float $Du_nt = null,
        ?string $Trang_thai = null,
        ?string $Post2gl = null,
        ?string $LUser = null,
    ): Collection {
        return self::call([
            'pMa_cty'      => $Ma_cty,
            'pStt_rec'     => $Stt_rec,
            'pMa_ct'       => $Ma_ct,
            'pSo_ct'       => $So_ct,
            'pStt_rec_dh'  => $Stt_rec_dh,
            'pSo_dh'       => $So_dh,
            'pNgay_ct'     => $Ngay_ct,
            'pNgay_lct'    => $Ngay_lct,
            'pMa_kh'       => $Ma_kh,
            'pDia_chi'     => $Dia_chi,
            'pNguoi_gd'    => $Nguoi_gd,
            'pDien_giai'   => $Dien_giai,
            'pTk_co'       => $Tk_co,
            'pTk_no'       => $Tk_no,
            'pMa_gd'       => $Ma_gd,
            'pMa_nt'       => $Ma_nt,
            'pTy_gia'      => $Ty_gia,
            'pT_tien_nt'   => $T_tien_nt,
            'pT_tien'      => $T_tien,
            'pDu'          => $Du,
            'pDu_nt'       => $Du_nt,
            'pTrang_thai'  => $Trang_thai,
            'pPost2gl'     => $Post2gl,
            'pLUser'       => $LUser,
        ]);
    }
}
