# Portal Project Documentation

Documentation index cho Portal Project.

---

## Project Documentation

Tài liệu chung cho toàn bộ dự án.

| File | Mô tả |
|------|-------|
| **[Workspace Guide](workspace-guide.md)** | Cấu trúc thư mục, quy tắc tạo file, Git workflow |
| **[Core Package Loading](core-package-loading.md)** | Hệ thống auto-discovery và auto-registration packages |
| **[Package Namespace Conventions](package-namespace-conventions.md)** | Quy ước namespace cho 14 packages |
| **[Serve:Dev Commands](serve-dev-commands.md)** | Hướng dẫn development server commands |
| **[Model Architecture](model-architecture.md)** | Kiến trúc Model 3 lớp (SModel → Simba\Models → Catalog\Models) |

---

## Package Documentation

Tài liệu riêng cho từng package trong `diepxuan/`.

| Package | README | Docs |
|---------|--------|------|
| **laravel-catalog** | [README](../../diepxuan/laravel-catalog/README.md) | - |
| **laravel-core** | [README](../../diepxuan/laravel-core/README.md) | - |
| **laravel-simba** | [README](../../diepxuan/laravel-simba/README.md) | - |
| **laravel-support** | [README](../../diepxuan/laravel-support/README.md) | - |
| **laravel-magento** | [README](../../diepxuan/laravel-magento/README.md) | - |
| **laravel-ronaldjack** | [README](../../diepxuan/laravel-ronaldjack/README.md) | - |
| **laravel-log** | [README](../../diepxuan/laravel-log/README.md) | - |
| **laravel-disreg** | [README](../../diepxuan/laravel-disreg/README.md) | - |
| **laravel-gmail** | [README](../../diepxuan/laravel-gmail/README.md) | - |
| **laravel-scavenger** | [README](../../diepxuan/laravel-scavenger/README.md) | - |
| **laravel-currency** | [README](../../diepxuan/laravel-currency/README.md) | - |
| **laravel-eloquent-composite** | [README](../../diepxuan/laravel-eloquent-composite/README.md) | - |
| **php-charset** | [README](../../diepxuan/php-charset/README.md) | - |

---

## External Documentation

| Tài liệu | Link |
|----------|------|
| **AI Agent Guide** | [AI_AGENT_GUIDE.md](../AI_AGENT_GUIDE.md) |
| **Architecture** | [ARCHITECTURE.md](../ARCHITECTURE.md) |
| **Development Setup** | [DEVELOPMENT.md](../DEVELOPMENT.md) |
| **Packages Overview** | [PACKAGES.md](../PACKAGES.md) |

---

## Documentation Structure

```
docs/
├── README.md                    # File này - Documentation index
├── project/                     # Project-wide documentation
│   ├── workspace-guide.md
│   ├── core-package-loading.md
│   ├── package-namespace-conventions.md
│   ├── serve-dev-commands.md
│   └── model-architecture.md
└── packages/                    # Package-specific documentation (nếu có)
    └── {package-name}/
        └── ...
```

---

## Documentation Guidelines

### Khi tạo tài liệu mới

1. **Project-wide docs** → `docs/project/`
2. **Package-specific docs** → `diepxuan/{package}/docs/`
3. **Update logs** → `docs/project/UPDATE-YYYY-MM-DD.md`

### Quy tắc đặt tên

- **File names:** lowercase, dash-separated
- **Date format:** `UPDATE-YYYY-MM-DD.md`
- **Package docs:** Theo tên package

### Nội dung tối thiểu

- Mục đích
- Cách sử dụng
- Cấu trúc (nếu áp dụng)
- Examples
- Troubleshooting

---

**Last Updated:** 2026-03-28  
**Maintained by:** Bột
