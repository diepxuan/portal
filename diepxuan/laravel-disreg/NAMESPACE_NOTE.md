# ⚠️ IMPORTANT NAMESPACE NOTE - LARAVEL-DISREG PACKAGE

## CRITICAL INFORMATION FOR AI AGENTS

### 🚨 **DO NOT USE `Diepxuan\Disreg`**

**WRONG (will break the system):**
```php
namespace Diepxuan\Disreg;  // ❌ WRONG!
```

**CORRECT (must use this):**
```php
namespace Diepxuan\DisableRegistration;  // ✅ CORRECT!
```

## Package Details

```
Package Name:    diepxuan/laravel-disreg
Config Key:      disreg
Config File:     config/disreg.php
Config Value:    'namespace' => 'Diepxuan\DisableRegistration'
Actual Code:     Uses 'Diepxuan\DisableRegistration' namespace
```

## Why This Matters

### 1. **Core Package System Dependency**
- `Package::getCommands('disreg')` looks for: `Diepxuan\DisableRegistration\Commands\*`
- `config('disreg.namespace')` must return: `Diepxuan\DisableRegistration`
- Auto-discovery depends on this exact namespace

### 2. **Existing Codebase**
- All source files already use `Diepxuan\DisableRegistration`
- Changing to `Diepxuan\Disreg` would require refactoring all files
- Would break backward compatibility

### 3. **Descriptive Name**
- `DisableRegistration` is more descriptive than `Disreg`
- Matches the package's purpose (disable user registration)

## Current Structure

```
diepxuan/laravel-disreg/
├── src/
│   ├── Http/
│   │   └── Middleware/
│   │       └── DisableRegistrationMiddleware.php
│   │           └── namespace Diepxuan\DisableRegistration\Http\Middleware
│   └── Providers/
│       └── DisableRegistrationServiceProvider.php
│           └── namespace Diepxuan\DisableRegistration\Providers
├── config/
│   └── disreg.php
│       └── 'namespace' => 'Diepxuan\DisableRegistration'
└── routes/
    └── disable_registration.php
```

## Verification Commands

### Check Config Namespace:
```bash
php -r "require 'vendor/autoload.php'; \$app = require 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); echo 'disreg.namespace: ' . config('disreg.namespace');"
# Should output: disreg.namespace: Diepxuan\DisableRegistration
```

### Check Code Namespace:
```bash
grep -r "^namespace" diepxuan/laravel-disreg/src/ --include="*.php"
# Should show: namespace Diepxuan\DisableRegistration\...
```

### Test Package System:
```bash
php test_config_loading.php
# Should show config loaded successfully for 'disreg'
```

## Common Mistakes to Avoid

1. **❌ Assuming package name = namespace**
   - Package: `laravel-disreg` ≠ Namespace: `Disreg`
   - Correct: `DisableRegistration`

2. **❌ Using shorthand**
   - Wrong: `Diepxuan\Disreg`
   - Correct: `Diepxuan\DisableRegistration`

3. **❌ Case mismatch**
   - Wrong: `Diepxuan\Disableregistration`
   - Correct: `Diepxuan\DisableRegistration` (PascalCase)

## When Adding New Files

**ALWAYS use this template:**
```php
<?php

declare(strict_types=1);

namespace Diepxuan\DisableRegistration;  // ← MUST USE THIS

// Your code here
```

## Related Documentation

- See main documentation: `PACKAGE_NAMESPACE_CONVENTIONS.md`
- Core package system: `CORE_PACKAGE_LOADING_DOCS.md`

---

**IMPORTANT**: Any AI agent working on this package MUST read this file first. Using the wrong namespace will break the entire package loading system.