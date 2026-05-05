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
 * Class AsArDelDmkh.
 *
 * Stored procedure: SP_AR_DMKH_DELETE
 * Mục đích: Xóa khách hàng khỏi danh mục.
 *
 * Tham số:
 * - @pMa_cty (string): Mã công ty.
 * - @pMa_kh (string): Mã khách hàng.
 * - @pStatus (int, output): Trạng thái kết quả. 0 = thành công.
 */
class AsArDelDmkh
{
    /**
     * Gọi stored procedure SP_AR_DMKH_DELETE.
     *
     * @param array $params tham số truyền vào
     *
     * @return Collection kết quả trả về (chứa output @pStatus)
     */
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('SP_AR_DMKH_DELETE', [
            'pMa_cty' => $paramObj->pMa_cty ?? SModel::CTY,
            'pMa_kh'  => $paramObj->pMa_kh ?? null,
            'pStatus' => ['output' => true, 'type' => 'INT'],
        ], $connection);
    }
}
