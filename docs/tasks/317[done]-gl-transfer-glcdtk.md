# Task 317: GLTransferGLCDTK

## Nhom: GL (So cai tong hop)

## Muc tieu
Chuyen doi module Chuyen so du tai khoan sang nam sau tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** GLTransferGLCDTK.dll
- **Assembly Title:** Chuyen so du tai khoan sang nam sau
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** GL

## Cau truc du lieu

### Bang tham chieu

| Bang | Mo ta | Relationship |
|------|-------|---------------|
| DMTK | Danh muc tai khoan | Loc so du |
| CDTK | Chu so du tai khoan | Theo nam |

### Parameters

| Parameter | Mo ta |
|-----------|-------|
| CompanyID | Ma cong ty |
| final_day | Ngay cuoi nam (FinalDay) |

---

## Form classes

### 1. frmGLTransferGLCDTK
- **Ke thua:** frmReport
- **Chuc nang:** Chuyen so du TK sang nam sau

### Controls

| Control | Type | Mo ta |
|---------|------|-------|
| txtFinalDay | AsMaskedTextBox | Ngay cuoi nam |
| txtTieu_De | TextBox | Tieu de |
| cmdOk, cmdCancel | Button | Nut dieu khien |
| lblStatus | Label | Trang thai |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_GL_TRANSFER_CDTK | Chuyen so du tai khoan |

### Parameters reference

```sql
EXEC SP_GL_TRANSFER_CDTK
    @pMa_cty VARCHAR(50),
    @pFinalDay DATETIME
```

---

## Business Logic

### Business Rules

1. **Chuyen so du**: Chuyen so du cuoi nam sang nam sau
2. **FinalDay**: Ngay cuoi nam can chuyen (01/01 nam sau)
3. **Trang thai**: Hien thi tien trinh chuyen du lieu

---

## Mapping PHP

### 1. Transfer Service

```php
// diepxuan/laravel-simba/src/Services/GL/TransferGLCDTKService.php
namespace Diepxuan\Simba\Services\GL;

class TransferGLCDTKService
{
    public function transfer(string $ma_cty, Carbon $finalDay): bool;
}
```

### 2. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Chuyendoi/TransferGLCDTK.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Chuyendoi;

class TransferGLCDTK extends Component
{
    const MA_CT = 'GL';

    public ?Carbon $final_day = null;
    public string $status = '';
}
```

### 3. Views

```
resources/views/catalog/gl/chuyendoi/
├── transfer-glcdtk.blade.php
└── _transfer-glcdtk-form.blade.php
```

### 4. Routes

```php
Route::get('/catalog/gl/chuyendoi/transfer-glcdtk', [TransferGLCDTK::class, 'render'])
    ->name('catalog.gl.chuyendoi.transfer-glcdtk');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | TransferGLCDTKService.php | Chinh |
| Component | laravel-catalog | TransferGLCDTK.php | Livewire |
| Model | laravel-simba | CDTK.php | Chu so du |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review DLL
- [ ] Tao Transfer Service
- [ ] Tao Livewire Component
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test chuyen so du
- [ ] Test trang thai
- [ ] Integration test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal Update 2026-05-15

- Active Simba menu `90.40.14` (Nhập/Chuyển số dư) đã được map vào route hiện hữu `system.balance.index`.
- Route chi tiết `system.balance.transfer` và component `System\Balance\Transfer` đã tồn tại trong codebase.
- Component hiện có tham chiếu stored procedure `AsGLChuyenSdTk`, nhưng task chưa được đánh dấu hoàn tất execute vì session này không truy cập SQL Server và chưa audit đủ side effect theo `simba-docs`.
- Giữ trạng thái blocked cho phần chạy chuyển số dư cho đến khi xác minh đầy đủ tham số, quyền chạy, ngày khóa sổ và rollback/error handling.

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `gl.task.317`
