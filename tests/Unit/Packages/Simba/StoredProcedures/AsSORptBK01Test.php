<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Simba\StoredProcedures;

use Diepxuan\Simba\StoredProcedures\AsSORptBK01;
use Tests\TestCase;

final class AsSORptBK01Test extends TestCase
{
    public function testProcedureParamsUseDocumentedSorptbk01Arguments(): void
    {
        self::assertSame([
            'pMa_cty'   => 'GBB',
            'pNgay1'    => '2026-07-01',
            'pNgay2'    => '2026-07-31',
            'pMa_ct'    => 'SO3',
            'pTrang_thai' => '',
            'pMa_kh'    => 'KH001',
            'pMa_nhkh'  => 'NH01',
            'pMa_vt'    => 'VT001',
            'pMa_nhvt'  => 'NVT01',
            'pMa_kho'   => 'KHO01',
            'pMa_vitri' => 'A01',
            'pMa_lo'    => 'LO01',
            'pMa_httt'  => 'TM',
            'pMa_TT'    => 'TT01',
            'pMa_bp'    => 'BP01',
            'pMa_nvkd'  => 'NV01',
            'pMa_spct'  => 'SPCT01',
            'pMa_hd'    => 'HD01',
            'pMa_nhhd'  => 'NHD01',
            'pMa_nt'    => 'USD',
            'pSoct1'    => 'HD0001',
            'pSoct2'    => 'HD0100',
            'pMa_plkh1' => 'PL1',
            'pMa_plkh2' => 'PL2',
            'pMa_plkh3' => 'PL3',
            'pMa_plvt1' => 'PLV1',
            'pMa_plvt2' => 'PLV2',
            'pMa_plvt3' => 'PLV3',
        ], AsSORptBK01::procedureParams([
            'pMa_cty'   => 'GBB',
            'pNgay1'    => '2026-07-01',
            'pNgay2'    => '2026-07-31',
            'pMa_ct'    => 'SO3',
            'pTrang_thai' => '',
            'pMa_kh'    => 'KH001',
            'pMa_nhkh'  => 'NH01',
            'pMa_vt'    => 'VT001',
            'pMa_nhvt'  => 'NVT01',
            'pMa_kho'   => 'KHO01',
            'pMa_vitri' => 'A01',
            'pMa_lo'    => 'LO01',
            'pMa_httt'  => 'TM',
            'pMa_TT'    => 'TT01',
            'pMa_bp'    => 'BP01',
            'pMa_nvkd'  => 'NV01',
            'pMa_spct'  => 'SPCT01',
            'pMa_hd'    => 'HD01',
            'pMa_nhhd'  => 'NHD01',
            'pMa_nt'    => 'USD',
            'pSoct1'    => 'HD0001',
            'pSoct2'    => 'HD0100',
            'pMa_plkh1' => 'PL1',
            'pMa_plkh2' => 'PL2',
            'pMa_plkh3' => 'PL3',
            'pMa_plvt1' => 'PLV1',
            'pMa_plvt2' => 'PLV2',
            'pMa_plvt3' => 'PLV3',
        ]));
    }

    public function testProcedureParamsAcceptUnprefixedAliases(): void
    {
        self::assertSame([
            'pMa_cty'   => 'GBB',
            'pNgay1'    => '2026-07-01',
            'pNgay2'    => '2026-07-31',
            'pMa_ct'    => null,
            'pTrang_thai' => null,
            'pMa_kh'    => null,
            'pMa_nhkh'  => null,
            'pMa_vt'    => null,
            'pMa_nhvt'  => null,
            'pMa_kho'   => null,
            'pMa_vitri' => null,
            'pMa_lo'    => null,
            'pMa_httt'  => null,
            'pMa_TT'    => null,
            'pMa_bp'    => null,
            'pMa_nvkd'  => null,
            'pMa_spct'  => null,
            'pMa_hd'    => null,
            'pMa_nhhd'  => null,
            'pMa_nt'    => 'USD',
            'pSoct1'    => null,
            'pSoct2'    => null,
            'pMa_plkh1' => null,
            'pMa_plkh2' => null,
            'pMa_plkh3' => null,
            'pMa_plvt1' => null,
            'pMa_plvt2' => null,
            'pMa_plvt3' => null,
        ], AsSORptBK01::procedureParams([
            'ma_cty' => 'GBB',
            'Ngay1'  => '2026-07-01',
            'Ngay2'  => '2026-07-31',
            'ma_nt'  => 'USD',
        ]));
    }
}
