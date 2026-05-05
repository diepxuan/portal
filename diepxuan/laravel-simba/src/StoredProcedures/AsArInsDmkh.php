<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-05 20:11:22
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\Helper\ParamHelper;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * Class AsArInsDmkh.
 *
 * Stored procedure: SP_AR_DMKH_INSERT
 * Mục đích: Thêm mới khách hàng vào danh mục.
 *
 * Tham số:
 * - @pMa_cty (string): Mã công ty.
 * - @pMa_kh (string): Mã khách hàng.
 * - @pTen_kh (string): Tên khách hàng.
 * - @pDia_chi (string): Địa chỉ.
 * - @pMa_so_thue (string): Mã số thuế.
 * - @pDien_thoai (string): Điện thoại.
 * - @pFax (string): Fax.
 * - @pEmail (string): Email.
 * - @pMa_nt (string): Mã ngoại tệ.
 * - @pTk_cn (string): Tài khoản công nợ.
 * - @pMa_plkh1 (string): Phân loại KH 1.
 * - @pMa_plkh2 (string): Phân loại KH 2.
 * - @pMa_plkh3 (string): Phân loại KH 3.
 * - @pMa_nhkh (string): Nhóm khách hàng.
 * - @pIsKh (bool): Là khách hàng.
 * - @pStatus (int, output): Trạng thái kết quả.
 */
class AsArInsDmkh
{
    /**
     * Gọi stored procedure SP_AR_DMKH_INSERT.
     *
     * @param array $params tham số truyền vào
     *
     * @return Collection kết quả trả về (chứa output @pStatus)
     */
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('SP_AR_DMKH_INSERT', [
            'pMa_cty'     => $paramObj->pMa_cty ?? SModel::CTY,
            'pMa_kh'      => $paramObj->pMa_kh ?? null,
            'pTen_kh'     => $paramObj->pTen_kh ?? null,
            'pDia_chi'    => $paramObj->pDia_chi ?? null,
            'pMa_so_thue' => $paramObj->pMa_so_thue ?? null,
            'pDien_thoai' => $paramObj->pDien_thoai ?? null,
            'pFax'        => $paramObj->pFax ?? null,
            'pEmail'      => $paramObj->pEmail ?? null,
            'pMa_nt'      => $paramObj->pMa_nt ?? 'VND',
            'pTk_cn'      => $paramObj->pTk_cn ?? null,
            'pMa_plkh1'   => $paramObj->pMa_plkh1 ?? null,
            'pMa_plkh2'   => $paramObj->pMa_plkh2 ?? null,
            'pMa_plkh3'   => $paramObj->pMa_plkh3 ?? null,
            'pMa_nhkh'    => $paramObj->pMa_nhkh ?? null,
            'pIsKh'       => $paramObj->pIsKh ?? true,
            'pStatus'     => ['output' => true, 'type' => 'INT'],
        ], $connection);
    }
}
