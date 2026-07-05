<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Simba\StoredProcedures;

use Diepxuan\Simba\StoredProcedures\AsINRptCD02;
use Tests\TestCase;

final class AsINRptCD02Test extends TestCase
{
    public function testProcedureParamsUseDocumentedInrptcd02Arguments(): void
    {
        self::assertSame([
            'pMa_cty'      => 'GBB',
            'pMa_vt'       => 'VT001',
            'pMa_kho'      => 'KHO01',
            'pMa_vitri'    => 'A01',
            'pTk_vt'       => '1561',
            'pMa_nhvt'     => 'NH01',
            'pNgay'        => '2026-07-05',
            'pDVT'         => '0',
            'pNgoai_te'    => '1',
            'pDk_Ck'       => true,
            'pMa_lo'       => 'LO01',
            'pQuaToiThieu' => false,
            'pQuaToiDa'    => true,
        ], AsINRptCD02::procedureParams([
            'pMa_cty'      => 'GBB',
            'pMa_vt'       => 'VT001',
            'pMa_kho'      => 'KHO01',
            'pMa_vitri'    => 'A01',
            'pTk_vt'       => '1561',
            'pMa_nhvt'     => 'NH01',
            'pNgay'        => '2026-07-05',
            'pDVT'         => '0',
            'pNgoai_te'    => '1',
            'pDk_Ck'       => true,
            'pMa_lo'       => 'LO01',
            'pQuaToiThieu' => false,
            'pQuaToiDa'    => true,
            'pSysMsg1'     => 'ignored',
        ]));
    }

    public function testProcedureParamsAcceptLegacyCompanyAlias(): void
    {
        self::assertSame([
            'pMa_cty'      => 'GBB',
            'pMa_vt'       => 'VT001',
            'pMa_kho'      => 'KHO01',
            'pMa_vitri'    => null,
            'pTk_vt'       => null,
            'pMa_nhvt'     => null,
            'pNgay'        => '2026-07-05',
            'pDVT'         => null,
            'pNgoai_te'    => null,
            'pDk_Ck'       => null,
            'pMa_lo'       => null,
            'pQuaToiThieu' => null,
            'pQuaToiDa'    => null,
        ], AsINRptCD02::procedureParams([
            'pMa_Cty' => 'GBB',
            'ma_vt'   => 'VT001',
            'ma_kho'  => 'KHO01',
            'ngay'    => '2026-07-05',
        ]));
    }
}
