# Task 099: SIRptLOGCT

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang thong ke cap nhat chung tu (Log) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** SIRptLOGCT.dll
- **Chuc nang:** Thong ke / Log cap nhat chung tu
- **Loai:** Report (RPT)
- **Assembly Title:** Thong ke cap nhat chung tu
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** asiasoft
- **Ma_ct:** SIRptLOGCT

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIRptLOGCT.dll/README.md`

---

## Form classes

### frmSIRptLOGCT (Form bao cao)
- **Ke thua:** frmReport
- **Chuc nang:** Theo doi log sua/xoa chung tu

### Filter Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtUser | AsTextBox | Nguoi su dung |
| cboAction | ComboBox | Hanh dong (Sua/Xoa) |
| txtMa_ct | AsTextBox | Ma chung tu |
| txtTu_ngay | DateTimePicker | Tu ngay |
| txtDen_ngay | DateTimePicker | Den ngay |
| cmdExport | Button | Xuat Excel |

### Action values

| Gia tri | Mo ta |
|---------|-------|
| Sửa | UPDATE |
| Xóa | DELETE |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_SI_LOGCT_GET | Lay danh sach log |
| SP_SI_LOGCT_GETBYID | Lay chi tiet 1 log |
| SP_SI_LOGCT_FIND | Tim kiem |

### SP_GET (reference)

```sql
EXEC SP_SI_LOGCT_GET
    @pMa_cty VARCHAR(50) = '001',
    @pUser VARCHAR(50) = NULL,
    @pAction VARCHAR(20) = NULL,
    @pMa_ct VARCHAR(10) = NULL,
    @pTu_ngay DATETIME = NULL,
    @pDen_ngay DATETIME = NULL
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid date range | tu_ngay/den_ngay | 'Ngay khong hop le' |

### Business Rules

1. **Theo doi thay doi**:
   - Ghi nhan cac thao tac sua (UPDATE)
   - Ghi nhan cac thao tac xoa (DELETE)

2. **Loc theo nhieu tieu chi**:
   - Theo nguoi su dung
   - Theo hanh dong
   - Theo ma chung tu
   - Theo thoi gian

3. **Audit trail**:
   - Ho tro kiem toan
   - Phat hien bat thuong

---

## Mapping PHP

### 1. Model (Log Table)

```php
// app/Models/SI/LOGCT.php
namespace Diepxuan\Simba\Models\SI;

class LOGCT extends Model
{
    protected $table = 'LOGCT';  // Bang log chung tu
    protected $primaryKey = 'log_id';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'log_id',
        'ma_ct',
        'ten_ct',
        'stt_rec',
        'so_ct',
        'action',     // UPDATE/DELETE
        'user_id',
        'user_name',
        'old_data',
        'new_data',
        'log_date',
        'log_time',
    ];

    protected $casts = [
        'log_date' => 'datetime',
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDateRange($query, $tu_ngay, $den_ngay)
    {
        if ($tu_ngay) $query->where('log_date', '>=', $tu_ngay);
        if ($den_ngay) $query->where('log_date', '<=', $den_ngay);
        return $query;
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/Report/Logchungtu.php
namespace Diepxuan\Catalog\Http\Livewire\SI\Report;

class Logchungtu extends Component
{
    public ?string $pUser = null;
    public ?string $pAction = null;
    public ?string $pMa_ct = null;
    public ?string $pTu_ngay = null;
    public ?string $pDen_ngay = null;

    public Collection $pDanhSach;
    public array $pActionOptions = [
        '' => 'Tat ca',
        'UPDATE' => 'Sua',
        'DELETE' => 'Xoa',
    ];

    protected $rules = [
        'pTu_ngay' => 'nullable|date',
        'pDen_ngay' => 'nullable|date',
    ];

    public function mount(): void
    {
        $this->pDanhSach = collect([]);
    }

    public function loadData(): void
    {
        $query = LOGCT::query()
            ->byDateRange($this->pTu_ngay, $this->pDen_ngay);

        if ($this->pUser) {
            $query->byUser($this->pUser);
        }
        if ($this->pAction) {
            $query->byAction($this->pAction);
        }
        if ($this->pMa_ct) {
            $query->where('ma_ct', 'like', "%{$this->pMa_ct}%");
        }

        $this->pDanhSach = $query->orderBy('log_date', 'desc')
            ->orderBy('log_time', 'desc')
            ->limit(500)
            ->get();
    }

    public function exportExcel(): void
    {
        // Xuat danh sach log ra Excel
    }

    public function viewDetail(LOGCT $log): void
    {
        // Hien thi chi tiet thay doi
    }

    public function render(): View
    {
        return view('catalog::si.report.logchungtu');
    }
}
```

### 3. Views

```
resources/views/catalog/si/report/
├── logchungtu.blade.php
├── logchungtu-detail.blade.php
└── _logchungtu-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si/report')
    ->name('catalog.si.report.')
    ->group(function () {
        Route::get('/log-chung-tu', [Logchungtu::class, 'render'])
            ->name('logchungtu');
        Route::get('/log-chung-tu/{log_id}', [Logchungtu::class, 'render'])
            ->name('logchungtu.detail');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | LOGCT.php | Bang log |
| Component | laravel-catalog | Logchungtu.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nafy
- [ ] Tao Model LOGCT
- [ ] Tao Livewire Logchungtu
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test xem log
- [ ] Test xuat Excel
- [ ] Test xem chi tiet thay doi
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
