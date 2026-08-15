<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Catalog;

use Diepxuan\Catalog\Http\Livewire\Po\Vch\Povchpo3;
use Tests\TestCase;

final class Povchpo3Test extends TestCase
{
    public function testListSelectPhieuFiltersDetailRowsAndTogglesOff(): void
    {
        $component = new Povchpo3();
        $component->phieuRows = [
            ['stt_rec' => 'PO1', 'so_ct' => 'HD001'],
            ['stt_rec' => 'PO2', 'so_ct' => 'HD002'],
        ];
        $component->chiTietRows = [
            ['stt_rec' => 'PO1', 'ma_vt' => 'VT1'],
            ['stt_rec' => 'PO2', 'ma_vt' => 'VT2'],
        ];

        $component->selectPhieu(0);

        self::assertSame(0, $component->selectedPhieuIndex);
        self::assertSame([['stt_rec' => 'PO1', 'ma_vt' => 'VT1']], $component->chiTietFiltered);

        $component->selectPhieu(0);

        self::assertNull($component->selectedPhieuIndex);
        self::assertSame([], $component->chiTietFiltered);
    }

    public function testListSelectPhieuSwitchesBetweenRows(): void
    {
        $component = new Povchpo3();
        $component->phieuRows = [
            ['stt_rec' => 'PO1', 'so_ct' => 'HD001'],
            ['stt_rec' => 'PO2', 'so_ct' => 'HD002'],
        ];
        $component->chiTietRows = [
            ['stt_rec' => 'PO1', 'ma_vt' => 'VT1'],
            ['stt_rec' => 'PO2', 'ma_vt' => 'VT2'],
        ];

        $component->selectPhieu(0);
        $component->selectPhieu(1);

        self::assertSame(1, $component->selectedPhieuIndex);
        self::assertSame([['stt_rec' => 'PO2', 'ma_vt' => 'VT2']], $component->chiTietFiltered);
    }
}
