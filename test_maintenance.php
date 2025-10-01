<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\GeneralSetting;

echo "Testing Maintenance Mode...\n\n";

// Enable maintenance mode
GeneralSetting::setValue('maintenance_mode', 'true', 'boolean', 'system');
echo "✅ Maintenance mode enabled\n";

// Test maintenance settings
$settings = [
    'maintenance_title' => 'Website Sedang Dalam Perbaikan',
    'maintenance_message' => 'Kami sedang melakukan perbaikan untuk memberikan pengalaman yang lebih baik.',
    'maintenance_estimated_time' => '1-2 jam lagi',
    'maintenance_progress' => '75',
    'maintenance_retry' => '60',
    'maintenance_background_color' => '#667eea',
    'maintenance_show_social_links' => 'true',
];

foreach ($settings as $key => $value) {
    GeneralSetting::setValue($key, $value, 'text', 'maintenance');
    echo "✅ Set $key = $value\n";
}

echo "\n🎉 Maintenance mode setup completed!\n";
echo "You can now visit the homepage to see the maintenance page.\n";
echo "Admin users can still access the site normally.\n";
