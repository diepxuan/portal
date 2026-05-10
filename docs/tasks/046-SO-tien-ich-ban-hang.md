# Task 046: SO - Tien ich ban hang

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | SOUtilities.dll |
| **Module** | SO (Sales Order) |
| **Loai** | Utility Library |
| **Trang thai** | Da phan tich |

## Muc tieu
Su dung thu vien tien ich SO cho cac chuc nang ban hang (lay gia, chiet khau, lookup chung tu, in an).

## Chi tiet
- **DLL:** SOUtilities.dll
- **Chuc nang:** Common utilities cho module SO
- **Loai:** Utility Library (khong co UI chinh)
- **Assembly Title:** SOUtilities
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.DataAccess`, `AsiaErp.SOUtilities`
- **Company:** nguyenthai
- **Ma_ct:** SO

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOUtilities.dll/README.md`

---

## Cau truc du lieu

### Bang: SO (Don hang ban)

| Bang | Mo ta | Loai |
|------|-------|------|
| SO1 | Don hang ban - Phan dau | Transaction |
| SO2 | Don hang ban - Chi tiet | Transaction |
| SO3 | Hoa don ban - Phan dau | Transaction |
| SO4 | Hoa don ban - Chi tiet | Transaction |

---

## Form classes

### frmCA4SO
- **Muc dich:** Form xu ly nghiep vu ban hang trong module CA4 (Bao co)
- **Khong co form chinh** - Day la utility library duoc goi tu cac form khac

---

## SOCommon Static Module Methods

### Pricing Functions

| Method | Mo ta | Parameters | Return |
|--------|-------|------------|--------|
| `Get_GiaBan` | Lay gia ban | ma_vt, ma_nt, ngay_ct | double |
| `Get_GiamGia` | Lay gia va chiet khau | ma_kh, ma_vt, ma_nt, so_luong, ref arTl, ref arGiamGia | void |

### Lookup Functions (Document Chain)

| Method | Mo ta | Parameters |
|--------|-------|------------|
| `SOLookupDH4PX` | Lookup Don hang -> Phieu xuat | aKey, ref oTblPh, ref oTblCt |
| `SOLookupDH4HD` | Lookup Don hang -> Hoa don | aKey, ref oTblPh, ref oTblCt |
| `SOLookupPX4HD` | Lookup Phieu xuat -> Hoa don | aKey, ref oTblPh, ref oTblCt |
| `SOLookupPX4PN` | Lookup Phieu xuat -> Phieu nhap | aKey, ref oTblPh, ref oTblCt |
| `SOLookupHD4PN` | Lookup Hoa don -> Phieu nhap | aKey, ref oTblPh, ref oTblCt |

### Print Management

| Method | Mo ta | Parameters |
|--------|-------|------------|
| `Get_RightPrint` | Kiem tra quyen in | ma_cty, so_ct, so_seri, pLimitedPrint, pIs_oke |
| `SoInsLogPrint` | Ghi log in an | params object[] |

### Status & Rights Check

| Method | Mo ta | Parameters |
|--------|-------|------------|
| `SOChkStatusRightSO1` | Check quyen SO1 | stt_rec, ref aMessContent |
| `SOChkStatusRightSO2` | Check quyen SO2 | stt_rec, ref aMessContent |
| `SOChkStatusRightSO3` | Check quyen SO3 | stt_rec, ref aMessContent |
| `SOChkStatusRightSO5` | Check quyen SO5 | stt_rec, ref aMessContent |

---

## Stored Procedures

| Method | Stored Procedure | Mo ta |
|--------|------------------|-------|
| Get_GiaBan | asSOGetGiaban | Lay gia ban theo cau hinh |
| Get_GiamGia | asGetGiabanGiamGia | Lay gia va chiet khau |
| SOLookupDH4PX | asSOLookupDhPx | Lookup DH -> PX |
| SOLookupDH4HD | asSOLookupDhHd | Lookup DH -> HD |
| SOLookupPX4HD | asSOLookupPxHd | Lookup PX -> HD |
| SOLookupPX4PN | asSOLookupPxPn | Lookup PX -> PN |
| SOChkStatusRightSO1 | asSOChkRightStatusSO1 | Check quyen SO1 |
| SOChkStatusRightSO3 | asSOChkRightStatusSO3 | Check quyen SO3 |

---

## Business Logic

### Pricing Engine

1. **Lay gia ban**:
   - Theo cau hinh "Kieu lay gia" trong SO
   - Ho tro da tien te
   - Theo ngay chung tu

2. **Tinh chiet khau**:
   - Dua tren KH, VT, so luong
   - Tra ve ty le % va so tien
   - Ap dung chinh sach gia theo KH

### Document Chain

```
Don hang (SO1) → Phieu xuat (SO2) → Hoa don (SO3) → Phieu nhap tra lai (SO5)
```

### Print Control

1. **Kiem tra quyen in**: Gioi han so lan in
2. **Log in an**: Luu nguoi in, thoi gian, so lan

---

## Mapping PHP

### 1. Service Class

```php
// diepxuan/laravel-simba/src/Services/SO/SOCommonService.php
namespace Diepxuan\Simba\Services\SO;

class SOCommonService
{
    public function getGiaBan(string $maVt, string $maNt, ?DateTime $ngayCt = null): float
    {
        // Call SP asSOGetGiaban
    }

    public function getGiamGia(string $maKh, string $maVt, string $maNt, float $soLuong, DateTime $ngayCt): array
    {
        // Call SP asGetGiabanGiamGia
        // Return: ['tl_gt' => ..., 'gg' => ...]
    }

    public function lookupDH4PX(string $key): array
    {
        // Call SP asSOLookupDhPx
        // Return: ['header' => [...], 'detail' => [...]]
    }

    public function lookupDH4HD(string $key): array { /* asSOLookupDhHd */ }
    public function lookupPX4HD(string $key): array { /* asSOLookupPxHd */ }
    public function lookupPX4PN(string $key): array { /* asSOLookupPxPn */ }
    public function lookupHD4PN(string $key): array { /* asSOLookupHdPn */ }

    public function checkRightPrint(string $soCt, string $soSeri): bool
    {
        // Call SP asCheckRightPrint
    }

    public function logPrint(array $logData): bool
    {
        // Call SP asInsLogPrint
    }

    public function checkStatusRightSO1(string $sttRec): ?string
    {
        // Return null = OK, string = error message
    }

    public function checkStatusRightSO3(string $sttRec): ?string { /* asSOChkRightStatusSO3 */ }
}
```

### 2. Stored Procedure Classes

```php
// diepxuan/laravel-simba/src/StoredProcedures/AsSOGetGiaban.php
class AsSOGetGiaban extends StoredProcedure
{
    protected $procedure = 'asSOGetGiaban';
    protected $params = ['pMa_Cty', 'pKieu_lay_gia', 'pMa_vt', 'pMa_Nt', 'pNgay_ct'];
}

// diepxuan/laravel-simba/src/StoredProcedures/AsGetGiabanGiamGia.php
class AsGetGiabanGiamGia extends StoredProcedure
{
    protected $procedure = 'asGetGiabanGiamGia';
    protected $params = ['pMa_Cty', 'pMa_Kh', 'pMa_Vt', 'pMa_Nt', 'pSo_Luong', 'pNgay_ct'];
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Service | laravel-simba | SOCommonService.php | Chinh |
| SP | laravel-simba | AsSOGetGiaban.php | Lay gia |
| SP | laravel-simba | AsGetGiabanGiamGia.php | Chiet khau |
| SP | laravel-simba | AsSOLookup* | Lookup chung tu |

---

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tao SOCommonService
- [ ] Tao SP classes
- [ ] Tich hop vao cac Livewire SO (SO1, SO3)
- [ ] Test pricing engine
- [ ] Test document chain lookup
- [ ] Test print control

---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
