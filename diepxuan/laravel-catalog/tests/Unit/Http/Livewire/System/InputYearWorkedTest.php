<?php

declare(strict_types=1);

namespace Diepxuan\Catalog\Tests\Unit\Http\Livewire\System;

use Diepxuan\Catalog\Http\Livewire\Component\InputYearWorked;
use PHPUnit\Framework\TestCase;

final class InputYearWorkedTest extends TestCase
{
    public function testRangeIsCurrentYearMinusTenToPlusTen(): void
    {
        $years = InputYearWorked::availableYears(2026);

        self::assertSame(2016, $years->first());
        self::assertSame(2036, $years->last());
        self::assertCount(21, $years);
    }

    public function testRangeAlwaysIncludesCurrentYearAndBothBounds(): void
    {
        $years = InputYearWorked::availableYears(2026);

        self::assertContains(2016, $years);
        self::assertContains(2026, $years);
        self::assertContains(2036, $years);
    }

    public function testYearRangeConstantMatchesDllWindow(): void
    {
        self::assertSame(10, InputYearWorked::YEAR_RANGE);
    }
}
