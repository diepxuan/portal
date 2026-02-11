# Stored Procedures Conversion

This document lists all stored procedures that have been converted to PHP classes in the `Diepxuan\Simba\StoredProcedures` namespace.

## Usage

Each class provides a static `call(array $params): mixed` method that maps to the corresponding stored procedure. Use `ProcedureCaller::call()` internally.

Example:
```php
use Diepxuan\Simba\StoredProcedures\AsGetSoCt;

$result = AsGetSoCt::call([
    'pMa_Cty' => '001',
    'pMa_ct' => 'GL1',
]);
```

## Procedures Converted

### asGL* (General Ledger)
Xem chi tiết trong [docs/procedures-gl.md](docs/procedures-gl.md). Đã chuyển đổi 20 procedures.

### asGet* (Get data)
| Procedure | Class | Parameters | Description |
|-----------|-------|------------|-------------|
| asGetRight | AsGetRight | pUserName, pMenuID | Get user rights |
| asGetArkhInfo_SO | (pending) | | |

### asIN* (Inventory)
Xem chi tiết trong [docs/procedures-in.md](docs/procedures-in.md). Đã chuyển đổi 22 procedures.

### asHR* (Human Resources)
| Procedure | Class | Parameters | Description |
|-----------|-------|------------|-------------|
| asHrUpdQTDanhGiaPH | AsHrUpdQTDanhGiaPH | pMa_cty, pId, pId_qtdg, pNgay_dg, pNgay_bd, pNgay_kt, pMa_nvdg, pMa_nhdg, pTrang_thai, pKet_luan, pGhi_chu, pTai_lieu, pLuser | Sửa đánh giá nhân viên |

### asSI* (Sales & Inventory)
Xem chi tiết trong [docs/procedures-si.md](docs/procedures-si.md). Đã chuyển đổi 23 procedures.

### asDel* (Delete)
| Procedure | Class | Parameters | Description |
|-----------|-------|------------|-------------|
| asDelTAOUT | AsDelTAOUT | pMa_cty, pStt_rec | Delete TAOUT |

### asAR* (Accounts Receivable)
Xem chi tiết trong [docs/procedures-ar.md](docs/procedures-ar.md). Đã chuyển đổi 11 procedures.

### asPost* (Posting)
| Procedure | Class | Parameters | Description |
|-----------|-------|------------|-------------|
| asPostPoPh4_PoCt | AsPostPoPh4_PoCt | pMa_cty, pStt_rec | Post phieu nhap chi phi. PoPh4 -> PoCt |

### asAP* (Accounts Payable)
Xem chi tiết trong [docs/procedures-ap.md](docs/procedures-ap.md). Đã chuyển đổi 18 procedures.

### asPO* (Purchase Order)
Xem chi tiết trong [docs/procedures-po.md](docs/procedures-po.md). Đã chuyển đổi 14 procedures.

## Notes

- Parameters with default values in SQL are given appropriate defaults in PHP (null, empty string, '0', etc.).
- Output parameters (`@pRet output`) are omitted from the PHP call; they are handled internally by the stored procedure.
- All classes return `Illuminate\Support\Collection` unless otherwise specified (some return a single value like `AsGetSoCt`).
- The connection is automatically determined via `SModel::getConnectionName()`.

## Conversion Progress

- Total SQL files in `SimbaSql/dbo/StoredProcedures/`: 2031
- Files with prefix `as*`: 1831
- Converted so far: 128
- Last updated: 2026-02-11
