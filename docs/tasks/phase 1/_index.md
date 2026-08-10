# Phase 1 Tasks

> Tự động sinh bởi `scripts/gen-tasks-index.php`. **Không sửa tay** — sửa script rồi chạy lại.

Các task đã xong phase hiện tại và được chuyển sang phase 1 để tiếp tục hoàn thiện chức năng nghiệp vụ và UI.

## Tổng quan

| Module | Files | DONE | PENDING | Khác |
|---|---:|---:|---:|---:|
| AP — Công nợ phải trả | 1 | 1 | 0 | 0 |
| AR — Công nợ phải thu | 1 | 1 | 0 | 0 |
| CA — Tiền mặt & Ngân hàng | 1 | 1 | 0 | 0 |
| IN — Tồn kho | 1 | 1 | 0 | 0 |
| PO — Đơn hàng mua | 2 | 2 | 0 | 0 |
| SI — System Integration | 1 | 1 | 0 | 0 |
| SO — Đơn hàng bán | 3 | 3 | 0 | 0 |
| System — Framework & cross-link | 1 | 1 | 0 | 0 |
| **Tổng** | **11** | | | |

## AP — Công nợ phải trả

| ID | File | DLL | Status |
|---|---|---|---|
| 359 | `359-ap-so-chi-tiet-cong-no-mot-nha-cung-cap-10-30-23.md` | ARRptBCCN01.dll (form dung chung cho AR va AP, menuid phan biet) | DONE |

## AR — Công nợ phải thu

| ID | File | DLL | Status |
|---|---|---|---|
| 008 | `008-ar-bao-cao-cong-no-tk-kh.md` | ARRptBCCN01.dll, ARRptBCCN01a.dll | DONE |

## CA — Tiền mặt & Ngân hàng

| ID | File | DLL | Status |
|---|---|---|---|
| 375 | `375-ca-ardmkh-nhan-vien.md` |  | DONE |

## IN — Tồn kho

| ID | File | DLL | Status |
|---|---|---|---|
| 117 | `117-IN-baocao-tonkho-02.md` | INRptCD02.dll | DONE |

## PO — Đơn hàng mua

| ID | File | DLL | Status |
|---|---|---|---|
| 069 | `069-po-hoadon-mua-hang.md` | `POVchPO3.dll` (form `frmPOVchPO3`, namespace `AsiaErp.UserInterface`) | DONE |
| 373 | `373-po-ardmkh-nha-cung-cap.md` |  | DONE |

## SI — System Integration

| ID | File | DLL | Status |
|---|---|---|---|
| 360 | `360-si-smks-khoa-so-lieu-ky.md` |  | DONE |

## SO — Đơn hàng bán

| ID | File | DLL | Status |
|---|---|---|---|
| 197 | `197-so-hoa-don-ban-hang.md` | SOVchSO3.dll | DONE |
| 201 | `201-so-bang-ke-chung-tu-ban-hang-01.md` | SORptBK01.dll | DONE |
| 374 | `374-so-ardmkh-khach-hang-crud.md` |  | DONE |

## System — Framework & cross-link

| ID | File | DLL | Status |
|---|---|---|---|
| 358 | `358-simba-menu-route-metadata-suffix-format.md` |  | DONE |

