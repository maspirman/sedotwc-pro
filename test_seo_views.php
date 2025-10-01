<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Authenticate admin
$adminUser = User::where('role', 'admin')->first();
if (!$adminUser) {
    echo '❌ No admin user found' . PHP_EOL;
    exit(1);
}
Auth::login($adminUser);

echo '=== Testing SEO View Rendering ===' . PHP_EOL . PHP_EOL;

// Test each view with proper data
$tests = [
    'admin.seo.create' => [
        'description' => 'Create SEO form',
        'data' => []
    ],
    'admin.seo.sitemap' => [
        'description' => 'Sitemap generator',
        'data' => ['sitemapData' => [
            ['url' => 'http://example.com', 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => '2024-01-01']
        ]]
    ],
    'admin.seo.robots' => [
        'description' => 'Robots.txt editor',
        'data' => ['currentContent' => 'User-agent: *\nAllow: /']
    ],
    'admin.seo.page-speed' => [
        'description' => 'Page speed dashboard',
        'data' => [
            'stats' => [
                'minification_enabled' => true,
                'css_defer_enabled' => true,
                'js_defer_enabled' => false,
                'image_optimization' => false,
                'caching_enabled' => false
            ],
            'recommendations' => ['Enable Gzip compression']
        ]
    ]
];

foreach ($tests as $view => $config) {
    echo "Testing {$config['description']} ($view)..." . PHP_EOL;

    try {
        $rendered = View::make($view, $config['data'])->render();
        echo '✅ View renders successfully (' . strlen($rendered) . ' characters)' . PHP_EOL;

        // Check for common issues
        if (strpos($rendered, 'Undefined variable') !== false) {
            echo '⚠️  Warning: Contains undefined variable references' . PHP_EOL;
        }

        if (strpos($rendered, 'Error') !== false && strpos($rendered, '<title>') === false) {
            echo '⚠️  Warning: Contains error messages' . PHP_EOL;
        }

    } catch (Exception $e) {
        echo '❌ View render error: ' . $e->getMessage() . PHP_EOL;
        echo '   Line: ' . $e->getLine() . PHP_EOL;
    }

    echo PHP_EOL;
}

// Test index view with proper data
echo 'Testing admin.seo.index with controller data...' . PHP_EOL;
try {
    $controller = app(\App\Http\Controllers\Admin\SeoController::class);
    $request = \Illuminate\Http\Request::create('/admin/seo', 'GET');
    $response = $controller->index($request);

    if (method_exists($response, 'getData')) {
        $viewData = $response->getData();
        $rendered = View::make('admin.seo.index', $viewData)->render();
        echo '✅ Index view renders successfully (' . strlen($rendered) . ' characters)' . PHP_EOL;
    }
} catch (Exception $e) {
    echo '❌ Index view render error: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . '=== SEO View Test Complete ===' . PHP_EOL;

Auth::logout();
