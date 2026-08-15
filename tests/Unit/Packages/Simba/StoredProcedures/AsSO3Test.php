<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Simba\StoredProcedures;

use Diepxuan\Simba\StoredProcedures\AsSOGetCT3;
use Diepxuan\Simba\StoredProcedures\AsSOGetPH3;
use Diepxuan\Simba\StoredProcedures\AsSoFilt3;
use Tests\TestCase;

final class AsSO3Test extends TestCase
{
    public function testCallSqlUsesCanonicalProcedureAndParams(): void
    {
        $sql = AsSoFilt3::callSql([
            'pKeyPh' => "ma_cty = '001'",
            'pKeyCt' => "ma_cty = '001'",
        ]);

        self::assertStringContainsString('EXECUTE [dbo].[asSoFilt3]', $sql);
        self::assertStringContainsString('@pKeyPh = N\'ma_cty = \'\'001\'\'\'', $sql);
        self::assertStringContainsString('@pKeyCt = N\'ma_cty = \'\'001\'\'\'', $sql);
    }

    public function testAsSoFilt3BuildsHeaderKeyWithPortalFilters(): void
    {
        self::assertSame(
            "ma_cty = '001' and ma_ct = 'SO3' and ngay_ct >= '2026-08-01' and ngay_ct <= '2026-08-31' and ma_kh like N'KH%' and (so_ct like N'%HD%' or so_seri like N'%HD%' or ma_kh like N'%HD%')",
            AsSoFilt3::keyPh('001', 'SO3', '2026-08-01', '2026-08-31', 'KH', 'HD')
        );
    }

    public function testAsSoFilt3BuildsDetailKeyWithWarehouseFilter(): void
    {
        self::assertSame(
            "ma_cty = '001' and ma_vt = N'VT001' and ma_kho = N'KHO01'",
            AsSoFilt3::keyCt('001', 'VT001', 'KHO01')
        );
    }

    public function testAsSoFilt3EscapesSingleQuotes(): void
    {
        self::assertSame("ma_cty = '001' and ma_ct = 'SO''3'", AsSoFilt3::keyPh('001', "SO'3"));
    }

    public function testAsSoFilt3NormalizesPhRow(): void
    {
        $row = AsSoFilt3::normalizePh((object) [
            'ma_cty' => '001',
            'stt_rec' => '001xSO3001',
            'so_ct' => 'HD001',
            'ma_kh' => 'KH001',
            't_tt' => '123.45',
        ]);

        self::assertSame('HD001', $row['so_ct']);
        self::assertSame('KH001', $row['ma_kh']);
        self::assertSame(123.45, $row['t_tt']);
        self::assertSame('', $row['so_seri']);
    }

    public function testAsSOGetPH3NormalizesHeaderAndDefaults(): void
    {
        $row = AsSOGetPH3::normalizeHeader([
            'stt_rec' => '001xSO3001',
            'so_ct' => 'HD001',
            'ma_kh' => 'KH001',
            'ma_nt' => 'USD',
            'ty_gia' => '25000.5',
        ]);

        self::assertSame('HD001', $row['so_ct']);
        self::assertSame('USD', $row['ma_nt']);
        self::assertSame(25000.5, $row['ty_gia']);
        self::assertSame('', $row['tk_pt']);
        self::assertSame('', $row['tk_thue']);
    }

    public function testAsSOGetCT3NormalizesDetailRow(): void
    {
        $row = AsSOGetCT3::normalizeDetail([
            'stt_rec' => '001xSO3001',
            'stt_rec0' => '1',
            'ma_vt' => 'VT001',
            'ten_vt' => 'Vật tư A',
            'so_luong' => '2',
            'gia_nt2' => '10.5',
            'tien_nt2' => '21',
            'ts_gtgt' => '10',
        ]);

        self::assertSame('VT001', $row['ma_vt']);
        self::assertSame(2.0, $row['so_luong']);
        self::assertSame(10.5, $row['gia_nt2']);
        self::assertSame(21.0, $row['tien_nt2']);
        self::assertSame(10.0, $row['ts_gtgt']);
        self::assertSame('', $row['tk_dt']);
    }
}
