# SimbaERP Menu Route Review

Ngày review: 2026-06-19

## Nguồn dữ liệu

Review dựa trên menu thực tế từ MSSQL SimbaERP trên server `web`, đọc qua `SimbaMenuRepository::activeMenus()`.

Kết quả audit trước khi sửa classifier:

```json
{
  "active_count": 357,
  "type_counts": {"5": 9, "": 69, "1": 67, "6": 9, "4": 152, "2": 48, "3": 3},
  "route_counts": {"voucher": 67, "custom": 10, "report": 152, "dictionary": 48},
  "route_count": 277,
  "unrouted_count": 42,
  "missing_count": 57
}
```

## Sai lệch phát hiện

### 1. Menu F5 report bị bỏ route

Nhiều menu thực tế có:

- `type = ''`
- `report = true`
- có `dllName` / `command`

Ví dụ:

- `02.80.02` GL `F5GLRptTH01`
- `06.80.02` SO `Framework` / `frmDrilldownReport`
- `10.80.02` PO `Framework` / `frmDrilldownReport`
- `14.80.02` IN `INRptF5CD02`

Code cũ bỏ qua `TYPE_GROUP` trước khi xét `report`, nên các menu F5 này không có route dù là menu action thực tế.

### 2. Header report bị tạo route thừa

Một số menu header có:

- `type = '4'` hoặc `report = true`
- không có `dllName`, `command`, `code_name`
- không có row report metadata

Ví dụ:

- `02.25.00` Báo cáo Nhật ký chung
- `02.20.00` Báo cáo Chứng từ ghi sổ
- `06.20.00` Báo cáo Bán hàng
- `10.20.00` Báo cáo Mua hàng

Các dòng này là container/header, không nên sinh route shell riêng.

## Quy tắc route sau khi sửa

- `TYPE_MODULE_ROOT` luôn là container, không sinh route.
- `TYPE_MASTER` sinh dictionary route.
- `TYPE_VOUCHER` sinh voucher route.
- `TYPE_REPORT` hoặc `report = true` chỉ sinh report route khi:
  - có callable metadata (`dllName` / `command` / `code_name`), hoặc
  - có row report metadata trong `SysReportInfo` / `ZSysReportInfo`.
- Menu còn lại có callable metadata sinh custom/process route.
- Menu trống không callable metadata không sinh route.

## Test bổ sung

- Group menu có `report = true` + callable metadata phải sinh report route.
- Header report không callable metadata phải bị skip.
