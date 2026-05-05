<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-05 20:11:19
 */

namespace Diepxuan\Simba\StoredProcedures;

use Diepxuan\Simba\Helper\ParamHelper;
use Diepxuan\Simba\SModel\SModel;
use Illuminate\Support\Collection;

/**
 * Class AsArChkDmkh.
 *
 * Stored procedure: SP_AR_DMKH_CHECK
 * Mục đích: Kiểm tra trùng mã khách hàng.
 *
 * Tham số:
 * - @pMa_cty (string): Mã công ty.
 * - @pMa_kh (string): Mã khách hàng cần kiểm tra.
 * - @pExists (int, output): 1 = tồn tại, 0 = không tồn tại.
 */
class AsArChkDmkh
{
    /**
     * Gọi stored procedure SP_AR_DMKH_CHECK.
     *
     * @param array $params tham số truyền vào
     *
     * @return Collection kết quả trả về (chứa output @pExists)
     */
    public static function call(array $params): Collection
    {
        $paramObj   = ParamHelper::fromArray($params);
        $connection = (new SModel())->getConnectionName();

        return ProcedureCaller::call('SP_AR_DMKH_CHECK', [
            'pMa_cty' => $paramObj->pMa_cty ?? SModel::CTY,
            'pMa_kh'  => $paramObj->pMa_kh ?? null,
            'pExists' => ['output' => true, 'type' => 'INT'],
        ], $connection);
    }

    /**
     * Kiểm tra nhanh mã khách hàng có tồn tại không.
     *
     * @param string $maKh  mã khách hàng
     * @param string $maCty mã công ty
     *
     * @return bool true nếu tồn tại
     */
    public static function exists(string $maKh, string $maCty = SModel::CTY): bool
    {
        $result = self::call([
            'pMa_cty' => $maCty,
            'pMa_kh'  => $maKh,
        ]);

        if ($result->isNotEmpty()) {
            $first  = $result->first();
            $exists = \is_object($first)
                ? ($first->pExists ?? $first->Exists ?? null)
                : ($first['pExists'] ?? $first['Exists'] ?? null);

            return 1 === (int) $exists;
        }

        return false;
    }
}
