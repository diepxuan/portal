# Tổng quan các package trong thư mục `diepxuan/`

Thư mục `diepxuan/` chứa **14 package Laravel nội bộ** được quản lý qua Composer `path` repositories (symlink). Các package này cung cấp chức năng module hóa cho hệ thống Portal.

## Danh sách package

| Package | Mô tả | Dependencies chính | Ghi chú |
|---------|-------|-------------------|---------|
| **laravel‑core** | Core hệ thống DX: quản lý package, auto‑discovery (commands, Livewire/Blade components), đăng ký service providers. | (none) | Cung cấp class `Diepxuan\Core\Models\Package` với các helper `list()`, `path()`, `getCommands()`, `livewireComponentNamespace()`, … |
| **laravel‑catalog** | Quản lý catalog cho DXPanel. | laravel‑core, laravel‑currency, laravel‑log, laravel‑magento, laravel‑ronaldjack, laravel‑simba, php‑charset, laravel/jetstream | Package chính của hệ thống, tích hợp nhiều package khác. |
| **laravel‑currency** | Format tiền tệ trong Blade. | symfony/intl | Cung cấp Blade directives/helpers để format currency. |
| **laravel‑disreg** | Vô hiệu hóa chức năng đăng ký user của Laravel. | (none) | Service provider `DisableRegistrationServiceProvider`. |
| **laravel‑eloquent‑composite** | Hỗ trợ composite model cho Eloquent. | illuminate/database | Các trait/class mở rộng Eloquent. |
| **laravel‑gmail** | Client Gmail tùy chỉnh cho Laravel. | google/apiclient | Giao tiếp với Gmail API. |
| **laravel‑log** | Custom log channel cho Laravel. | (none) | Service provider `Diepxuan\Log\Providers\ServiceProvider`. |
| **laravel‑magento** | Tích hợp Magento API (OAuth 1.0). | laravel‑core, guzzlehttp/guzzle, guzzlehttp/oauth‑subscriber | Service provider `MagentoServiceProvider`, client `MagentoClient`. |
| **laravel‑ronaldjack** | SDK Ronald Jack cho Laravel. | (none) | Các class giao tiếp với Ronald Jack API. |
| **laravel‑scavenger** | Web scraper tích hợp. | ext‑iconv, ext‑json, ext‑dom | Cung cấp scraper engine với hỗ trợ charset tiếng Việt. |
| **laravel‑simba** | Tích hợp với hệ thống Simba. | php‑charset, laravel‑core, laravel‑eloquent‑composite | Cung cấp model, service để đồng bộ dữ liệu Simba. |
| **laravel‑support** | Các utility hỗ trợ developer. | php‑charset, laravel‑core | Các helper, macros, service hỗ trợ. |
| **php‑charset** | Chuyển đổi charset tiếng Việt (kế thừa từ `kenny‑ngo/vietnamese‑converter`). | (none) | Cung cấp hàm `vn_to_ascii()`, `vn_to_utf8()`, … |

## Quan hệ phụ thuộc (dependency graph)

```
laravel‑catalog
├── laravel‑core
├── laravel‑currency
├── laravel‑log
├── laravel‑magento
├── laravel‑ronaldjack
├── laravel‑simba
└── php‑charset

laravel‑simba
├── php‑charset
├── laravel‑core
└── laravel‑eloquent‑composite

laravel‑magento
└── laravel‑core

laravel‑support
├── php‑charset
└── laravel‑core

laravel‑catalog, laravel‑simba, laravel‑support, laravel‑magento đều phụ thuộc vào laravel‑core.
```

## Auto‑discovery (do laravel‑core cung cấp)

Package `laravel‑core` tự động phát hiện và đăng ký:

1.  **Commands:** Tìm tất cả class kế thừa `Illuminate\Console\Command` trong thư mục `Commands` của mỗi package.
2.  **Livewire components:** Tìm class trong `Http\Livewire` và đăng ký với tên `<package>::<component‑name>`.
3.  **Blade components:** Tìm class trong `View\Components` và file `.blade.php` trong `resources/views/components`.
4.  **Service providers:** Mỗi package có một service provider chính (khai báo trong `composer.json` → `extra.laravel.providers`).

## Cách thêm package mới

1.  Tạo thư mục `diepxuan/laravel‑<tên>` với cấu trúc chuẩn.
2.  Viết `composer.json` với `name: "diepxuan/laravel‑<tên>"`, khai báo dependencies nếu có.
3.  Thêm `extra.laravel.providers` nếu package cung cấp service provider.
4.  Chạy `composer dump‑autoload` từ root project để symlink.

## Lưu ý

-   **Không sửa trực tiếp code trong `vendor/diepxuan/`** – đó là symlink, hãy sửa trong `diepxuan/`.
-   **Sau khi sửa file trong `diepxuan/`**, luôn chạy `composer dump‑autoload` từ root.
-   **Commit message** nên bắt đầu bằng tên package: `<package>: mô tả thay đổi`.

---
*Tài liệu này được cập nhật dựa trên code hiện tại (2026‑02‑11).*