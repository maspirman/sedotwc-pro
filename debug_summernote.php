<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING SUMMERNOTE LOADING ===\n\n";

// Test admin access
$admin = User::where('role', 'admin')->first();
if (!$admin) {
    echo "✗ No admin user found\n";
    exit(1);
}

auth()->login($admin);

$request = Request::create('/admin/blogs/create', 'GET');
$response = app()->handle($request);

if ($response->getStatusCode() == 200) {
    $content = $response->getContent();

    echo "✓ Page loads successfully\n";

    // Check for Summernote scripts
    $checks = [
        'jQuery' => strpos($content, 'jquery') !== false,
        'Summernote CSS' => strpos($content, 'summernote') !== false,
        'Summernote JS init' => strpos($content, '$(\'#content\').summernote(') !== false,
        'Textarea exists' => strpos($content, 'id="content"') !== false,
        'Vite assets' => strpos($content, '/build/') !== false,
    ];

    echo "\nScript/Asset Checks:\n";
    foreach ($checks as $check => $result) {
        echo ($result ? "✓" : "✗") . " $check\n";
    }

    // Extract and show relevant parts
    echo "\n=== SCRIPTS SECTION ===\n";

    // Find all script tags
    preg_match_all('/<script[^>]*>.*?<\/script>/s', $content, $scriptMatches);
    if (!empty($scriptMatches[0])) {
        foreach ($scriptMatches[0] as $script) {
            if (strpos($script, 'summernote') !== false || strpos($script, 'DOMContentLoaded') !== false) {
                echo "Found relevant script:\n" . substr($script, 0, 500) . "...\n\n";
            }
        }
    }

    // Check for CDN links
    echo "=== CDN LINKS ===\n";
    preg_match_all('/<link[^>]*href="[^"]*summernote[^"]*"[^>]*>/', $content, $linkMatches);
    if (!empty($linkMatches[0])) {
        foreach ($linkMatches[0] as $link) {
            echo "Summernote CSS: $link\n";
        }
    }

    preg_match_all('/<script[^>]*src="[^"]*summernote[^"]*"[^>]*><\/script>/', $content, $scriptSrcMatches);
    if (!empty($scriptSrcMatches[0])) {
        foreach ($scriptSrcMatches[0] as $scriptSrc) {
            echo "Summernote JS: $scriptSrc\n";
        }
    }

    // Check for textarea
    echo "=== TEXTAREA SECTION ===\n";
    if (preg_match('/<textarea[^>]*id="content"[^>]*>.*?<\/textarea>/s', $content, $matches)) {
        echo "Found textarea:\n$matches[0]\n\n";
    }

} else {
    echo "✗ Page failed to load with status: " . $response->getStatusCode() . "\n";
}

auth()->logout();
