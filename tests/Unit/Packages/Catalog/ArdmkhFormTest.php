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

    public function testSorptbk01PhieuColumnsIncludeVoucherTypeColumn(): void
    {
        $component = new Sorptbk01();
        $columns = $component->phieuColumns();

        self::assertSame('ma_ct', $columns[0]['key']);
        self::assertSame('Loại phiếu', $columns[0]['label']);
    }

    public function testSorptbk01PhieuColumnsUseAsSORptBK01ResultNames(): void
    {
        $component = new Sorptbk01();
        $component->phieuRows = [[
            'tien2'     => '70000',
            'thue_gtgt' => '7000',
            'tt'        => '77000',
            'tien_nt2'  => '70',
            'thue_gtgt_nt' => '7',
            'tt_nt'     => '77',
        ]];

        $columns = $component->phieuColumns();
        $keys = array_column($columns, 'key');

        self::assertContains('tien2', $keys);
        self::assertContains('thue_gtgt', $keys);
        self::assertContains('tt', $keys);
        self::assertNotContains('t_tien', $keys);
        self::assertNotContains('t_thue', $keys);
        self::assertNotContains('t_tt', $keys);

        $labels = array_column($columns, 'label');
        self::assertContains('Tiền VND', $labels);
        self::assertContains('Thuế VND', $labels);
        self::assertContains('Thanh toán VND', $labels);
    }

    public function testSorptbk01PhieuMoneyCellsUseAsSORptBK01ResultNames(): void
    {
        $component = new Sorptbk01();

        self::assertSame('70,000', $component->phieuCellValue(['tien2' => '70000'], 'tien2'));
        self::assertSame('7,000', $component->phieuCellValue(['thue_gtgt' => '7000'], 'thue_gtgt'));
        self::assertSame('77,000', $component->phieuCellValue(['tt' => '77000'], 'tt'));
        self::assertSame('70', $component->phieuCellValue(['tien_nt2' => '70'], 'tien2'));
        self::assertSame('7', $component->phieuCellValue(['thue_gtgt_nt' => '7'], 'thue_gtgt'));
        self::assertSame('77', $component->phieuCellValue(['tt_nt' => '77'], 'tt'));
    }

    public function testSorptbk01VoucherTypeCellMapsMaCtToTenCt(): void
    {
        $component = new Sorptbk01();
        $component->voucherTypes = [
            ['ma_ct' => 'SO3', 'ten_ct' => 'Hóa đơn bán hàng'],
            ['ma_ct' => 'SO4', 'ten_ct' => 'Phiếu nhập hàng bán bị trả lại'],
        ];

        self::assertSame('Hóa đơn bán hàng', $component->phieuCellValue(['ma_ct' => 'SO3'], 'ma_ct'));
        self::assertSame('Phiếu nhập hàng bán bị trả lại', $component->phieuCellValue(['MA_CT' => 'SO4'], 'ma_ct'));
        self::assertSame('SO5', $component->phieuCellValue(['ma_ct' => 'SO5'], 'ma_ct'));
        self::assertSame('', $component->phieuCellValue([], 'ma_ct'));
    }

    public function testSorptbk01PhieuMoneyCellNegativeUsesRedText(): void
    {
        $component = new Sorptbk01();

        self::assertSame('text-red-500', $component->phieuCellClass(['t_tien' => '-500000'], 't_tien'));
        self::assertSame('text-red-500', $component->phieuCellClass(['T_TIEN' => '-500000'], 't_tien'));
        self::assertSame('text-gray-700', $component->phieuCellClass(['t_tien' => '500000'], 't_tien'));
        self::assertSame('text-gray-700', $component->phieuCellClass(['t_tien' => '0'], 't_tien'));
        self::assertSame('text-gray-700', $component->phieuCellClass([], 't_tien'));
    }

    public function testSorptbk01PhieuMoneyCellRedWhenReturnVoucherSo4(): void
    {
        $component = new Sorptbk01();

        // SO4 luu so tien duong trong SoPh4; dau am chi ap dung khi post GL —
        // phai nhan dien theo ma_ct de phiếu tra hang co mau.
        self::assertSame('text-red-500', $component->phieuCellClass(['ma_ct' => 'SO4', 't_tien' => '500000'], 't_tien'));
        self::assertSame('text-red-500', $component->phieuCellClass(['MA_CT' => 'SO4', 't_thue' => '50000'], 't_thue'));
        self::assertSame('text-gray-700', $component->phieuCellClass(['ma_ct' => 'SO3', 't_tien' => '500000'], 't_tien'));
        self::assertSame('text-gray-700', $component->phieuCellClass(['ma_ct' => 'SO4', 'ten_kh' => 'KH'], 'ten_kh'));
    }

    public function testSorptbk01PhieuEmptyMoneyCellShowsPlaceholder(): void
    {
        $component = new Sorptbk01();

        self::assertSame('—', $component->phieuCellValue(['t_tien' => null], 't_tien'));
        self::assertSame('—', $component->phieuCellValue([], 't_tien'));
        self::assertSame('-500,000', $component->phieuCellValue(['t_tien' => '-500000'], 't_tien'));
        self::assertSame('500,000', $component->phieuCellValue(['t_tien' => '500000'], 't_tien'));
    }

    public function testSorptbk01ChiTietNegativeQuantityAndMoneyUseRedText(): void
    {
        $component = new Sorptbk01();

        self::assertSame('text-red-500', $component->chiTietCellClass(['so_luong' => '-2'], 'so_luong'));
        self::assertSame('text-red-500', $component->chiTietCellClass(['tien' => '-100000'], 'tien'));
        self::assertSame('text-red-500', $component->chiTietCellClass(['thue_gtgt' => '-10000'], 'thue_gtgt'));
        self::assertSame('text-gray-700', $component->chiTietCellClass(['so_luong' => '2'], 'so_luong'));
        self::assertSame('text-gray-700', $component->chiTietCellClass(['tien' => '100000'], 'tien'));
        self::assertSame('text-gray-700', $component->chiTietCellClass(['so_luong' => '2'], 'ma_vt'));
    }

    public function testSorptbk01ChiTietColumnsUseAsSORptBK01ResultNames(): void
    {
        $component = new Sorptbk01();
        $component->chiTietRows = [[
            'gia2'      => '70000',
            'tien2'     => '70000',
            'thue_gtgt' => '7000',
            'tt'        => '77000',
        ]];

        $keys = array_column($component->chiTietColumns(), 'key');

        self::assertContains('gia2', $keys);
        self::assertContains('tien2', $keys);
        self::assertContains('thue_gtgt', $keys);
        self::assertContains('tt', $keys);
    }

    public function testSorptbk01ChiTietMoneyCellRedWhenSelectedPhieuIsSo4(): void
    {
        $component = new Sorptbk01();
        $component->selectedPhieu = ['ma_ct' => 'SO4'];

        self::assertSame('text-red-500', $component->chiTietCellClass(['so_luong' => '2'], 'so_luong'));
        self::assertSame('text-red-500', $component->chiTietCellClass(['tien' => '100000'], 'tien'));
        self::assertSame('text-gray-700', $component->chiTietCellClass(['so_luong' => '2'], 'ma_vt'));
    }

    public function testSorptbk01PhieuColumnsAppendAllSpResultFields(): void
    {
        $component = new Sorptbk01();
        $component->phieuRows = [[
            'stt_rec'  => 'P1',
            'ma_ct'    => 'SO3',
            'so_ct'    => 'HD001',
            'dien_giai' => 'Ghi chú bán hàng',
            'ma_nt'    => 'VND',
            'ty_gia'   => '24000',
            'so_seri'  => '01AA',
            'ngay_lct' => '2026-07-01',
            't_ck'     => '10000',
        ]];

        $keys = array_column($component->phieuColumns(), 'key');

        // Các cột quen thuộc vẫn đứng trước
        self::assertSame('ma_ct', $keys[0]);
        // Các cột phụ của SP được tự bổ sung (giống SimbaERP auto-generate)
        self::assertContains('dien_giai', $keys);
        self::assertContains('ma_nt', $keys);
        self::assertContains('ty_gia', $keys);
        self::assertContains('so_seri', $keys);
        self::assertContains('ngay_lct', $keys);
        self::assertContains('t_ck', $keys);
        // Cột liên kết nội bộ không hiển thị
        self::assertNotContains('stt_rec', $keys);
    }

    public function testSorptbk01DynamicColumnsSkipInactiveCurrencyVariants(): void
    {
        $component = new Sorptbk01();
        $component->phieuRows = [[
            'tien2'    => '1000000',
            'tien_nt2' => '1000',
            't_ck'     => '10000',
            't_ck_nt'  => '10',
        ]];

        // Mặc định VND: cột quen thuộc lấy tien2, bỏ qua biến thể NT động (t_ck_nt)
        $keys = array_column($component->phieuColumns(), 'key');
        self::assertContains('tien2', $keys);
        self::assertNotContains('tien_nt2', $keys);
        self::assertNotContains('t_ck_nt', $keys);
        self::assertContains('t_ck', $keys);

        // Chọn NT: cột quen thuộc giữ key, cột động giữ biến thể NT, bỏ VND
        $component->pMa_nt = 'USD';
        $keys = array_column($component->phieuColumns(), 'key');
        self::assertContains('tien2', $keys);
        self::assertNotContains('t_ck', $keys);
        self::assertContains('t_ck_nt', $keys);
    }

    public function testSorptbk01DynamicColumnsSkipRawFieldsWithoutLabels(): void
    {
        $component = new Sorptbk01();
        $component->phieuRows = [[
            'ma_cty'    => '001',
            'stt_rec0'  => '001',
            'stt_rec'   => 'P1',
            'ma_lo'     => 'LO01',
            'tk_pt'     => '131',
            'tk_thue'   => '3331',
            'ma_nt'     => 'VND',
            'ty_gia'    => '1',
            'dien_giai' => 'Ghi chú bán hàng',
            'nguoi_gd'  => 'Chị Thuận',
            'so_seri'   => '01AA',
        ]];

        $keys = array_column($component->phieuColumns(), 'key');

        // Cột liên kết nội bộ không hiển thị.
        self::assertNotContains('stt_rec', $keys);
        self::assertContains('ma_nt', $keys);
        self::assertContains('ty_gia', $keys);
        self::assertContains('dien_giai', $keys);
        self::assertContains('nguoi_gd', $keys);
        self::assertContains('so_seri', $keys);

        self::assertNotContains('ma_cty', $keys);
        self::assertNotContains('stt_rec0', $keys);
        self::assertNotContains('ma_lo', $keys);
        self::assertNotContains('tk_pt', $keys);
        self::assertNotContains('tk_thue', $keys);
    }

    public function testSorptbk01DiscountColumnLabelsAreNotAbbreviated(): void
    {
        $component = new Sorptbk01();
        $component->phieuRows = [[
            'tien_ck'    => '10000',
            'tien_ck_nt' => '10',
            'ck_ds'      => '5000',
            'ck_ds_nt'   => '5',
        ]];

        $labels = array_column($component->phieuColumns(), 'label');

        self::assertContains('Tiền chiết khấu', $labels);
        self::assertContains('Chiết khấu doanh số', $labels);
        self::assertNotContains('Tiền CK', $labels);
        self::assertNotContains('CK ĐS', $labels);
        self::assertNotContains('CK đặc biệt', $labels);
    }

    public function testSorptbk01DynamicMoneyCellFormatsAndMarksRed(): void
    {
        $component = new Sorptbk01();

        self::assertSame('10,000', $component->phieuCellValue(['t_ck' => '10000'], 't_ck'));
        self::assertSame('', $component->phieuCellValue(['t_ck' => null], 't_ck', true));
        self::assertSame('—', $component->phieuCellValue(['t_ck' => null], 't_ck'));
        self::assertSame('text-red-500', $component->phieuCellClass(['t_ck' => '-10000'], 't_ck'));
        self::assertSame('text-red-500', $component->phieuCellClass(['ma_ct' => 'SO4', 't_ck' => '10000'], 't_ck'));
    }

    public function testSorptbk01DynamicDateAndTextCells(): void
    {
        $component = new Sorptbk01();

        self::assertSame('01/07/2026', $component->phieuCellValue(['ngay_lct' => '2026-07-01'], 'ngay_lct'));
        self::assertSame('Ghi chú bán hàng', $component->phieuCellValue(['dien_giai' => 'Ghi chú bán hàng'], 'dien_giai'));
    }
}
