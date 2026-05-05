<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-05 20:11:20
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\Helper\ParamHelper;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * Class AsArGetDmkh.
 *
 * Stored procedure: SP_AR_DMKH_GET
 * Mục đích: Lấy danh sách khách hàng với tìm kiếm và phân trang.
 *
 * Tham số:
 * - @pMa_cty (string): Mã công ty.
 * - @pSearch (string): Từ khóa tìm kiếm (ma_kh, ten_kh, dia_chi, dien_thoai).
 * - @pPageIndex (int): Trang hiện tại.
 * - @pPageSize (int): Số lượng mỗi trang.
 */
class AsArGetDmkh
{
    /**
     * Gọi stored procedure SP_AR_DMKH_GET.
     *
     * @param array $params tham số truyền vào
     *
     * @return Collection kết quả trả về
     */
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('SP_AR_DMKH_GET', [
            'pMa_cty'    => $paramObj->pMa_cty ?? SModel::CTY,
            'pSearch'    => $paramObj->pSearch ?? null,
            'pPageIndex' => $paramObj->pPageIndex ?? 1,
            'pPageSize'  => $paramObj->pPageSize ?? 50,
        ], $connection);
    }
}
