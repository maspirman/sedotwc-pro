<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SeoSetting;

// Authenticate admin
$adminUser = User::where('role', 'admin')->first();
if (!$adminUser) {
    echo '❌ No admin user found' . PHP_EOL;
    exit(1);
}
Auth::login($adminUser);

echo '=== Testing SEO Controller Methods ===' . PHP_EOL . PHP_EOL;

$controller = app(\App\Http\Controllers\Admin\SeoController::class);

// Test 1: Index method
echo '1. Testing index method...' . PHP_EOL;
try {
    $request = Request::create('/admin/seo', 'GET');
    $response = $controller->index($request);
    echo '✅ Index method executed successfully' . PHP_EOL;

    // Check if response has data
    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo '✅ Index response contains data: ' . count($data) . ' variables' . PHP_EOL;
        if (isset($data['stats'])) {
            echo '✅ Stats data found' . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo '❌ Index method error: ' . $e->getMessage() . PHP_EOL;
}

// Test 2: Create method
echo PHP_EOL . '2. Testing create method...' . PHP_EOL;
try {
    $response = $controller->create();
    echo '✅ Create method executed successfully' . PHP_EOL;

    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo '✅ Create response contains data: ' . count($data) . ' variables' . PHP_EOL;
    }
} catch (Exception $e) {
    echo '❌ Create method error: ' . $e->getMessage() . PHP_EOL;
}

// Test 3: Sitemap method
echo PHP_EOL . '3. Testing sitemap method...' . PHP_EOL;
try {
    $response = $controller->sitemap();
    echo '✅ Sitemap method executed successfully' . PHP_EOL;

    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo '✅ Sitemap response contains data: ' . count($data) . ' variables' . PHP_EOL;
        if (isset($data['sitemapData'])) {
            echo '✅ Sitemap data found: ' . count($data['sitemapData']) . ' URLs' . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo '❌ Sitemap method error: ' . $e->getMessage() . PHP_EOL;
}

// Test 4: Robots method
echo PHP_EOL . '4. Testing robots method...' . PHP_EOL;
try {
    $response = $controller->robots();
    echo '✅ Robots method executed successfully' . PHP_EOL;

    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo '✅ Robots response contains data: ' . count($data) . ' variables' . PHP_EOL;
        if (isset($data['currentContent'])) {
            echo '✅ Robots content found: ' . strlen($data['currentContent']) . ' characters' . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo '❌ Robots method error: ' . $e->getMessage() . PHP_EOL;
}

// Test 5: Page speed method
echo PHP_EOL . '5. Testing page-speed method...' . PHP_EOL;
try {
    $response = $controller->pageSpeed();
    echo '✅ Page-speed method executed successfully' . PHP_EOL;

    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo '✅ Page-speed response contains data: ' . count($data) . ' variables' . PHP_EOL;
        if (isset($data['stats'])) {
            echo '✅ Page-speed stats found' . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo '❌ Page-speed method error: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . '=== SEO Controller Test Complete ===' . PHP_EOL;

Auth::logout();
