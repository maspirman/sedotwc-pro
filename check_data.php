<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DATABASE SEEDING CHECK ===\n\n";

echo "Users: " . App\Models\User::count() . "\n";
echo "Services: " . App\Models\Service::count() . "\n";
echo "Categories: " . App\Models\Category::count() . "\n";
echo "Testimonials: " . App\Models\Testimonial::count() . "\n\n";

echo "=== ADMIN USER ===\n";
$admin = App\Models\User::where('role', 'admin')->first();
if ($admin) {
    echo "Email: " . $admin->email . "\n";
    echo "Name: " . $admin->name . "\n";
    echo "Role: " . $admin->role . "\n";
    echo "Phone: " . $admin->phone . "\n";
}

echo "\n=== SAMPLE SERVICES ===\n";
$services = App\Models\Service::take(3)->get();
foreach ($services as $service) {
    echo "- " . $service->title . " (Rp " . number_format($service->price, 0, ',', '.') . ")\n";
}

echo "\n=== SAMPLE CATEGORIES ===\n";
$categories = App\Models\Category::all();
foreach ($categories as $category) {
    echo "- " . $category->name . "\n";
}

echo "\n=== SEEDING COMPLETED SUCCESSFULLY! ===\n";
