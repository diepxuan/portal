# Task 242: FADMLDTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang danh muc ly do tang giam tai san tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADMLDTS.dll
- **Chuc nang:** Danh muc ly do tang giam tai san
- **Loai:** Danh muc (DM)
- **Assembly Title:** danh muc ly do tang giam tai san co dinh
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** FA (Danh muc)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADMLDTS.dll/README.md`

---

## Cau truc du lieu

### Bang: DMLDTS (Danh muc ly do tang giam tai san)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_ldts | varchar | 50 | Ma ly do TS (khoa chinh) |
| ten_ldts | nvarchar | 200 | Ten ly do TS |
| tg | varchar | 1 | Loai: T (tang) / G (giam) |
| ghi_chu | nvarchar | 500 | Ghi chu |

---

## Form classes

### 1. frmFADMLDTS (Form xem danh sach)
- **Ke thua:** frmDMView
- **Chuc nang:** Hien thi danh sach ly do TS

### 2. frmFADMLDTGEdit (Form them/sua)
- **Ke thua:** frmDMEdit
- **Controls:**

| Control | Type | DataField | Mo ta |
|---------|------|-----------|-------|
| txtMa_Ldts | TextBox | ma_ldts | Ma ly do TS |
| txtTen_Ldts | TextBox | ten_ldts | Ten ly do TS |
| cboTg | ComboBox | tg | Loai (T/G) |
| txtGhi_Chu | TextBox | ghi_chu | Ghi chu |

---

## Stored Procedures

| SP Name | Mo ta |
|---------|-------|
| SP_FA_DMLDTS_GET | Lay danh sach ly do TS |
| SP_FA_DMLDTS_GETBYID | Lay chi tiet 1 ly do TS |
| SP_FA_DMLDTS_INSERT | Them ly do TS |
| SP_FA_DMLDTS_UPDATE | Cap nhat ly do TS |
| SP_FA_DMLDTS_DELETE | Xoa ly do TS |
| SP_FA_DMLDTS_FIND | Tim kiem ly do TS |
| SP_FA_DMLDTS_CHECK | Kiem tra trung ma |

---

## Business Logic

### Business Rules

1. **2 loai**:
   - T (Tang): Tang nguyen gia TS
   - G (Giam): Giam nguyen gia TS

2. **Validation**:
   - ma_ldts: required, unique
   - ten_ldts: required
   - tg: required (T hoac G)

---

## Mapping PHP

### 1. Model

```php
// app/Models/FA/DMLDTS.php
namespace Diepxuan\Simba\Models\FA;

class DMLDTS extends Model
{
    protected $table = 'DMLDTS';
    protected $primaryKey = 'ma_ldts';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_ldts', 'ten_ldts', 'tg', 'ghi_chu',
    ];

    public function scopeTang($query)
    {
        return $query->where('tg', 'T');
    }

    public function scopeGiam($query)
    {
        return $query->where('tg', 'G');
    }
}
```

### 2. Livewire Components

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/LyDoTs.php
class LyDoTs extends Component
{
    const MA_CT = 'FA';
}

// diepxuan/laravel-catalog/src/Http/Livewire/FA/Danhmuc/LyDoTsEdit.php
class LyDoTsEdit extends Component
{
    // Edit modal
}
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMLDTS.php | Chinh |
| SP | laravel-simba | AsFAGetDMLDTS.php | Get |
| SP | laravel-simba | AsFAInsDMLDTS.php | Insert |
| Component | laravel-catalog | LyDoTs.php | List |
| Component | laravel-catalog | LyDoTsEdit.php | Edit |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure classes
- [ ] Tao Model DMLDTS
- [ ] Tao Livewire LyDoTs (list)
- [ ] Tao Livewire LyDoTsEdit (modal)
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test CRUD operations
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Implementation Update 2026-05-15

- Da co route anchor `fa.dict.fadmldts` qua generic `simba.dictionary`.
- Route la alias theo `sysMenu.code_name`; `source_menuid` that trong `sysDictionaryInfo` la `18.90.05`, active FA menu la `20.90.05`.
- Chua mo CRUD ghi/xoa cho den khi audit du payload va side effect; khong goi SQL/SP/function.

## Portal implementation status

- **Status:** DONE (route/shell exists)
- **Route:** `fa.dict.ldtg`
- **Note:** Shell/voucher; write blocked until payload audit.
