<?php

namespace Tests\Unit\Core;

use Diepxuan\Core\Models\Package;
use Tests\TestCase;

class SimplePackageTest extends TestCase
{
    /**
     * Test that Package::list() returns packages.
     */
    public function test_package_list_returns_packages()
    {
        $packages = Package::list();
        
        $this->assertNotEmpty($packages, 'Package::list() should return non-empty collection');
        
        // Just check that we have some packages
        $this->assertGreaterThan(0, $packages->count());
        
        // Check a specific package we know exists
        $this->assertArrayHasKey('catalog', $packages->toArray());
        $this->assertEquals('diepxuan/laravel-catalog', $packages['catalog']);
    }

    /**
     * Test that config is loaded for catalog package.
     */
    public function test_config_loaded_for_catalog_package()
    {
        $namespace = config('catalog.namespace');
        $name = config('catalog.name');
        
        $this->assertNotNull($namespace, 'catalog.namespace should not be null');
        $this->assertNotNull($name, 'catalog.name should not be null');
        
        $this->assertEquals('Diepxuan\Catalog', $namespace);
        $this->assertEquals('diepxuan/laravel-catalog', $name);
    }

    /**
     * Test that Package::getCommands() works for catalog.
     */
    public function test_get_commands_for_catalog()
    {
        $commands = Package::getCommands('catalog');
        
        $this->assertNotNull($commands);
        // Catalog may or may not have commands, that's okay
        // Just test that the method doesn't crash
        $this->assertIsIterable($commands);
    }
}