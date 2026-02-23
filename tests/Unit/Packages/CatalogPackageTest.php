<?php

namespace Tests\Unit\Packages;

use Diepxuan\Core\Models\Package;
use Tests\TestCase;

class CatalogPackageTest extends TestCase
{
    /**
     * Test catalog package config loading.
     */
    public function test_catalog_package_config_loaded()
    {
        $namespace = config('catalog.namespace');
        $name = config('catalog.name');
        
        $this->assertEquals('Diepxuan\Catalog', $namespace);
        $this->assertEquals('diepxuan/laravel-catalog', $name);
    }

    /**
     * Test catalog package commands.
     */
    public function test_catalog_package_commands()
    {
        $commands = Package::getCommands('catalog');
        
        $this->assertNotNull($commands);
        $this->assertGreaterThan(0, $commands->count(), 'Catalog package should have commands');
        
        // Check if commands are valid classes
        foreach ($commands as $commandClass) {
            $this->assertTrue(
                class_exists($commandClass),
                "Command class '{$commandClass}' should exist"
            );
        }
    }
}