<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CmsPage;

echo "Debugging CMS preview text...\n\n";

$pages = CmsPage::all();
foreach($pages as $page) {
    echo $page->id . ' - ' . $page->title . ' (' . $page->template . ')';
    try {
        $preview = $page->getPreviewText();
        echo ' -> Preview: ' . $preview . "\n";
    } catch (Exception $e) {
        echo ' -> ERROR: ' . $e->getMessage() . "\n";
    }
    echo "Template Data: " . json_encode($page->template_data) . "\n";
    echo "---\n";
}
