<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

echo '=== Testing SEO Route Fixes ===' . PHP_EOL . PHP_EOL;

// Authenticate admin
$adminUser = User::where('role', 'admin')->first();
if (!$adminUser) {
    echo '❌ No admin user found' . PHP_EOL;
    exit(1);
}
Auth::login($adminUser);

echo '✅ Admin authenticated' . PHP_EOL . PHP_EOL;

// Test specific routes
$testRoutes = [
    ['path' => '/admin/seo/robots', 'expected' => 'admin.seo.robots', 'description' => 'Robots.txt editor'],
    ['path' => '/admin/seo/sitemap', 'expected' => 'admin.seo.sitemap', 'description' => 'Sitemap generator'],
    ['path' => '/admin/seo/page-speed', 'expected' => 'admin.seo.page-speed', 'description' => 'Page speed dashboard'],
    ['path' => '/admin/seo/1', 'expected' => 'admin.seo.show', 'description' => 'SEO show with ID 1'],
];

foreach ($testRoutes as $test) {
    echo "Testing: {$test['description']} ({$test['path']})" . PHP_EOL;

    try {
        $route = Route::getRoutes()->match(
            \Illuminate\Http\Request::create($test['path'], 'GET')
        );

        if ($route && $route->getName() === $test['expected']) {
            echo '✅ Correctly routes to: ' . $route->getName() . PHP_EOL;
        } else {
            echo '❌ Wrong route - Expected: ' . $test['expected'];
            if ($route) {
                echo ', Got: ' . $route->getName();
            }
            echo PHP_EOL;
        }
    } catch (Exception $e) {
        echo '❌ Route error: ' . $e->getMessage() . PHP_EOL;
    }

    echo PHP_EOL;
}

// Test controller methods for specific routes
echo 'Testing controller methods...' . PHP_EOL;

$controller = app(\App\Http\Controllers\Admin\SeoController::class);

$methods = ['robots', 'sitemap', 'pageSpeed'];
foreach ($methods as $method) {
    try {
        $response = $controller->$method();
        echo '✅ ' . $method . '() method works' . PHP_EOL;
    } catch (Exception $e) {
        echo '❌ ' . $method . '() method error: ' . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . '=== Route Fix Test Complete ===' . PHP_EOL;

Auth::logout();
