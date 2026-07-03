<?php

declare(strict_types=1);

namespace Diepxuan\Catalog\Tests\Unit\Http\Livewire\So\Rpt;

use Diepxuan\Catalog\Http\Livewire\So\Rpt\Arrptbccn01;
use Tests\TestCase;

final class Arrptbccn01Test extends TestCase
{
    public function testDisplayValueNormalizesScalarValuesForReportTable(): void
    {
        $component = new Arrptbccn01();

        self::assertSame('', $component->displayValue(null));
        self::assertSame('1', $component->displayValue(true));
        self::assertSame('0', $component->displayValue(false));
        self::assertSame('1250.5', $component->displayValue(1250.5));
        self::assertSame('', $component->displayValue(['unexpected']));
    }

    public function testNumericColumnDetectionMatchesReportTableAlignment(): void
    {
        $component = new Arrptbccn01();

        self::assertTrue($component->isNumericColumn('ps_no'));
        self::assertTrue($component->isNumericColumn('du_ck'));
        self::assertTrue($component->isNumericColumn('t_tt_nt'));
        self::assertTrue($component->isNumericColumn('tien_fm'));

        self::assertFalse($component->isNumericColumn('ma_nt'));
        self::assertFalse($component->isNumericColumn('ma_kh'));
        self::assertFalse($component->isNumericColumn('tk'));
        self::assertFalse($component->isNumericColumn('dien_giai'));
    }
}
