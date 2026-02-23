<?php

namespace Tests\Unit\Packages;

use Diepxuan\Core\Models\Package;
use Tests\TestCase;

class SupportPackageTest extends TestCase
{
    /**
     * Test support package config loading.
     */
    public function test_support_package_config_loaded()
    {
        $namespace = config('support.namespace');
        $name = config('support.name');
        
        $this->assertEquals('Diepxuan\Support', $namespace);
        $this->assertEquals('diepxuan/laravel-support', $name);
    }

    /**
     * Test support package commands.
     */
    public function test_support_package_commands()
    {
        $commands = Package::getCommands('support');
        
        $this->assertNotNull($commands);
        $this->assertGreaterThan(0, $commands->count(), 'Support package should have commands');
        
        // Support package should have dev commands
        $commandClasses = $commands->toArray();
        $hasDevCommand = false;
        
        foreach ($commandClasses as $commandClass) {
            if (strpos($commandClass, 'Dev') !== false || strpos($commandClass, 'Serve') !== false) {
                $hasDevCommand = true;
            }
            
            $this->assertTrue(
                class_exists($commandClass),
                "Command class '{$commandClass}' should exist"
            );
        }
        
        $this->assertTrue($hasDevCommand, 'Support package should have dev-related commands');
    }
}