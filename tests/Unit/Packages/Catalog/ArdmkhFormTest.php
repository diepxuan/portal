<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Catalog;

use Diepxuan\Catalog\Http\Livewire\Ca\Dict\ArdmkhForm as CaArdmkhForm;
use Diepxuan\Catalog\Http\Livewire\Po\Dict\ArdmkhForm;
use Diepxuan\Catalog\Http\Livewire\So\Dict\ArdmkhForm as SoArdmkhForm;
use Diepxuan\Catalog\Http\Livewire\So\Rpt\Sorptbk01;
use Tests\TestCase;

final class ArdmkhFormTest extends TestCase
{
    public function testFieldHelperIsProtectedSoSubclassesCanLoadDoiTuong(): void
    {
        foreach ([ArdmkhForm::class, SoArdmkhForm::class, CaArdmkhForm::class] as $class) {
            $method = new \ReflectionMethod($class, 'field');
            self::assertTrue($method->isProtected(), "{$class}::field() phai la protected de subclass goi duoc.");
        }
    }

    public function testArdmkhRulesIncludeClassificationAndKsd(): void
    {
        $method = new \ReflectionMethod(ArdmkhForm::class, 'rules');
        $rules = $method->invoke(new ArdmkhForm());

        foreach (['ma_plkh1', 'ma_plkh2', 'ma_plkh3', 'ma_nhkh', 'isKh', 'isNcc', 'isNv', 'ksd'] as $key) {
            self::assertArrayHasKey($key, $rules, "Missing rule {$key}");
        }
    }

    public function testArdmkhPayloadHelpersUseDatabaseDefaults(): void
    {
        $form = new ArdmkhForm();

        $stringValue = new \ReflectionMethod(ArdmkhForm::class, 'stringValue');
        $numberValue = new \ReflectionMethod(ArdmkhForm::class, 'numberValue');

        self::assertSame('', $stringValue->invoke($form, null));
        self::assertSame('abc', $stringValue->invoke($form, 'abc'));
        self::assertSame(0.0, $numberValue->invoke($form, null));
        self::assertSame(12.5, $numberValue->invoke($form, '12.5'));
    }

    public function testProcedureSuccessThrowsOnNonZeroPRet(): void
    {
        $form = new ArdmkhForm();
        $method = new \ReflectionMethod(ArdmkhForm::class, 'assertProcedureSuccess');
        $method->invoke($form, collect([(object) ['pRet' => 0]]));

        $this->expectException(\RuntimeException::class);
        $method->invoke($form, collect([(object) ['pRet' => 1]]));
    }

    public function testSorptbk01FiltersDetailRowsBySttRec(): void
    {
        $component = new Sorptbk01();
        $component->phieuRows = [
            ['STT_REC' => 'P1', 'so_ct' => 'SO1'],
            ['stt_rec' => 'P2', 'so_ct' => 'SO2'],
        ];
        $component->chiTietRows = [
            ['stt_rec' => 'P1', 'ma_vt' => 'VT001'],
            ['Stt_rec' => 'P2', 'ma_vt' => 'VT002'],
        ];

        $component->selectPhieu(0);

        self::assertSame(0, $component->selectedPhieuIndex);
        self::assertSame('P1', $component->selectedPhieu['STT_REC']);
        self::assertCount(1, $component->chiTietFiltered);
        self::assertSame('VT001', $component->chiTietFiltered[0]['ma_vt']);
    }

    public function testSorptbk01PayloadMapsDkttToPMaTT(): void
    {
        $component = new Sorptbk01();
        $component->pMa_ct = 'SO3';
        $component->pMa_dktt = 'TT01';
        $component->pMa_kh = 'KH001';

        $payload = $component->procedurePayload();

        self::assertSame('SO3', $payload['pMa_ct']);
        self::assertSame('TT01', $payload['pMa_TT']);
        self::assertSame('KH001', $payload['pMa_kh']);
        self::assertArrayHasKey('pSoct1', $payload);
        self::assertArrayHasKey('pSoct2', $payload);
    }
}
