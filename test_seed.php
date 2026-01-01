<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $user = \App\Models\User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
    echo "User created: " . $user->id . PHP_EOL;
    
    \App\Models\Link::factory()
        ->count(2)
        ->for($user)
        ->has(\App\Models\Redirect::factory()->count(1))
        ->create();
    
    echo "Links: " . \App\Models\Link::count() . PHP_EOL;
    echo "Redirects: " . \App\Models\Redirect::count() . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}
