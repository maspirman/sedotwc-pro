<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

echo '=== Testing SEO Edit Route ===' . PHP_EOL;

// Authenticate admin
$adminUser = User::where('role', 'admin')->first();
if (!$adminUser) {
    echo '❌ No admin user found' . PHP_EOL;
    exit(1);
}
Auth::login($adminUser);

echo '✅ Admin authenticated' . PHP_EOL;

// Test edit method with existing SEO setting
try {
    $seoSetting = App\Models\SeoSetting::first();
    if (!$seoSetting) {
        echo '❌ No SEO settings found' . PHP_EOL;
        exit(1);
    }

    echo '✅ Found SEO setting with ID: ' . $seoSetting->id . PHP_EOL;

    $controller = app(\App\Http\Controllers\Admin\SeoController::class);
    $response = $controller->edit($seoSetting);

    echo '✅ Edit controller method executed successfully' . PHP_EOL;

    if (method_exists($response, 'getData')) {
        $data = $response->getData();
        echo '✅ Edit response contains data: ' . count($data) . ' variables' . PHP_EOL;

        if (isset($data['seoSetting'])) {
            echo '✅ seoSetting data found in response' . PHP_EOL;
        }
        if (isset($data['pageTypes'])) {
            echo '✅ pageTypes data found in response' . PHP_EOL;
        }
        if (isset($data['availablePages'])) {
            echo '✅ availablePages data found in response' . PHP_EOL;
        }
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . PHP_EOL;
    echo 'Stack trace:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

echo PHP_EOL . '=== Test Complete ===' . PHP_EOL;

Auth::logout();
