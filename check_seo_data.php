<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== Checking SEO Data ===' . PHP_EOL;

try {
    $seoCount = App\Models\SeoSetting::count();
    echo 'SEO Settings count: ' . $seoCount . PHP_EOL;

    if ($seoCount > 0) {
        echo PHP_EOL . 'All SEO Settings:' . PHP_EOL;
        $seoSettings = App\Models\SeoSetting::all();
        foreach ($seoSettings as $seo) {
            echo 'ID: ' . $seo->id . ', Type: ' . $seo->page_type . ', Page ID: ' . ($seo->page_id ?? 'null') . PHP_EOL;
        }
    } else {
        echo 'No SEO settings found in database.' . PHP_EOL;
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . '=== Check Complete ===' . PHP_EOL;
