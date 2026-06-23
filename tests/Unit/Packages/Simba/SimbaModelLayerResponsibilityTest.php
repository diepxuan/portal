<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 *
 * @lastupdate 2026-06-22
 */

namespace Tests\Unit\Packages\Simba;

use Tests\TestCase;

/**
 * Bảo vệ ranh giới 3 lớp của gói laravel-simba.
 *
 * Lớp 1: SModel (Diepxuan\Simba\SModel\<XxxModel>)
 *         - Chỉ chứa raw schema mapping (table, fillable, casts, primaryKey, PRIMARY_KEY_COLUMNS, ...).
 *         - KHÔNG được phép scope, relation, accessor, mutator, method nghiệp vụ, override booted() / parent::boot().
 *
 * Lớp 2: Simba Models (Diepxuan\Simba\Models\<Xxx>)
 *         - Kế thừa SModel, bổ sung scope helper query, relation Simba-Simba, stored procedure wrapper.
 *         - KHÔNG được phép method thuần business (getReceiptRate, getInventoryValue, resxByLanguage, ...).
 *         - KHÔNG được có 2 method trùng tên (do shadow cùng tên với concern).
 *
 * Lớp 3: Catalog Models (Diepxuan\Catalog\Models\<Xxx>)
 *         - Kế thừa Simba Model, bổ sung business logic, concern nghiệp vụ.
 *         - KHÔNG được khai báo $table / $connection / $primaryKey / $fillable trực tiếp
 *           (vì phải dùng schema từ SModel cha).
 *         - KHÔNG được override booted() với parent::boot() (SModel base không dùng booted lifecycle để set connection).
 */
final class SimbaModelLayerResponsibilityTest extends TestCase
{
    private const SMODEL_DIR    = __DIR__ . '/../../../../diepxuan/laravel-simba/src/SModel';
    private const SIMBA_DIR     = __DIR__ . '/../../../../diepxuan/laravel-simba/src/Models';
    private const CATALOG_DIR   = __DIR__ . '/../../../../diepxuan/laravel-catalog/src/Models';

    /**
     * Whitelist method từ concern nghiệp vụ không được phép xuất hiện ở Simba Models.
     * (Đã chuyển sang Catalog concerns trong PR #222.)
     */
    private const CATALOG_BUSINESS_METHODS = [
        'getInventoryByProduct',
        'getInventoryList',
        'getInventoryValue',
        'getTotalPurchaseByProduct',
        'getTotalQuantityByProduct',
        'getTotalPurchaseBySupplier',
        'getReceiptRate',
        'getPORptMH01',
        'getPORptDH01',
        'getPORptNH01',
        'getTotalRevenueByProduct',
        'getTotalRevenueBySalesperson',
        'getSORptBH01',
        'getSORptDT01',
        'getSORptSL01',
        'resxByLanguage',
        'laKhachHang',
        'laNhaCungCap',
        'laNhanVien',
        'isKhachHang',
        'isNhaCungCap',
        'isNhanVien',
    ];

    /**
     * Catalog Models được phép khai báo DB metadata khi cần cho lý do đặc biệt:
     * - Zsysmenu, System, SystemConfig, UserLink: alias/subclass pattern.
     * - Params: utility bảng không có SModel.
     * - User: extend App\Models\User (Laravel auth).
     * - InDmNhvt: $casts với custom Cast class CategoryMagento (nghiệp vụ).
     */
    private const CATALOG_DB_METADATA_WHITELIST = [
        'Zsysmenu'   => ['table'],          // cùng schema SysMenu, bảng khác
        'System'     => [],                 // không khai báo metadata; extends SysCompany
        'SystemConfig' => [],               // extends SiSetup
        'UserLink'   => ['fillable'],       // simple utility table
        'User'       => [],                 // extends App\Models\User
        'Params'     => ['incrementing', 'timestamps', 'guarded'], // utility
        'InDmNhvt'   => ['casts'],          // custom cast CategoryMagento
    ];

    /**
     * Catalog Models được phép extend không theo Simba\Models:
     * - App\Models\User (Laravel auth) - User.
     * - Illuminate\Database\Eloquent\Model - Params, AbstractModel.
     * - Catalog\Models (subclass catalog alias) - System, SystemConfig, Zsysmenu, UserLink.
     *
     * Lưu ý: CaCt2/CaPh2/CaPh3 trước đây whitelist SModel vì chưa có Simba Model
     * tương ứng; từ PR này cả 3 đã chuyển sang extends Diepxuan\Simba\Models\*.
     */
    private const CATALOG_EXTENDS_WHITELIST = [
        'Params'      => 'Illuminate\\Database\\Eloquent\\Model',
        'User'        => 'App\\Models\\User',
        'System'      => 'Diepxuan\\Catalog\\Models\\Simba\\SysCompany',
        'SystemConfig'=> 'Diepxuan\\Catalog\\Models\\Simba\\SiSetup',
        'UserLink'    => 'Diepxuan\\Catalog\\Models\\AbstractModel',
        'Zsysmenu'    => 'Diepxuan\\Catalog\\Models\\Simba\\SysMenu',
    ];

    /**
     * SModel generated không được có behavior (scope, relation, accessor, mutator, business method).
     */
    public function testSModelGeneratedClassesHaveNoBehavior(): void
    {
        $files = glob(self::SMODEL_DIR . '/*Model.php') ?: [];
        self::assertGreaterThan(100, count($files), 'SModel directory phải có file generated');

        $violations = [];
        foreach ($files as $file) {
            $shortName = basename($file, '.php');
            if ($shortName === 'SModel') {
                continue; // base SModel, không phải generated
            }
            $class     = $this->resolveClass('Diepxuan\\Simba\\SModel', $shortName);
            if ($class === null) {
                continue;
            }
            $reflection = new \ReflectionClass($class);
            if ($reflection->isAbstract() || $reflection->isInterface() || $reflection->isTrait()) {
                continue;
            }
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $declaring = $method->getDeclaringClass()->getName();
                if ($declaring !== $class) {
                    continue; // inherited từ SModel/Model bỏ qua
                }
                $name = $method->getName();
                if (str_starts_with($name, 'scope')) {
                    $violations[] = "SModel/{$shortName}: scope{$this->stripScope($name)}() không được phép";
                    continue;
                }
                if ($this->isRelationMethod($method)) {
                    $violations[] = "SModel/{$shortName}: relation method {$name}() không được phép";
                    continue;
                }
                if (str_starts_with($name, 'get') || str_starts_with($name, 'set')) {
                    $violations[] = "SModel/{$shortName}: accessor/mutator {$name}() không được phép";
                    continue;
                }
                if ($name === 'booted') {
                    $violations[] = "SModel/{$shortName}: override booted() không được phép";
                    continue;
                }
                if ($this->isSchemaDeclaration($name)) {
                    continue;
                }
                $violations[] = "SModel/{$shortName}: method {$name}() không được phép";
            }
        }

        self::assertSame([], $violations, "SModel vi phạm ranh giới:\n" . implode("\n", $violations));
    }

    /**
     * SModel generated không được gọi parent::boot() / parent::initializeTraits().
     */
    public function testSModelClassesDoNotCallParentBoot(): void
    {
        $files = glob(self::SMODEL_DIR . '/*Model.php') ?: [];
        $violations = [];
        foreach ($files as $file) {
            if (basename($file) === 'SModel.php') {
                continue;
            }
            $content = file_get_contents($file);
            if ($content === false) {
                continue;
            }
            if (preg_match('/parent\s*::\s*boot\s*\(/', $content) === 1) {
                $violations[] = basename($file) . ': gọi parent::boot() không được phép trong SModel';
            }
        }
        self::assertSame([], $violations, "SModel vi phạm parent::boot:\n" . implode("\n", $violations));
    }

    /**
     * Simba Models không được chứa method business đã chuyển sang catalog.
     */
    public function testSimbaModelsDoNotExposeBusinessMethods(): void
    {
        $files = glob(self::SIMBA_DIR . '/*.php') ?: [];
        self::assertGreaterThan(100, count($files), 'Simba Models directory phải có file');

        $violations = [];
        foreach ($files as $file) {
            $shortName = basename($file, '.php');
            $class     = $this->resolveClass('Diepxuan\\Simba\\Models', $shortName);
            if ($class === null) {
                continue;
            }
            $reflection = new \ReflectionClass($class);
            if ($reflection->isAbstract() || $reflection->isInterface() || $reflection->isTrait()) {
                continue;
            }
            foreach (self::CATALOG_BUSINESS_METHODS as $bizMethod) {
                if ($reflection->hasMethod($bizMethod)) {
                    $method = $reflection->getMethod($bizMethod);
                    if ($method->getDeclaringClass()->getName() === $class) {
                        $violations[] = "Simba\\Models\\{$shortName}: method {$bizMethod}() đã được move_catalog";
                    }
                }
            }
        }

        self::assertSame([], $violations, "Simba\\Models chứa business method cấm:\n" . implode("\n", $violations));
    }

    /**
     * Simba Models có thể có scope/relation nhưng KHÔNG được gọi parent::boot() trong booted().
     */
    public function testSimbaModelsBootedDoesNotCallParentBoot(): void
    {
        $files = glob(self::SIMBA_DIR . '/*.php') ?: [];
        $violations = [];
        foreach ($files as $file) {
            $content = file_get_contents($file);
            if ($content === false) {
                continue;
            }
            if (preg_match('/static\s+function\s+booted\b[^{]*\{[^}]*parent\s*::\s*boot\s*\(/s', $content) === 1) {
                $violations[] = basename($file) . ': booted() gọi parent::boot() không cần thiết';
            }
        }
        self::assertSame([], $violations, "Simba\\Models booted() vi phạm:\n" . implode("\n", $violations));
    }

    /**
     * Catalog Models không được khai báo $table / $connection / $primaryKey trực tiếp.
     * Phải dùng schema từ SModel cha.
     */
    public function testCatalogModelsDoNotRedefineDbMetadata(): void
    {
        $files = glob(self::CATALOG_DIR . '/*.php') ?: [];
        $violations = [];
        foreach ($files as $file) {
            $shortName = basename($file, '.php');
            $class     = $this->resolveClass('Diepxuan\\Catalog\\Models', $shortName);
            if ($class === null) {
                continue;
            }
            $reflection = new \ReflectionClass($class);
            if ($reflection->isAbstract() || $reflection->isInterface() || $reflection->isTrait()) {
                continue;
            }
            // Bỏ qua Concerns — không phải Model.
            if (str_contains($class, '\\Concerns\\')) {
                continue;
            }
            $whitelistedProps = self::CATALOG_DB_METADATA_WHITELIST[$shortName] ?? [];
            foreach (['table', 'connection', 'primaryKey', 'keyType', 'incrementing', 'timestamps', 'guarded', 'fillable', 'hidden', 'casts', 'attributes'] as $prop) {
                if (in_array($prop, $whitelistedProps, true)) {
                    continue;
                }
                if ($reflection->hasProperty($prop)) {
                    $declaring = $reflection->getProperty($prop)->getDeclaringClass()->getName();
                    if ($declaring === $class) {
                        $violations[] = "Catalog\\Models\\{$shortName}: \$" . $prop . ' phải khai báo ở SModel cha';
                    }
                }
            }
        }
        self::assertSame([], $violations, "Catalog\\Models khai báo DB metadata trực tiếp:\n" . implode("\n", $violations));
    }

    /**
     * Catalog Models không được override booted() gọi parent::boot() (vì SModel base dùng __construct, không booted).
     */
    public function testCatalogModelsBootedDoesNotCallParentBoot(): void
    {
        $files = glob(self::CATALOG_DIR . '/*.php') ?: [];
        $violations = [];
        foreach ($files as $file) {
            $content = file_get_contents($file);
            if ($content === false) {
                continue;
            }
            if (preg_match('/static\s+function\s+booted\b[^{]*\{[^}]*parent\s*::\s*boot\s*\(/s', $content) === 1) {
                $violations[] = basename($file) . ': booted() gọi parent::boot() không cần thiết';
            }
        }
        self::assertSame([], $violations, "Catalog\\Models booted() vi phạm:\n" . implode("\n", $violations));
    }

    /**
     * Mỗi Catalog Model phải extends một Simba Model (tránh định nghĩa lại schema).
     */
    public function testCatalogModelsExtendSimbaModel(): void
    {
        $files = glob(self::CATALOG_DIR . '/*.php') ?: [];
        $violations = [];
        foreach ($files as $file) {
            $shortName = basename($file, '.php');
            $class     = $this->resolveClass('Diepxuan\\Catalog\\Models', $shortName);
            if ($class === null) {
                continue;
            }
            $reflection = new \ReflectionClass($class);
            if ($reflection->isAbstract() || $reflection->isInterface() || $reflection->isTrait()) {
                continue;
            }
            $parent = $reflection->getParentClass();
            if ($parent === false) {
                $violations[] = "Catalog\\Models\\{$shortName}: không có parent class";
                continue;
            }
            $parentName = $parent->getName();
            $expectedParent = self::CATALOG_EXTENDS_WHITELIST[$shortName] ?? null;
            if ($expectedParent !== null) {
                if ($parentName === $expectedParent) {
                    continue;
                }
                $violations[] = "Catalog\\Models\\{$shortName}: parent {$parentName} phải là {$expectedParent}";
                continue;
            }
            if (str_starts_with($parentName, 'Diepxuan\\Simba\\Models\\')) {
                continue;
            }
            $violations[] = "Catalog\\Models\\{$shortName}: parent {$parentName} không thuộc Diepxuan\\Simba\\Models";
        }
        self::assertSame([], $violations, "Catalog\\Models extend sai:\n" . implode("\n", $violations));
    }

    /**
     * Catalog Model không được extends trực tiếp `Diepxuan\Simba\SModel\*` -
     * phải đi qua lớp `Simba\Models\*` (lớp 2).
     *
     * Lý do: SModel là raw schema mapping; Catalog phải dùng Simba Model để
     * thừa hưởng helper/composite-key trait.
     */
    public function testCatalogModelsDoNotExtendSModelDirectly(): void
    {
        $files = glob(self::CATALOG_DIR . '/*.php') ?: [];
        $violations = [];
        foreach ($files as $file) {
            $shortName = basename($file, '.php');
            $class     = $this->resolveClass('Diepxuan\\Catalog\\Models', $shortName);
            if ($class === null) {
                continue;
            }
            $reflection = new \ReflectionClass($class);
            if ($reflection->isAbstract() || $reflection->isInterface() || $reflection->isTrait()) {
                continue;
            }
            $parent = $reflection->getParentClass();
            if ($parent === false) {
                continue;
            }
            $parentName = $parent->getName();
            if (str_starts_with($parentName, 'Diepxuan\\Simba\\SModel\\')) {
                $violations[] = "Catalog\\Models\\{$shortName}: extends {$parentName} trực tiếp - phải đi qua Diepxuan\\Simba\\Models\\*";
            }
        }
        self::assertSame([], $violations, "Catalog\\Models extends SModel trực tiếp:\n" . implode("\n", $violations));
    }

    private function resolveClass(string $namespace, string $shortName): ?string
    {
        $class = $namespace . '\\' . $shortName;
        return class_exists($class) ? $class : null;
    }

    private function isRelationMethod(\ReflectionMethod $method): bool
    {
        $returnType = (string) $method->getReturnType();
        if ($returnType === '') {
            return false;
        }
        return str_contains($returnType, 'Relations\\');
    }

    private function stripScope(string $name): string
    {
        return substr($name, 5);
    }

    private function isSchemaDeclaration(string $name): bool
    {
        static $schemaMethods = [
            'casts', 'getTable', 'getKeyName', 'getConnectionName',
            'getKeyType', 'getIncrementing', 'getDates', 'getCasts',
            'getPrimaryKey', 'getForeignKey',
        ];
        return in_array($name, $schemaMethods, true);
    }
}