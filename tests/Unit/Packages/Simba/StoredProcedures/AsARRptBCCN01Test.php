<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Simba\StoredProcedures;

use Diepxuan\Simba\StoredProcedures\AsARRptBCCN01;
use Tests\TestCase;

final class AsARRptBCCN01Test extends TestCase
{
    public function testProcedureParamsUseDocumentedArrptbccn01Arguments(): void
    {
        self::assertSame([
            'ma_cty' => 'GBB',
            'Ngay1'  => '2026-06-01',
            'Ngay2'  => '2026-06-30',
            'Tk'     => '131',
            'ma_kh'  => 'KH001',
            'ma_nt'  => '',
        ], AsARRptBCCN01::procedureParams([
            'ma_cty' => 'GBB',
            'Ngay1'  => '2026-06-01',
            'Ngay2'  => '2026-06-30',
            'Tk'     => '131',
            'ma_kh'  => 'KH001',
            'ma_nt'  => '',
        ]));
    }

    public function testProcedureParamsAcceptPortalPrefixedAliases(): void
    {
        self::assertSame([
            'ma_cty' => 'GBB',
            'Ngay1'  => '2026-06-01',
            'Ngay2'  => '2026-06-30',
            'Tk'     => '131',
            'ma_kh'  => 'KH001',
            'ma_nt'  => 'USD',
        ], AsARRptBCCN01::procedureParams([
            'pMa_cty' => 'GBB',
            'pNgay1'  => '2026-06-01',
            'pNgay2'  => '2026-06-30',
            'pTk'     => '131',
            'pMa_kh'  => 'KH001',
            'pMa_nt'  => 'USD',
        ]));
    }
}
