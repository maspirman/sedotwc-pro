<?php

echo '=== Testing SEO Pages After Fix ===' . PHP_EOL . PHP_EOL;

// Test 1: Check if blade templates compile without errors
echo '1. Testing blade template compilation...' . PHP_EOL;

$views = [
    'admin.seo.index',
    'admin.seo.create',
    'admin.seo.show',
    'admin.seo.edit',
    'admin.seo.sitemap',
    'admin.seo.robots',
    'admin.seo.page-speed'
];

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

$adminUser = User::where('role', 'admin')->first();
if ($adminUser) {
    Auth::login($adminUser);
    echo '✅ Admin authenticated' . PHP_EOL;
} else {
    echo '❌ No admin user found' . PHP_EOL;
    exit(1);
}

foreach ($views as $view) {
    try {
        // Try to render the view
        $rendered = View::make($view)->render();
        echo '✅ ' . $view . ' renders successfully' . PHP_EOL;
    } catch (Exception $e) {
        echo '❌ ' . $view . ' render error: ' . $e->getMessage() . PHP_EOL;
        echo '   Line: ' . $e->getLine() . PHP_EOL;
        echo '   File: ' . $e->getFile() . PHP_EOL;
    }
}

echo PHP_EOL . '2. Testing controller methods...' . PHP_EOL;

// Test controller instantiation
try {
    $controller = app(\App\Http\Controllers\Admin\SeoController::class);
    echo '✅ SeoController instantiated successfully' . PHP_EOL;

    // Test create method
    $response = $controller->create();
    echo '✅ create() method executed successfully' . PHP_EOL;

    // Test sitemap method
    $response = $controller->sitemap();
    echo '✅ sitemap() method executed successfully' . PHP_EOL;

} catch (Exception $e) {
    echo '❌ Controller error: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . '=== SEO Pages Test Complete ===' . PHP_EOL;

Auth::logout();
