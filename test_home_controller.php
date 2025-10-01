<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\HomeSetting;

echo "Testing HomeController data loading...\n\n";

try {
    echo "1. Testing Services:\n";
    $services = Service::where('status', 'active')
                      ->orderBy('created_at', 'desc')
                      ->take(4)
                      ->get();
    echo "   Services count: " . $services->count() . "\n";
    if ($services->count() > 0) {
        echo "   Services: \n";
        foreach ($services as $service) {
            echo "     - {$service->title} (status: {$service->status})\n";
        }
    }

    echo "\n2. Testing Testimonials:\n";
    $testimonials = Testimonial::where('status', 'active')
                                      ->orderBy('created_at', 'desc')
                                      ->take(3)
                                      ->get();
    echo "   Testimonials count: " . $testimonials->count() . "\n";

    echo "\n3. Testing Latest Blogs:\n";
    $latestBlogs = Blog::published()
                               ->with('category')
                               ->orderBy('published_at', 'desc')
                               ->take(3)
                               ->get();
    echo "   Blogs count: " . $latestBlogs->count() . "\n";

    echo "\n4. Testing Home Settings:\n";
    $homeSettings = [
        'hero' => HomeSetting::getSection('hero'),
        'about' => HomeSetting::getSection('about'),
        'stats' => HomeSetting::getSection('stats'),
        'cta' => HomeSetting::getSection('cta'),
    ];
    echo "   Hero section: " . (isset($homeSettings['hero']['title']) ? 'OK' : 'Missing') . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
