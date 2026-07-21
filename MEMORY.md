# MEMORY.md - Long-Term Memory

## 2026-07-17: docs/DESIGN.md merged (PR #248) + learnings

- Tao file `docs/DESIGN.md` (241 dong, Markdown-only) — design system cho Portal, ban rewrite theo audit codebase that te phase 1 (008/117/358/359).
- Squash commit: `5e922d73f docs(design): add DESIGN.md + audit rewrite per phase 1 (#248)` da merge vao main.
- Cau truc file: 7 sections (Overview / Colors / Typography / Layout / Elevation / Shapes / Components) + Do's & Don'ts + Ap dung. Khong co YAML front matter (Markdown don gian, ghi chu Map token -> Tailwind class truc tiep trong bang).
- Chuyen `DEVELOPMENT.md` tu root vao `docs/DEVELOPMENT.md` (git mv giu lich su).
- Xoa `docs/GITHUB_PROJECTS.md` (noi dung loi thoi, workflow dung `gh` CLI).
- Cap nhat ref DESIGN.md trong `README.md` (root), `docs/README.md`, `AGENTS.md` (boot step 6 + guardrail §6), `AI_AGENT_GUIDE.md` (§2 + §9 TL;DR).

### Token da chot (theo ban rewrite 241 dong, audit codebase that te)

- Primary `#2563EB` (`bg-blue-600`); hover `#1D4ED8`.
- Tertiary `#0EA5E9` (`bg-sky-500`); row hover `hover:bg-sky-50`.
- Neutral page background: `bg-gray-100` (gray-100 #F3F4F6, dam hon neutral #F9FAFB) — KHONG dung `bg-gray-50` lam page background.
- Surface card: `bg-white` + `border border-gray-200` + `shadow-sm` + `rounded-lg`.
- On-surface text chinh: `text-gray-800`.
- Error `#DC2626` (red-600); Success `#16A34A` (green-600); Warning `#CA8A04` (yellow-600); Info `#4F46E5` (indigo-600).
- Badge rule: `bg-{color}-100 text-{color}-800` (khong dung `text-{color}-600` tren nen nhat — khong du contrast).
- Banner success: `bg-indigo-500` (quy uoc Jetstream, khong green). Banner danger: `bg-red-700`. Banner warning: `bg-yellow-500`.
- Font: Figtree (trong `tailwind.config.js`), weight 400/500/600 (toi da 2 weight tren cung man hinh). Font phu: JetBrains Mono (ID/so chung tu, code snippet).
- Radius: `rounded-md` (6px) button/input/link inline, `rounded-lg` (8px) card/table wrapper, `rounded-xl` (12px) modal, `rounded-full` badge status, `rounded` (4px) link nho trong table row.
- Spacing scale 4px (`xs=4 / sm=8 / md=16 / lg=24 / xl=32 / xxl=48`); cau tu dat gia tri le (`p-3.5`, `mt-2.5`).
- Header max width: `mx-auto max-w-7xl px-4 pt-6 pb-6 sm:px-6 lg:px-8` (= 80rem = 1280px, KHONG 1200px).
- Shadow: `shadow-sm` (card/button), `shadow` (header navigation), `shadow-lg` (dropdown Alpine), `shadow-xl` (dashboard panel).

### Pattern Portal thuc te (tham khao task 008/117/358/359)

- Form filter 3-col grid: `grid grid-cols-3 items-center gap-4` + label `text-right text-sm text-gray-700` + control `col-span-2`.
- Stack form: `space-y-3` / `space-y-4` (khong tu them margin-bottom cho tung element).
- Table wrapper: `<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">` + `<table class="w-full text-sm">` + `<thead class="bg-gray-50">` + row `hover:bg-sky-50`.
- Click handler cho action chinh: `wire:click="submit"` + wrap trong `<x-button-loading>` de co spinner tu dong.
- Destructive action: `wire:confirm="Bạn có chắc chắn muốn xóa {ma_kh}?"` (khong dung modal rieng cho row-level delete).
- Khong bind `wire:model` cho field display-only — chi render `{{ $value }}` trong `<div>` readonly.
- Tao `$presentationColumns()` trong component de quyet dinh cot hien thi (khong render raw toan bo column SP).

### Bai hoc workflow (QUAN TRONG - ghi nho ky)

- KHONG silent rewrite commit: moi commit phai bao cao cho Sep ngay trong turn do, ke ca khi chua push. Neu da rewrite xong ma chua bao cao, bao cao ngay truoc khi lam bat ky thao tac git nao tiep theo.
- Truoc khi push, LUON kiem tra `git log origin/branch..branch` de confirm khong co commit un-pushed. Neu co, doi chieu local vs remote xem commit do da duoc push chua.
- KHONG ghi file tam / backup trong Portal root (khong tao `.openclaw/`, `.bak/`, ... trong workspace Portal). Backup file tam phai o ngoai workspace, vi du `/tmp/portal-backup-<YYYY-MM-DD>/`. Runtime artifact `.openclaw/` la cua OpenClaw framework — khong phai source Portal, khong commit, khong ghi o Portal root.
- Khi phat hien local ↔ remote diverge (git push bi reject non-fast-forward): DUNG, phan tich xem commit nao dang o remote ma local khong co, hoi Sep truoc khi force-push hoac rebase.
- Khi bi Sep dung giua task (vd: Sep tu merge khi em dang sua), chap nhan, bao cao lai nhung gi da xong + nhung gi con sot, doi lenh tiep.
- **"merge PR" = `gh pr merge`, KHONG phai `git merge` local** (bai hoc tu PR #247, #248). Khi Sep noi "merge PR" / "merge #N" / "merge cho anh", dung `gh pr merge <N> --repo <owner/repo> --squash --delete-branch` (hoac `--merge`/`--rebase` tuy convention). KHONG dung `git merge --squash` local roi `gh pr close --delete-branch` — cach nay mat PR state MERGED, mat attribution contributor, mat audit trail. Verify sau merge: `state == MERGED`, `mergeCommit.oid` khong rong. Xem AGENTS.md §5.1.

## Simba-docs Mount (2026-05-05)

- Chứa toàn bộ tài liệu SimbaSql .NET: 10 module ERP, 338 decompiled DLLs, SPs, system tables
- Read-only — nguồn sự thật về logic nghiệp vụ Simba
- Hướng dẫn chi tiết: `docs/SIMBA-DOCS.md`
- Identity files đã cập nhật: `SOUL.md`, `IDENTITY.md`, `AGENTS.md`, `TOOLS.md`

---

## 2026-07-11: PR #244 merged

- Task 357 (Livewire input components) DONE — merged PR #244 bang squash len main (commit `aa6c8c8fc`).
- Squash stats: +930 / -263, 12 files.
- Pattern da chuan hoa tren 4 component (InputKhachhang, InputTaikhoan, InputIndmvt, InputIndmkho):
  - Preload kho tu SP (boot/render), pass reduced payload xuong view
  - Blade search bang Alpine local JS (`khInputComponent`, `tkInputComponent`, `vtInputComponent`, `khoInputComponent`)
  - Bo `wire:model` khi go, sync Livewire qua `$wire.set()` chi khi chon item / Enter / Tab
  - Normalize bo dau (NFD + combining marks + `d/đ` + lowercase + collapse space)
  - Commit: exact code truoc, fallback dong dau filtered
- CatalogService::glDmTks() cache key doi tu `maCty|pTk|pStruct` -> `maCty|pStruct`, filter local theo `pTk`.
- Deferred: browser E2E cho CA4 / ARRptBCCN01 / INRptCD02; InputDonVi van dung Eloquent.

## 2026-07-17: Task 359 - AP ARRptBCCN01 SL (DONE - merged PR #247)

- AP report "Sổ chi tiết công nợ một nhà cung cấp - có số lượng" (menuid 10.30.23, SP asARRptBCCN01SL, report ARBCCN012.rpt).
- DLL gốc ARRptBCCN01.dll chia sẻ form frmARRptBCCN01 giữa AR (06.30.14/10.30.11) và AP (10.30.23); wrapper SP chi normalize 6 tham so (ma_cty/Ngay1/Ngay2/Tk/ma_kh/ma_nt) và nhận alias pMa_*/pCompanyID.
- Livewire Po\Rpt\Arrptbccn01Sl 555 dòng, view po/rpt/arrptbccn01sl.blade.php, route po.rpt.arrptbccn01103023 (slug compact theo task 358).
- Foreign currency precision: 4 decimals cho gia/tien/ps_no/ps_co khi pMa_nt != VND; 0 decimals cho VND/empty. Token Simba #ARRptBCCN_DDK/TPS/DCK dịch sang tiếng Việt trong dien_giai.
- Tests: AsARRptBCCN01SLTest 4/10, Arrptbccn01SlTest 11/34, SourceRouteCoverageTest 8/201 pass.
- Squash commit: 12c1ae27d; doc commit: a002ba750. PR #247 đã đóng + xóa branch sau merge.
- File task 359 move sang docs/tasks/phase 1/ theo quy tắc root PENDING; phase 1 _index 4 tasks (008, 117, 358, 359).

## 2026-07-17: DESIGN.md bootstrap + audit rewrite (DONE - merged PR #248)

- docs/DESIGN.md: design system chuan Google Labs design.md spec alpha
  (12 colors / 8 typography / 5 rounded / 6 spacing / 5 component groups,
  7 sections: Overview / Colors / Typography / Layout / Elevation / Shapes / Components / Do's & Don'ts).
- Phan 1 (commit 8ea76e5b3): bootstrap DESIGN.md, chuyen DEVELOPMENT.md tu root
  sang docs/, xoa docs/GITHUB_PROJECTS.md, cap nhat README + AGENTS + AI_AGENT_GUIDE.
- Phan 2 (commit 3cb995af6): audit & rewrite DESIGN.md theo phase 1.
  Phat hien nhieu thong tin ban dau khong khop codebase that, sua:
  + Layout that te (max-w-7xl + bg-gray-100, khong 1200px / bg-gray-50).
  + Palette bo sung: info (indigo) cho banner success Jetstream,
    yellow-200 cho warning hover, text-*-800 cho badge (khong *-700).
  + 5 component pattern: button-loading wrapper, table wrapper, input readonly,
    presentationColumns, wire:confirm.
  + 6 spacing / 8 typography / 4 shadow token khop Tailwind class that te.
  + Do/Don't 14 muc cu the cho Livewire/Alpine.
  + Bo class khong dung (letter-spacing -0.01em, font-scale viewport,
    shadow inner, spacing.xxl 48px co dinh).
- File giam tu 317 dong xuong 241 dong (-24%), noi dung chat hon.
- DEVELOPMENT.md chuyen tu root sang docs/ (cung cap DESIGN, SIMBA-DOCS).
- Squash commit: 5e922d73f. PR #248 da dong + xoa branch sau merge.

## 2026-07-17: Merge PR guardrail (DONE - merged PR #250)

- Bai hoc tu PR #247, #248: agent dung `git merge --squash` local + `gh pr close`
  thay vi `gh pr merge` => PR state = CLOSED, mat attribution contributor.
- Sua 4 file:
  + AGENTS.md §5.1: guardrail chi tiet (dung/sai, truoc/sau merge verify).
  + AGENTS.md §5.2: khi nao duoc dung `git merge` local.
  + AGENTS.md §6 step 7a: them step merge PR trong task completion cycle.
  + AI_AGENT_GUIDE.md §2 + §9: bullet ngan gon cho AI agent moi.
  + MEMORY.md bai hoc workflow: phan biet gh pr merge vs git merge local.
- Commit cu: `d9a068fae` da bi revert (`1d1054f43`) vi commit thang len main,
  khong mo PR de Sep review. Re-do tren branch `task/249-docs-merge-pr-guardrail`
  + mo PR #250 + dung `gh pr merge --squash --delete-branch` de merge.
- Squash commit: `1f1777c80 docs(workflow): them guardrail (#250)`. PR state = MERGED
  (verified qua `gh pr view --json state`).
- Bài hoc them: khi Sếp nói "merge PR" / "em làm X đi" ngay sau commit, PHAI tao
  branch + PR, KHONG commit thang len main.
## 2026-07-17: TOOLS.md phan nhom lenh theo quyen (DONE - merged PR #253)

- Bai hoc: em hoi approved qua nhieu cho lenh don gian (grep/cat/ls/find/...)
  gay phien. Sep yeu cau phan biet ro 3 nhom lenh.
- AGENTS.md boot sequence them buoc 3 doc `TOOLS.md` (sau USER.md, truoc memory/).
  Do so step DESIGN.md doi tu 6 thanh 7.
- TOOLS.md "Sandbox & Escalation" phan nhom:
  + Read-only (KHONG can hoi): cat/head/tail/wc/file/ls/find/tree/grep/rg/sed -n/
    git status/log/diff/show/branch -a/remote -v/ls-files/ls-tree/
    php -l, phpunit, route:list, config:show/
    curl GET, gh pr view, gh issue view/
    node --version, composer --version/date, whoami, pwd, echo.
  + Ghi local (KHONG can hoi, trong scope): mkdir/cp/mv trong workspace hoac
    /tmp/, sed -i, write file moi trong workspace/
    git checkout -b, git add/commit/mv, git push origin <feature-branch>/
    gh pr create/edit, gh api PATCH/POST/
    composer dump-autoload, php artisan config:clear, cache:clear/
    vendor/bin/phpunit, npm run build/dev (khi task yeu cau).
  + Ghi can hoi Sep: git push origin main, gh pr merge/close,
    git reset --hard/checkout --/clean -fd, force push/
    rm file lon, rm -rf ngoai /tmp/hoac workspace/
    ghi ngoai workspace, network ngoai GitHub (composer install/update, npm install),
    GUI/browser/app, migration DB ngoai task, start/stop dev server,
    lenh fail do sandbox.
- Quy tac moi khi lenh fail/kq khong mong muon:
  + DUNG, khong tu retry bang flag hay ne sandbox.
  + Bao cao Sep: exit code, stderr/output, nghi van nguyen nhan.
  + Xin approval chay lai voi `sandbox_permissions: require_escalated` + justification.
  + Vi du: git push bi reject non-fast-forward -> KHONG tu
    git pull --rebase + push lai; bao Sep truoc.
- Squash commit: `683fc3626 docs(workflow): boot doc TOOLS.md + phan nhom lenh (#253)`.
  PR state = MERGED, branch da xoa.


## 2026-07-13: Task 358 - slug suffix compact (DONE - merged PR #246)

- `SimbaMenuRouteMetadata::routeNameFor()` doi hau to slug trung ten thanh `menuIdSuffix()` (noi cac ky tu cua menuid, khong them `-`).
- Vi du: SysMenu `menuid=10.30.23, code_name=ARRptBCCN01` -> routeName `po.rpt.arrptbccn01103023` (thay vi `po.rpt.arrptbccn01-10-30-23`).
- URL moi: `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023`.
- Unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior; phpunit `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass.
- Squash commit: `e3371acc8` (commit goc `8cdda4298`). PR #246 da xoa branch sau merge.
- File task 358 (`docs/tasks/358-simba-menu-route-metadata-suffix-format.md`) tao moi voi trang thai DONE.
- `_index.md`: row 358 doi `PENDING` -> `DONE`.

## 2026-05-05: Cac task co yeu cau CRUD khach hang

### Task 001: AR - Danh muc khach hang

- **Yeu cau:** Nhap, sua thong tin khach hang
- **Chuc nang:** Quan ly danh muc khach hang (CRUD)
- **Form classes:** frmARDMKH (xem danh sach voi btnAdd, btnEdit, btnDelete), frmARDMKHEdit (them/sua)
- **Stored Procedures:** SP_AR_DMKH_GET, INSERT, UPDATE, DELETE
- **Business Rules:**
    - Khong cho phep sua khi da co giao dich
    - Khong cho phep xoa khi da co giao dich
- **Trang thai:** HOAN THANH (da xac nhan)

### Task 38: Ban hang | khach hang | them, sua, xoa

- **Yeu cau:** Task CRUD cho khach hang trong module ban hang
- **Trang thai:** OPEN
- **Tien do:**
    - [ ] Phan tich yeu cau
    - [ ] Thiet ke co so du lieu (neu can)
    - [ ] Implement CRUD methods
    - [ ] Tao Livewire component (list, create, edit)
    - [ ] Them route
    - [ ] Viet test
    - [ ] Review va merge

### Task 002: AR - Danh muc nhom khach hang

- **Lien quan:** Co rang buoc voi khach hang
- **Business Rules:** Khong cho phep sua/xoa khi da co khach hang thuoc nhom

### Task 003: AR - Danh muc phan loai khach hang

- **Lien quan:** Co rang buoc voi khach hang
- **Business Rules:** Khong cho phep sua/xoa khi da co khach hang su dung

---

## 2026-05-04: Hoan thanh docs/tasks/

### Noi dung

Da hoan thanh viec tao **298 task files** trong `docs/tasks/` cho Portal Project.

### Chi tiet

| Chi so           | Gia tri |
| ---------------- | ------- |
| Tong so task     | 298     |
| DLLs decompiled  | 338     |
| DLLs da co task  | 336     |
| Ty le hoan thanh | 99.4%   |

### Cau truc

| Nhom   | So DLL | Task IDs                              |
| ------ | ------ | ------------------------------------- |
| AR     | ~16    | 001-018, 158                          |
| AP     | ~4     | 017-020                               |
| CA     | ~12    | 021-032, 159-165                      |
| CO     | ~20    | 039-042, 166-180                      |
| SO     | ~40    | 043-061, 197-216, 338-340             |
| PO     | ~20    | 063-080, 217                          |
| SI     | ~26    | 081-099, 218-224                      |
| IN     | ~29    | 100-117, 225-235                      |
| FA     | ~36    | 051 (da rename 341), 118-137, 236-253 |
| GL     | ~95    | 049, 138-157, 254-337                 |
| System | ~18    | 181-196                               |

### Lưu ý

- File 049-SO-phieuxuat-banle.md da rename thanh 340-SO-phieuxuat-banle.md
- File 051-FA-daocao-phantich-tscd-01.md da rename thanh 341-FA-baocao-phantich-tscd-01.md
- Simba.exe va INDMVT\_ khong phai DLL, khong can tao task

### Quy tac

- Task files theo khuon mau 002 (9 sections)
- Task ID unique, khong trung lap
- Nguon thong tin: SimbaSql/docs/decompiled/asia/{DLL}.dll/README.md

## 2026-07-21: PR #257 Codex CLI escalation syntax + InputHttt refactor (DONE - merged)

- PR #257 squash merged len main: `368f87600 docs(tools): add Codex CLI escalation syntax + 4 phuong an + 9router cross-ref (#257)`.
- Branch: `task/257-tools-md-codex-escalation` (da xoa remote qua `--delete-branch`;
  local branch con sot do `.git` read-only, se tu don o session sau).
- Noi dung gom 2 commit (squash thanh 1):
  + `c6407a461` refactor(catalog): sync InputHttt convention + HasKsdFilter trait + reset HTTT (PO3)
    - Trait `Concerns/HasKsdFilter` loc ksd chung (dung cho Httt/Chiphi/Ngoaite).
    - InputHttt doi tu event-only sang `#[Modelable]` pattern, dong bo voi Chiphi/Ngoaite.
    - Povchpo3Edit: reset pMa_httt/pTk_pt/pTk_thue khi clear NCC; flash warning khi
      `asSIGetDMHTTT` tra empty; bo dispatch thu cong, dung `updatedPMaHttt`.
    - docs/tasks/069: tick [x] Phase E auto-fill HTTT + Phase F tests (PR #255).
  + `4dfbd0879` docs(tools): Codex CLI escalation syntax + 4 phuong an A/B/C/D
    + token hygiene + 9router cross-ref.
- Follow-up PR #258 (cung task nay): branch `task/258-tools-md-polish`, polish 6 diem
  TOOLS.md (overlap justification, bwrap runtime token, gh auth khong noi 'expired
  2024-03-14', link repo 9router, rule plain text justification, git push example).
- Bai hoc ky thuat:
  + Phai tao branch moi truoc commit (AGENTS.md §5: 1 task = 1 branch = 1 PR).
    Em da commit nham len `main` o session truoc (c6407a461), khac phuc bang
    `git reset --hard origin/main` sau khi PR squash merge.
  + Sentry `.git` read-only trong sandbox mac dinh: phai dung
    `sandbox_permissions: require_escalated` cho moi lenh `git add/commit/push`
    va `gh pr create/merge`. Justification tieng Viet, 1 dong, theo format
    "Sếp cho phép em chạy '<lệnh>' ngoài sandbox để <mục đích> không?"
  + Token GH: TOOLS.md cu ghi 'expired 2024-03-14' nhung session nay `gh pr create`
    van chay duoc. Sua o PR #258 (a-f polish).
- PR state = MERGED, mergeCommit.oid = `368f8760006c7e2b9aa75029cb357ec6a4307745`.

## 2026-07-21: PR #258 polish 6 điểm TOOLS.md (in progress)

- Branch: `task/258-tools-md-polish`, commit `d26746610 docs(tools): polish 6 diem TOOLS.md sau PR #257 review`.
- Noi dung:
  + (a) Bo overlap example justification o §Cach xin phep cu, tham chieu §2.
  + (b) Them `bwrap ... --argv0 codex-linux-sandbox` runtime hien tai o §1.
  + (c) Sua §4: `gh auth status` neu PASS thi token con live, neu fail dung theo §5.
  + (d) §6 them link https://github.com/diepxuan/9router.
  + (e) §2 them rule plain text cho justification.
  + (f) §3 Phuong an A them `git push origin <branch>` example.
- Diff: +7/-14 tren 1 file (TOOLS.md only).
- Status: PR #258 OPEN, cho Sep review/merge.
