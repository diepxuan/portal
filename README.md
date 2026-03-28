# Diepxuan Portal (Laravel 11)

Portal là ứng dụng web cốt lõi cho hệ sinh thái Diepxuan, được xây dựng trên nền tảng Laravel 11. Nó đóng vai trò là nền tảng tập trung tích hợp nhiều module nghiệp vụ khác nhau thông qua kiến trúc module hóa.

## Tài liệu quan trọng

### Documentation Index
- **[Documentation Hub](docs/README.md)**: Index toàn bộ tài liệu dự án

### Bắt buộc đọc (AI Agents & Developers)
- **[Hướng dẫn AI Agent](AI_AGENT_GUIDE.md)**: **BẮT BUỘC**. Quy tắc nghiêm ngặt cho AI agents về phạm vi công việc, Git workflow và an toàn code
- **[Tổng quan kiến trúc](ARCHITECTURE.md)**: Kiến trúc hệ thống, luồng dữ liệu, thành phần cốt lõi
- **[Hệ thống Package](PACKAGES.md)**: 14 package nội bộ trong `diepxuan/` và cách module hoạt động
- **[Thiết lập môi trường](DEVELOPMENT.md)**: Hướng dẫn setup development environment

### Project Documentation (trong `docs/`)
- **[Workspace Guide](docs/project/workspace-guide.md)**: Cấu trúc thư mục, quy tắc tạo file, Git workflow
- **[Core Package Loading](docs/project/core-package-loading.md)**: Auto-discovery và auto-registration system
- **[Package Namespace Conventions](docs/project/package-namespace-conventions.md)**: Quy ước namespace cho packages
- **[Serve:Dev Commands](docs/project/serve-dev-commands.md)**: Development server commands
- **[Model Architecture](docs/project/model-architecture.md)**: Kiến trúc Model 3 lớp

### Core Identity (OpenClaw)
- **[SOUL.md](SOUL.md)**: Core operating identity
- **[IDENTITY.md](IDENTITY.md)**: Role definition & capabilities
- **[AGENTS.md](AGENTS.md)**: Workspace operating protocol
- **[USER.md](USER.md)**: User profile

---

## Bắt đầu nhanh

### 1. Clone & Cài đặt
```bash
git clone git@github.com:diepxuan/portal.git
cd portal
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Cấu hình Database
Cập nhật file `.env` với thông tin kết nối database.

### 3. Chạy Dev Server

**Option 1: Portal-dev.sh wrapper (Recommended)**
```bash
./portal-dev.sh start      # Start development
./portal-dev.sh status     # Check status
./portal-dev.sh stop       # Stop everything
```

**Option 2: Artisan commands**
```bash
php artisan serve:dev          # Start Laravel + Vite
php artisan serve:dev:status   # Check status
php artisan serve:dev:stop     # Stop servers
```

**Xem chi tiết:** [Serve:Dev Commands Documentation](docs/project/serve-dev-commands.md)

---

## Cấu trúc dự án

```
portal/
├── Core Identity (OpenClaw)
│   ├── SOUL.md, IDENTITY.md, AGENTS.md, USER.md
│   └── BOOTSTRAP.md, MEMORY.md, HEARTBEAT.md
│
├── Documentation
│   ├── README.md, AI_AGENT_GUIDE.md, ARCHITECTURE.md
│   ├── DEVELOPMENT.md, PACKAGES.md
│   └── docs/                    # Project & package docs
│       ├── README.md            # Documentation index
│       ├── project/             # Project-wide docs
│       └── packages/            # Package-specific docs
│
├── Laravel Application
│   ├── app/                     # Standard Laravel app
│   ├── diepxuan/                # CORE BUSINESS PACKAGES (14 packages)
│   ├── config/, database/, resources/, routes/, tests/
│   └── ...
│
└── Scripts & Config
    ├── portal-dev.sh            # Development wrapper
    ├── composer.json, package.json
    └── .env, .gitignore
```

### Thư mục quan trọng

| Thư mục | Mô tả |
|---------|-------|
| **`diepxuan/`** | **Core Business Logic** - 14 modular packages (symlink qua Composer). **Hầu hết development diễn ra ở đây** |
| **`app/`** | Standard Laravel application logic |
| **`docs/`** | Documentation hub - project và package docs |
| **`config/`** | Configuration files |
| **`database/`** | Migrations, seeders, factories |
| **`resources/`** | Views, assets, lang files |

---

## Packages (diepxuan/)

14 core business packages:

| Package | Mô tả | README |
|---------|-------|--------|
| **laravel-core** | Core system: package management, auto-discovery | [README](diepxuan/laravel-core/README.md) |
| **laravel-catalog** | Catalog management, main business package | [README](diepxuan/laravel-catalog/README.md) |
| **laravel-simba** | Accounting integration | [README](diepxuan/laravel-simba/README.md) |
| **laravel-support** | Developer utilities & commands | [README](diepxuan/laravel-support/README.md) |
| **laravel-magento** | Magento API integration | [README](diepxuan/laravel-magento/README.md) |
| **laravel-ronaldjack** | Ronald Jack SDK | [README](diepxuan/laravel-ronaldjack/README.md) |
| **laravel-log** | Custom logging channels | [README](diepxuan/laravel-log/README.md) |
| **laravel-disreg** | Disable user registration | [README](diepxuan/laravel-disreg/README.md) |
| **laravel-gmail** | Gmail API client | [README](diepxuan/laravel-gmail/README.md) |
| **laravel-scavenger** | Web scraper engine | [README](diepxuan/laravel-scavenger/README.md) |
| **laravel-currency** | Currency formatting | [README](diepxuan/laravel-currency/README.md) |
| **laravel-eloquent-composite** | Composite model support | [README](diepxuan/laravel-eloquent-composite/README.md) |
| **php-charset** | Vietnamese charset conversion | [README](diepxuan/php-charset/README.md) |

**Xem tổng quan:** [PACKAGES.md](PACKAGES.md)

---

## Đóng góp (Contributing)

### Git Workflow

1. **Mỗi task = 1 branch mới**
2. **Mỗi set thay đổi = 1 PR mới**
3. **Luôn commit** cho mọi thay đổi
4. **Không làm việc** trực tiếp trên `main`

### Cấm tuyệt đối

- Tự ý push
- Tự ý tạo PR
- Tự ý merge/revert
- Cập nhật PR cũ
- Force push

**Chỉ push khi Sếp nói:** "Em tạo PR đi"

**Xem chi tiết:** [AI_AGENT_GUIDE.md](AI_AGENT_GUIDE.md) §3

---

## Development Tools

### Commands hữu ích

```bash
# Development server
php artisan serve:dev
php artisan serve:dev:status
php artisan serve:dev:stop

# Health check
php artisan serve:dev:health --fix

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# View logs
php artisan serve:dev:logs --follow
```

### Code Quality

```bash
# Format code
./vendor/bin/pint

# Run tests
php artisan test
```

---

## Checklist cho AI Agents

Trước khi bắt đầu task:

- [ ] Đọc [SOUL.md](SOUL.md) - Core identity
- [ ] Đọc [USER.md](USER.md) - User profile
- [ ] Đọc [AI_AGENT_GUIDE.md](AI_AGENT_GUIDE.md) - **BẮT BUỘC**
- [ ] Xác nhận phạm vi: **Chỉ `diepxuan/` packages**
- [ ] Tạo branch mới: `task/<tên-task>`
- [ ] Commit với message: `<package>: mô tả`
- [ ] Chờ Sếp review trước khi push

---

## Links

- **Repository:** https://github.com/diepxuan/portal
- **Documentation:** [docs/README.md](docs/README.md)
- **Community:** https://discord.com/invite/clawd

---

*Laravel 11 | PHP 8.2+ | Livewire 3 | Tailwind CSS*
