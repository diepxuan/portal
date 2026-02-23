# ⚠️ IMPORTANT NAMESPACE NOTE - LARAVEL-RONALDJACK PACKAGE

## CASE SENSITIVITY WARNING

### 🚨 **MUST USE `Diepxuan\RonaldJack` (with capital J)**

**WRONG (will break the system):**
```php
namespace Diepxuan\Ronaldjack;  // ❌ WRONG! lowercase 'j'
```

**CORRECT (must use this):**
```php
namespace Diepxuan\RonaldJack;  // ✅ CORRECT! capital 'J'
```

## Package Details

```
Package Name:    diepxuan/laravel-ronaldjack
Config Key:      ronaldjack
Config File:     config/ronaldjack.php
Config Value:    'namespace' => 'Diepxuan\RonaldJack'
Actual Code:     Uses 'Diepxuan\RonaldJack' namespace
```

## Why Case Sensitivity Matters

### 1. **PHP Namespace Rules**
- PHP namespaces are **case-sensitive**
- `Ronaldjack` ≠ `RonaldJack` (different namespaces)
- Autoloading will fail with wrong case

### 2. **Core Package System**
- `Package::getCommands('ronaldjack')` looks for: `Diepxuan\RonaldJack\Commands\*`
- `config('ronaldjack.namespace')` returns: `Diepxuan\RonaldJack`
- Wrong case = commands not found

### 3. **Existing Codebase**
- Source files use `Diepxuan\RonaldJack` (PascalCase)
- Config must match exactly

## Current Structure

```
diepxuan/laravel-ronaldjack/
├── src/
│   ├── Http/
│   │   └── Controllers/
│   │       └── RonaldJackController.php
│   │           └── namespace Diepxuan\RonaldJack\Http\Controllers
│   └── Models/
│       └── Machine.php
│           └── namespace Diepxuan\RonaldJack\Models
├── config/
│   └── ronaldjack.php
│       └── 'namespace' => 'Diepxuan\RonaldJack'
└── (other files)
```

## Verification Commands

### Check Config Namespace:
```bash
php -r "require 'vendor/autoload.php'; \$app = require 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); echo 'ronaldjack.namespace: ' . config('ronaldjack.namespace');"
# Should output: ronaldjack.namespace: Diepxuan\RonaldJack
```

### Check Code Namespace:
```bash
grep -r "^namespace" diepxuan/laravel-ronaldjack/src/ --include="*.php"
# Should show: namespace Diepxuan\RonaldJack\...
```

### Test Package System:
```bash
php test_config_loading.php
# Should show config loaded successfully for 'ronaldjack'
```

## Common Mistakes to Avoid

1. **❌ Assuming lowercase from package name**
   - Package: `laravel-ronaldjack` (all lowercase in composer)
   - Namespace: `Diepxuan\RonaldJack` (PascalCase in code)

2. **❌ Inconsistent casing**
   - Wrong: `Diepxuan\Ronaldjack`, `Diepxuan\RONALDJACK`, `Diepxuan\Ronaldjack`
   - Correct: `Diepxuan\RonaldJack` (exactly this)

3. **❌ Auto-generated namespaces**
   - Tools may generate wrong case
   - Always verify against existing code

## When Adding New Files

**ALWAYS use this template:**
```php
<?php

declare(strict_types=1);

namespace Diepxuan\RonaldJack;  // ← MUST USE capital 'J'

// Your code here
```

## Related Documentation

- See main documentation: `PACKAGE_NAMESPACE_CONVENTIONS.md`
- Core package system: `CORE_PACKAGE_LOADING_DOCS.md`

---

**IMPORTANT**: PHP namespaces are case-sensitive. Using `Ronaldjack` instead of `RonaldJack` will cause "Class not found" errors and break the package system.