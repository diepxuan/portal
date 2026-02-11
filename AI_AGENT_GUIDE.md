# Hướng dẫn AI Agent cho dự án Portal

Mục đích: tài liệu này cung cấp hướng dẫn ngắn gọn, chính xác cho **AI agents** khi làm việc trên toàn bộ repository `diepxuan/portal`. Mọi AI cần tuân thủ nghiêm ngặt các quy tắc dưới đây.

---

## 1. Phạm vi công việc (BẮT BUỘC)

- **CHỈ** được tạo mới hoặc chỉnh sửa file trong `diepxuan/` và các thư mục con của `diepxuan/`.
- **KHÔNG** được sửa bất kỳ file nào ngoài phạm vi này, bao gồm nhưng không giới hạn: `app/`, `routes/`, `config/`, `database/`, `.github/`, `resources/`, v.v.
- Chỉ được sửa ngoài phạm vi khi có chỉ dẫn rõ ràng bằng văn bản từ người dùng.
- Nếu yêu cầu nằm ngoài phạm vi `diepxuan/`, AI phải dừng lại và báo lại thay vì tự ý sửa.

## 2. Ngữ cảnh nhanh

- **Portal** là ứng dụng Laravel chính (framework version 11+).
- **Thư mục `diepxuan/`** chứa **14 package Laravel nội bộ** được quản lý qua Composer `path` repositories (symlink). Các package này cung cấp chức năng module hóa cho hệ thống.
- **Thay đổi trong `diepxuan/*`** ảnh hưởng trực tiếp đến ứng dụng chính vì autoload sử dụng symlink.

## 3. Quy trình Git bắt buộc

**Mọi thay đổi code phải tuân thủ quy trình sau:**

### 3.1. Trước khi bắt đầu
- Luôn pull branch `main` mới nhất:
  ```bash
  git checkout main
  git pull origin main
  ```

### 3.2. Tạo branch
- **Tên branch phải theo mẫu:** `task/<tên-task-ngắn-gọn>` (viết thường, phân cách bằng dấu gạch ngang).
- Ví dụ:
  ```bash
  git checkout -b task/fix-magento-api-auth
  git checkout -b task/add-catalog-import-feature
  git checkout -b task/update-core-package-discovery
  ```

### 3.3. Làm việc và commit
- Chỉ sửa file trong phạm vi được giao.
- Commit message ngắn gọn, theo cú pháp:
  ```
  <package>: mô tả thay đổi
  ```
- Ví dụ:
  ```
  laravel-catalog: thêm method import từ CSV
  laravel-core: sửa lỗi auto-discovery Livewire component
  ```

### 3.4. Push branch lên GitHub
- Sau khi commit, push branch lên remote:
  ```bash
  git push origin task/<tên-branch>
  ```

### 3.5. Tạo Pull Request (PR)
- **Luôn tạo PR từ branch task vào `main`** (không merge trực tiếp).
- Tiêu đề PR: `[<package>] Mô tả ngắn`
- Mô tả PR cần ghi rõ:
  - File nào đã sửa (chỉ đường dẫn tương đối từ root).
  - Ảnh hưởng đến package nào.
  - Cách kiểm thử (test steps).
  - Nếu ảnh hưởng đến behavior toàn hệ thống, ghi rõ các bước reproduce.

## 4. Quy trình phát triển

### 4.1. Khi sửa package trong `diepxuan/`
- Chỉ sửa code trong thư mục package tương ứng.
- Nếu thay đổi `composer.json` của package, cần chạy từ **root project**:
  ```bash
  composer dump-autoload
  ```

### 4.2. Cập nhật autoload và cache
Sau khi sửa file bất kỳ trong `diepxuan/`, từ root project chạy:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### 4.3. Test (nếu có)
- Nếu package có unit tests, chạy từ thư mục package:
  ```bash
  cd diepxuan/laravel-<tên-package>
  ../../vendor/bin/phpunit
  ```
- Hoặc chạy toàn bộ test suite từ root:
  ```bash
  php artisan test
  ```

## 5. Tiêu chuẩn mã

- **PHP:** Tuân thủ PHP ^8.2, strict types, type hints đầy đủ.
- **Coding style:** Theo PSR‑12, sử dụng Laravel Pint / PHP‑CS‑Fixer có sẵn.
- **Commit message:** Ngắn gọn, rõ ràng, bắt đầu bằng tên package.
- **Code review:** Tự review trước khi commit, đảm bảo không phá vỡ API hiện có.

## 6. Debug nhanh

Nếu thay đổi không có hiệu lực:
1. Chạy `composer dump-autoload` từ root.
2. Chạy `php artisan config:clear` và `php artisan cache:clear`.
3. Kiểm tra symlink trong `vendor/diepxuan/` đang trỏ đúng đến `diepxuan/`.
4. Xem log ở `storage/logs/laravel.log`.

## 7. Khi gặp vấn đề

- **Không chắc thay đổi có an toàn?** → Hỏi maintainers hoặc mở issue trước.
- **Phát hiện bug không liên quan đến task hiện tại?** → Ghi note trong PR description, không sửa ngoài phạm vi.
- **Cần thay đổi file ngoài `diepxuan/`?** → Phải được phép rõ ràng trong yêu cầu task.

## 8. Nguyên tắc an toàn

Khi không chắc chắn một thay đổi có an toàn hay không:

- **Không tự ý đoán** → dừng lại và xác nhận.
- **Đề xuất hỏi maintainer** hoặc mở issue trước.
- **Ưu tiên an toàn và tính ổn định** hơn tốc độ.
- **Tránh phá vỡ backward compatibility**: không thay đổi public API (tên class, namespace, interface, method signature) nếu không được phép rõ ràng.

## 9. Tóm tắt cho AI (TL;DR)

- **Chỉ làm việc trong `diepxuan/`** – không sửa file ngoài phạm vi này trừ khi được chỉ định rõ ràng.
- **Coi mỗi thư mục con là một package độc lập** với cấu trúc Laravel chuẩn.
- **Không phá public API** nếu không được phép.
- **Nhắc chạy `composer dump-autoload`** khi thay đổi liên quan autoload.
- **Không chắc thì dừng và hỏi** – an toàn trên hết.

## 10. Tổng kết quy trình AI Agent

1. **Nhận task** → hiểu rõ phạm vi, package nào cần sửa.
2. **Pull main** → `git checkout main && git pull origin main`
3. **Tạo branch** → `git checkout -b task/<tên-task>`
4. **Sửa code** → chỉ trong phạm vi được giao.
5. **Commit** → message: `<package>: mô tả`
6. **Push** → `git push origin task/<tên-task>`
7. **Tạo PR** → từ branch task vào `main`, mô tả đầy đủ.
8. **Chờ review** → không tự merge.

---

*Tài liệu này cập nhật lần cuối: 2026‑02‑11. Mọi AI agent làm việc trên repository `diepxuan/portal` phải tuân thủ các quy tắc trên.*