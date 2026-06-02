# Task 168-180: CO-BaoCao-SanXuat

## Nhom: CO (Cost Accounting - Ke toan gia thanh)

## Muc tieu
Chuyen doi cac chuc nang bao cao san xuat tu .NET sang PHP Laravel.

## Chi tiet chung
- **Nhom DLL:** COGDBGT, COLK, COPB, CORptGt01-03, CoCalcCost, CoDMCPTT, CoDelPostCP2GL, CoNgungKHCPTT, CoPostCPTT2GL, CoRptCTPBCPTT, CoRptKHCPTT
- **Loai:** Bao cao & Danh muc (CO)
- **Assembly Company:** Asia Software Development JSC / ASIASOFT
- **Ma_ct:** CO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/CODMSPCT.dll/README.md`  
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/COGDBGT.dll/README.md`  
(Nhua cac DLL khac trong nhom)

---

## Cau truc du lieu CO

### Bang: CODMPB (Danh muc phan bo)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_pb | varchar | Ma phan bo (khoa chinh) |
| ten_pb | nvarchar | Ten phan bo |
| tk_pb | varchar | Tai khoan phan bo |
| theo_spct | bit | Theo san pham |
| theo_bp | bit | Theo bo phan |
| theo_tkdu | bit | Theo tai khoan doi ung |

### Bang: COCPTT (Chi phi tap trung)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_cptt | varchar | Ma chi phi (khoa chinh) |
| ten_cptt | nvarchar | Ten chi phi |
| dvt | varchar | Don vi tinh |
| so_luong | decimal | So luong |
| don_gia | decimal | Don gia |
| ng_gia | decimal | Nguyen gia |
| so_ky | int | So ky phan bo |
| tk_cptt | varchar | TK phan bo |
| tk_cp | varchar | TK chi phi |
| ma_bpsd | varchar | Ma bo phan su dung |
| ma_spct | varchar | Ma san pham |

### Bang: COLK (Lien ket)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| ma_lk | varchar | Ma lien ket (khoa chinh) |
| ten_lk | nvarchar | Ten lien ket |
| tk_no | varchar | TK no |
| tk_co | varchar | TK co |

---

## Chi tiet cac DLL

### 168. COGDBGT - Bao cao Gia dinh bien gia thanh
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmReport |
| Controls | txtTk, txtNam, txtThang1, txtThang2 |
| Chuc nang | Bao cao Gia dinh bien theo tai khoan |

### 169. COLK - Khai bao but toan ket chuyen tu dong
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmDMComplexView |
| Chuc nang | Khai bao cac but toan ket chuyen tu dong |

### 170. COPB - But toan phan bo tu dong
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmAsiaRoot |
| Controls | cboKyBc, txtNgay1, txtNgay2, dgvDMPB, dgvDMPB2, btn_PB, btn_XPB |
| Chuc nang | Thuc hien but toan phan bo chi phi tu dong |

### 171-173. CORptGt01-03 - Bao cao Gia thanh
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmReport |
| Controls | txtTk, txtNam, txtThang1, txtThang2, txtMA_SPCT |
| Chuc nang | Bao cao gia thanh 01/02/03 |

### 174. CoCalcCost - Tinh gia thanh
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmReport2DGV |
| Controls | txtTK, cboKyBc, btnUpdate, btnDelUpdate, dgvBCPh, dgvBCCt |
| Chuc nang | Tinh gia thanh san pham |

### 175. CoDMCPTT - Danh muc chi phi tap trung
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmDMComplexView |
| Chuc nang | Quan ly danh muc chi phi tap trung |

### 176. CoDelPostCP2GL - Xoa post chi phi sang GL
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmCalc |
| Controls | cboKyBc, txtNam, cmdOK |
| Chuc nang | Xoa post chi phi da chuyen sang GL |

### 177. CoNgungKHCPTT - Ngung khau hao chi phi
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmDMComplexView |
| Chuc nang | Quan ly ngung phan bo chi phi tap trung |

### 178. CoPostCPTT2GL - Post chi phi sang GL
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmCalc |
| Controls | cboKyBc, txtNam, cmdOK |
| Chuc nang | Post chi phi tap trung sang GL |

### 179. CoRptCTPBCPTT - Bao cao chi tiet phan bo chi phi
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmReport |
| Controls | txtMa_bpsd, txtMa_cp, txtTk_pb, txtTk_cp, txtMa_phi, txtMa_spct |
| Chuc nang | Bao cao chi tiet phan bo chi phi tap trung |

### 180. CoRptKHCPTT - Bao cao khai bao chi phi
| Thuoc tinh | Gia tri |
|------------|---------|
| Ke thua | frmReport |
| Controls | txtMa_bpsd |
| Chuc nang | Bao cao khai bao chi phi tap trung |

---

## Stored Procedures

### Phan bo chi phi (COPB)

| SP Name | Mo ta |
|---------|-------|
| asCOGetDMPB | Lay danh sach phan bo |
| asCOInsDMPB | Them phan bo |
| asCOUpdDMPB | Cap nhat phan bo |
| asCOPostPB | Thuc hien phan bo |
| asCOXoaPB | Xoa phan bo |

### Chi phi tap trung (CoDMCPTT)

| SP Name | Mo ta |
|---------|-------|
| asCOGetCPTT | Lay danh sach CPTT |
| asCOInsCPTT | Them CPTT |
| asCOUpdCPTT | Cap nhat CPTT |
| asCODelCPTT | Xoa CPTT |

### Gia thanh (CoCalcCost)

| SP Name | Mo ta |
|---------|-------|
| (par2) | Stored procedure tinh gia thanh |
| (par3) | Stored procedure xoa gia thanh |

---

## Business Logic

### Business Rules chinh

1. **But toan phan bo (COPB):**
   - Chon ky bao cao
   - Chon cac but toan phan bo
   - Thuc hien tinh toan phan bo theo he so
   - Xoa phan bo neu can

2. **Tinh gia thanh (CoCalcCost):**
   - Chon tai khoan dang dang
   - Chon ky tinh gia thanh
   - Cap nhat gia thanh vao bang GIA_THANH
   - Xoa cap nhat neu can

3. **Chi phi tap trung:**
   - Khai bao nguyen gia, so ky phan bo
   - Tu dong tinh gia tri phan bo 1 ky
   - Theo doi gia tri da phan bo

4. **Post/Xoa post GL:**
   - Kiem tra ngay khoa so
   - Thuc hien post chi phi
   - Hoac xoa post chi phi

---

## Mapping PHP

### 1. Models

```php
// app/Models/CO/DMPB.php
namespace Diepxuan\Simba\Models\CO;

class DMPB extends Model
{
    protected $table = 'CODMPB';
    protected $primaryKey = 'ma_pb';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = ['ma_pb', 'ten_pb', 'tk_pb', 'theo_spct', 'theo_bp', 'theo_tkdu'];
    protected $casts = ['theo_spct' => 'boolean', 'theo_bp' => 'boolean', 'theo_tkdu' => 'boolean'];
}

// app/Models/CO/CPTT.php
namespace Diepxuan\Simba\Models\CO;

class CPTT extends Model
{
    protected $table = 'COCPTT';
    protected $primaryKey = 'ma_cptt';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_cptt', 'ten_cptt', 'dvt', 'so_luong', 'don_gia', 'ng_gia',
        'so_ky', 'tk_cptt', 'tk_cp', 'ma_bpsd', 'ma_spct', 'ma_phi'
    ];
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/
namespace Diepxuan\Simba\StoredProcedures;

// COPB
class AsCOGetDMPB extends StoredProcedure { /* ... */ }
class AsCOPostPB extends StoredProcedure { /* ... */ }

// CoCalcCost
class AsCOCalcGiaThanh extends StoredProcedure { /* ... */ }
class AsCODelGiaThanh extends StoredProcedure { /* ... */ }

// CoDMCPTT
class AsCOGetCPTT extends StoredProcedure { /* ... */ }
```

### 3. Livewire Components

```php
// COPB - But toan phan bo
namespace Diepxuan\Catalog\Http\Livewire\CO\ButToan;
class ButToanPhanBo extends Component { /* ... */ }

// CoCalcCost - Tinh gia thanh
namespace Diepxuan\Catalog\Http\Livewire\CO\TinhGiaThanh;
class TinhGiaThanh extends Component { /* ... */ }

// CoDMCPTT - Danh muc CPTT
namespace Diepxuan\Catalog\Http\Livewire\CO\Danhmuc;
class ChiPhiTapTrung extends Component { /* ... */ }
```

### 4. Views

```
resources/views/catalog/co/
├── but-toan/phan-bo.blade.php
├── tinh-gia-thanh.blade.php
├── danh-muc/chi-phi-tap-trung.blade.php
├── bao-cao/gia-thanh-01.blade.php
├── bao-cao/gia-thanh-02.blade.php
├── bao-cao/gia-thanh-03.blade.php
├── bao-cao/gia-dinh-bien.blade.php
├── bao-cao/chi-tiet-phan-bo.blade.php
└── bao-cao/khai-bao-chi-phi.blade.php
```

### 5. Routes

```php
Route::prefix('catalog/co')
    ->name('catalog.co.')
    ->group(function () {
        // Danh muc
        Route::get('/chi-phi-tap-trung', [ChiPhiTapTrung::class, 'render'])
            ->name('chiphitaptrung');
        Route::get('/danh-muc-lien-ket', [DanhMucLienKet::class, 'render'])
            ->name('danhmuchienthong');
        
        // But toan
        Route::get('/but-toan-phan-bo', [ButToanPhanBo::class, 'render'])
            ->name('buttoanphanbo');
        Route::post('/but-toan-phan-bo/execute', [ButToanPhanBo::class, 'execute'])
            ->name('buttoanphanbo.execute');
        
        // Tinh gia thanh
        Route::get('/tinh-gia-thanh', [TinhGiaThanh::class, 'render'])
            ->name('tinhtangthanhmh');
        Route::post('/tinh-gia-thanh/update', [TinhGiaThanh::class, 'update'])
            ->name('tinhtangthanhmh.update');
        
        // Bao cao
        Route::get('/bao-cao/gia-dinh-bien', [GiaDinhBien::class, 'render'])
            ->name('baocao.giadinhbien');
        Route::get('/bao-cao/gia-thanh-01', [GiaThanh01::class, 'render'])
            ->name('baocao.giathanh01');
        Route::get('/bao-cao/gia-thanh-02', [GiaThanh02::class, 'render'])
            ->name('baocao.giathanh02');
        Route::get('/bao-cao/gia-thanh-03', [GiaThanh03::class, 'render'])
            ->name('baocao.giathanh03');
    });
```

---

## Dependencies

| Loai | Package | Ghi chu |
|------|---------|---------|
| Model | laravel-simba | DMPB, CPTT, LK |
| SP Classes | laravel-simba | AsCO* |
| Components | laravel-catalog | CO* |
| Framework | AsiaERP | frmReport, frmCalc pattern |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model DMPB, CPTT
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire ButToanPhanBo
- [ ] Tao Livewire TinhGiaThanh
- [ ] Tao Livewire ChiPhiTapTrung
- [ ] Tao Livewire LienKet (COLK)
- [ ] Tao Views cho cac bao cao
- [ ] Them Routes
- [ ] Test CRUD operations
- [ ] Test but toan phan bo
- [ ] Test tinh gia thanh
- [ ] Test Integration voi GL
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.168`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
