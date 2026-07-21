# Portal Agent — Long-term Memory

Memory dai han cho Portal agent (Bột). Moi entry khi co PR merged hoac insight dang nho
deu ghi vao day. Doc MEMORY.md nay truoc moi task lon de khong lap lai loi cu.

---

## 0. Quy tac co dinh (khong theo PR, chi theo AGENTS.md/TOOLS.md)

### 0.1 Git workflow (AGENTS.md §5)

- **1 task = 1 branch = 1 PR.** KHONG commit thang len `main` (da vi pham o session
  c6407a461 InputHttt refactor).
- Truoc khi push: `git log origin/branch..branch` de confirm khong co commit un-pushed.
- Khong silent rewrite commit — bao cao Sep truoc khi sua commit da tao.
- Khi local <> remote diverge (push bi reject non-fast-forward): DUNG, phan tich,
  KHONG tu `git pull --rebase` + push lai ma bao Sep.
- Khi bi Sep dung giua task (vd: Sep tu merge khi em dang sua): chap nhan, bao
  cao lai nhung gi da xong + con sot, doi lenh tiep.

### 0.2 Merge PR (AGENTS.md §5.1)

- "merge PR" = `gh pr merge <N> --repo <owner/repo> --squash --delete-branch`.
  KHONG `git merge --squash` local + `gh pr close --delete-branch` — mat PR state
  MERGED, mat attribution contributor, mat audit trail.
- Verify sau merge: `state == MERGED`, `mergeCommit.oid` khong rong, branch da xoa.
- `git push origin main` (push thang main) can Sep duyet rieng.

### 0.3 Sandbox & Escalation (TOOLS.md)

- `.git` trong sandbox mac dinh mount read-only (ZFS snapshot). Moi lenh
  `git add/commit/push`, `gh pr create/merge`, `gh api` can
  `sandbox_permissions: require_escalated`.
- Justification: tieng Viet, 1 dong, format
  `Sếp cho phép em chạy '<lệnh>' ngoài sandbox để <mục đích> không?`.
- Justification KHONG kèm markdown/code fence/escape (runtime doc thang lam UI prompt).
- Lenh doc local (khong network) chay duoc ngay ca khi sandbox chan DNS:
  + `gh auth status` (doc `/root/.config/gh/hosts.yml`).
  + `cat/ls/grep/diff/...` workspace.
- Lenh hit network (`gh pr view`, `gh pr create`, `gh api`, `curl https://...`)
  fail khi `CODEX_SANDBOX_NETWORK_DISABLED=1`. Test `gh api /octocat` truoc khi chay
  mutation de xac nhan route network.
- 4 phuong an neu sandbox chan (uu tien A):
  + A — `sandbox_permissions: require_escalated` + justification (mac dinh).
  + B — proxy HTTP/SOCKS do Sep cap (chua co trong ha tang).
  + C — chay agent tren may ngoai sandbox (do Sep quyet).
  + D — agent soan script, Sep copy/paste (1-2 lenh/ngay).

### 0.4 Token hygiene (TOOLS.md §5)

- Token GH luu tai `/root/.config/gh/hosts.yml`. KHONG tu `gh auth login` khi gap
  `authentication failed` — dung va bao Sep.
- Scope khuyen nghi: `repo`, `read:org`, `workflow`.
- Khong in token ra log, khong paste vao file workspace (ke ca `/tmp/`).
- Trang thai thuc te session 2026-07-21: token con live, `gh auth status` PASS, scope
  `gist, project, read:org, repo, workflow`. File mtime cu (~2024-03-14) chi la
  timestamp cap nhat lan cu, khong phai expiration.

### 0.5 Phan loai lenh (TOOLS.md, rut gon tu #253)

| Nhom | Vi du | Can hoi Sep? |
|------|------|--------------|
| Read-only | `cat/ls/grep/diff/`, `git status/log/diff`, `php -l`, `phpunit`, `gh pr view`, `curl GET` | KHONG |
| Ghi local | `mkdir/cp/mv` trong workspace, `git add/commit`, `git push origin <feature>`, `gh pr create/edit`, `composer dump-autoload`, `php artisan config:clear` | KHONG |
| Ghi can hoi | `git push origin main`, `gh pr merge/close`, `git reset --hard`, force push, `rm -rf` ngoai workspace, network ngoai GH | CO |

---

## 1. PRs merged (timeline tang dan)

### 1.1 PR #244 — Task 357 Livewire input components SP wrappers (2026-07-11)

- Squash: `aa6c8c8fc`, +930/-263, 12 files.
- Pattern chuan hoa 4 component (InputKhachhang, InputTaikhoan, InputIndmvt, InputIndmkho):
  + Preload kho tu SP (boot/render), pass reduced payload xuong view.
  + Blade search bang Alpine local JS.
  + Bo `wire:model` khi go, sync Livewire qua `$wire.set()` khi chon item / Enter / Tab.
  + Normalize VN (NFD + combining marks + `d/đ` + lowercase + collapse space).
- `CatalogService::glDmTks()` cache key doi tu `maCty|pTk|pStruct` -> `maCty|pStruct`.
- Deferred: browser E2E cho CA4 / ARRptBCCN01 / INRptCD02; InputDonVi con dung Eloquent.

### 1.2 PR #246 — Task 358 slug suffix compact (2026-07-13)

- `SimbaMenuRouteMetadata::routeNameFor()` doi hau to slug trung ten thanh `menuIdSuffix()`
  (noi cac ky tu cua menuid, khong them `-`).
- Vi du: SysMenu `menuid=10.30.23, code_name=ARRptBCCN01` ->
  routeName `po.rpt.arrptbccn01103023`.
- URL moi: `http://portal.diepxuan.corp/simba/po/rpt/arrptbccn01103023`.
- Unit test `testRouteNameSuffixAppendsCompactMenuId` pin behavior; phpunit
  `SimbaMenuRouteMetadataTest` 9 tests / 20 assertions pass.
- Squash commit goc: `8cdda4298`. PR #246 da xoa branch sau merge.

### 1.3 PR #247 — Task 359 AP ARRptBCCN01 SL (2026-07-17)

- Report "So chi tiet cong no mot nha cung cap - co so luong" (menuid 10.30.23,
  SP `asARRptBCCN01SL`, report ARBCCN012.rpt).
- DLL goc ARRptBCCN01.dll chia se form frmARRptBCCN01 giua AR (06.30.14/10.30.11) va
  AP (10.30.23); wrapper SP chi normalize 6 tham so (ma_cty/Ngay1/Ngay2/Tk/ma_kh/ma_nt)
  va nhan alias `pMa_*`/`pCompanyID`.
- Livewire `Po\Rpt\Arrptbccn01Sl` 555 dong, view `po/rpt/arrptbccn01sl.blade.php`,
  route `po.rpt.arrptbccn01103023` (slug compact theo task 358).
- Foreign currency precision: 4 decimals cho gia/tien/ps_no/ps_co khi `pMa_nt != VND`;
  0 decimals cho VND/empty. Token Simba `#ARRptBCCN_DDK/TPS/DCK` dich sang tieng Viet.
- Tests: AsARRptBCCN01SLTest 4/10, Arrptbccn01SlTest 11/34, SourceRouteCoverageTest 8/201 pass.
- Squash: 12c1ae27d. File task 359 move sang `docs/tasks/phase 1/`.

### 1.4 PR #248 — DESIGN.md bootstrap + audit rewrite (2026-07-17)

- Tao `docs/DESIGN.md` (241 dong, Markdown-only) — design system Portal theo
  Google Labs `design.md` spec.
- Cau truc 7 sections: Overview / Colors / Typography / Layout / Elevation / Shapes /
  Components + Do's & Don'ts.
- Phan 2 audit rewrite: phat hien thong tin ban dau khong khop codebase that, sua:
  + Layout that te (max-w-7xl + bg-gray-100, KHONG 1200px / bg-gray-50).
  + Palette bo sung: info (indigo) cho banner success Jetstream, yellow-200 cho
    warning hover, text-*-800 cho badge (khong *-700).
  + 5 component pattern: button-loading, table wrapper, input readonly,
    presentationColumns, wire:confirm.
  + 6 spacing / 8 typography / 4 shadow token khop Tailwind class that te.
  + Do/Don't 14 muc cu the cho Livewire/Alpine.
  + Bo class khong dung (letter-spacing -0.01em, font-scale viewport, shadow inner,
    spacing.xxl 48px co dinh).
- File giam tu 317 dong xuong 241 dong (-24%).
- Chuyen `DEVELOPMENT.md` tu root sang `docs/`. Xoa `docs/GITHUB_PROJECTS.md`.
- Cap nhat ref DESIGN.md trong README, docs/README, AGENTS.md (boot + guardrail),
  AI_AGENT_GUIDE.md.
- Squash: 5e922d73f.

### 1.5 PR #250 — Merge PR guardrail (2026-07-17)

- Bai hoc: agent dung `git merge --squash` local + `gh pr close` thay vi `gh pr merge`
  => PR state = CLOSED, mat attribution contributor.
- Sua 4 file: AGENTS.md §5.1 (guardrail chi tiet), §5.2 (khi nao dung `git merge` local),
  §6 step 7a (them merge step), AI_AGENT_GUIDE.md §2/§9.
- Commit cu `d9a068fae` bi revert (`1d1054f43`) vi commit thang len main, re-do tren
  branch `task/249-docs-merge-pr-guardrail` + PR #250.
- Squash: 1f1777c80. PR state = MERGED verified qua `gh pr view --json state`.

### 1.6 PR #253 — TOOLS.md phan nhom lenh theo quyen (2026-07-17)

- Bai hoc: em hoi approved qua nhieu cho lenh don gian (grep/cat/ls/find/...) gay
  phien. Sep yeu cau phan biet ro 3 nhom lenh.
- AGENTS.md boot sequence them buoc 3 doc TOOLS.md (sau USER.md, truoc memory/) —
  step DESIGN.md doi tu 6 thanh 7.
- TOOLS.md "Sandbox & Escalation" ghi 3 nhom lenh (Read-only / Ghi local / Can hoi).
- Quy tac moi khi lenh fail: DUNG, khong retry bang flag, bao Sep, xin approval
  chay lai voi `require_escalated` + justification.
- Squash: 683fc3626.

### 1.7 PR #257 — Codex CLI escalation syntax + InputHttt refactor (2026-07-21)

- Squash: 368f87600. Gop 2 commit:
  + `c6407a461` refactor(catalog): sync InputHttt convention + HasKsdFilter trait
    + reset HTTT (PO3). Trait `Concerns/HasKsdFilter` loc ksd chung; InputHttt
    doi tu event-only sang `#[Modelable]` pattern, dong bo voi Chiphi/Ngoaite;
    Povchpo3Edit reset pMa_httt/pTk_pt/pTk_thue khi clear NCC + flash warning
    khi `asSIGetDMHTTT` empty; docs/tasks/069 tick [x] Phase E/F.
  + `4dfbd0879` docs(tools): Codex CLI escalation syntax + 4 phuong an A/B/C/D +
    token hygiene + 9router cross-ref.
- mergeCommit.oid = 368f8760006c7e2b9aa75029cb357ec6a4307745.

### 1.8 PR #258 — Polish 6 diem TOOLS.md + fix §4 (2026-07-21)

- Squash: cae6ae5e0. Gop 4 commit:
  + `d26746610` polish 6 diem cu §TOOLS.md (a-f: overlap justification, bwrap runtime,
    gh auth message, link 9router, plain text rule, git push example).
  + `61f0958fa` MEMORY.md record PR #257.
  + `a64eef296` §4 phan biet `gh auth status` (local) vs `gh api` (network).
  + `05cd36a6f` MEMORY.md record §4 fix.

---

## 2. Tasks done (theo task ID, lien ket PR)

### Task 244 (PR #244) — Livewire input components theo SP wrappers

- Pattern chuan o muc 1.1. 4 component.

### Task 246 (PR #246) — slug suffix compact

- Pattern o muc 1.2.

### Task 247 (PR #247) — AP ARRptBCCN01 SL report

- Pattern o muc 1.3.

### Task 248 (PR #248) — DESIGN.md bootstrap + audit

- Pattern o muc 1.4. File design system thanh nguon su that cho moi view/component moi.

### Task 250 (PR #250) — Merge PR guardrail

- Pattern o muc 1.5.

### Task 253 (PR #253) — TOOLS.md phan nhom lenh

- Pattern o muc 1.6.

### Task 069 — POVchPO3 (PO3 hoa don mua hang)

- Status: DONE Phase A-F (qua cac PR #251 + #254 + #255).
- Squash commit cac PR lien quan:
  + #251 (`268d350a2`): InputHttt component + PO3 hoan chinh.
  + #254 (`2ea51ef13`): InputChiphi + InputNgoaite + redesign PO3 layout 2 cot.
  + #255 (`af30db3e6`): unit test (reflection-based) cho AsPOGetPO3/AsPOSavePO3/AsPODeletePO3.
- Convention dat: Po/Vch/Povchpo3{Edit}.php (khong dung Muahang/Hoadonmua* shell cu).
- Route: `po.vch.povchpo3` (khong suffix menuid).
- Docs: `docs/tasks/069-po-hoadon-mua-hang.md`.

---

## 3. Bai hoc ky thuat duc rut

### 3.1 Git/sandbox: `.git` read-only trong sandbox mac dinh

- Trieu chung: moi lenh `git add/commit/push` o session Codex mac dinh deu fail
  "Read-only file system" cho `.git/`.
- Giai phap: dung `sandbox_permissions: require_escalated` cho moi lenh git va
  gh. Justification tieng Viet, 1 dong, format chuan (xem §0.3).
- Bai hoc: KHONG tu "vy" sandbox bang flag. DUNG, bao Sep, xin approval.

### 3.2 gh CLI: local check vs network call

- `gh auth status` doc LOCAL `/root/.config/gh/hosts.yml`, KHONG hit network.
  PASS (Logged in + scopes) khong dam bao lenh network chay duoc.
- Lenh network (`gh pr view`, `gh pr create/merge`, `gh api`) hit `api.github.com`,
  fail khi `CODEX_SANDBOX_NETWORK_DISABLED=1` (DNS block).
- Test `gh api /octocat` truoc khi chay mutation de xac nhan route network.
- Bao Sep cu the loai failure (token vs network), khong bao chung "gh fail".

### 3.3 Commit nham len main: phat hien + khoi phuc

- Trieu chung: `git status -sb` hien `## main...origin/main [ahead N]`.
- Khoi phuc an toan (sau khi PR squash merge gom cung content):
  + Cherry-pick commit nham sang branch moi.
  + Push + mo PR rieng.
  + `git reset --hard origin/main` (can Sep duyet — lenh pha data local).
- Bai hoc: TAO BRANCH TRUOC commit (AGENTS.md §5). Working tree untracked file =
  chua commit -> o workdir branch moi.

### 3.4 Design system DESIGN.md la nguon su that

- Moi view/component moi phai doc `docs/DESIGN.md` truoc.
- Token dung: primary `bg-blue-600`, surface `bg-white border border-gray-200 shadow-sm
  rounded-lg`, text `text-sm font-medium` cho label, `text-xs` cho caption.
- Spelling: KHONG `letter-spacing` am, KHONG scale font theo viewport, KHONG
  palette don hue (purple/blue/sand/dark-blue/brown).

### 3.5 Input component convention

- Tat ca Input component autocomplete (Httt/Chiphi/Ngoaite/Khachhang/Taikhoan/Indmvt/
  Indmkho) dung:
  + `#[Modelable]` cho p parent bind qua `wire:model`.
  + Dispatch `{slug}-updated` khi user chon/xoa de parent auto-fill.
  + `updatedValue()` dong bo `search` khi value doi tu server (parent reset).
- Filter `ksd` qua trait `Concerns/HasKsdFilter::isActiveRow()` (khong inline
  `(int) $ksd === 1`). Cho phep bool / int / string '1' / null.
- SP wrapper la nguon lay data, KHONG Eloquent (theo policy).

### 3.6 TOOLS.md/AGENTS.md updates — pattern pho bien

- Moi PR co docs/workflow deu record vao MEMORY.md (1 entry `DONE - merged`,
  format nhat quan: squash commit, branch da xoa, bai hoc ky thuat, PR state).
- Pre-merge cho PR docs-only trong repo `diepxuan/portal`:
  + Repo khong trigger CI cho PR docs-only (workflow `module.yml` chi `push to main`,
    `pull-requests.yml` chi job "uneditable").
  + Chi can verify `mergeable == MERGEABLE` + `mergeStateStatus CLEAN`. KHONG can
    `statusCheckRollup` cho docs PR.

---

## 4. Domain knowledge (Portal / Simba)

### 4.1 Simba-docs mount (2026-05-05)

- Chua toan bo tai lieu SimbaSql .NET: 10 module ERP, 338 decompiled DLLs, SPs,
  system tables.
- Read-only — nguon su that ve logic nghiep vu Simba.
- Huong dan chi tiet: `docs/SIMBA-DOCS.md`.
- Identity files can cap nhat khi mount doi: SOUL.md, IDENTITY.md, AGENTS.md, TOOLS.md.

### 4.2 SimbaMenuRouteMetadata — route compact + slug

- Helper `SimbaMenuRouteMetadata::routeNameFor()` sinh route name theo
  `{module}.{kind}.{slug}` (vd `po.vch.povchpo3`).
- Chi append menuid suffix khi slug trung ten (qua `menuIdSuffix()`).
- Moi SLUG compact `po.rpt.arrptbccn01103023` (noi cac ky tu, khong them `-`).
- Source: `diepxuan/laravel-catalog/src/Services/SimbaMenuRouteMetadata.php`.

### 4.3 Pattern SP wrappers priority over Eloquent

- Policy: uu tien Stored Procedure cho data SimbaERP, Eloquent la fallback.
- Eloquent chi dung khi SP chua co hoac khi can prototype nhanh.
- Tags SP source tu `simba-docs/`: data/sysDAOInfo.md + procedures/<group>/procedures.md.

### 4.4 Pages/form Portal thuc te (tham khao DESIGN.md + tasks 008/117/358/359)

- Form filter 3-col grid: `grid grid-cols-3 items-center gap-4` + label
  `text-right text-sm text-gray-700` + control `col-span-2`.
- Stack form: `space-y-3` / `space-y-4` (khong tu them margin-bottom).
- Table wrapper: `<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">`
  + `<table class="w-full text-sm">` + `<thead class="bg-gray-50">` + row `hover:bg-sky-50`.
- Click action chinh: `wire:click="submit"` wrap trong `<x-button-loading>`.
- Destructive row-level: `wire:confirm="Bạn có chắc chắn muốn xóa {ma_kh}?"`.
- KHONG bind `wire:model` cho field display-only — chi render `{{ $value }}` readonly.
- Tao `$presentationColumns()` trong component de quyet dinh cot hien thi.

---

## 5. Backlog / Open questions

### 5.1 Cleanup local branch stuck do `.git` read-only

- Trang thai (2026-07-21): branch local `task/257-tools-md-codex-escalation` +
  `task/258-tools-md-polish` + `task/259-record-pr-258` (neu PR chua merge)
  con sot trong working tree sau khi PR squash merge xoa remote.
- Se tu don khi `.git` umount read-write o session sau.
- Neu gap lai: `git branch -D <stuck>` + `git remote prune origin` (can Sep duyet
  vi `git branch -D` thuoc "phá dữ liệu local").

### 5.2 9router protocol port

- TOOLS.md §6 noi Sếp dang port protocol tu Portal sang 9router de 2 agent
  dung chung quy tac.
- Agent KHONG tu port — Sep quyet khi nao can.

### 5.3 Tasks CRUD khach hang (2026-05-05, chua merge)

- Task 001 (AR - Danh muc khach hang): HOAN THANH da xac nhan.
- Task 38 (Ban hang CRUD khach hang): OPEN, danh sach tien do chua lam.
- Task 002 (Nhom khach hang), Task 003 (Phan loai khach hang): rang buoc
  "khong sua/xoa khi da su dung", chua co PR.

### 5.4 Hoan thanh `docs/tasks/` audit (2026-05-04)

- Da tao 298 task files trong `docs/tasks/`, ti le 99.4% (336/338 DLLs).
- Co the da co task moi them sau audit nay (task 360-369 split tu 181-196
  da thay o commit goc, xem PR #256).
- Con lai: 2 DLLs chua co task (ty le 0.6%) + 1-2 file rename (049 -> 340,
  051 -> 341) theo note trong MEMORY.md cu.

---

## Phu luc A: Token/chu ky commit agent

- Author: Bột <bot@diepxuan.corp>
- Tool sandbox: Codex CLI 0.142.0 + OpenClaw gateway 2026.6.8 (port 18789).
- Git remote: `git@github.com:diepxuan/portal.git`
- Token gh luu tai `/root/.config/gh/hosts.yml`, scope hien tai (2026-07-21):
  `gist, project, read:org, repo, workflow`.
