# CORE PACKAGE LOADING SYSTEM - DOCUMENTATION

## 🎯 Tổng quan

Hệ thống `Diepxuan\Core` cung cấp cơ chế auto-discovery và auto-registration cho tất cả packages trong hệ thống. Tài liệu này giải thích cách hệ thống hoạt động để tránh phá hủy core khi thực hiện changes.

## 📁 CẤU TRÚC PACKAGE

Mỗi package trong hệ thống phải có cấu trúc sau:

```
diepxuan/laravel-{package-name}/
├── src/
│   ├── Commands/          # Artisan commands (auto-registered)
│   ├── Providers/         # Service providers
│   └── ...                # Other source code
├── config/
│   └── {package-name}.php # Package configuration (NEW CONVENTION)
│   └── config.php         # Legacy (backward compatibility)
└── composer.json
```

## 🔧 CORE COMPONENTS

### 1. `Package` Model (`Diepxuan\Core\Models\Package`)

#### `Package::list()`
- Lấy danh sách tất cả diepxuan packages từ Composer
- Map package name thành code (e.g., `diepxuan/laravel-catalog` → `catalog`)

#### `Package::getCommands($code)`
- **QUAN TRỌNG**: Gọi `config("{$code}.namespace")` và `config("{$code}.name")`
- Config key phải match package code
- Tự động scan và register tất cả commands trong thư mục `Commands`

### 2. `ConfigServiceProvider` (`Diepxuan\Core\Providers\ConfigServiceProvider`)

#### Cách hoạt động:
1. **Tìm config file**: Ưu tiên `{code}.php`, fallback `config.php`
2. **Merge config**: `mergeConfigFrom($configFile, $code)` - config key = package code
3. **Publish config**: `config_path($code . '.php')` - publish với tên package code

#### Code mẫu:
```php
Package::list()->map(function (string $package, string $code): void {
    // NEW: Try {code}.php first
    $configFile = Package::path($package, "/config/{$code}.php");
    
    // Legacy: Fallback to config.php
    if (!file_exists($configFile)) {
        $configFile = Package::path($package, '/config/config.php');
    }
    
    if (file_exists($configFile)) {
        $this->mergeConfigFrom($configFile, $code);
    }
});
```

### 3. `ServiceProvider` (`Diepxuan\Core\Providers\ServiceProvider`)

#### Auto-command registration:
```php
protected function registerCommands()
{
    Package::list()->map(function (string $package, string $code) {
        return Package::getCommands($code); // ← Config key = $code
    })->flatten()->filter()->toArray();
}
```

## ⚠️ QUY TẮC QUAN TRỌNG (KHÔNG ĐƯỢC VI PHẠM)

### 1. **CONFIG FILE NAMING**
- **NEW**: `{package-code}.php` (e.g., `catalog.php`, `support.php`)
- **Legacy**: `config.php` (backward compatibility)
- **Config key**: Phải match package code từ `Package::list()`

### 2. **CONFIG CONTENT**
```php
// config/{package-code}.php
return [
    'name'      => 'diepxuan/laravel-{package-name}', // Full package name
    'namespace' => 'Diepxuan\\{StudlyCase}',          // String, NOT Class::class
];
```

### 3. **KHÔNG MANUAL COMMAND REGISTRATION**
- **ĐÚNG**: Dùng auto-discovery qua `Package::getCommands()`
- **SAI**: `$this->commands([...])` trong ServiceProvider (gây duplicate)

### 4. **SERVICE PROVIDER REGISTRATION**
- Package ServiceProvider phải được register trong `composer.json`
- Core sẽ auto-load tất cả ServiceProviders

## 🚨 CÁC LỖI THƯỜNG GẶP VÀ CÁCH FIX

### Lỗi 1: "Class not found" khi config dùng `Class::class`
**Triệu chứng**: `Class "Diepxuan\Support" not found`
**Nguyên nhân**: Laravel cố load class trước khi config ready
**Fix**: Dùng string `'Diepxuan\\Support'` thay vì `Support::class`

### Lỗi 2: Commands không được register
**Triệu chứng**: `php artisan` không hiển thị commands
**Nguyên nhân**: Config key không match package code
**Fix**: Đảm bảo `config('{code}.namespace')` tồn tại

### Lỗi 3: Duplicate command registration
**Triệu chứng**: Lỗi "Command already registered"
**Nguyên nhân**: Manual `$this->commands()` + auto-discovery
**Fix**: Xóa manual registration, chỉ dùng auto-discovery

### Lỗi 4: Config không được load
**Triệu chứng**: `config('catalog.namespace')` trả về null
**Nguyên nhân**: Config file không tồn tại hoặc sai tên
**Fix**: Đảm bảo file `config/{code}.php` tồn tại

## 🔄 WORKFLOW KHI THÊM PACKAGE MỚI

1. **Tạo package structure** đúng convention
2. **Tạo config file**: `config/{package-code}.php`
3. **Định nghĩa namespace**: String format, không dùng `Class::class`
4. **Tạo commands**: Trong `src/Commands/` - sẽ auto-registered
5. **KHÔNG** manual register commands trong ServiceProvider
6. **Test**: `php artisan` phải hiển thị commands mới

## 📝 TESTING CORE FUNCTIONALITY

### Test 1: Package listing
```bash
php -r "require 'vendor/autoload.php'; use Diepxuan\Core\Models\Package; print_r(Package::list()->toArray());"
```

### Test 2: Config loading
```bash
php artisan tinker
>>> config('catalog.namespace') // Should return 'Diepxuan\Catalog'
>>> config('support.namespace') // Should return 'Diepxuan\Support'
```

### Test 3: Command registration
```bash
php artisan | grep -i "catalog\|support"  # Should show package commands
```

## 🏗️ ARCHITECTURE OVERVIEW

```
┌─────────────────────────────────────────────────────────────┐
│                    Laravel Application                      │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────┐  │
│  │   Package    │◄───│ ConfigService│◄───│   Service    │  │
│  │    Model     │    │   Provider   │    │   Provider   │  │
│  └──────────────┘    └──────────────┘    └──────────────┘  │
│         │                         │               │        │
│         ▼                         ▼               ▼        │
│  ┌──────────────┐    ┌────────────────────┐ ┌──────────┐  │
│  │  Composer    │    │  Package Configs   │ │ Commands │  │
│  │   Packages   │    │  {code}.php files  │ │ Auto-reg │  │
│  └──────────────┘    └────────────────────┘ └──────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## ✅ CHECKLIST TRƯỚC KHI THAY ĐỔI CORE

- [ ] Hiểu rõ `Package::list()` mapping
- [ ] Đảm bảo config file naming đúng convention
- [ ] Test config loading với `config('{code}.namespace')`
- [ ] Verify command auto-registration
- [ ] Kiểm tra backward compatibility
- [ ] Update documentation nếu cần

## 🆘 KHI GẶP VẤN ĐỀ

1. **Debug config loading**: Check `ConfigServiceProvider` logic
2. **Verify package code**: `Package::list()` mapping
3. **Check file names**: `{code}.php` vs `config.php`
4. **Test in isolation**: Tạo test script đơn giản
5. **Consult this doc**: Đảm bảo tuân thủ tất cả rules

---

**Lưu ý quan trọng**: Hệ thống này là nền tảng của toàn bộ application. Mọi thay đổi phải được test kỹ và đảm bảo backward compatibility.