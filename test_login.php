<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

Log::debug('=== HTTP LOGIN TEST START ===');

// Test 1: Direct auth attempt
$credentials = [
    'email' => 'ductn@diepxuan.com',
    'password' => 'Ductn@123'
];

Log::debug('Testing credentials', $credentials);

$result = Auth::attempt($credentials);
Log::debug('Auth attempt result', ['result' => $result]);

if ($result) {
    $user = Auth::user();
    Log::debug('User authenticated', ['user_id' => $user->id, 'name' => $user->name]);
    echo "✅ Direct auth SUCCESS\n";
} else {
    echo "❌ Direct auth FAILED\n";
}

// Test 2: Check password manually
$user = \App\Models\User::where('email', 'ductn@diepxuan.com')->first();
if ($user) {
    $passwordMatch = \Illuminate\Support\Facades\Hash::check('Ductn@123', $user->password);
    Log::debug('Manual password check', [
        'user_exists' => true,
        'password_match' => $passwordMatch,
        'password_hash' => substr($user->password, 0, 20) . '...'
    ]);
    
    if ($passwordMatch) {
        echo "✅ Password hash matches\n";
    } else {
        echo "❌ Password hash DOES NOT match\n";
        echo "Hash in DB: " . $user->password . "\n";
        echo "Hash of 'Ductn@123': " . \Illuminate\Support\Facades\Hash::make('Ductn@123') . "\n";
    }
} else {
    echo "❌ User not found\n";
}

Log::debug('=== HTTP LOGIN TEST END ===');
echo "\nCheck laravel.log for details\n";