# Task 007: ARRecalCustBalance

## Nhom: AR (Accounts Receivable - Cong no phai thu)

## Muc tieu
Chuyen doi chuc nang tinh lai so du khach hang tu .NET sang PHP Laravel, dat ket qua tuong duong ARRecalCustBalance.

## Chi tiet
- **DLL:** ARRecalCustBalance.dll
- **Chuc nang:** Tinh lai so du cong no khach hang khi co sailech hoac sau khi import du lieu
- **Loai:** Tinh toan (Batch process)
- **Assembly Title:** Asia Enterprise
- **Version:** 9.1.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** AR (module AR)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/ARRecalCustBalance.dll/README.md`

---

## Cau truc du lieu

### Bang lien quan

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Danh muc khach hang | FK ma_kh |
| ARTT | So du dau ky | So du dau ky |
| AR4PH | Chung tu AR4 | Phat sinh cong no |
| ARPost2TT | Phan bo thanh toan | Cap nhat trang thai TT |
| ARBalance | Bang so du | Luu so du cuoi ky |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMKH | Khach hang | Lookup ma_kh |
| AR4PH | Chung tu | Lookup stt_rec, tinh ps_no/ps_co |
| ARPost2TT | Phan bo | Lookup stt_rec, tinh ps_co |

---

## Form classes

### 1. frmARRecalCustBalance (Form tinh lai so du)
- **Ke thua:** frmReport
- **Chuc nang:** Chon thoi gian, khach hang, thuc hien tinh lai, xem ket qua
- **Controls:**

| Control | Type | Mo ta |
|---------|------|-------|
| txtNgay1 | AsMaskedTextBox | Tu ngay |
| txtNgay2 | AsMaskedTextBox | Den ngay |
| txtMa_Kh | AsTextBox | Ma khach hang (tuy chon) |
| lblTen_Kh | Label | Ten khach hang |
| cmdTinhLai | Button | Nut thuc hien tinh lai |
| dgvKetQua | DataGridView | Ket qua tinh toan |
| lblStatus | Label | Trang thai xu ly |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_AR_RECAL_GETDATA | Lay du lieu can tinh lai |
| SP_AR_RECAL_PROCESS | Tinh lai so du cho 1 KH |
| SP_AR_RECAL_ALL | Tinh lai tat ca KH |
| SP_AR_RECAL_REPORT | Lay ket qua tinh lai |

### SP_RECAL_PROCESS (reference)

```sql
-- Tinh lai so du cho 1 khach hang
EXEC SP_AR_RECAL_PROCESS
    @pMa_cty VARCHAR(50),
    @pMa_kh VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pStatus INT OUTPUT
```

### SP_RECAL_ALL (reference)

```sql
-- Tinh lai tat ca khach hang
EXEC SP_AR_RECAL_ALL
    @pMa_cty VARCHAR(50),
    @pNgay1 DATETIME,
    @pNgay2 DATETIME,
    @pStatus INT OUTPUT
```

---

## Business Logic

### Quy trinh tinh lai so du

1. **Xac dinh khoang thoi gian**:
   - Tu ngay - Den ngay
   - Kiem tra ngay khoa so (khong cho phep tinh lai truoc ngay khoa so)

2. **Lay du lieu phat sinh**:
   - Lay tu bang AR4PH (chung tu AR)
   - Lay tu bang ARPost2TT (phan bo thanh toan)
   - Lay tu bang ARTT (so du dau ky)

3. **Tinh toan so du**:
   ```
   So du dau ky = Du_dk_tu_ARTT
   Phat sinh no = Sum(ps_no) tu AR4PH trong ky
   Phat sinh co = Sum(ps_co) tu AR4PH + ARPost2TT trong ky
   So du cuoi ky = Dau ky + No - Co
   ```

4. **Cap nhat so du**:
   - Luu vao bang ARBalance
   - Cap nhat ngay tinh lai cuoi

5. **Hien thi ket qua**:
   - Grid ket qua voi chi tiet tinh toan
   - Bao gom: ma_kh, ten_kh, du_dk, ps_no, ps_co, du_ck

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid date range | ngay1, ngay2 | 'Ngay bat dau phai nho hon ngay ket thuc' |
| After lock date | ngay1 | 'Khong the tinh lai truoc ngay khoa so' |
| Valid customer | ma_kh | 'Ma khach hang khong ton tai' |

### Canh bao

1. **Kiem tra ngay khoa so**:
   - Khong cho phep tinh lai neu ngay1 < ngay_khoa_so

2. **Sao luu truoc khi thuc hien**:
   - Khuyen cao nguoi dung sao luu du lieu
   - Tao log truoc khi tinh lai

3. **Xu ly batch**:
   - Neu chon nhieu KH, xu ly theo batch
   - Hien thi tien trinh (progress bar)
   - Cho phep huy giua chung

---

## Mapping PHP

### 1. Model

```php
// app/Models/AR/ARBalance.php
namespace Diepxuan\Simba\Models\AR;

class ARBalance extends Model
{
    protected $table = 'ARBalance';
    protected $primaryKey = ['ma_kh', 'ma_tk', 'nam', 'ky'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_kh',
        'ma_tk',
        'nam',
        'ky',
        'du_dk',
        'ps_no',
        'ps_co',
        'du_ck',
        'ngay_tinh_lai',
    ];

    protected $casts = [
        'du_dk' => 'decimal:2',
        'ps_no' => 'decimal:2',
        'ps_co' => 'decimal:2',
        'du_ck' => 'decimal:2',
        'ngay_tinh_lai' => 'datetime',
    ];

    // Relationships
    public function khachHang()
    {
        return $this->belongsTo(DMKH::class, 'ma_kh', 'ma_kh');
    }
}

// app/Models/AR/ARRecalLog.php
class ARRecalLog extends Model
{
    protected $table = 'ARRecalLog';
    protected $primaryKey = 'id';
    protected $connection = 'simba';

    protected $fillable = [
        'ma_kh',
        'ngay1',
        'ngay2',
        'tong_kh',
        'tong_ps_no',
        'tong_ps_co',
        'trang_thai',
        'nguoi_thuc_hien',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
    ];

    protected $casts = [
        'ngay1' => 'datetime',
        'ngay2' => 'datetime',
        'thoi_gian_bat_dau' => 'datetime',
        'thoi_gian_ket_thuc' => 'datetime',
    ];
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsARRecalProcess.php
namespace Diepxuan\Simba\StoredProcedures;

class AsARRecalProcess extends StoredProcedure
{
    protected $procedure = 'SP_AR_RECAL_PROCESS';
    protected $params = [
        'pMa_cty',
        'pMa_kh',
        'pNgay1',
        'pNgay2',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARRecalAll.php
class AsARRecalAll extends StoredProcedure
{
    protected $procedure = 'SP_AR_RECAL_ALL';
    protected $params = [
        'pMa_cty',
        'pNgay1',
        'pNgay2',
    ];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsARRecalReport.php
class AsARRecalReport extends StoredProcedure
{
    protected $procedure = 'SP_AR_RECAL_REPORT';
    protected $params = [
        'pMa_cty',
        'pNgay1',
        'pNgay2',
    ];
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/AR/Tools/TinhLaiSoDu.php
namespace Diepxuan\Catalog\Http\Livewire\AR\Tools;

class TinhLaiSoDu extends Component
{
    const MA_CT = 'AR';

    public ?Carbon $pNgay1 = null;
    public ?Carbon $pNgay2 = null;
    public ?string $pMaKh = null;
    public ?string $pTenKh = null;
    public bool $pIsProcessing = false;
    public float $pProgress = 0;
    public Collection $pResults;
    public ?string $pStatus = null;

    public function mount(): void
    {
        $this->pNgay1 = now()->startOfMonth();
        $this->pNgay2 = now();
        $this->pResults = collect();
    }

    public function updatedPMaKh($value): void
    {
        if ($value) {
            $kh = DMKH::find($value);
            $this->pTenKh = $kh?->ten_kh;
        }
    }

    public function processRecal(): void
    {
        $this->validate([
            'pNgay1' => 'required|date',
            'pNgay2' => 'required|date|after_or_equal:pNgay1',
        ]);

        $this->pIsProcessing = true;
        $this->pProgress = 0;

        try {
            if ($this->pMaKh) {
                // Tinh lai 1 khach hang
                $sp = new AsARRecalProcess();
                $sp->execute([
                    'pMa_cty' => '001',
                    'pMa_kh' => $this->pMaKh,
                    'pNgay1' => $this->pNgay1,
                    'pNgay2' => $this->pNgay2,
                ]);
            } else {
                // Tinh lai tat ca
                $sp = new AsARRecalAll();
                $sp->execute([
                    'pMa_cty' => '001',
                    'pNgay1' => $this->pNgay1,
                    'pNgay2' => $this->pNgay2,
                ]);
            }

            // Lay ket qua
            $reportSp = new AsARRecalReport();
            $this->pResults = $reportSp->execute([
                'pMa_cty' => '001',
                'pNgay1' => $this->pNgay1,
                'pNgay2' => $this->pNgay2,
            ]);

            $this->pStatus = 'Hoan thanh tinh lai so du';
        } catch (\Exception $e) {
            $this->pStatus = 'Loi: ' . $e->getMessage();
        } finally {
            $this->pIsProcessing = false;
        }
    }

    public function render(): View
    {
        return view('catalog::ar.tools.tinh-lai-so-du');
    }
}
```

### 4. Views

```
resources/views/catalog/ar/tools/
├── tinh-lai-so-du.blade.php        (Form chinh)
├── tinh-lai-so-du-results.blade.php (Ket qua)
└── _tinh-lai-progress.blade.php    (Progress bar)
```

### 5. Routes

```php
// routes/catalog.php
Route::prefix('catalog/ar/tools')
    ->name('catalog.ar.tools.')
    ->group(function () {
        Route::get('/tinh-lai-so-du', [TinhLaiSoDu::class, 'render'])
            ->name('tinh-lai-so-du');
        Route::post('/tinh-lai-so-du/process', [TinhLaiSoDu::class, 'processRecal'])
            ->name('tinh-lai-so-du.process');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | ARBalance.php | Bang so du |
| Model | laravel-simba | ARRecalLog.php | Log tinh lai |
| Model | laravel-simba | DMKH.php | Lookup KH |
| Model | laravel-simba | AR4PH.php | Chung tu phat sinh |
| SP | laravel-simba | AsARRecalProcess.php | Tinh lai 1 KH |
| SP | laravel-simba | AsARRecalAll.php | Tinh lai tat ca |
| SP | laravel-simba | AsARRecalReport.php | Lay ket qua |
| Component | laravel-catalog | TinhLaiSoDu.php | Form tinh lai |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tim kiem mapping SP tu DLL
- [ ] Tao Model ARBalance, ARRecalLog
- [ ] Tao Stored Procedure classes
- [ ] Tao Livewire TinhLaiSoDu
- [ ] Tao Views (form + results)
- [ ] Them Routes
- [ ] Implement progress tracking
- [ ] Test tinh lai so du
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (task shell route)
- **Route:** `task.shell.007`
- **Note:** Process/voucher/report shell; write/transfer blocked until payload audit.
