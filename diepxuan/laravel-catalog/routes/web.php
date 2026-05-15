<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-05-16 00:27:44
 */

use Diepxuan\Catalog\Http\Controllers\SellController;
use Diepxuan\Catalog\Http\Controllers\SystemController;
use Diepxuan\Catalog\Http\Controllers\SystemUserController;
use Diepxuan\Catalog\Http\Controllers\SystemWebsiteController;
use Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\Nhomkhachhang;
use Diepxuan\Catalog\Http\Livewire\AR\Danhmuc\NhomkhachhangEdit;
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
use Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baoco;
use Diepxuan\Catalog\Http\Livewire\Cash\Nganhang\Baono;
use Diepxuan\Catalog\Http\Livewire\Cash\Tienmat\Phieuchi;
use Diepxuan\Catalog\Http\Livewire\Cash\Tienmat\Phieuthu;
use Diepxuan\Catalog\Http\Livewire\Co\CoDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\Co\CoReportIndex;
use Diepxuan\Catalog\Http\Livewire\Fa\FaDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\Fa\FaReportIndex;
use Diepxuan\Catalog\Http\Livewire\FinanceVoucherIndex;
use Diepxuan\Catalog\Http\Livewire\Gl\GlReportIndex;
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
use Diepxuan\Catalog\Http\Livewire\System\Menu;
use Diepxuan\Catalog\Http\Livewire\System\SiDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\System\SimbaDictionaryIndex;
use Diepxuan\Catalog\Http\Livewire\System\SimbaProcessIndex;
use Diepxuan\Catalog\Http\Livewire\System\SimbaReportIndex;
use Diepxuan\Catalog\Http\Livewire\System\YearSelector;
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
Route::middleware(['auth'])->group(static function (): void {
    Route::get('/gl/taikhoan', Taikhoan::class)->name('gl.taikhoan');
    Route::get('/gl/phieu-ke-toan', FinanceVoucherIndex::class)->defaults('voucherCode', 'GL1')->name('gl.vch.gl1');
    Route::get('/gl/chung-tu-ngoai-bang', FinanceVoucherIndex::class)->defaults('voucherCode', 'NB1')->name('gl.vch.nb1');
    Route::prefix('gl/baocao')->name('gl.rpt.')->group(static function (): void {
        Route::get('/so-dang-ky-ctgs', GlReportIndex::class)->defaults('routeName', 'gl.rpt.ctgs01')->name('ctgs01');
        Route::get('/chung-tu-ghi-so', GlReportIndex::class)->defaults('routeName', 'gl.rpt.ctgs02')->name('ctgs02');
        Route::get('/so-cai-ctgs', GlReportIndex::class)->defaults('routeName', 'gl.rpt.ctgs03')->name('ctgs03');
        Route::get('/bang-ke-ctgs', GlReportIndex::class)->defaults('routeName', 'gl.rpt.ctgs05')->name('ctgs05');
        Route::get('/so-cai', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc01')->name('nkc01');
        Route::get('/so-nhat-ky-chung', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc02')->name('nkc02');
        Route::get('/so-nhat-ky-thu-tien', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc03')->name('nkc03');
        Route::get('/so-nhat-ky-chi-tien', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc03-chi')->name('nkc03-chi');
        Route::get('/so-nhat-ky-ban-hang', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc04')->name('nkc04');
        Route::get('/so-nhat-ky-mua-hang', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc05')->name('nkc05');
        Route::get('/so-chi-tiet-tai-khoan', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc06')->name('nkc06');
        Route::get('/so-chu-t-tai-khoan', GlReportIndex::class)->defaults('routeName', 'gl.rpt.nkc07')->name('nkc07');
        Route::get('/bang-ke-chung-tu', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bk02')->name('bk02');
        Route::get('/tong-hop-phat-sinh-nhom', GlReportIndex::class)->defaults('routeName', 'gl.rpt.th01')->name('th01');
        Route::get('/thue-mua-vao', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bct01')->name('bct01');
        Route::get('/thue-ban-ra', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bct02')->name('bct02');
        Route::get('/to-khai-thue-gtgt', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bct03')->name('bct03');
        Route::get('/to-khai-thue-tndn-tam-tinh', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bct04')->name('bct04');
        Route::get('/quyet-toan-thue-tndn', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bct05')->name('bct05');
        Route::get('/phu-luc-ket-qua-hdkd', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bct06')->name('bct06');
        Route::get('/can-doi-phat-sinh', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctc01')->name('bctc01');
        Route::get('/can-doi-ke-toan', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctc02')->name('bctc02');
        Route::get('/ket-qua-kinh-doanh', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctc03')->name('bctc03');
        Route::get('/luu-chuyen-tien-te-truc-tiep', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctc04')->name('bctc04');
        Route::get('/thuyet-minh-bctc', GlReportIndex::class)->defaults('routeName', 'gl.rpt.tmbctc')->name('tmbctc');
        Route::get('/nguon-von-dau-tu', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtb02')->name('bctccdtb02');
        Route::get('/chi-tiet-nguon-von-dau-tu', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtf02')->name('bctccdtf02');
        Route::get('/thuc-hien-dau-tu-du-an', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtf03a')->name('bctccdtf03a');
        Route::get('/quyet-toan-dau-tu-du-an', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtf03b')->name('bctccdtf03b');
        Route::get('/thuc-hien-dau-tu', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtb03')->name('bctccdtb03');
        Route::get('/chi-phi-khac', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtf03c')->name('bctccdtf03c');
        Route::get('/chi-phi-ban-quan-ly-du-an', GlReportIndex::class)->defaults('routeName', 'gl.rpt.bctccdtf03d')->name('bctccdtf03d');
    });

    Route::get('/cash/tienmat/thu', Phieuthu::class)->name('ca.tienmat.thu');
    Route::get('/cash/tienmat/chi', Phieuchi::class)->name('ca.tienmat.chi');
    Route::get('/cash/tienmat/quy', Tienmat::class)->name('ca.tienmat.quy');
    Route::get('/cash/nganhang/baoco', Baoco::class)->name('ca.nganhang.baoco');
    Route::get('/cash/nganhang/baono', Baono::class)->name('ca.nganhang.baono');
    Route::get('/cash/nganhang/quy', Nganhang::class)->name('ca.nganhang.quy');
    Route::get('/cash/thu', Thu::class)->name('ca.thu');
    Route::get('/cash/chi', Chi::class)->name('ca.chi');
    Route::get('/cash/quy', static fn () => view('catalog::dashboard'))->name('ca.quy');

    Route::get('banhang/hoadonbanhang', Hoadonbanhang::class)->name('ar.ph.hdbh');
    Route::get('banhang/dondathang', SoVoucherIndex::class)->defaults('voucherCode', 'SO1')->name('banhang.so1');
    Route::get('banhang/nhap-hang-ban-tra-lai', SoVoucherIndex::class)->defaults('voucherCode', 'SO4')->name('banhang.so4');
    Route::get('banhang/hoadon-dichvu', SoVoucherIndex::class)->defaults('voucherCode', 'SO5')->name('banhang.so5');
    Route::get('banhang/bu-tru-cong-no', FinanceVoucherIndex::class)->defaults('voucherCode', 'AR4')->name('ar.vch.ar4');
    Route::resource('banhang/bangkebanhang', SellController::class)->names('sell.list');
    Route::get('/banhang/khachhang', Khachhang::class)->name('ar.khachhang');
    Route::get('/banhang/khachhang/create', KhachhangForm::class)->name('ar.khachhang.create');
    Route::get('/banhang/khachhang/edit/{id}', KhachhangForm::class)->name('ar.khachhang.edit');
    Route::get('/ar/danhmuc/nhom-khach-hang', Nhomkhachhang::class)->name('ar.nhomkhachhang');
    Route::get('/ar/danhmuc/nhom-khach-hang/create', NhomkhachhangEdit::class)->name('ar.nhomkhachhang.create');
    Route::get('/ar/danhmuc/nhom-khach-hang/edit/{id}', NhomkhachhangEdit::class)->name('ar.nhomkhachhang.edit');
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
    });

    Route::get('/muahang/cungcap', Cungcap::class)->name('ar.cungcap');
    Route::get('/muahang/nhacungcap', Cungcap::class)->name('po.cungcap');
    Route::get('/muahang/chiphimuahang/danhmuc', PoDmCpIndex::class)->name('po.dmcp');
    Route::get('/muahang/bu-tru-cong-no', FinanceVoucherIndex::class)->defaults('voucherCode', 'AP4')->name('ap.vch.ap4');
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

    Route::get('khohang/sanpham', Dmvt::class)->name('in.dmvt');
    Route::get('khohang/nhomsanpham', Dmnhvt::class)->name('in.dmnhvt');
    Route::get('khohang/khohang', Dmkho::class)->name('in.khohang');
    Route::prefix('khohang/chungtu')->name('in.vch.')->group(static function (): void {
        Route::get('/phieu-nhap-kho', InVoucherIndex::class)->defaults('voucherCode', 'IN1')->name('in1');
        Route::get('/phieu-xuat-kho', InVoucherIndex::class)->defaults('voucherCode', 'IN2')->name('in2');
        Route::get('/phieu-xuat-chuyen-kho', InVoucherIndex::class)->defaults('voucherCode', 'IN3')->name('in3');
        Route::get('/phieu-nhap-dieu-chuyen', InVoucherIndex::class)->defaults('voucherCode', 'IN4')->name('in4');
        Route::get('/phieu-xuat-cong-cu-dung-cu', InVoucherIndex::class)->defaults('voucherCode', 'IN5')->name('in5');
        Route::get('/phieu-thao-do-lap-rap', InVoucherIndex::class)->defaults('voucherCode', 'IN6')->name('in6');
    });
    Route::get('khohang/tonkho', Tonkho::class)->name('in.tonkho');
    Route::prefix('khohang/baocao')->name('in.rpt.')->group(static function (): void {
        Route::get('/the-kho', InReportIndex::class)->defaults('routeName', 'in.rpt.ctvt01')->name('ctvt01');
        Route::get('/the-kho-in-tat-ca', InReportIndex::class)->defaults('routeName', 'in.rpt.ctvt02')->name('ctvt02');
        Route::get('/tonghop-nhapxuatton', InReportIndex::class)->defaults('routeName', 'in.rpt.cd01')->name('cd01');
        Route::get('/bangke-phieu-nhap', InReportIndex::class)->defaults('routeName', 'in.rpt.bkn04')->name('bkn04');
        Route::get('/tonghop-hang-nhap', InReportIndex::class)->defaults('routeName', 'in.rpt.thn01')->name('thn01');
        Route::get('/tonghop-hang-nhap-hai-chitieu', InReportIndex::class)->defaults('routeName', 'in.rpt.thn02')->name('thn02');
        Route::get('/bangke-phieu-xuat', InReportIndex::class)->defaults('routeName', 'in.rpt.bkx04')->name('bkx04');
        Route::get('/tonghop-hang-xuat', InReportIndex::class)->defaults('routeName', 'in.rpt.thx01')->name('thx01');
        Route::get('/tonghop-hang-xuat-hai-chitieu', InReportIndex::class)->defaults('routeName', 'in.rpt.thx02')->name('thx02');
        Route::get('/thongtin-tinhgia-ntxt', InReportIndex::class)->defaults('routeName', 'in.rpt.bk01')->name('bk01');
        Route::get('/banggia-trungbinh', InReportIndex::class)->defaults('routeName', 'in.rpt.banggiatb')->name('banggiatb');
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

    Route::get('hethong/system', Dashboard::class)->name('system.system');
    Route::get('hethong/company', CompanySelector::class)->name('system.company');
    Route::prefix('hethong/danhmuc')->name('si.')->group(static function (): void {
        Route::get('/chung-tu', SiDictionaryIndex::class)->defaults('routeName', 'si.dmct')->name('dmct');
        Route::get('/khoan-muc-phi', SiDictionaryIndex::class)->defaults('routeName', 'si.dmphi')->name('dmphi');
        Route::get('/ngoai-te', SiDictionaryIndex::class)->defaults('routeName', 'si.dmnt')->name('dmnt');
    });
    Route::resource('hethong/user', SystemUserController::class)->names('system.user');
    Route::resource('hethong/website', SystemWebsiteController::class)->names('system.website');
    Route::get('hethong/menu', Menu::class)->name('system.menu');
    Route::get('hethong/year', YearSelector::class)->name('system.year');
    Route::get('simba/dictionaries/{routeName}', SimbaDictionaryIndex::class)
        ->where('routeName', '[A-Za-z0-9_.-]+')
        ->name('simba.dictionary')
    ;
    Route::get('simba/reports/{routeName}', SimbaReportIndex::class)
        ->where('routeName', '[A-Za-z0-9_.-]+')
        ->name('simba.report')
    ;
    Route::get('simba/processes/{routeName}', SimbaProcessIndex::class)
        ->where('routeName', '[A-Za-z0-9_.-]+')
        ->name('simba.process')
    ;

    // Balance Management Routes - Livewire Components
    Route::prefix('hethong/balance')->name('system.balance.')->group(static function (): void {
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
