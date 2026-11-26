# Task CO-RptGt03: CORptGt03

## Nhom: CO (Cost)

- **Status:** DONE (component) — `Co\Rpt\Corptgt03182502` + route `co.rpt.corptgt03182502`, verify browser 2026-11-25: **0 dòng**
- **Route:** `co.rpt.corptgt03182502`
- **Loai:** Báo cáo (Report)
- **SP:** `asCORptGt03` — 4 tham số

## Portal implementation (2026-11-25)

- **Component:** `Co\Rpt\Corptgt03182502` (kế thừa `Rpt\AbstractReport`)
- **View:** `co/rpt/corptgt03182502.blade.php` + filter tương ứng
- **Route:** `co.rpt.corptgt03182502`

### 🔧 Hoàn thiện wrapper RỖNG

`AsCORptGt03` có file nhưng mảng params **rỗng** `[]`.

Quá trình:
1. Đọc form gốc → 5-6 tham số
2. SP báo `@pTk is not a parameter` → bỏ `pTk`
3. Còn **4 tham số** đúng

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::co.rpt.corptgt03182502` render thật |
| Dữ liệu | **0 dòng** |
| Page error | **0** |
