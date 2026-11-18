# Phase 1 — Phát triển thêm chức năng cho Portal

> Tự động sinh bởi `scripts/gen-tasks-index.php`. **Không sửa tay** — sửa script rồi chạy lại.

**Đây là phase 1** — giai đoạn phát triển thêm và hoàn thiện chức năng **cho Portal**
sau khi đã port xong từ SimbaERP .NET.

| Phase | Ý nghĩa | Thư mục |
|---|---|---|
| **Phase hiện tại (port)** | Chuyển đổi chức năng từ SimbaERP .NET sang PHP Laravel | `docs/tasks/*.md` |
| **Phase 1 (mở rộng)** | Phát triển thêm chức năng, hoàn thiện UI/UX, tối ưu cho Portal | `docs/tasks/phase 1/*.md` |

Task trong phase 1 xuất phát từ task đã xong ở phase port, sau đó tiếp tục được phát
triển thêm: bổ sung tính năng, chuẩn hóa UI theo `docs/DESIGN.md`, tối ưu hiệu năng,
sửa lỗi phát sinh trong quá trình vận hành Portal.

**Quy ước:** ID giữ nguyên từ task gốc; mỗi task chỉ tồn tại **một bản** trong phase 1.

## Tổng quan

| Module | Files | DONE | PENDING | Khác |
|---|---:|---:|---:|---:|
| AP — Công nợ phải trả | 1 | 1 | 0 | 0 |
| AR — Công nợ phải thu | 2 | 2 | 0 | 0 |
| CA — Tiền mặt & Ngân hàng | 1 | 1 | 0 | 0 |
| GL — Sổ cái tổng hợp | 1 | 1 | 0 | 0 |
| IN — Tồn kho | 3 | 3 | 0 | 0 |
| PO — Đơn hàng mua | 2 | 2 | 0 | 0 |
| SI — System Integration | 2 | 2 | 0 | 0 |
| SO — Đơn hàng bán | 3 | 3 | 0 | 0 |
| System — Framework & cross-link | 1 | 1 | 0 | 0 |
| **Tổng** | **16** | | | |

## AP — Công nợ phải trả

| ID | File | DLL | Status |
|---|---|---|---|
| 359 | `359-ap-so-chi-tiet-cong-no-mot-nha-cung-cap-10-30-23.md` | ARRptBCCN01.dll (form dung chung cho AR va AP, menuid phan biet) | DONE |

## AR — Công nợ phải thu

| ID | File | DLL | Status |
|---|---|---|---|
| 001 | `001-ar-danh-muc-khach-hang.md` | ARDMKH.dll | DONE |
| 008 | `008-ar-bao-cao-cong-no-tk-kh.md` | ARRptBCCN01.dll, ARRptBCCN01a.dll | DONE |

## CA — Tiền mặt & Ngân hàng

| ID | File | DLL | Status |
|---|---|---|---|
| 375 | `375-ca-ardmkh-nhan-vien.md` |  | DONE |

## GL — Sổ cái tổng hợp

| ID | File | DLL | Status |
|---|---|---|---|
| 146 | `146-GL-danhmuc-taikhoan.md` | GLDMTK.dll | DONE |

## IN — Tồn kho

| ID | File | DLL | Status |
|---|---|---|---|
| 114 | `114-IN-danhmuc-vattu.md` | INDMVT.dll | DONE |
| 117 | `117-IN-baocao-tonkho-02.md` | INRptCD02.dll | DONE |
| 225 | `225-in-danh-muc-nhom-vat-tu.md` | INDMNHVT.dll | DONE |

## PO — Đơn hàng mua

| ID | File | DLL | Status |
|---|---|---|---|
| 069 | `069-po-hoadon-mua-hang.md` | `POVchPO3.dll` (form `frmPOVchPO3`, namespace `AsiaErp.UserInterface`) | DONE |
| 373 | `373-po-ardmkh-nha-cung-cap.md` |  | DONE |

## SI — System Integration

| ID | File | DLL | Status |
|---|---|---|---|
| 360 | `360-si-smks-khoa-so-lieu-ky.md` |  | DONE |
| 364 | `364-si-year-chon-nam-lam-viec.md` | `SiChangeFY.dll` (namespace `AsiaErp.UserInterface`, form `frmSiChangeFY`). | DONE |

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

