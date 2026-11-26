# Task CO-RptGt01: CORptGt01

## Nhom: CO (Cost)

- **Status:** DONE (component) — `Co\Rpt\Corptgt01` + route `co.rpt.corptgt01`, verify browser 2026-11-25: **6 dòng / 16 cột**
- **Route:** `co.rpt.corptgt01`
- **Loai:** Báo cáo (Report)
- **SP:** `asCORptGt01` — 5 tham số

## Portal implementation (2026-11-25)

- **Component:** `Co\Rpt\Corptgt01` (kế thừa `Rpt\AbstractReport`)
- **View:** `co/rpt/corptgt01.blade.php` + filter tương ứng
- **Route:** `co.rpt.corptgt01`

### 🔧 Hoàn thiện wrapper RỖNG

`AsCORptGt01` có file nhưng mảng params **rỗng** `[]`.

Quá trình:
1. Đọc form gốc → 5-6 tham số
2. SP báo `@pTk is not a parameter` → bỏ `pTk`
3. Còn **5 tham số** đúng

### Verify browser thật

| Kiểm chứng | Kết quả |
|---|---|
| Livewire component | `catalog::co.rpt.corptgt01` render thật |
| Dữ liệu | **6 dòng / 16 cột** |
| Page error | **0** |
