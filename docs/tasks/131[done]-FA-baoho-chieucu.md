# Task 131: FADGTS

## Nhom: FA (Fixed Assets - Tai san co dinh)

## Muc tieu
Chuyen doi chuc nang bao ho chieu cu (dinh gia lai tai san) tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** FADGTS.dll (shared voi task 124)
- **Chuc nang:** Bao ho chieu cu (Dinh gia lai TSCĐ)
- **Loai:** Voucher (Chung tu)
- **Assembly Title:** Bao ho chieu cu
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** FA (dinh gia)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/FADGTS.dll/README.md`

**Luu y:** Task 131 cung su dung FADGTS.dll nhu task 124. Vui long tham khao task 124 cho cau truc chi tiet.

### Bo sung: Bao ho chieu cu

| Truong | Mo ta |
|--------|-------|
| ma_cc | Ma cong cu |
| ten_cc | Ten cong cu |
| sl_hong | So luong hong |
| tien_hong | Tien hong |
| don_gia_hong | Don gia hong |
| ngay_bh | Ngay bao hong |
| so_px | So phieu xuat |
| ngay_xuat | Ngay xuat |
| tk_cp | TK chi phi |
| tk_cc | TK cong cu |
| gia_goc | Gia goc |
| con_lai | Con lai |

---

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmFADGTS | frmVoucher | Form nhap chung tu |
| frmFADGTSFind | frmVoucherFind | Form tim kiem |

## Business Logic

1. **Dinh gia lai**: Ghi nhan gia tri hien tai cua tai san
2. **Bao ho chieu cu**: Ghi nhan thong tin hong mat, hao mon
3. **Cap nhat GTCL**: Gia tri con lai = Gia tri - Hao mon luy ke

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/FA/Vouchers/Baohochieurcu.php
namespace Diepxuan\Catalog\Http\Livewire\FA\Vouchers;

class Baohochieurcu extends Component
{
    const MA_CT = 'FA';

    public function render(): View
    {
        return view('catalog::fa.vouchers.bao-ho-chieu-cu');
    }
}
```

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| FADGTS | Dinh gia tai san | Master |
| FATSO | Tai san co dinh | Master |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `FA_DGTS_Get` | Lay danh sach bao ho chieu cu |
| `FA_DGTS_Insert` | Them bao ho chieu cu |
| `FA_DGTS_Update` | Cap nhat bao ho chieu cu |

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | FA | Module TSCĐ |
| diepxuan/system | Commons | Lookup TS, CC |

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] (Da co task 124 - cung DLL)
- [ ] Tao Livewire Baohochieurcu va BaohochieurcuEdit
- [ ] Tao Views (tab them cho bao hong CC)
- [ ] Them Routes
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement

## Portal implementation status

- **Status:** DONE (route/report shell)
- **Route:** `fa.vch.dgts-old`
- **Note:** Calculation/transfer/voucher shell chưa execute side-effect khi chưa audit payload.
