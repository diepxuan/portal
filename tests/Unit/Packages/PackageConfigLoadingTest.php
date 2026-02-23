<?php

namespace Tests\Unit\Packages;

use Diepxuan\Core\Models\Package;
use Tests\TestCase;

class PackageConfigLoadingTest extends TestCase
{
    /**
     * Test that all diepxuan packages can be listed.
     */
    public function test_all_diepxuan_packages_can_be_listed()
    {
        $packages = Package::list();
        
        $this->assertNotEmpty($packages, 'Package::list() should return non-empty collection');
        
        // We should have at least some diepxuan packages
        $this->assertGreaterThan(5, $packages->count(), 'Should have more than 5 diepxuan packages');
        
        // Check for specific packages we know exist
        $expectedPackages = ['catalog', 'core', 'support', 'simba'];
        
        foreach ($expectedPackages as $expectedPackage) {
            $this->assertArrayHasKey(
                $expectedPackage,
                $packages->toArray(),
                "Package '{$expectedPackage}' should be in Package::list()"
            );
        }
    }

    /**
     * Test that packages with config files have their config loaded.
     */
    public function test_packages_with_config_files_have_config_loaded()
    {
        $packagesWithConfig = ['catalog', 'core', 'disreg', 'support', 'simba', 'magento', 'log'];
        
        foreach ($packagesWithConfig as $packageCode) {
            $namespace = config("{$packageCode}.namespace");
            $name = config("{$packageCode}.name");
            
            $this->assertNotNull(
                $namespace,
                "Config key '{$packageCode}.namespace' should not be null"
            );
            
            $this->assertNotNull(
                $name,
                "Config key '{$packageCode}.name' should not be null"
            );
            
            $this->assertStringStartsWith(
                'Diepxuan\\',
                $namespace,
                "Namespace for '{$packageCode}' should start with 'Diepxuan\\'"
            );
            
            $this->assertStringContainsString(
                'diepxuan/laravel-',
                $name,
                "Name for '{$packageCode}' should contain 'diepxuan/laravel-'"
            );
        }
    }

    /**
     * Test special namespace cases.
     */
    public function test_special_namespace_cases()
    {
        // Test disreg package - uses DisableRegistration not Disreg
        $disregNamespace = config('disreg.namespace');
        $this->assertEquals('Diepxuan\DisableRegistration', $disregNamespace);
        
        // Test ronaldjack package - case sensitivity
        $ronaldjackNamespace = config('ronaldjack.namespace');
        $this->assertEquals('Diepxuan\RonaldJack', $ronaldjackNamespace);
    }

    /**
     * Test that Package::getCommands() works for packages.
     */
    public function test_package_get_commands_works()
    {
        // Test for packages that should have commands
        $packagesWithCommands = ['catalog', 'support'];
        
        foreach ($packagesWithCommands as $packageCode) {
            $commands = Package::getCommands($packageCode);
            
            $this->assertNotNull(
                $commands,
                "Package::getCommands('{$packageCode}') should not return null"
            );
            
            // Just verify it returns a collection without errors
            $this->assertIsIterable($commands);
            
            // Some packages should have commands
            if ($packageCode === 'support') {
                $this->assertGreaterThan(
                    0,
                    $commands->count(),
                    "Package '{$packageCode}' should have some commands"
                );
            }
        }
    }

    /**
     * Test backward compatibility of config loading.
     */
    public function test_backward_compatibility()
    {
        // This test ensures ConfigServiceProvider handles both
        // {code}.php and config.php files correctly
        
        $packages = Package::list();
        
        $packagesWithConfig = 0;
        
        foreach ($packages as $code => $packageName) {
            $namespace = config("{$code}.namespace");
            
            if ($namespace) {
                $packagesWithConfig++;
                
                // Verify namespace follows convention
                $this->assertStringStartsWith(
                    'Diepxuan\\',
                    $namespace,
                    "Namespace for '{$code}' should start with 'Diepxuan\\'"
                );
            }
        }
        
        // We should have config for several packages
        $this->assertGreaterThan(5, $packagesWithConfig, 'Should have config for more than 5 packages');
    }
}