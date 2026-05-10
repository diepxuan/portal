# Task 081: SIUPDATETOOL

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang dong bo/cap nhat he thong tu .NET sang PHP Laravel. Day la cong cu dong bo du lieu giua cac he thong, dam bao tinh nhat quan khi cap nhat.

## Chi tiet
- **DLL:** SIUPDATETOOL.dll
- **Chuc nang:** Dong bo / Cap nhat he thong
- **Loai:** System Tool (HE THONG)
- **Assembly Title:** SIUPDATETOOL
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia
- **Ma_ct:** SIUPDATETOOL

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIUPDATETOOL.dll/README.md`

---

## Cau truc du lieu

SIUPDATETOOL la cong cu dong bo chuong trinh, khong su dung bang du lieu chinh ma phu thuoc vao:

### File cau hinh: AsiaErpSync.exe.config

| Key | Mo ta |
|-----|-------|
| UPDATE_PATH | Duong dan thu muc chua file cap nhat tren server |
| ServerName | Ten server de ket noi |
| DatabaseName | Ten database |

### Bang log cap nhat (Sys)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| log_id | int | Khoa chinh |
| update_date | datetime | Ngay cap nhat |
| update_by | varchar(50) | Nguoi thuc hien |
| update_version | varchar(50) | Phien ban |
| status | int | Trang thai (50999=Loi, 50010=Loi chung, 50015=Thanh cong) |

### Bang can dong bo (tham chieu)

| Bang | Mo ta | Relationship |
|------|-------|--------------|
| DMLOG | Log thay doi du lieu | Tu dong tao khi cap nhat |
| SYSMENU | Menu he thong | Cap nhat theo phien ban |
| SYSPARAMS | Tham so he thong | Cap nhat theo phien ban |

---

## Form classes

### 1. FrmSync (Form chinh dong bo)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Dong bo/cap nhat chuong trinh

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtFromPath | AsTextBox | Thu muc nguon (Từ thư mục) |
| txtToPath | AsTextBox | Thu muc dich (Đến thư mục) |
| rbSyncServer | RadioButton | Dong bo voi may chu |
| rbSyncZip | RadioButton | Cap nhat tu file zip |
| btnSync | Button | Nut thuc hien dong bo |
| btnCancel | Button | Nut huy |
| lblNote | Label | Ghi chu trang thai |

### 2. frmSplash (Splash screen)
- **Ke thua:** Form
- **Chuc nang:** Man hinh cho trong qua trinh cap nhat

---

## Stored Procedures

SIUPDATETOOL su dung cac SP de ghi log va thuc thi cau lenh:

| SP Name | Mo ta |
|---------|-------|
| SP_SI_LOG_UPDATE | Ghi log qua trinh cap nhat |
| asSIUPDATETOOL_GetVersion | Lay phien ban hien tai |
| asSIUPDATETOOL_GetStatus | Lay trang thai cap nhat |

### SP_LOG_UPDATE (reference)

```sql
-- Ghi log qua trinh cap nhat
EXEC SP_SI_LOG_UPDATE
    @pMa_cty VARCHAR(50),
    @pUpdate_Version VARCHAR(50),
    @pStatus INT OUTPUT,
    @pError_Code INT OUTPUT
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid path | FromPath | 'Thu muc/file khong ton tai' |
| Config exists | UPDATE_PATH | 'File config khong ton tai' |
| Valid config write | UPDATE_PATH | 'Loi ghi config' |

### Business Rules

1. **Che do Dong bo Server**:
   - Chon thu muc nguon chua file cap nhat tren server
   - Copy file tu thu muc nguon den thu muc ung dung
   - Ghi log vao bang SysLogUpdate
   - Chay AsiaErpSync.exe de bat dau dong bo

2. **Che do Dong bo Zip File**:
   - Chon file .zip chua package cap nhat
   - Giai nen va copy noi dung vao thu muc ung dung
   - Kiem tra tinh toan ven cua file truoc khi replace

3. **Tat dong ung dung truoc cap nhat**:
   - Su dung `Process.GetProcessesByName('Startup')` de tim process
   - Kill process truoc khi copy/replace file
   - Dam bao khong co file bi khoa

4. **Splash Screen**:
   - Hien thi khi qua trinh cap nhat bat dau
   - Chay tren thread rieng
   - Tu dong dong khi hoan tat

5. **Ghi log**:
   - Ghi vao bang SYSLOGUPDATE
   - Theo doi phien ban, ngay gio, nguoi thuc hien
   - Su dung ma trang thai de phan biet ket qua

### Ma trang thai

| Ma | Mo ta |
|----|-------|
| 50999 | Thu muc/file khong ton tai |
| 50110 | File config khong ton tai |
| 50998 | Loi ghi config |
| 50010 | Loi chung |
| 50015 | Thanh cong |

---

## Mapping PHP

### 1. Model

```php
// app/Models/SI/SyncLog.php
namespace Diepxuan\Simba\Models\SI;

class SyncLog extends Model
{
    protected $table = 'SYNCLOG';  // Bang log dong bo
    protected $primaryKey = 'log_id';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'log_id',
        'update_date',
        'update_by',
        'update_version',
        'status',
        'error_code',
        'notes',
    ];

    protected $casts = [
        'update_date' => 'datetime',
        'status' => 'integer',
    ];

    public function scopeSuccess($query)
    {
        return $query->where('status', 50015);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', '<>', 50015);
    }
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/DongboCapnhat.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class DongboCapnhat extends Component
{
    public string $pMode = 'server'; // 'server' | 'zip'
    public ?string $pFromPath = null;
    public ?string $pToPath = null;
    public ?string $pZipFile = null;
    public string $pStatus = '';
    public bool $pIsSyncing = false;
    public float $pProgress = 0;

    public array $pModeOptions = [
        'server' => 'Dong bo voi may chu',
        'zip' => 'Cap nhat tu file (*.zip)',
    ];

    protected $rules = [
        'pFromPath' => 'required_if:pMode,server|nullable|string',
        'pZipFile' => 'required_if:pMode,zip|nullable|string',
    ];

    public function mount(): void
    {
        // Doc duong dan mac dinh tu config
        $this->pToPath = base_path();
        $this->pFromPath = config('simba.update_path', '');
    }

    public function sync(): void
    {
        $this->validate();

        $this->pIsSyncing = true;
        $this->pStatus = 'Dang dong bo...';
        $this->pProgress = 0;

        try {
            if ($this->pMode === 'server') {
                $this->syncFromServer();
            } else {
                $this->syncFromZip();
            }

            $this->pStatus = 'Dong bo thanh cong!';
            $this->pProgress = 100;

        } catch (\Exception $e) {
            $this->pStatus = 'Loi: ' . $e->getMessage();
            $this->pProgress = 0;
        } finally {
            $this->pIsSyncing = false;
        }
    }

    protected function syncFromServer(): void
    {
        // Copy file tu thu muc nguon den thu muc dich
        // Kill running processes
        // Ghi log
    }

    protected function syncFromZip(): void
    {
        // Giai nen file zip
        // Copy file da giai nen
        // Ghi log
    }

    public function render(): View
    {
        return view('catalog::si.system.dongbo-capnhat');
    }
}
```

### 3. Views

```
resources/views/catalog/si/system/
├── dongbo-capnhat.blade.php
└── _dongbo-capnhat-progress.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/dong-bo-cap-nhat', [DongboCapnhat::class, 'render'])
            ->name('dongbo-capnhat');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | SyncLog.php | Bang log dong bo |
| Config | laravel-simba | simba.php | UPDATE_PATH |
| Component | laravel-catalog | DongboCapnhat.php | Form chinh |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Model SyncLog
- [ ] Tao Livewire DongboCapnhat
- [ ] Tao Views (server mode + zip mode)
- [ ] Them Routes
- [ ] Test dong bo tu server
- [ ] Test dong bo tu file zip
- [ ] Test kill process & ghi log
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
