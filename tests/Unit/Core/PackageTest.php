<?php

namespace Tests\Unit\Core;

use Diepxuan\Core\Models\Package;
use Tests\TestCase;

class PackageTest extends TestCase
{
    /**
     * Test that Package::list() returns diepxuan packages.
     */
    public function test_package_list_returns_diepxuan_packages()
    {
        $packages = Package::list();
        
        $this->assertNotEmpty($packages);
        $this->assertGreaterThan(0, $packages->count());
        
        // Check specific packages we know exist
        $this->assertArrayHasKey('catalog', $packages->toArray());
        $this->assertEquals('diepxuan/laravel-catalog', $packages['catalog']);
        
        $this->assertArrayHasKey('support', $packages->toArray());
        $this->assertEquals('diepxuan/laravel-support', $packages['support']);
    }

    /**
     * Test that config is loaded for packages with config files.
     */
    public function test_config_loaded_for_packages()
    {
        // Test packages that should have config files
        $packagesWithConfig = ['catalog', 'core', 'support'];
        
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
            
            $this->assertStringContainsString(
                'Diepxuan\\',
                $namespace,
                "Namespace for '{$packageCode}' should contain 'Diepxuan\\'"
            );
            
            $this->assertStringContainsString(
                'diepxuan/laravel-',
                $name,
                "Name for '{$packageCode}' should contain 'diepxuan/laravel-'"
            );
        }
    }

    /**
     * Test that Package::getCommands() works without errors.
     */
    public function test_get_commands_works()
    {
        // Test for packages that might have commands
        $packagesToTest = ['catalog', 'support'];
        
        foreach ($packagesToTest as $packageCode) {
            $commands = Package::getCommands($packageCode);
            
            $this->assertNotNull(
                $commands,
                "Package::getCommands('{$packageCode}') should not return null"
            );
            
            // Just verify it returns a collection, doesn't matter if empty or not
            $this->assertIsIterable($commands);
        }
    }

    /**
     * Test backward compatibility - packages without {code}.php should still work.
     */
    public function test_backward_compatibility()
    {
        // This test verifies that ConfigServiceProvider handles both
        // {code}.php and config.php files
        
        $packages = Package::list();
        
        foreach ($packages as $code => $packageName) {
            // Skip packages that don't need config
            if (in_array($code, ['currency', 'eloquent-composite', 'charset'])) {
                continue;
            }
            
            $namespace = config("{$code}.namespace");
            $name = config("{$code}.name");
            
            // Packages with config files should have values
            if (in_array($code, ['catalog', 'core', 'disreg', 'gmail', 'log', 'magento', 'ronaldjack', 'scavenger', 'simba', 'support'])) {
                $this->assertNotNull(
                    $namespace,
                    "Package '{$code}' should have namespace config"
                );
                
                $this->assertNotNull(
                    $name,
                    "Package '{$code}' should have name config"
                );
            }
        }
    }
}