<?php

declare(strict_types=1);

namespace Diepxuan\Catalog\Tests\Unit\Http\Livewire\System;

use Diepxuan\Catalog\Http\Livewire\Component\InputYearWorked;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;
use PHPUnit\Framework\TestCase;

final class InputYearWorkedTest extends \Tests\TestCase
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

    public function testSelectYearUpdatesSessionAndRedirectsToCurrentUrl(): void
    {
        Session::start();

        Livewire::test(InputYearWorked::class)
            ->call('selectYear', 2026)
            ->assertSet('selectedYear', 2026)
            ->assertRedirect(url()->current())
        ;

        self::assertSame(2026, Session::get('year'));
    }
}
