# Kế hoạch triển khai: PO - Hóa đơn mua hàng

**Ngày bắt đầu:** 2026-05-13  
**GitHub Issues:** #178 (PO3), #179 (PO6)  
**Project Board:** https://github.com/orgs/diepxuan/projects/2

---

## Tổng quan module PO

Module Mua hàng (Purchase Order) trong Simba ERP gồm các nhóm chức năng chính:

| Task ID | Chức năng | DLL | Status |
|---------|-----------|-----|--------|
| 063 | CT Mua hàng | - | TODO |
| 064 | DM ĐK TT | - | TODO |
| 065 | PTLHM | - | TODO |
| 068 | DM HTTT | - | TODO |
| **069** | **Hóa đơn mua (PO3)** | POVchPO3.dll | **START** |
| 070 | CT nhận hàng mua | - | TODO |
| 074 | PTT mua hàng | - | TODO |
| 080 | ĐH mua hàng | - | TODO |
| **217** | **Hóa đơn mua DV (PO6)** | PoVchPO6.dll | **TODO** |

---

## Lộ trình chi tiết

### Phase 1: PO3 - Hóa đơn mua hàng (#178)

| Bước | Nội dung | Files cần tạo/sửa | Package |
|------|----------|-------------------|---------|
| **1** | Models POHMN, POHMNCT, POHMNCP | `laravel-simba/src/Models/PO/POHMN.php`<br>`laravel-simba/src/Models/PO/POHMNCT.php`<br>`laravel-simba/src/Models/PO/POHMNCP.php` | laravel-simba |
| **2** | SP Classes: Get, GetById, Ins, Upd, Del | `laravel-simba/src/StoredProcedures/AsPOGetHDMH.php`<br>`laravel-simba/src/StoredProcedures/AsPOGetHDMHByID.php`<br>`laravel-simba/src/StoredProcedures/AsPOInsHDMH.php`<br>`laravel-simba/src/StoredProcedures/AsPOUpdHDMH.php`<br>`laravel-simba/src/StoredProcedures/AsPODelHDMH.php` | laravel-simba |
| **3** | Livewire List — Hoadonmua | `laravel-catalog/src/Http/Livewire/Muahang/Hoadonmua.php` | laravel-catalog |
| **4** | Livewire Edit — HoadonmuaEdit | `laravel-catalog/src/Http/Livewire/Muahang/HoadonmuaEdit.php` | laravel-catalog |
| **5** | Views: list, edit, row partial | `laravel-catalog/resources/views/muahang/hoadonmua.blade.php`<br>`laravel-catalog/resources/views/muahang/hoadonmua-edit.blade.php`<br>`laravel-catalog/resources/views/muahang/_hoadonmua-row.blade.php` | laravel-catalog |
| **6** | Routes | `laravel-catalog/routes/web.php` (thêm route `/muahang/hoadonmua`) | laravel-catalog |
| **7** | Validation & tính toán | Validation rules, tính tổng tiền, thuế | laravel-catalog |
| **8** | Lookup NCC, HTTT, DMVT | Tích hợp các component lookup | laravel-catalog |

### Phase 2: PO6 - Hóa đơn mua dịch vụ (#179)

| Bước | Nội dung | Files cần tạo/sửa | Package |
|------|----------|-------------------|---------|
| **1** | Models PO6, PO7 | `laravel-simba/src/Models/PO/PO6.php`<br>`laravel-simba/src/Models/PO/PO7.php` | laravel-simba |
| **2** | SP Classes | `AsPOGetPO6.php`, `AsPOGetPO6ByID.php`, `AsPOInsPO6.php`, `AsPOUpdPO6.php`, `AsPODelPO6.php` | laravel-simba |
| **3** | Livewire List + Edit | `Muahang/Hoadonmuadv.php`, `Muahang/HoadonmuadvEdit.php` | laravel-catalog |
| **4** | Views + Routes | Views + routes tương tự PO3 | laravel-catalog |

---

## Tiến độ

### Phase 1 - PO3 (Issue #178)

| Bước | Trạng thái | Chi tiết |
|------|------------|----------|
| 1. Models POHMN, POHMNCT, POHMNCP | ✅ DONE | SModel + Models |
| 2. SP Classes (Ins/Upd/Del/Get) | ✅ DONE | AsPOInsOrder, AsPOUpdOrder, AsPODelOrder, AsPOGetOrder |
| 3. Livewire List — Hoadonmua | ✅ DONE | |
| 4. Livewire Edit — HoadonmuaEdit | ✅ DONE | |
| 5. Views (list, edit, row partial) | ✅ DONE | list + edit form |
| 6. Routes | ✅ DONE | muahang/hoadonmua, create, edit |
| 7. Validation & tính toán | ✅ DONE | Auto-calc trong Edit component |
| 8. Lookup NCC, HTTT, DMVT | 🔄 PARTIAL | NCC done, HTTT/DMVT cần input components |

## Nguyên tắc
1. Mỗi bước = 1 commit
2. 1 Phase = 1 branch = 1 PR
3. Không push khi Sếp chưa yêu cầu
4. Tham chiếu pattern từ code hiện có (Cash, Banhang)
