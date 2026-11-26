# Task CO-RptGt02: CORptGt02

## Nhom: CO (Cost)

- **Status:** DONE (component) — `Co\Rpt\Corptgt02` + route `co.rpt.corptgt02`, verify browser 2026-11-25: **0 dòng**
- **Route:** `co.rpt.corptgt02`
- **Loai:** Báo cáo (Report)
- **SP:** `asCORptGt02` — 4 tham số

## Portal implementation (2026-11-25)

- **Component:** `Co\Rpt\Corptgt02` (kế thừa `Rpt\AbstractReport`)
- **View:** `co/rpt/corptgt02.blade.php` + filter tương ứng
- **Route:** `co.rpt.corptgt02`

### 🔧 Hoàn thiện wrapper RỖNG

`AsCORptGt02` có file nhưng mảng params **rỗng** `[]`.

Quá trình:
1. Đọc form gốc → 5-6 tham số
2. SP báo `@pTk is not a parameter` → bỏ `pTk`
3. Còn **4 tham số** đúng

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::co.rpt.corptgt02` render thật |
| Dữ liệu | **0 dòng** |
| Page error | **0** |
