# Task 097: SIBackupData

## Nhom: SI (System Integration - He thong)

## Muc tieu
Chuyen doi chuc nang sao luu phuc hoi du lieu tu .NET sang PHP Laravel. Bao gom: Backup thu cong, Restore, Auto backup.

## Chi tiet
- **DLL:** SIBackupData.dll
- **Chuc nang:** Sao luu / Phuc hoi du lieu
- **Loai:** System (SYS)
- **Assembly Title:** Bao tri he thong
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** SIBackupData

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SIBackupData.dll/README.md`

---

## Cau truc du lieu

SIBackupData la module backup/restore, khong co bang du lieu rieng. Tat ca thao tac deu thong qua SQL Server.

### Bang tam thoi (neu can)

| Bang | Mo ta | Tam thoi |
|------|-------|----------|
| SYSAUTH | Quyen truy cap | Khong |
| SYSBACKUPJOBS | Thong tin auto backup job | Khong |

### Database connections

| Database | Mo ta | Backup |
|----------|-------|--------|
| Data | Database du lieu chinh | Co |
| Sys | Database he thong | Co |

---

## Form classes

### 1. frmSIBackupDB (Sao luu thu cong)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Sao luu database thu cong
- **MenuID:** 90.20.30

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtPath | TextBox | Thu muc luu backup |
| btnPath | Button | Chon thu muc |
| btnBackup | Button | Sao luu |
| lblDataDB | Label | Ten database Data |
| lblSysDB | Label | Ten database Sys |
| lblStatus | Label | Trang thai |
| pbProgress | ProgressBar | Tien trinh |

### 2. frmSIRestoreDB (Phuc hoi du lieu)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Phuc hoi tu file .bak
- **MenuID:** 90.20.31

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtFile | TextBox | Duong dan file .bak |
| btnFile | Button | Chon file |
| lblInfo | Label | Thong tin file backup |
| lblStatus | Label | Trang thai |
| btnRestore | Button | Phuc hoi |
| pbProgress | ProgressBar | Tien trinh |

### 3. frmAutoBackup (Cau hinh auto backup)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Tao auto backup job
- **MenuID:** 90.20.32

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
| btnPath | Button | Chon thu muc |
| btnSave | Button | Luu cau hinh |
| btnDelete | Button | Xoa auto backup |
| lblStatus | Label | Trang thai |

### 4. frmSIMaintain (Menu tong hop)
- **Chuc nang:** Menu cac chuc nang bao tri

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| asSIMaintain05 | Sao luu database |
| asSiScheduleAutoBackupData | Tao auto backup job |
| asSIMaintain01_ReIndex | Danh lai chi muc |

### asSIMaintain05 (reference)

```sql
-- Sao luu database Data va Sys
EXEC asSIMaintain05
    @pMa_cty VARCHAR(50),
    @pStr_Path VARCHAR(255)  -- Thu muc luu backup
-- Tra ve: 0 = Thanh cong, -1 = Loi
```

### asSiScheduleAutoBackupData (reference)

```sql
-- Tao auto backup job trong SQL Server Agent
EXEC asSiScheduleAutoBackupData
    @pMa_cty VARCHAR(50),
    @pBackupPath VARCHAR(255),
    @pFreqType INT,           -- 8 = Weekly
    @pFreqInterval INT,       -- Bitmask ngay trong tuan
    @pActiveStartTime INT     -- Thoi gian (HHMMSS)
```

### SQL Backup command (tham khao)

```sql
-- Backup database
BACKUP DATABASE [Data] TO DISK = N'{path}\Data_{timestamp}.bak'
    WITH NOFORMAT, NOINIT, NAME = N'Data-Full Backup',
    SKIP, NOREWIND, NOUNLOAD, STATS = 10

BACKUP DATABASE [Sys] TO DISK = N'{path}\Sys_{timestamp}.bak'
    WITH NOFORMAT, NOINIT, NAME = N'Sys-Full Backup',
    SKIP, NOREWIND, NOUNLOAD, STATS = 10
```

### SQL Restore command (tham khao)

```sql
-- Restore database
RESTORE DATABASE [Data] FROM DISK = N'{bak_file}'
    WITH FILE = 1, NOUNLOAD, REPLACE, STATS = 10
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Valid path | BackupPath | 'Duong dan khong hop le' |
| Path exists | BackupPath | 'Thu muc khong ton tai' |
| Valid file | RestoreFile | 'File backup khong ton tai' |
| Valid file ext | RestoreFile | 'Phai la file .bak' |
| At least one day | BackupDays | 'Chon it nhat 1 ngay' |
| Valid time | BackupTime | 'Gio khong hop le (HH:MM:SS)' |

### Business Rules

1. **Sao luu (Backup)**:
   - Backup database Data truoc, sau do Sys
   - Ten file: `{DB}_{yyyyMMdd_HHmmss}.bak`
   - Hien thi tien trinh (Stats = 10%)
   - Ghi log vao bang SYSRESTOREHISTORY

2. **Phuc hoi (Restore)**:
   - **CANH BAO:** Chi restore khi khong co user dang nhap
   - Can quyen sysadmin hoac db_backupoperator
   - Chi cho phep restore Data (Sys khong nen restore tuy y)
   - Su dung `WITH REPLACE` de ghi de
   - Tat ca connection toi database phai duoc ngat

3. **Auto Backup (Tu dong sao luu)**:
   - Tao SQL Server Agent Job
   - Chon ngay trong tuan (multiselect)
   - Chon thoi gian chay trong ngay
   - Bitmask cho ngay trong tuan:
     | Ngay | Gia tri |
     |------|---------|
     | Chu nhat | 1 |
     | Thu 2 | 2 |
     | Thu 3 | 4 |
     | Thu 4 | 8 |
     | Thu 5 | 16 |
     | Thu 6 | 32 |
     | Thu 7 | 64 |
   - Tinh toan: `Freq_interval = sum(cac ngay duoc chon)`

4. **Xoa Auto Backup**:
   - Xoa SQL Server Agent Job cu
   - Cap nhat cau hinh trong bang

5. **Lich su backup**:
   - Luu thong tin vao bang SYSRESTOREHISTORY
   - Theo doi: ngay gio, nguoi thuc hien, trang thai

6. **Xac nhan trong Restore**:
   - Hien thi canh bao truoc khi restore
   - Yeu cau nguoi dung xac nhan
   - Khong hoan tac duoc

---

## Mapping PHP

### 1. Livewire Component (Main)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/System/SaoluuPhuchoi.php
namespace Diepxuan\Catalog\Http\Livewire\SI\System;

class SaoluuPhuchoi extends Component
{
    public string $pActiveTab = 'backup';

    // Backup tab
    public ?string $pBackupPath = null;
    public string $pBackupStatus = '';
    public float $pBackupProgress = 0;
    public string $pDataDBName = '';
    public string $pSysDBName = 'Sys';

    public function mount(): void
    {
        $this->pDataDBName = config('database.connections.simba.database', 'Data');
        $this->pBackupPath = config('simba.backup_path', 'D:\\Backups');
    }

    public function setBackupPath(string $path): void
    {
        $this->pBackupPath = $path;
    }

    public function backup(): void
    {
        if (empty($this->pBackupPath)) {
            $this->pBackupStatus = 'Chua chon thu muc luu';
            return;
        }

        $this->pBackupStatus = 'Dang sao luu database Data...';
        $this->pBackupProgress = 10;

        try {
            // Backup Data
            // DB::statement('EXEC asSIMaintain05 ?,?', [$ma_cty, $this->pBackupPath]);
            $this->pBackupStatus = 'Dang sao luu database Sys...';
            $this->pBackupProgress = 60;

            // Backup Sys
            // ...

            $this->pBackupStatus = 'Hoan tat sao luu';
            $this->pBackupProgress = 100;

        } catch (\Exception $e) {
            $this->pBackupStatus = 'Loi: ' . $e->getMessage();
            $this->pBackupProgress = 0;
        }
    }

    // Restore tab
    public ?string $pRestoreFile = null;
    public string $pRestoreStatus = '';
    public float $pRestoreProgress = 0;
    public string $pRestoreInfo = '';

    public function setRestoreFile(string $file): void
    {
        $this->pRestoreFile = $file;
        $this->pRestoreInfo = pathinfo($file, PATHINFO_BASENAME);
    }

    public function restore(): void
    {
        if (empty($this->pRestoreFile)) {
            $this->pRestoreStatus = 'Chua chon file backup';
            return;
        }

        if (!file_exists($this->pRestoreFile)) {
            $this->pRestoreStatus = 'File khong ton tai';
            return;
        }

        $this->pRestoreStatus = 'Dang phuc hoi...';
        $this->pRestoreProgress = 0;

        try {
            // Kill active connections
            // Set single user mode
            // Restore database
            // Set multi user mode
            $this->pRestoreStatus = 'Hoan tat phuc hoi';
            $this->pRestoreProgress = 100;

        } catch (\Exception $e) {
            $this->pRestoreStatus = 'Loi: ' . $e->getMessage();
            $this->pRestoreProgress = 0;
        }
    }

    // Auto Backup tab
    public array $pBackupDays = [];
    public ?string $pBackupTime = '00:00:00';
    public ?string $pAutoBackupPath = null;
    public bool $pAutoBackupEnabled = false;

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

        $time = (int) str_replace(':', '', $this->pBackupTime);

        // DB::statement('EXEC asSiScheduleAutoBackupData ?,?,?,?,?',
        //    [$ma_cty, $this->pAutoBackupPath, 8, $freqInterval, $time]);

        $this->pBackupStatus = 'Da luu cau hinh auto backup';
        $this->pAutoBackupEnabled = true;
    }

    public function deleteAutoBackup(): void
    {
        // Xoa SQL Agent Job cu
        $this->pAutoBackupEnabled = false;
        $this->pBackupStatus = 'Da xoa auto backup';
    }

    public function render(): View
    {
        return view('catalog::si.system.saoluu-phuchoi');
    }
}
```

### 2. Views

```
resources/views/catalog/si/system/
├── saoluu-phuchoi.blade.php       (Main with tabs)
├── _saoluu-backup.blade.php       (Backup tab)
├── _saoluu-restore.blade.php      (Restore tab)
└── _saoluu-autobackup.blade.php   (Auto backup tab)
```

### 3. Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/sao-luu-phuc-hoi', [SaoluuPhuchoi::class, 'render'])
            ->name('saoluu-phuchoi');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Component | laravel-catalog | SaoluuPhuchoi.php | Form chinh |
| Config | laravel-catalog | simba.php | backup_path |
| SP | laravel-simba | asSIMaintain05 | Backup |
| SP | laravel-simba | asSiScheduleAutoBackupData | Auto backup |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Livewire SaoluuPhuchoi
- [ ] Tao Views (3 tabs: backup, restore, auto)
- [ ] Them Routes
- [ ] Test backup thu cong (Data + Sys)
- [ ] Test restore (can xac nhan)
- [ ] Test auto backup (SQL Agent Job)
- [ ] Test delete auto backup
- [ ] Test quyen han (sysadmin required)
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
