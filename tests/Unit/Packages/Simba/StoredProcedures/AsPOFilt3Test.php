<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Simba\StoredProcedures;

use Diepxuan\Simba\StoredProcedures\AsPOFilt3;
use Tests\TestCase;

final class AsPOFilt3Test extends TestCase
{
    public function testBuildsHeaderKeyWithPortalFilters(): void
    {
        self::assertSame(
            "ma_cty = '001' and ma_ct = 'PO3' and ngay_ct >= '2026-08-01' and ngay_ct <= '2026-08-31' and ma_kh like N'NCC%' and (so_ct like N'%HD%' or so_hd like N'%HD%' or ma_kh like N'%HD%')",
            AsPOFilt3::keyPh('001', 'PO3', '2026-08-01', '2026-08-31', 'NCC', 'HD')
        );
    }

    public function testBuildsDetailKeyWithWarehouseFilter(): void
    {
        self::assertSame(
            "ma_cty = '001' and ma_vt = N'VT001' and ma_kho = N'KHO01'",
            AsPOFilt3::keyCt('001', 'VT001', 'KHO01')
        );
    }

    public function testEscapesSingleQuotes(): void
    {
        self::assertSame("ma_cty = '001' and ma_ct = 'PO''3'", AsPOFilt3::keyPh('001', "PO'3"));
    }

    public function testCallSqlUsesCanonicalProcedureAndParams(): void
    {
        $sql = AsPOFilt3::callSql([
            'pKeyPh' => "ma_cty = '001'",
            'pKeyCt' => "ma_cty = '001'",
        ]);

        self::assertStringContainsString('EXECUTE [dbo].[asPOFilt3]', $sql);
        self::assertStringContainsString('@pKeyPh = N\'ma_cty = \'\'001\'\'\'', $sql);
        self::assertStringContainsString('@pKeyCt = N\'ma_cty = \'\'001\'\'\'', $sql);
    }
}
