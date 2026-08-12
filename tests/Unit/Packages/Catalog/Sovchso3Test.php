<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Catalog;

use Diepxuan\Catalog\Http\Livewire\So\Vch\Sovchso3;
use Diepxuan\Catalog\Http\Livewire\So\Vch\Sovchso3Edit;
use Tests\TestCase;

final class Sovchso3Test extends TestCase
{
    public function testListAndEditUseCanonicalSo3RouteName(): void
    {
        self::assertSame('so.vch.sovchso3', 'so.vch.sovchso3');
        self::assertSame('so.vch.sovchso3.create', 'so.vch.sovchso3.create');
        self::assertSame('so.vch.sovchso3.edit', 'so.vch.sovchso3.edit');
    }

    public function testListConstantsUseSo3(): void
    {
        self::assertSame('SO3', Sovchso3::MA_CT);
    }

    public function testEditConstantsUseSo3(): void
    {
        self::assertSame('SO3', Sovchso3Edit::MA_CT);
    }

    public function testEditExposesRequiredHeaderFields(): void
    {
        $component = new Sovchso3Edit();

        self::assertSame('', $component->pMa_kh);
        self::assertSame('', $component->pSo_ct);
        self::assertSame('', $component->pSo_seri);
        self::assertSame('VND', $component->pMa_nt);
        self::assertSame(1.0, $component->pTy_gia);
        self::assertSame([], $component->pChiTiet);
    }

    public function testEditCalculatesDetailTotals(): void
    {
        $component = new Sovchso3Edit();
        $component->pTy_gia = 2;
        $component->pChiTiet = [[
            'stt_rec0' => '', 'so_luong' => 3, 'gia_nt2' => 100, 'gia2' => 0,
            'tien_nt2' => 0, 'tien2' => 0, 'tl_ck' => 10, 'tien_ck_nt' => 0, 'tien_ck' => 0,
            'ck_ds_nt' => 0, 'ck_ds' => 0, 'ts_gtgt' => 10, 'thue_gtgt_nt' => 0, 'thue_gtgt' => 0,
            'tt_nt' => 0, 'tt' => 0,
        ]];

        $component->calculateChiTietRow(0);

        self::assertSame(300.0, $component->pChiTiet[0]['tien_nt2']);
        self::assertSame(600.0, $component->pChiTiet[0]['tien2']);
        self::assertSame(30.0, $component->pChiTiet[0]['tien_ck_nt']);
        self::assertSame(60.0, $component->pChiTiet[0]['tien_ck']);
        self::assertSame(27.0, $component->pChiTiet[0]['thue_gtgt_nt']);
        self::assertSame(54.0, $component->pChiTiet[0]['thue_gtgt']);
        self::assertSame(297.0, $component->pChiTiet[0]['tt_nt']);
        self::assertSame(594.0, $component->pChiTiet[0]['tt']);
        self::assertSame(300.0, $component->pT_tien_nt2);
        self::assertSame(30.0, $component->pT_ck_nt);
        self::assertSame(27.0, $component->pT_thue_nt);
        self::assertSame(297.0, $component->pT_tt_nt);
    }

    public function testEditRecalculatesCkDsAndTotals(): void
    {
        $component = new Sovchso3Edit();
        $component->pTy_gia = 1;
        $component->pTl_ck_ds = 5;
        $component->pChiTiet = [[
            'stt_rec0' => '', 'so_luong' => 2, 'gia_nt2' => 100, 'gia2' => 100,
            'tien_nt2' => 200, 'tien2' => 200, 'tl_ck' => 0, 'tien_ck_nt' => 0, 'tien_ck' => 0,
            'ck_ds_nt' => 0, 'ck_ds' => 0, 'ts_gtgt' => 10, 'thue_gtgt_nt' => 0, 'thue_gtgt' => 0,
            'tt_nt' => 0, 'tt' => 0,
        ]];

        $component->updatedPTlCkDs();

        self::assertSame(10.0, $component->pChiTiet[0]['ck_ds_nt']);
        self::assertSame(10.0, $component->pChiTiet[0]['ck_ds']);
        self::assertSame(10.0, $component->pT_ck_ds_nt);
        self::assertSame(209.0, $component->pT_tt_nt);
    }
}
