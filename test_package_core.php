<?php

// Simple test runner for laravel-core package tests
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Include test files directly
require __DIR__ . '/diepxuan/laravel-core/tests/TestCase.php';
require __DIR__ . '/diepxuan/laravel-core/tests/Unit/PackageConfigTest.php';

use Diepxuan\Core\Tests\Unit\PackageConfigTest;

echo "=== Running PackageConfigTest manually ===\n\n";

$test = new PackageConfigTest('test_package_list_returns_diepxuan_packages');

try {
    $test->setUp();
    $test->test_package_list_returns_diepxuan_packages();
    echo "✅ Test passed: test_package_list_returns_diepxuan_packages\n";
} catch (Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// Run another test
$test2 = new PackageConfigTest('test_config_is_loaded_for_each_package');
try {
    $test2->setUp();
    $test2->test_config_is_loaded_for_each_package();
    echo "✅ Test passed: test_config_is_loaded_for_each_package\n";
} catch (Exception $e) {
    echo "❌ Test failed: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";