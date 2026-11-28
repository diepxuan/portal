# Task 431: PODMGIAMUA — Danh mục giá mua

## Nhóm: PO (Purchase Order)

## Trạng thái

- **Status:** TODO — chưa có component
- **DLL:** `PODMGIAMUA.dll` (không có decompiled — suy từ bảng + SP)
- **Bảng:** `PODmGiaMua`
- **Route:** `po.dict.podmgiamua` → menu `10.90.12`
- **Component dự kiến:** `Po\Dict\Podmgiamua`
- **View:** `po/dict/podmgiamua.blade.php`

---

## Checklist DONE (9 mục — PROJECT_CONVENTIONS §2.7)

| # | Mục | Kết quả |
|---|---|---|
| 1 | Component render thật | ⬜ |
| 2 | Route 200 | ⬜ |
| 3 | Hiển thị đúng **13.849** dòng | ⬜ |
| 4 | Không `errorMessage` | ⬜ |
| 5 | Bộ chọn kỳ | — **nhưng nên có filter ngày áp dụng** (`ngay_ad`) |
| 6 | Label tiếng Việt | ⬜ |
| 7 | Dropdown Mã VT | ⬜ → `input-indmvt` |
| 8 | Dropdown Mã NT | ⬜ → `input-ngoaite` |
| 9 | Tham số rỗng = `''` | ⬜ (kiểm theo bảng) |

---

## Cấu trúc bảng `PODmGiaMua` (9 cột)

Nguồn: `simba-docs/tables/PODmGiaMua.md`

| # | Cột | Kiểu | Nullable | Default | Ý nghĩa |
|---|---|---|---|---|---|
| 1 | `ma_cty` **PK** | NVARCHAR(3) | NO | `''` | Mã công ty |
| 2 | `ma_vt` **PK** | NVARCHAR(20) | NO | `''` | Mã vật tư |
| 3 | `ngay_ad` **PK** | SMALLDATETIME | NO | `''` | Ngày áp dụng |
| 4 | `ma_nt` **PK** | NVARCHAR(3) | NO | `''` | Mã ngoại tệ |
| 5 | `gia_nt0` | DECIMAL(19,4) | NO | `0` | Giá ngoại tệ 0 |

**Khoá chính phức hợp 4 cột:** `(ma_cty, ma_vt, ngay_ad, ma_nt)`

> ⚠️ Bảng này **13.849 dòng** — bắt buộc phân trang + filter. Không load hết 1 lần.

---

## Stored Procedures — `INFORMATION_SCHEMA.PARAMETERS`

| SP | Tham số | Ghi chú |
|---|---|---|
| `asPOGetDmGiaMua` | `pMa_cty` (1) | trả **toàn bộ** — cần filter client-side hoặc phân trang |
| `asPOInsDmGiaMua` | `pMa_cty, pMa_vt, pNgay_ad, pMa_nt, pGia_nt0, pLUser, pRet` (7) | `pRet` OUTPUT |
| `asPOUpdDmGiaMua` | `pMa_cty, pMa_vt, pNgay_ad, pMa_nt, pGia_nt0, pLUser, pRet` (7) | `pRet` OUTPUT |
| `asPODelDmGiaMua` | `pMa_cty, pMa_vt, pNgay_ad, pMa_nt, pRet` (5) | `pRet` OUTPUT |

> ⚠️ **SP Get không có tham số filter** (chỉ `pMa_cty`). Với 13.849 dòng phải:
> - Phân trang server-side bằng `LengthAwarePaginator` trên collection (như `Podmcp`)
> - Hoặc filter client-side sau khi load
>
> Đo thời gian load thực tế — nếu > 2s cần cache hoặc task riêng tối ưu SP.

### Kiểm tra NULL vs `''`

Chưa test. Phải chạy cho từng tham số trước khi implement.

---

## Dữ liệu thật (cty 001 — 13.849 dòng)

| ma_vt | ngay_ad | ma_nt | gia_nt0 |
|---|---|---|---|
| CUNHN12 | 2026-11-24 | VND | 49000.0000 |
| CUNHN14 | 2026-11-24 | VND | 51000.0000 |
| CUNHN15 | 2026-11-24 | VND | 53000.0000 |
| CUNHN16 | 2026-11-24 | VND | 54000.0000 |

---

## Label tiếng Việt

Không có decompiled. Lấy từ bảng + `sysMenu.bar`.

| Cột | Label | Nguồn |
|---|---|---|
| `ma_vt` | Mã vật tư | `PODmGiaMua.md` |
| `ten_vt` | Tên vật tư | join `InDmVt` |
| `ngay_ad` | Ngày áp dụng | `PODmGiaMua.md` |
| `ma_nt` | Mã ngoại tệ | `PODmGiaMua.md` |
| `gia_nt0` | Giá ngoại tệ | `PODmGiaMua.md` |

Format số: `gia_nt0` dùng `FA`/`OP` (xem §2.9.10) — **`### ### ### ##0.#0`**.

---

## Verify browser (khi implement)

| Kiểm chứng | Cách |
|---|---|
| Route | 200 |
| Component | `catalog::po.dict.podmgiamua` |
| Số dòng | **13.849** (kiểm qua `total()`) |
| Thời gian load | ghi lại số ms |
| Phân trang | chuyển trang 2, 3 hoạt động |
| Filter | lọc theo mã VT, ngày, ngoại tệ |
