<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo '=== Seeding SEO Data ===' . PHP_EOL;

try {
    // Create sample SEO settings
    $seoData = [
        [
            'page_type' => 'home',
            'page_id' => null,
            'meta_title' => 'SedotWC - Jasa Sedot WC Profesional 24 Jam',
            'meta_description' => 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat. Bersih, cepat, dan terpercaya.',
            'meta_keywords' => 'sedot wc, jasa sedot wc, wc mampet, sedot wc jakarta',
            'og_title' => 'SedotWC - Jasa Sedot WC Profesional',
            'og_description' => 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat.',
            'og_image' => '/images/og-image.jpg',
            'twitter_title' => 'SedotWC - Jasa Sedot WC Profesional',
            'twitter_description' => 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat.',
            'twitter_image' => '/images/twitter-image.jpg',
            'schema_ld' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'SedotWC',
                'description' => 'Jasa sedot WC profesional',
                'url' => 'https://sedotwc.com'
            ],
            'noindex' => false,
            'nofollow' => false,
        ],
        [
            'page_type' => 'blogs',
            'page_id' => 1, // Assuming there's a blog with ID 1
            'meta_title' => 'Tips Merawat WC agar Tidak Mampet',
            'meta_description' => 'Pelajari tips merawat WC agar tidak mudah mampet dan perlu disedot. Panduan lengkap dari SedotWC.',
            'meta_keywords' => 'merawat wc, wc mampet, tips wc, sedot wc',
            'og_title' => 'Tips Merawat WC agar Tidak Mampet',
            'og_description' => 'Pelajari tips merawat WC agar tidak mudah mampet.',
            'og_image' => '/images/blog-wc-care.jpg',
            'noindex' => false,
            'nofollow' => false,
        ],
        [
            'page_type' => 'services',
            'page_id' => 1, // Assuming there's a service with ID 1
            'meta_title' => 'Sedot WC Standar - Layanan Profesional',
            'meta_description' => 'Layanan sedot WC standar dengan peralatan modern dan tim berpengalaman. Harga terjangkau dan garansi kepuasan.',
            'meta_keywords' => 'sedot wc standar, jasa sedot wc, wc mampet',
            'og_title' => 'Sedot WC Standar - Layanan Profesional',
            'og_description' => 'Layanan sedot WC standar dengan peralatan modern.',
            'og_image' => '/images/service-standard.jpg',
            'noindex' => false,
            'nofollow' => false,
        ]
    ];

    foreach ($seoData as $data) {
        App\Models\SeoSetting::create($data);
        echo '✅ Created SEO setting for ' . $data['page_type'] . PHP_EOL;
    }

    echo PHP_EOL . 'Total SEO settings created: ' . count($seoData) . PHP_EOL;

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . '=== Seeding Complete ===' . PHP_EOL;
