# Task 086: SIMaintain

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang bao tri he thong tu .NET sang PHP Laravel. Bao gom: ReIndex database, Trim ma, Kiem tra hach toan, Kiem tra lech so, Sao luu.

## Chi tiet
- **DLL:** SIMaintain.dll
- **Chuc nang:** Bao tri he thong
- **Loai:** System (SYS)
- **Assembly Title:** Bao tri he thong
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** SIMaintain

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIMaintain.dll/README.md`

---

## Cau truc du lieu

SIMaintain la module bao tri he thong, khong co bang du lieu chinh. Cac chuc nang tac dong truc tiep len database.

### Bang tam thoi (neu can)

| Bang | Mo ta | Tam thoi |
|------|-------|----------|
| TMP_TRIM_RESULT | Ket qua trim ma | Co |
| TMP_CHECK_RESULT | Ket qua kiem tra | Co |

### Table Navigation

| Bang | Mo ta | Relationship |
|------|-------|--------------|
| SYS | Database Sys | Tham chieu cau hinh |
| DATA | Database Data | Tham chieu du lieu |

---

## Form classes

### 1. frmSIMaintain (Menu tong hop)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Menu cac chuc nang bao tri
- **MenuID:** 90.10.70

### Controls (Menu Links)

| Link | Mo ta |
|------|-------|
| lnkReIndex | Danh lai chi muc |
| lnkTrimMa | Loai bo khoang trang |
| lnkCheckHT | Kiem tra hach toan |
| lnkCheckLech | Kiem tra lech so |
| lnkBackup | Sao luu du lieu |
| lnkAutoBackup | Tu dong sao luu |

### 2. frmSITrim_Ma (Loai bo khoang trang)
- **Chuc nang:** Loai bo khoang trang dau/cuoi trong ma
- **MenuID:** 90.10.71

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| dgvMa | DataGridView | Danh sach ma can xu ly |
| chkAll | CheckBox | Chon tat ca |
| btnExecute | Button | Thuc hien trim |
| lblCount | Label | So luong da xu ly |

### 3. frmSICheckHT2TKTH (Kiem tra hach toan TKTH)
- **Chuc nang:** Kiem tra TK tong hop
- **MenuID:** 90.10.72

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| dgvResult | DataGridView | Ket qua kiem tra |
| btnCheck | Button | Kiem tra |
| lblStatus | Label | Trang thai |

### 4. frmSICheckLechSo (Kiem tra lech so)
- **Chuc nang:** Kiem tra lech giua ke toan va kho
- **MenuID:** 90.10.73

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtTu_ngay | DateTimePicker | Tu ngay |
| txtDen_ngay | DateTimePicker | Den ngay |
| dgvLech | DataGridView | Ket qua lech |
| btnCheck | Button | Kiem tra |

### 5. frmSIBackupDB (Sao luu du lieu)
- **Chuc nang:** Sao luu thu cong

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtPath | TextBox | Thu muc luu backup |
| btnPath | Button | Chon thu muc |
| btnBackup | Button | Sao luu |
| lblDataDB | Label | Ten database Data |
| lblSysDB | Label | Ten database Sys |
| lblProgress | Label | Tien trinh |

### 6. frmAutoBackup (Cau hinh auto backup)
- **Chuc nang:** Tao auto backup job

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| chkCN | CheckBox | Chu nhat |
| chkT2 | CheckBox | Thu 2 |
| chkT3 | CheckBox | Thu 3 |
| chkT4 | CheckBox | Thu 4 |
| chkT5 | CheckBox | Thu 5 |
| chkT6 | CheckBox | Thu 6 |
| chkT7 | CheckBox | Thu 7 |
| txtTime | AsMaskedTextBox | Gio chay (HH:MM:SS) |
| txtPath | TextBox | Thu muc luu |
| btnSave | Button | Luu cau hinh |

### 7. frmBackup (Tien trinh backup)
- **Chuc nang:** Hien thi progress backup

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asSIMaintain01_ReIndex | Danh lai chi muc database |
| asSIMaintain021 | Lay danh sach ma can xu ly |
| asSIMaintain022 | Xoa khoang trang trong ma |
| asSIMaintain05 | Sao luu database |
| asSiScheduleAutoBackupData | Tao auto backup job |
| asSIMaintain_CheckHT2TKTH | Kiem tra hach toan |
| asSIMaintain_CheckLechSo | Kiem tra lech so |

### asSIMaintain01_ReIndex (reference)

```sql
-- Danh lai chi muc toan bo database
EXEC asSIMaintain01_ReIndex
    @pMa_cty VARCHAR(50) = '001'
-- Tra ve: so chi muc da danh lai
```

### asSIMaintain022 (reference)

```sql
-- Loai bo khoang trang trong ma
EXEC asSIMaintain022
    @pMa_cty VARCHAR(50) = '001',
    @pLst_Ma TEXT,  -- Danh sach ma can xu ly, phan cach bang ','
    @pResult INT OUTPUT
```

### asSiScheduleAutoBackupData (reference)

```sql
-- Tao auto backup job
EXEC asSiScheduleAutoBackupData
    @pMa_cty VARCHAR(50),
    @pBackupPath VARCHAR(255),
    @pFreqType INT,        -- 8 = Weekly
    @pFreqInterval INT,    -- Bitmask: CN=1,T2=2,T3=4,T4=8,T5=16,T6=32,T7=64
    @pActiveStartTime INT  -- Thoi gian chay (HHMMSS)
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid path | BackupPath | 'Duong dan khong hop le' |
| At least one day | BackupDays | 'Chon it nhat 1 ngay' |
| Valid time | BackupTime | 'Gio khong hop le' |

### Business Rules

1. **ReIndex (Danh lai chi muc)**:
   - Thuc thi `asSIMaintain01_ReIndex`
   - Hien thi xac nhan truoc khi thuc hien
   - Toi uu performance database
   - Chi danh lai cac chi muc (khong sua du lieu)

2. **Trim Ma (Loai bo khoang trang)**:
   - Lay danh sach ma tu `asSIMaintain021`
   - Hien thi grid de nguoi dung chon
   - Thuc thi `asSIMaintain022` voi danh sach da chon
   - Ap dung cho: ma_nhkh, ma_vt, ma_tk, ma_kho, ma_dt

3. **Kiem tra Hach toan vao TKTH**:
   - Kiem tra cac bung toan co mat TK tong hop
   - Tim phieu co TK chi tiet nhung khong co TK tong hop
   - Hien thi danh sach cac phieu loi

4. **Kiem tra Lec so**:
   - So sanh du lieu ke toan va kho
   - Tim cac phieu co so luong lech nhau
   - Theo khoang thoi gian

5. **Backup (Sao luu)**:
   - Backup database Data va Sys
   - Su dung `BACKUP DATABASE` cua SQL Server
   - Hien thi tien trinh

6. **Auto Backup (Tu dong sao luu)**:
   - Tao SQL Server Agent Job
   - Bitmask cho ngay trong tuan:
     - CN = 1, T2 = 2, T3 = 4, T4 = 8
     - T5 = 16, T6 = 32, T7 = 64
   - Neu khong chon ngay -> mac dinh Chu nhat (1)

---

## Mapping PHP

### 1. Livewire Component (Main Menu)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/BaotriHs.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class BaotriHs extends Component
{
    public string $pActiveTab = 'menu';
    public string $pStatus = '';

    // ReIndex
    public function reindex(): void
    {
        $this->pStatus = 'Dang danh lai chi muc...';
        // DB::statement('EXEC asSIMaintain01_ReIndex ?', [$ma_cty]);
        $this->pStatus = 'Hoan tat danh lai chi muc';
    }

    // Backup
    public ?string $pBackupPath = null;
    public function backup(): void
    {
        $this->pStatus = 'Dang sao luu...';
        // DB::statement('EXEC asSIMaintain05 ?', [$this->pBackupPath]);
        $this->pStatus = 'Hoan tat sao luu';
    }

    // Auto Backup
    public array $pBackupDays = [];
    public ?string $pBackupTime = '00:00:00';

    public function saveAutoBackup(): void
    {
        if (empty($this->pBackupDays)) {
            $this->pBackupDays = ['sunday'];
        }

        $freqInterval = 0;
        $dayMap = [
            'sunday' => 1, 'monday' => 2, 'tuesday' => 4,
            'wednesday' => 8, 'thursday' => 16,
            'friday' => 32, 'saturday' => 64,
        ];
        foreach ($this->pBackupDays as $day) {
            $freqInterval += $dayMap[$day] ?? 0;
        }

        $time = str_replace(':', '', $this->pBackupTime);
        // DB::statement('EXEC asSiScheduleAutoBackupData ?,?,?,?,?',
        //    [$ma_cty, $this->pBackupPath, 8, $freqInterval, $time]);

        $this->pStatus = 'Da luu cau hinh auto backup';
    }

    public function render(): View
    {
        return view('catalog::si.system.baotri-hs');
    }
}
```

### 2. Livewire Component (Trim Ma)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/TrimMa.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class TrimMa extends Component
{
    public Collection $pDanhSach;
    public array $pSelectedIds = [];
    public string $pStatus = '';
    public int $pProcessedCount = 0;

    public function mount(): void
    {
        $this->loadMa();
    }

    public function loadMa(): void
    {
        // $this->pDanhSach = DB::select('EXEC asSIMaintain021 ?', [$ma_cty]);
    }

    public function execute(): void
    {
        if (empty($this->pSelectedIds)) {
            $this->pStatus = 'Chon it nhat 1 ma de xu ly';
            return;
        }

        $lstMa = implode(',', $this->pSelectedIds);
        // DB::statement('EXEC asSIMaintain022 ?,?', [$ma_cty, $lstMa]);
        $this->pStatus = 'Da xu ly ' . count($this->pSelectedIds) . ' ma';
        $this->pProcessedCount = count($this->pSelectedIds);
        $this->loadMa(); // Tai lai danh sach
    }

    public function render(): View
    {
        return view('catalog::si.system.trim-ma');
    }
}
```

### 3. Views

```
resources/views/catalog/si/system/
├── baotri-hs.blade.php              (Main menu)
├── _baotri-hs-reindex.blade.php
├── _baotri-hs-backup.blade.php
├── _baotri-hs-autobackup.blade.php
├── trim-ma.blade.php                (Trim ma page)
└── _trim-ma-row.blade.php
```

### 4. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/bao-tri-hs', [BaotriHs::class, 'render'])
            ->name('baotri-hs');
        Route::get('/trim-ma', [TrimMa::class, 'render'])
            ->name('trim-ma');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | BaotriHs.php | Menu tong hop |
| Component | laravel-catalog | TrimMa.php | Trim ma |
| SP | laravel-simba | asSIMaintain01_ReIndex | ReIndex |
| SP | laravel-simba | asSIMaintain022 | Trim |
| SP | laravel-simba | asSIMaintain05 | Backup |
| SP | laravel-simba | asSiScheduleAutoBackupData | Auto backup |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Livewire BaotriHs (menu)
- [ ] Tao Livewire TrimMa
- [ ] Tao Views (menu + sub-forms)
- [ ] Them Routes
- [ ] Test ReIndex
- [ ] Test Trim Ma
- [ ] Test Backup thu cong
- [ ] Test Auto Backup