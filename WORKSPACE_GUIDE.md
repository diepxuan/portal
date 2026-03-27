# WORKSPACE_GUIDE.md - Portal Project Structure

Tài liệu này quy định cách tổ chức và làm việc trong workspace Portal project.

---

## 1. Workspace Root

**Tất cả công việc thực hiện trong:** `/root/.openclaw/workspace/projects/portal/`

Không tạo file hoặc thực hiện thao tác ra ngoài phạm vi này.

---

## 2. Cấu Trúc Thư Mục

```
/root/.openclaw/workspace/projects/portal/
│
├── 📁 Core Identity Files (OpenClaw Agent)
│   ├── SOUL.md                 # Bản sắc cốt lõi
│   ├── IDENTITY.md             # Định danh agent
│   ├── USER.md                 # Thông tin Sếp
│   ├── AGENTS.md               # Protocol cho agents
│   ├── BOOTSTRAP.md            # Boot sequence
│   ├── MEMORY.md               # Long-term memory (compact)
│   ├── HEARTBEAT.md            # Heartbeat tasks
│   └── TOOLS.md                # Tool notes (nếu cần)
│
├── 📁 Memory System
│   └── memory/
│       ├── 2026-03-28.md       # Daily memory (hôm nay)
│       └── YYYY-MM-DD.md       # Daily memory files
│
├── 📁 Laravel Application
│   ├── app/                    # Application logic
│   │   ├── Http/
│   │   ├── Models/
│   │   ├── Services/
│   │   └── ...
│   │
│   ├── diepxuan/               # CORE BUSINESS PACKAGES (14 packages)
│   │   ├── laravel-simba/      # Accounting integration
│   │   │   ├── src/
│   │   │   ├── config/
│   │   │   ├── docs/           # Package documentation
│   │   │   └── README.md
│   │   ├── laravel-catalog/    # Catalog package
│   │   │   ├── src/
│   │   │   ├── docs/
│   │   │   └── README.md
│   │   ├── laravel-core/       # Core system (auto-discovery)
│   │   │   ├── src/
│   │   │   ├── docs/
│   │   │   └── README.md
│   │   ├── laravel-support/    # Developer utilities + serve:dev
│   │   │   ├── src/
│   │   │   ├── docs/
│   │   │   └── README.md
│   │   ├── laravel-magento/    # Magento API integration
│   │   ├── laravel-ronaldjack/ # Ronald Jack SDK
│   │   ├── laravel-log/        # Custom log channel
│   │   ├── laravel-currency/   # Currency formatting
│   │   ├── laravel-disreg/     # Disable registration
│   │   ├── laravel-eloquent-composite/
│   │   ├── laravel-gmail/      # Gmail client
│   │   ├── laravel-scavenger/  # Web scraper
│   │   └── php-charset/        # Charset converter
│   │
│   ├── config/                 # Configuration files
│   ├── database/               # Migrations, seeders, factories
│   ├── resources/              # Views, assets, lang
│   ├── routes/                 # Route definitions
│   ├── tests/                  # Test files
│   ├── bootstrap/              # Bootstrap files
│   ├── docker/                 # Docker configuration
│   └── .githooks/              # Git hooks
│
├── 📁 Project Documentation
│   ├── README.md               # Project overview
│   ├── AI_AGENT_GUIDE.md       # Guide for AI agents
│   ├── ARCHITECTURE.md         # System architecture
│   ├── DEVELOPMENT.md          # Development setup
│   ├── PACKAGES.md             # Package overview & links
│   ├── CHANGELOG.md            # Version history
│   └── docs/                   # Additional documentation
│       └── UPDATE-YYYY-MM-DD.md # Config/behavior changes
│
├── 📁 Scripts (Project-specific)
│   └── scripts/                # Scripts riêng cho Portal
│       └── README.md           # Script documentation
│
├── 📁 GitHub Configuration
│   └── .github/
│       └── copilot-instructions.md
│
└── 📁 Configuration Files
    ├── composer.json
    ├── package.json
    ├── vite.config.js
    ├── tailwind.config.js
    ├── .env
    ├── .env.example
    ├── .gitignore
    └── ...
```

---

## 3. Quy Tắc Tạo File Mới

### 3.1 Scripts
- **Vị trí:** `scripts/` trong project folder
- **Quy tắc:**
  - Đọc `scripts/README.md` trước khi tạo script mới
  - Đặt tên rõ ràng: `[purpose]_[language].ext`
  - Ví dụ: `fix_namespace_issues.php`, `generate_models.py`

### 3.2 Documentation

#### Project-level Documentation
- **Vị trí:** Root project hoặc `docs/` folder
- **File:**
  - `README.md` - Project overview
  - `PACKAGES.md` - Package overview với links đến docs chi tiết
  - `ARCHITECTURE.md` - System architecture
  - `DEVELOPMENT.md` - Development setup
  - `CHANGELOG.md` - Version history
  - `docs/UPDATE-YYYY-MM-DD.md` - Config/behavior changes

#### Package Documentation (QUAN TRỌNG)
- **Vị trí:** `diepxuan/[package-name]/docs/`
- **Quy tắc:**
  - Documentation thuộc về package nào → nằm trong package đó
  - Không tạo docs chung ở root cho tính năng của package cụ thể
  - Mỗi package phải có `README.md` với overview và links đến docs chi tiết

**Ví dụ:**
```
diepxuan/laravel-core/docs/
├── CORE-PACKAGE-LOADING.md      # Auto-discovery system
└── PACKAGE-NAMESPACE-CONVENTIONS.md

diepxuan/laravel-support/docs/
├── SERVE-DEV-COMMANDS.md        # Development server management
└── CODE-STYLE-AND-FORMATTING.md

diepxuan/laravel-simba/docs/
├── MODEL-ARCHITECTURE.md        # Model 3-layer architecture
├── CONFIGURATION.md
├── DATABASE_ACCESS_POLICY.md
├── TROUBLESHOOTING.md
└── procedures-*.md              # Stored procedure docs
```

#### Links từ PACKAGES.md
- `PACKAGES.md` là central index cho tất cả package documentation
- Mỗi package section trong `PACKAGES.md` phải có links đến docs chi tiết

### 3.3 Memory Files
- **Vị trí:** `memory/` folder
- **Quy tắc:**
  - Daily memory: `memory/YYYY-MM-DD.md`
  - Chỉ MAIN SESSION được sửa `MEMORY.md`

### 3.4 Package Files
- **Vị trí:** Trong package tương ứng (`diepxuan/[package-name]/`)
- **Quy tắc:**
  - Mỗi package phải có `README.md`
  - Package docs → `diepxuan/[package-name]/docs/`
  - Thay đổi lớn → `CHANGELOG.md` trong package
  - Config changes → `docs/UPDATE-YYYY-MM-DD.md` trong package

---

## 4. Git Workflow

**Repository:** `git@github.com:diepxuan/portal.git`

### Quy tắc bắt buộc:
1. Mỗi task = 1 branch mới
2. Mỗi set thay đổi = 1 PR mới
3. Luôn commit cho mọi thay đổi
4. Không làm việc trực tiếp trên main

### Cấm tuyệt đối:
- Tự ý push
- Tự ý tạo PR
- Tự ý merge/revert
- Cập nhật PR cũ
- Force push

Chỉ push khi Sếp nói: **"Em tạo PR đi"**

---

## 5. Documentation Requirements

Mọi thay đổi phải có tài liệu:

### 5.1 Feature mới
- Update README.md (nếu ảnh hưởng cách dùng)
- Tạo docs/FEATURE-YYYY-MM-DD.md
- Update CHANGELOG.md

### 5.2 Config/Behavior changes
- Bắt buộc: `docs/UPDATE-YYYY-MM-DD.md`
- Nội dung:
  - Người thực hiện
  - Lý do thay đổi
  - Phạm vi ảnh hưởng
  - Cách test
  - Cách rollback

### 5.3 Bug fixes
- Commit message rõ ràng
- Update CHANGELOG.md nếu ảnh hưởng logic

---

## 6. Checklist Trước Khi Commit

- [ ] README.md đã cập nhật (nếu cần)
- [ ] CHANGELOG.md có ghi nhận thay đổi
- [ ] Config changes có docs/UPDATE-YYYY-MM-DD.md
- [ ] Documentation nằm đúng vị trí (package docs → trong package)
- [ ] PACKAGES.md có links đến docs mới (nếu là package documentation)
- [ ] Cấu trúc thư mục đúng quy định
- [ ] Git branch đúng quy tắc (1 task = 1 branch)

---

## 7. Documentation Structure Summary

### Project-level (Root)
| File | Mục đích |
|------|----------|
| `README.md` | Project overview |
| `PACKAGES.md` | Package index với links |
| `ARCHITECTURE.md` | System architecture |
| `DEVELOPMENT.md` | Development setup |
| `CHANGELOG.md` | Project changelog |
| `docs/UPDATE-*.md` | Config/behavior changes |

### Package-level (`diepxuan/[package]/`)
| File | Mục đích |
|------|----------|
| `README.md` | Package overview + links to docs |
| `docs/*.md` | Package-specific documentation |
| `CHANGELOG.md` | Package changelog |

### Current Package Documentation
- **laravel-core:** `docs/CORE-PACKAGE-LOADING.md`, `docs/PACKAGE-NAMESPACE-CONVENTIONS.md`
- **laravel-support:** `docs/SERVE-DEV-COMMANDS.md`, `docs/CODE-STYLE-AND-FORMATTING.md`
- **laravel-simba:** `docs/MODEL-ARCHITECTURE.md`, `docs/CONFIGURATION.md`, `docs/DATABASE_ACCESS_POLICY.md`, `docs/TROUBLESHOOTING.md`, `docs/procedures-*.md`
- **laravel-catalog:** `docs/TIMER_SYSTEM.md`

---

## 8. Hiệu Lực

Quy tắc này có hiệu lực ngay lập tức và áp dụng cho toàn bộ Portal project.

**Last Updated:** 2026-03-28  
**Maintained by:** Bột (OpenClaw Assistant)
