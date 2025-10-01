<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $controller = new App\Http\Controllers\Admin\TestimonialController();
    echo "✅ TestimonialController instantiated successfully\n";
} catch (Exception $e) {
    echo "❌ Error instantiating TestimonialController: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
