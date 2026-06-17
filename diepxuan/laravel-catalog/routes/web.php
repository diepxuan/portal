<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-06-17 15:21:16
 */

use Diepxuan\Catalog\Http\Controllers\SellController;
use Diepxuan\Catalog\Http\Controllers\SystemController;
use Diepxuan\Catalog\Http\Controllers\SystemUserController;
use Diepxuan\Catalog\Http\Controllers\SystemWebsiteController;
use Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\Nhomkhachhang;
use Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\NhomkhachhangEdit;
use Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\Phanloaikhachhang;
use Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\PhanloaikhachhangEdit;
use Diepxuan\Catalog\Http\Livewire\Banhang\ArReportIndex;
use Diepxuan\Catalog\Http\Livewire\Banhang\Hoadonbanhang;
use Diepxuan\Catalog\Http\Livewire\Banhang\Khachhang;
use Diepxuan\Catalog\Http\Livewire\Banhang\KhachhangForm;
use Diepxuan\Catalog\Http\Livewire\Banhang\SoReportIndex;
use Diepxuan\Catalog\Http\Livewire\Banhang\SoVoucherIndex;
use Diepxuan\Catalog\Http\Livewire\Cash\Baocao\Chi;
use Diepxuan\Catalog\Http\Livewire\Cash\Baocao\Nganhang;
use Diepxuan\Catalog\Http\Livewire\Cash\Baocao\Thu;
use Diepxuan\Catalog\Http\Livewire\Cash\Baocao\Tienmat;
use Diepxuan\Catalog\Http\Livewire\Cash\Danhmuc\Nhanvien;
use Diepxuan\Catalog\Http\Livewire\Cash\Danhmuc\NhanvienForm;
use Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baoco;
use Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baono;
use Diepxuan\Catalog\Http\Livewire\Cash\Tienmat\Phieuchi;
use Diepxuan\Catalog\Http\Livewire\Cash\Tienmat\Phieuthu;
use Diepxuan\Catalog\Http\Livewire\Co\CoDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\Co\CoReportIndex;
use Diepxuan\Catalog\Http\Livewire\Co\Danhmuc\Dinhmucchitiet;
use Diepxuan\Catalog\Http\Livewire\Co\Danhmuc\Dmbom;
use Diepxuan\Catalog\Http\Livewire\Fa\FaDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\Fa\FaReportIndex;
use Diepxuan\Catalog\Http\Livewire\Gl\Taikhoan;
use Diepxuan\Catalog\Http\Livewire\Home\Dashboard as DashboardLivewire;
use Diepxuan\Catalog\Http\Livewire\In\Baocao\InReportIndex;
use Diepxuan\Catalog\Http\Livewire\In\Baocao\Tonkho;
use Diepxuan\Catalog\Http\Livewire\In\Dmkho;
use Diepxuan\Catalog\Http\Livewire\In\Dmnhvt;
use Diepxuan\Catalog\Http\Livewire\In\Dmvt;
use Diepxuan\Catalog\Http\Livewire\In\InVoucherIndex;
use Diepxuan\Catalog\Http\Livewire\Muahang\ApReportIndex;
use Diepxuan\Catalog\Http\Livewire\Muahang\Cungcap;
use Diepxuan\Catalog\Http\Livewire\Muahang\CungcapForm;
use Diepxuan\Catalog\Http\Livewire\Muahang\Hoadonmua;
use Diepxuan\Catalog\Http\Livewire\Muahang\HoadonmuaEdit;
use Diepxuan\Catalog\Http\Livewire\Muahang\PoDmCpIndex;
use Diepxuan\Catalog\Http\Livewire\Muahang\PoReportIndex;
use Diepxuan\Catalog\Http\Livewire\Muahang\PoVoucherIndex;
use Diepxuan\Catalog\Http\Livewire\System\Balance\AccountOpening;
use Diepxuan\Catalog\Http\Livewire\System\Balance\AccountsPayable;
use Diepxuan\Catalog\Http\Livewire\System\Balance\AccountsReceivable;
use Diepxuan\Catalog\Http\Livewire\System\Balance\CumulativeTransactions;
use Diepxuan\Catalog\Http\Livewire\System\Balance\Index as BalanceIndex;
use Diepxuan\Catalog\Http\Livewire\System\Balance\InventoryOpening;
use Diepxuan\Catalog\Http\Livewire\System\Balance\InventoryOpeningNtxt;
use Diepxuan\Catalog\Http\Livewire\System\Balance\InventoryTransfer;
use Diepxuan\Catalog\Http\Livewire\System\Balance\Transfer;
use Diepxuan\Catalog\Http\Livewire\System\Balance\WorkInProgress;
use Diepxuan\Catalog\Http\Livewire\System\CompanySelector;
use Diepxuan\Catalog\Http\Livewire\System\Dashboard;
use Diepxuan\Catalog\Http\Livewire\System\SiDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\System\SimbaPage;
use Diepxuan\Catalog\Http\Livewire\System\YearSelector;
use Diepxuan\Support\Http\Middleware\CorpAutoLogin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::domain(env('APP_URL','portal.diepxuan.io.vn'))->middleware(['clearcache', 'auth'])->group(static function (): void {
Route::middleware([CorpAutoLogin::class])->group(static function (): void {
    Route::get('/gl/taikhoan', Taikhoan::class)->name('gl.taikhoan');
    Route::get('/cash/tienmat/thu', Phieuthu::class)->name('ca.tienmat.thu');
    Route::get('/cash/tienmat/chi', Phieuchi::class)->name('ca.tienmat.chi');
    Route::get('/cash/tienmat/quy', Tienmat::class)->name('ca.tienmat.quy');
    Route::get('/cash/nganhang/baoco', Baoco::class)->name('ca.nganhang.baoco');
    Route::get('/cash/nganhang/baono', Baono::class)->name('ca.nganhang.baono');
    Route::get('/cash/nganhang/quy', Nganhang::class)->name('ca.nganhang.quy');
    Route::get('/cash/thu', Thu::class)->name('ca.thu');
    Route::get('/cash/chi', Chi::class)->name('ca.chi');
    Route::get('/cash/quy', static fn () => view('catalog::dashboard'))->name('ca.quy');
    Route::get('/cash/nhanvien', Nhanvien::class)->name('ca.nhanvien');
    Route::get('/cash/nhanvien/create', NhanvienForm::class)->name('ca.nhanvien.create');
    Route::get('/cash/nhanvien/edit/{id}', NhanvienForm::class)->name('ca.nhanvien.edit');

    Route::get('banhang/hoadonbanhang', Hoadonbanhang::class)->name('ar.ph.hdbh');
    Route::get('banhang/dondathang', SoVoucherIndex::class)->defaults('voucherCode', 'SO1')->name('banhang.so1');
    Route::get('banhang/nhap-hang-ban-tra-lai', SoVoucherIndex::class)->defaults('voucherCode', 'SO4')->name('banhang.so4');
    Route::get('banhang/hoadon-dichvu', SoVoucherIndex::class)->defaults('voucherCode', 'SO5')->name('banhang.so5');
    Route::resource('banhang/bangkebanhang', SellController::class)->names('sell.list');
    Route::get('/co/danhmuc/dinh-muc-bom', Dmbom::class)->name('co.dmbom');
    Route::get('/co/danhmuc/dinh-muc-chi-tiet', Dinhmucchitiet::class)->name('co.dinhmucchitiet');

    Route::get('/banhang/khachhang', Khachhang::class)->name('ar.khachhang');
    Route::get('/banhang/khachhang/create', KhachhangForm::class)->name('ar.khachhang.create');
    Route::get('/banhang/khachhang/edit/{id}', KhachhangForm::class)->name('ar.khachhang.edit');
    Route::get('/ar/danhmuc/nhom-khach-hang', Nhomkhachhang::class)->name('ar.nhomkhachhang');
    Route::get('/ar/danhmuc/nhom-khach-hang/create', NhomkhachhangEdit::class)->name('ar.nhomkhachhang.create');
    Route::get('/ar/danhmuc/nhom-khach-hang/edit/{id}', NhomkhachhangEdit::class)->name('ar.nhomkhachhang.edit');
    Route::get('/ar/danhmuc/phan-loai-khach-hang', Phanloaikhachhang::class)->name('ar.phanloaikhachhang');
    Route::get('/ar/danhmuc/phan-loai-khach-hang/create', PhanloaikhachhangEdit::class)->name('ar.phanloaikhachhang.create');
    Route::get('/ar/danhmuc/phan-loai-khach-hang/edit/{id}', PhanloaikhachhangEdit::class)->name('ar.phanloaikhachhang.edit');
    Route::prefix('banhang/baocao')->name('so.rpt.')->group(static function (): void {
        Route::get('/bangke-banhang', SoReportIndex::class)->defaults('routeName', 'so.rpt.bk01')->name('bk01');
        Route::get('/bangke-banhang-nhom', SoReportIndex::class)->defaults('routeName', 'so.rpt.bk02')->name('bk02');
        Route::get('/tonghop-banhang', SoReportIndex::class)->defaults('routeName', 'so.rpt.th01')->name('th01');
        Route::get('/tonghop-banhang-ky', SoReportIndex::class)->defaults('routeName', 'so.rpt.th02')->name('th02');
        Route::get('/lailo-mathang', SoReportIndex::class)->defaults('routeName', 'so.rpt.bcpt03')->name('bcpt03');
        Route::get('/doanhso-bophan', SoReportIndex::class)->defaults('routeName', 'so.rpt.bcpt04')->name('bcpt04');
        Route::get('/banhang-hai-chitieu', SoReportIndex::class)->defaults('routeName', 'so.rpt.bcpt06')->name('bcpt06');
        Route::get('/lailo-hopdong', SoReportIndex::class)->defaults('routeName', 'so.rpt.lailo')->name('lailo');
        Route::get('/nhatky-banhang', SoReportIndex::class)->defaults('routeName', 'so.rpt.nkc04')->name('nkc04');
        Route::get('/lailo-mathang-lairong', SoReportIndex::class)->defaults('routeName', 'so.rpt.bcpt03-net')->name('bcpt03-net');
        Route::get('/doanhso-nhanvien', SoReportIndex::class)->defaults('routeName', 'so.rpt.bcpt04-nv')->name('bcpt04-nv');
        Route::get('/tonghop-lailo-hopdong', SoReportIndex::class)->defaults('routeName', 'so.rpt.lailo-th')->name('lailo-th');
    });
    Route::prefix('banhang/congno/baocao')->name('ar.rpt.')->group(static function (): void {
        Route::get('/bangke-hoadon-phai-thu', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bk01')->name('bk01');
        Route::get('/so-chitiet-mot-khachhang', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn01')->name('bccn01');
        Route::get('/so-chitiet-nhieu-khachhang', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn01a')->name('bccn01a');
        Route::get('/can-doi-phat-sinh', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn02')->name('bccn02');
        Route::get('/tonghop-sodu-mot-taikhoan', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn03')->name('bccn03');
        Route::get('/doi-chieu-cong-no-tonghop', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn05')->name('bccn05');
        Route::get('/can-doi-theo-chitieu', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn04')->name('bccn04');
        Route::get('/so-chitiet-mot-khachhang-soluong', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn01sl')->name('bccn01sl');
        Route::get('/so-chitiet-nhieu-khachhang-lientuc', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn01a-cont')->name('bccn01a-cont');
        Route::get('/tonghop-sodu-dau', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn03-open')->name('bccn03-open');
        Route::get('/tonghop-sodu-cuoi', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn03-close')->name('bccn03-close');
        Route::get('/doi-chieu-cong-no-chitiet', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn05-detail')->name('bccn05-detail');
        Route::get('/can-doi-cong-no-theo-han-thanh-toan', ArReportIndex::class)->defaults('routeName', 'ar.rpt.bccn06')->name('bccn06');
    });

    Route::get('/muahang/cungcap', Cungcap::class)->name('ar.cungcap');
    Route::get('/muahang/nhacungcap', Cungcap::class)->name('po.cungcap');
    Route::get('/muahang/nhacungcap/create', CungcapForm::class)->name('po.cungcap.create');
    Route::get('/muahang/nhacungcap/edit/{id}', CungcapForm::class)->name('po.cungcap.edit');
    Route::get('/muahang/chiphimuahang/danhmuc', PoDmCpIndex::class)->name('po.dmcp');
    Route::prefix('muahang/baocao')->name('po.rpt.')->group(static function (): void {
        Route::get('/bangke-muahang', PoReportIndex::class)->defaults('routeName', 'po.rpt.bk01')->name('bk01');
        Route::get('/bangke-muahang-nhom', PoReportIndex::class)->defaults('routeName', 'po.rpt.bk02')->name('bk02');
        Route::get('/tonghop-muahang', PoReportIndex::class)->defaults('routeName', 'po.rpt.th01')->name('th01');
        Route::get('/tonghop-muahang-ky', PoReportIndex::class)->defaults('routeName', 'po.rpt.th02')->name('th02');
        Route::get('/bangke-chiphiphimuahang', PoReportIndex::class)->defaults('routeName', 'po.rpt.bk03')->name('bk03');
        Route::get('/tonghop-chiphiphimuahang', PoReportIndex::class)->defaults('routeName', 'po.rpt.th03')->name('th03');
        Route::get('/muahang-hai-chitieu', PoReportIndex::class)->defaults('routeName', 'po.rpt.bcpt03')->name('bcpt03');
        Route::get('/nhatky-muahang', PoReportIndex::class)->defaults('routeName', 'po.rpt.nkc05')->name('nkc05');
    });
    Route::prefix('muahang/congno/baocao')->name('ap.rpt.')->group(static function (): void {
        Route::get('/bangke-hoadon-phai-tra', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bk01')->name('bk01');
        Route::get('/so-chitiet-mot-nhacungcap', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn01')->name('bccn01');
        Route::get('/so-chitiet-nhieu-nhacungcap', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn01a')->name('bccn01a');
        Route::get('/can-doi-phat-sinh', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn02')->name('bccn02');
        Route::get('/tonghop-sodu-mot-taikhoan', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn03')->name('bccn03');
        Route::get('/so-chitiet-mot-nhacungcap-soluong', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn01sl')->name('bccn01sl');
        Route::get('/doi-chieu-cong-no-tonghop', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn05')->name('bccn05');
        Route::get('/so-chitiet-nhieu-nhacungcap-lientuc', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn01a-cont')->name('bccn01a-cont');
        Route::get('/can-doi-theo-chitieu', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn04')->name('bccn04');
        Route::get('/tonghop-sodu-dau', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn03-open')->name('bccn03-open');
        Route::get('/tonghop-sodu-cuoi', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn03-close')->name('bccn03-close');
        Route::get('/doi-chieu-cong-no-chitiet', ApReportIndex::class)->defaults('routeName', 'ap.rpt.bccn05-detail')->name('bccn05-detail');
    });

    Route::prefix('muahang')->name('muahang.')->group(static function (): void {
        Route::get('/hoadonmua', Hoadonmua::class)->name('hoadonmua');
        Route::get('/hoadonmua/create', HoadonmuaEdit::class)->name('hoadonmua.create');
        Route::get('/hoadonmua/edit/{stt_rec}', HoadonmuaEdit::class)->name('hoadonmua.edit');
        Route::get('/donhangmua', PoVoucherIndex::class)->defaults('voucherCode', 'PO1')->name('po1');
        Route::get('/chiphimuahang', PoVoucherIndex::class)->defaults('voucherCode', 'PO4')->name('po4');
        Route::get('/xuat-tralai-nhacungcap', PoVoucherIndex::class)->defaults('voucherCode', 'PO5')->name('po5');
        Route::get('/hoadonmuadichvu', PoVoucherIndex::class)->defaults('voucherCode', 'PO6')->name('po6');
        Route::get('/hoadonmuanhapkhau', PoVoucherIndex::class)->defaults('voucherCode', 'PO7')->name('po7');
    });

    // Source routes for SimbaERP screens. Canonical /simba/... aliases render
    // through SimbaPage; these internal named routes preserve component/defaults.
    Route::prefix('_simba-source')->group(static function (): void {
        // CA — Tiền mặt, Ngân hàng (sysMenu 04.*)
        Route::prefix('ca')->name('ca.')->group(static function (): void {
            Route::prefix('rpt')->name('rpt.')->group(static function (): void {});
        });

        // IN — Hàng tồn kho (sysMenu 14.*)
        Route::prefix('in')->group(static function (): void {
            Route::prefix('vch')->group(static function (): void {
                Route::get('/in1', InVoucherIndex::class)->defaults('voucherCode', 'IN1')->name('in.vch.in1');
                Route::get('/in2', InVoucherIndex::class)->defaults('voucherCode', 'IN2')->name('in.vch.in2');
                Route::get('/in3', InVoucherIndex::class)->defaults('voucherCode', 'IN3')->name('in.vch.in3');
                Route::get('/in5', InVoucherIndex::class)->defaults('voucherCode', 'IN5')->name('in.vch.in5');
                Route::get('/in6', InVoucherIndex::class)->defaults('voucherCode', 'IN6')->name('in.vch.in6');
                Route::get('/in4', InVoucherIndex::class)->defaults('voucherCode', 'IN4')->name('in.vch.in4');
            });

            Route::prefix('rpt')->group(static function (): void {
                Route::get('/ctvt01', InReportIndex::class)->defaults('routeName', 'in.rpt.ctvt01')->name('in.rpt.ctvt01');
                Route::get('/ctvt02', InReportIndex::class)->defaults('routeName', 'in.rpt.ctvt02')->name('in.rpt.ctvt02');
                Route::get('/cd01', InReportIndex::class)->defaults('routeName', 'in.rpt.cd01')->name('in.rpt.cd01');
                Route::get('/tonkho', Tonkho::class)->name('in.tonkho');
                Route::get('/bkn04', InReportIndex::class)->defaults('routeName', 'in.rpt.bkn04')->name('in.rpt.bkn04');
                Route::get('/thn01', InReportIndex::class)->defaults('routeName', 'in.rpt.thn01')->name('in.rpt.thn01');
                Route::get('/thn02', InReportIndex::class)->defaults('routeName', 'in.rpt.thn02')->name('in.rpt.thn02');
                Route::get('/bkx04', InReportIndex::class)->defaults('routeName', 'in.rpt.bkx04')->name('in.rpt.bkx04');
                Route::get('/thx01', InReportIndex::class)->defaults('routeName', 'in.rpt.thx01')->name('in.rpt.thx01');
                Route::get('/thx02', InReportIndex::class)->defaults('routeName', 'in.rpt.thx02')->name('in.rpt.thx02');
                Route::get('/bk01', InReportIndex::class)->defaults('routeName', 'in.rpt.bk01')->name('in.rpt.bk01');
                Route::get('/banggiatb', InReportIndex::class)->defaults('routeName', 'in.rpt.banggiatb')->name('in.rpt.banggiatb');
            });

            Route::prefix('dict')->group(static function (): void {
                Route::get('/dmvt', Dmvt::class)->name('in.dict.dmvt');
                Route::get('/dmnhvt', Dmnhvt::class)->name('in.dict.dmnhvt');
                Route::get('/dmkho', Dmkho::class)->name('in.dict.dmkho');
            });
        });

        // SI — Hệ thống (sysMenu 90.*)
        Route::prefix('si')->group(static function (): void {
            Route::prefix('dict')->group(static function (): void {
                Route::get('/dmct', SiDictionaryIndex::class)->defaults('routeName', 'si.dmct')->name('si.dmct');
                Route::get('/dmnt', SiDictionaryIndex::class)->defaults('routeName', 'si.dmnt')->name('si.dmnt');
                Route::get('/dmphi', SiDictionaryIndex::class)->defaults('routeName', 'si.dmphi')->name('si.dmphi');
            });
            Route::prefix('tool')->group(static function (): void {});
        });
    });

    // Canonical Simba shell entrypoint. Source routes above keep component/defaults;
    // public /simba/... URLs always render through SimbaPage.
    Route::prefix('simba')->name('simba.')->group(static function (): void {
        Route::get('/', SimbaPage::class)->name('index');
        Route::get('/{module}/{kind}', SimbaPage::class)
            ->where([
                'module' => '[a-z0-9-]+',
                'kind'   => '[a-z0-9-]+',
            ])
            ->name('show-short')
        ;
        Route::get('/{module}/{kind}/{slug}', SimbaPage::class)
            ->where([
                'module' => '[a-z0-9-]+',
                'kind'   => '[a-z0-9-]+',
                'slug'   => '[a-z0-9_.-]+',
            ])
            ->name('show')
        ;
    });

    Route::prefix('taisan/baocao')->name('fa.rpt.')->group(static function (): void {
        Route::get('/the-tscd', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts01')->name('bcts01');
        Route::get('/so-tscd', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts08')->name('bcts08');
        Route::get('/so-theo-doi-tscd-ccdc', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts09')->name('bcts09');
        Route::get('/bang-tinh-khau-hao', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts04')->name('bcts04');
        Route::get('/bang-phan-bo-khau-hao', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts05')->name('bcts05');
        Route::get('/tang-giam-tai-san', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts06')->name('bcts06');
        Route::get('/chi-tiet-kiem-ke-tai-san', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcts07')->name('bcts07');
        Route::get('/so-chi-tiet-ccdc', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bcpt10')->name('bcpt10');
        Route::get('/bangke-phieu-nhap-ccdc', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bkn04')->name('bkn04');
        Route::get('/tonghop-hang-nhap-ccdc', FaReportIndex::class)->defaults('routeName', 'fa.rpt.thn01')->name('thn01');
        Route::get('/bangke-phieu-xuat-ccdc', FaReportIndex::class)->defaults('routeName', 'fa.rpt.bkx04')->name('bkx04');
        Route::get('/tonghop-hang-xuat-ccdc', FaReportIndex::class)->defaults('routeName', 'fa.rpt.thx01')->name('thx01');
    });
    Route::prefix('taisan/danhmuc')->name('fa.')->group(static function (): void {
        Route::get('/nguon-von', FaDictionaryIndex::class)->defaults('routeName', 'fa.dmnv')->name('dmnv');
        Route::get('/bo-phan-su-dung', FaDictionaryIndex::class)->defaults('routeName', 'fa.dmbpsd')->name('dmbpsd');
    });

    Route::prefix('chiphi/baocao')->name('co.rpt.')->group(static function (): void {
        Route::get('/bang-ke-chung-tu', CoReportIndex::class)->defaults('routeName', 'co.rpt.bk02')->name('bk02');
        Route::get('/tong-hop-phat-sinh-nhom', CoReportIndex::class)->defaults('routeName', 'co.rpt.th01')->name('th01');
        Route::get('/bang-tinh-phan-bo-cptt', CoReportIndex::class)->defaults('routeName', 'co.rpt.khcp')->name('khcp');
        Route::get('/the-gia-thanh', CoReportIndex::class)->defaults('routeName', 'co.rpt.gt01')->name('gt01');
        Route::get('/bang-gia-thanh-san-pham', CoReportIndex::class)->defaults('routeName', 'co.rpt.gt02')->name('gt02');
        Route::get('/bangke-phieu-nhap', CoReportIndex::class)->defaults('routeName', 'co.rpt.bkn04')->name('bkn04');
        Route::get('/tonghop-hang-nhap', CoReportIndex::class)->defaults('routeName', 'co.rpt.thn01')->name('thn01');
        Route::get('/tonghop-hang-nhap-hai-chitieu', CoReportIndex::class)->defaults('routeName', 'co.rpt.thn02')->name('thn02');
        Route::get('/bangke-phieu-xuat', CoReportIndex::class)->defaults('routeName', 'co.rpt.bkx04')->name('bkx04');
        Route::get('/tonghop-hang-xuat', CoReportIndex::class)->defaults('routeName', 'co.rpt.thx01')->name('thx01');
        Route::get('/tonghop-hang-xuat-hai-chitieu', CoReportIndex::class)->defaults('routeName', 'co.rpt.thx02')->name('thx02');
        Route::get('/bang-gia-thanh-cong-trinh', CoReportIndex::class)->defaults('routeName', 'co.rpt.gt03')->name('gt03');
        Route::get('/bang-gia-thanh-cong-trinh-du-toan', CoReportIndex::class)->defaults('routeName', 'co.rpt.gt03-dutoan')->name('gt03-dutoan');
        Route::get('/lai-lo-cong-trinh', CoReportIndex::class)->defaults('routeName', 'co.rpt.gt03-lailo')->name('gt03-lailo');
        Route::get('/can-doi-cong-no-cong-trinh', CoReportIndex::class)->defaults('routeName', 'co.rpt.bccn04')->name('bccn04');
    });
    Route::prefix('chiphi/danhmuc')->name('co.')->group(static function (): void {
        Route::get('/san-pham', CoDictionaryIndex::class)->defaults('routeName', 'co.dmsp')->name('dmsp');
        Route::get('/cong-trinh', CoDictionaryIndex::class)->defaults('routeName', 'co.dmspct')->name('dmspct');
        Route::get('/nhom-cong-trinh', CoDictionaryIndex::class)->defaults('routeName', 'co.dmnhspct')->name('dmnhspct');
    });

    Route::prefix('hethong')->name('system.')->group(static function (): void {
        Route::get('system', Dashboard::class)->name('system');
        Route::get('company', CompanySelector::class)->name('company');
        Route::resource('user', SystemUserController::class)->names('user');
        Route::resource('website', SystemWebsiteController::class)->names('website');
        Route::get('year', YearSelector::class)->name('year');

        // Balance Management Routes - Livewire Components
        Route::prefix('balance')->name('balance.')->group(static function (): void {
            Route::get('/', BalanceIndex::class)->name('index');
            Route::get('/account-opening', AccountOpening::class)->name('account-opening');
            Route::get('/transfer', Transfer::class)->name('transfer');
            Route::get('/accounts-receivable', AccountsReceivable::class)->name('accounts-receivable');
            Route::get('/accounts-payable', AccountsPayable::class)->name('accounts-payable');
            Route::get('/inventory-opening', InventoryOpening::class)->name('inventory-opening');
            Route::get('/inventory-opening-ntxt', InventoryOpeningNtxt::class)->name('inventory-opening-ntxt');
            Route::get('/inventory-transfer', InventoryTransfer::class)->name('inventory-transfer');
            Route::get('/work-in-progress', WorkInProgress::class)->name('work-in-progress');
            Route::get('/cumulative-transactions', CumulativeTransactions::class)->name('cumulative-transactions');
        });
    });

    // Route::get('/', [SystemController::class, 'index']);
    Route::get('/', static fn () => view('catalog::dashboard'))->name('home');
    Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');
});

Route::get('/check-proxy', static fn () => [
    'app_url'           => config('app.url'),
    'url()'             => url('/'),
    'secure_url()'      => secure_url('/'),
    'request_scheme'    => request()->getScheme(),
    'request_secure'    => request()->isSecure(),
    'x_forwarded_proto' => request()->header('x-forwarded-proto'),
    'server_https'      => $_SERVER['HTTPS'] ?? null,
]);

/*
|--------------------------------------------------------------------------
| Test Routes - UTF-8 Blade Test
|--------------------------------------------------------------------------
*/

Route::get('test/utf8', static fn () => view('catalog::test.utf8-test'))->name('test.utf8')->middleware(['web']);
