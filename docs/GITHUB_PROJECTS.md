# GitHub Projects - Task Tracking Guide

## Project Board Chính

**URL:** https://github.com/orgs/diepxuan/projects/2

**Tên:** Simba Laravel

**Mục đích:** Task board chính cho Portal Project - theo dõi tất cả issues từ nhiều repos.

---

## Cách Truy Cập Issues

### 1. Qua Project Board (Khuyến nghị)

```bash
# Xem tất cả issues trong project
gh api graphql -f query='query { 
  organization(login: "diepxuan") { 
    projectsV2(first: 10) { 
      nodes { 
        id 
        number 
        title 
        url 
        items(first: 100) { 
          nodes { 
            id 
            content { 
              ... on Issue { 
                number 
                title 
                body 
                url 
                repository { name } 
              } 
            } 
          } 
        } 
      } 
    } 
  } 
}'
```

### 2. Qua GitHub CLI

```bash
# Xem issues từ portal repo
gh issue list --repo diepxuan/portal --limit 50 --state all

# Xem chi tiết issue
gh issue view <issue-number> --repo diepxuan/portal

# Xem issues từ SimbaSql repo
gh issue list --repo diepxuan/SimbaSql --limit 50 --state all
```

### 3. Qua Web Fetch

```bash
# Portal issues
https://github.com/diepxuan/portal/issues

# SimbaSql issues
https://github.com/diepxuan/SimbaSql/issues
```

---

## Repositories Trong Project

| Repo | URL | Mục đích |
|------|-----|----------|
| `diepxuan/portal` | https://github.com/diepxuan/portal | Laravel Portal - Frontend + Backend chính |
| `diepxuan/SimbaSql` | https://github.com/diepxuan/SimbaSql | Stored Procedures + SQL Scripts |

---

## Issue Numbering

**Lưu ý quan trọng:** Issue numbers có thể trùng giữa các repos nhưng là issues khác nhau.

| Issue # | Portal | SimbaSql |
|---------|--------|----------|
| #1 | Simba login | (khác) |
| #13 | Khoa so lieu | (khác) |
| #17 | (không tồn tại) | [CA] Phiếu thu |
| #18 | cash dashboard | [CA] Phiếu chi |
| #24 | Cash \| Phieu chi \| Them, sua, xoa | [PO] Hóa đơn mua hàng |
| #58 | Ban hang \| hoa don ban hang \| danh sach | (không tồn tại - 404) |

**Khi refer đến issue, LUÔN chỉ rõ repo:**
- ✅ `portal#24` - Phiếu chi (Portal)
- ✅ `SimbaSql#24` - Hóa đơn mua hàng (SimbaSql)
- ❌ `#24` - Không rõ ràng

---

## Các Issues Quan Trọng (đã có trong Project Board)

### Cash Module
| Issue | Repo | Tiêu đề | Trạng thái |
|-------|------|---------|------------|
| #18 | portal | cash dashboard | Closed |
| #19 | portal | Cash \| Menu | Closed |
| #20 | portal | Cash \| Phieu thu | Closed |
| #24 | portal | Cash \| Phieu chi \| Them, sua, xoa | Closed |
| #46 | portal | Cash \| So quy tien mat | Closed |
| #47 | portal | Cash \| so quy ngan hang | Closed |
| #49 | portal | Cash \| nhat ky thu tien | Closed |
| #50 | portal | Cash \| Nhat ky chi tien | Closed |

### SimbaSql Migration Tasks
| Issue | Repo | Tiêu đề | Size |
|-------|------|---------|------|
| #17 | SimbaSql | [CA] Phiếu thu - frmCaVchCA1 | M |
| #18 | SimbaSql | [CA] Phiếu chi - frmCaVchCA2 | M |
| #19 | SimbaSql | [GL] Chứng từ kế toán tổng hợp | L |
| #20 | SimbaSql | [IN] Nhập kho | L |
| #21 | SimbaSql | [IN] Xuất kho | L |
| #22 | SimbaSql | [AR] Công nợ phải thu | L |
| #23 | SimbaSql | [SO] Hóa đơn bán hàng | XL |
| #24 | SimbaSql | [PO] Hóa đơn mua hàng | XL |
| #25 | SimbaSql | [Base] Tạo Voucher Base Component | L |
| #26 | SimbaSql | [Base] Tạo Posting Engine | L |

---

## Checklist Khi Kiểm Tra Issue

1. [ ] Xác định repo chứa issue (portal hay SimbaSql)
2. [ ] Dùng `gh issue view <number> --repo <owner/repo>` để xem chi tiết
3. [ ] Kiểm tra xem issue có trong Project Board #2 không
4. [ ] Đọc kỹ description và checklist trong issue
5. [ ] Kiểm tra các issues liên quan (parent/child/related)

---

## Lưu Ý Quan Trọng

1. **KHÔNG dùng web fetch cho GitHub Projects** - cần authentication, sẽ trả về 404
2. **LUÔN dùng `gh` CLI** khi có thể - đã auth sẵn
3. **Issue numbers trùng nhau giữa repos** - luôn chỉ rõ repo khi refer
4. **Project Board #2 là nguồn truth** cho tất cả tasks của dự án
5. **Browser tool cần Chrome extension** - nếu không hoạt động, dùng `gh` CLI

---

## Quick Commands Reference

```bash
# List tất cả issues từ portal
gh issue list --repo diepxuan/portal --limit 50 --state all

# List tất cả issues từ SimbaSql
gh issue list --repo diepxuan/SimbaSql --limit 50 --state all

# Xem chi tiết issue (portal)
gh issue view 24 --repo diepxuan/portal

# Xem chi tiết issue (SimbaSql)
gh issue view 24 --repo diepxuan/SimbaSql

# Xem issue comments
gh issue view 24 --repo diepxuan/portal --comments

# Search issues
gh issue list --repo diepxuan/portal --state all | grep -i "phieu chi"
```

---

*Last updated: 2026-03-30*
*Author: Bột (Portal Project Assistant)*
