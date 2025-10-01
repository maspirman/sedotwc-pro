<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Blog;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Checking blog publication dates:\n\n";

$blogs = Blog::select('id', 'title', 'status', 'published_at')->get();

foreach ($blogs as $blog) {
    $publishedAt = $blog->published_at ? $blog->published_at->format('Y-m-d H:i:s') : 'NULL';
    $isFuture = $blog->published_at && $blog->published_at->isFuture();
    echo "{$blog->id}: {$blog->title}\n";
    echo "   Status: {$blog->status}\n";
    echo "   Published At: {$publishedAt}\n";
    echo "   Is Future: " . ($isFuture ? 'YES' : 'NO') . "\n";
    echo "   Should be accessible: " . (($blog->status === 'published' && !$isFuture) ? 'YES' : 'NO') . "\n\n";
}
