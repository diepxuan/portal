<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Simba\StoredProcedures;

use Diepxuan\Simba\StoredProcedures\AsPOGetPO3;
use Tests\TestCase;

final class AsPOGetPO3DataSetsTest extends TestCase
{
    public function testCallSqlUsesCanonicalProcedureAndParams(): void
    {
        $sql = AsPOGetPO3::callSql([
            'pMa_cty' => '001',
            'pStt_rec' => '001xPO3001',
        ]);

        self::assertStringContainsString('EXECUTE [dbo].[asPOGetPO3]', $sql);
        self::assertStringContainsString('@pMa_cty = N\'001\'', $sql);
        self::assertStringContainsString('@pStt_rec = N\'001xPO3001\'', $sql);
    }

    public function testCallSqlEscapesSingleQuote(): void
    {
        $sql = AsPOGetPO3::callSql([
            'pMa_cty' => '001',
            'pStt_rec' => "PO'3",
        ]);

        self::assertStringContainsString("@pStt_rec = N'PO''3'", $sql);
    }
}
