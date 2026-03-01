# Code Style & Formatting

## Overview

This project uses **PHP-CS-Fixer** to maintain consistent code style across all PHP files. The configuration is centralized and automatically synchronized from a remote source.

## Configuration

- **Main config**: `.php-cs-fixer.dist.php` (caches remote config)
- **Cache file**: `.php-cs-fixer.cache.php` (auto-updated daily)
- **Remote source**: https://raw.githubusercontent.com/diepxuan/php/main/.php-cs-fixer.dist.php

## Usage

### Via Artisan Command

```bash
# Format all PHP files in project
php artisan code:format

# Format specific paths
php artisan code:format app/Models app/Http

# Dry run (show what would be changed)
php artisan code:format --dry-run

# Show diff of changes
php artisan code:format --diff

# Disable cache
php artisan code:format --no-cache
```

### Via Portal Development Manager

```bash
# Format all code
./portal-dev.sh format

# With options
./portal-dev.sh format --dry-run --diff
```

### Direct PHP-CS-Fixer

```bash
# Using vendor binary
./vendor/bin/php-cs-fixer fix

# With specific config
./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

## Integration with Development Workflow

### Before Committing

Always run code formatting before committing:

```bash
./portal-dev.sh format
```

Or add to your pre-commit hook (see below).

### CI/CD Integration

The formatting check can be integrated into CI pipelines:

```yaml
# Example GitHub Actions step
- name: Check code style
  run: ./vendor/bin/php-cs-fixer fix --dry-run --diff
```

## Git Hooks (Optional)

### Pre-commit Hook

Create `.git/hooks/pre-commit`:

```bash
#!/bin/bash
echo "Running PHP-CS-Fixer..."
./vendor/bin/php-cs-fixer fix --quiet
git add -u
```

Make it executable:
```bash
chmod +x .git/hooks/pre-commit
```

### Using Husky (if using npm)

```bash
npm install --save-dev husky
npx husky add .husky/pre-commit "./vendor/bin/php-cs-fixer fix --quiet && git add -u"
```

## Rules Applied

The configuration includes:

- **@PHP74Migration** - PHP 7.4 compatibility rules
- **@PhpCsFixer** - Standard PHP-CS-Fixer rules
- **@PHPUnit100Migration:risky** - PHPUnit 10.0 migration rules
- **header_comment** - Copyright and author header
- **strict_types** declaration enforcement
- And many more style fixes

## Customizing Rules

To customize rules for a specific package, create a `.php-cs-fixer.dist.php` in that package directory. Example for `laravel-catalog`:

```php
<?php

declare(strict_types=1);

$config = require __DIR__ . '/../../.php-cs-fixer.dist.php';

// Override specific rules
$config->setRules(array_merge($config->getRules(), [
    'some_rule' => false,
]));

return $config;
```

## Troubleshooting

### Cache Issues

If formatting seems outdated:

```bash
# Clear cache
rm .php-cs-fixer.cache.php

# Force refresh
php artisan code:format --no-cache
```

### Permission Issues

Ensure PHP-CS-Fixer binary is executable:

```bash
chmod +x vendor/bin/php-cs-fixer
```

### Configuration Conflicts

If a package has its own `.php-cs-fixer.dist.php`, it will override the root config for files in that package. Check for nested config files.

## Best Practices

1. **Run before commits** - Ensure consistent style in repository
2. **Use dry-run in CI** - Catch formatting issues early
3. **Update cache regularly** - Config updates daily automatically
4. **Document custom rules** - If overriding, explain why

## Related Documentation

- [PHP-CS-Fixer Documentation](https://cs.symfony.com/)
- [Development Workflow](DEVELOPMENT.md)
- [Contributing Guidelines](CONTRIBUTING.md)
