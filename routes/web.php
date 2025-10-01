<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::middleware(['seo', 'maintenance'])->group(function () {
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

    // Services Routes
    Route::prefix('layanan')->name('services.')->group(function () {
        Route::get('/', [App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('index');
        Route::get('/{service:slug}', [App\Http\Controllers\Frontend\ServiceController::class, 'show'])->name('show');
        Route::post('/{service:slug}/order', [App\Http\Controllers\Frontend\ServiceController::class, 'storeOrder'])->name('order');
    });

    // Blog Routes
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('index');
        Route::get('/kategori/{category:slug}', [App\Http\Controllers\Frontend\BlogController::class, 'category'])->name('category');
        Route::get('/{blog:slug}', [App\Http\Controllers\Frontend\BlogController::class, 'show'])->name('show');
    });

    // CMS Pages Routes
    Route::get('/halaman/{page:slug}', [App\Http\Controllers\Frontend\PageController::class, 'show'])->name('page.show');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test route for order notification
Route::get('/test-order-notification', function() {
    // Create a dummy order to test notifications
    $service = \App\Models\Service::first();
    if (!$service) {
        return 'No service found. Please create a service first.';
    }

    $order = \App\Models\Order::create([
        'service_id' => $service->id,
        'status' => 'pending',
        'customer_name' => 'Test Customer',
        'customer_phone' => '081234567890',
        'customer_address' => 'Test Address',
        'scheduled_date' => now()->addDays(1),
        'notes' => 'Test order for notification',
        'total_price' => $service->price,
    ]);

    // Create notifications for admin users
    $adminUsers = \App\Models\User::where('role', 'admin')->get();
    foreach ($adminUsers as $admin) {
        \App\Models\Notification::create([
            'type' => 'order',
            'title' => 'Pesanan Layanan Baru (Test)',
            'message' => "Test: Pesanan baru dari Test Customer untuk {$service->title}. Jadwal: " . now()->addDays(1)->format('d/m/Y H:i'),
            'icon' => 'bi-receipt',
            'color' => 'warning',
            'action_url' => route('admin.orders.show', $order),
            'user_id' => $admin->id,
            'is_read' => false,
        ]);
    }

    return 'Test order created! Check admin notifications.';
});

// Test route for CMS preview
Route::get('/test-cms-preview', function() {
    $pages = App\Models\CmsPage::all();

    $html = '<h1>CMS Preview Test</h1><table border="1"><tr><th>Title</th><th>Template</th><th>Preview</th></tr>';

    foreach($pages as $page) {
        try {
            $preview = $page->getPreviewText();
            $html .= "<tr><td>{$page->title}</td><td>{$page->template}</td><td>{$preview}</td></tr>";
        } catch (Exception $e) {
            $html .= "<tr><td>{$page->title}</td><td>{$page->template}</td><td>ERROR: {$e->getMessage()}</td></tr>";
        }
    }

    $html .= '</table>';
    return $html;
});

// SUPER SIMPLE SETUP - Just create the missing table
Route::get('/create-tables', function() {
    try {
        // Use Laravel Schema Builder for simplicity
        \Illuminate\Support\Facades\Schema::dropIfExists('general_settings');
        \Illuminate\Support\Facades\Schema::create('general_settings', function ($table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('group')->default('general');
            $table->boolean('is_active')->default(true);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert minimal required data
        DB::table('general_settings')->insert([
            ['key' => 'site_name', 'value' => 'SedotWC', 'type' => 'text', 'group' => 'general', 'description' => 'Nama website'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'system', 'description' => 'Maintenance mode'],
        ]);

        return '<h1 style="color: green;">✅ SUCCESS: general_settings table created!</h1>
                <p>Table created with basic data.</p>
                <a href="' . url('/admin/settings') . '">→ Try Settings Page Now</a>';

    } catch (\Exception $e) {
        return '<h1 style="color: red;">❌ FAILED</h1>
                <p>Error: ' . $e->getMessage() . '</p>';
    }
});

// Emergency setup route - Try this first!
Route::get('/emergency-setup', function() {
    try {
        $pdo = DB::connection()->getPdo();

        // Test connection
        $pdo->query("SELECT 1");

        // Create tables using simple queries
        $pdo->exec("DROP TABLE IF EXISTS home_settings");
        $pdo->exec("DROP TABLE IF EXISTS general_settings");

        $pdo->exec("
            CREATE TABLE home_settings (
                id INT PRIMARY KEY AUTO_INCREMENT,
                section VARCHAR(255) NOT NULL,
                `key` VARCHAR(255) NOT NULL,
                `value` TEXT,
                `type` VARCHAR(50) DEFAULT 'text',
                is_active TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");

        $pdo->exec("
            CREATE TABLE general_settings (
                id INT PRIMARY KEY AUTO_INCREMENT,
                `key` VARCHAR(255) NOT NULL UNIQUE,
                `value` TEXT,
                `type` VARCHAR(50) DEFAULT 'text',
                `group` VARCHAR(50) DEFAULT 'general',
                is_active TINYINT(1) DEFAULT 1,
                description VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");

        // Insert sample data
        $pdo->exec("INSERT INTO home_settings (section, `key`, `value`, `type`) VALUES
            ('hero', 'title', 'Jasa Sedot WC 24 Jam', 'text'),
            ('hero', 'subtitle', 'Profesional & Modern', 'text'),
            ('stats', 'pelanggan_puas', '1000', 'number'),
            ('stats', 'tahun_pengalaman', '10', 'number'),
            ('stats', 'rating_google', '4.9', 'number')
        ");

        $pdo->exec("INSERT INTO general_settings (`key`, `value`, `type`, `group`, description) VALUES
            ('site_name', 'SedotWC', 'text', 'general', 'Nama website'),
            ('site_title', 'Jasa Sedot WC Profesional', 'text', 'general', 'Judul website'),
            ('maintenance_mode', 'false', 'boolean', 'system', 'Maintenance mode'),
            ('facebook', 'https://facebook.com/sedotwc', 'text', 'social_media', 'Facebook')
        ");

        return '<h1 style="color: green;">✅ EMERGENCY SETUP SUCCESS!</h1>
                <p>Tables created and data inserted.</p>
                <a href="' . url('/admin/settings') . '">→ Test Settings Page</a>';

    } catch (\Exception $e) {
        return '<h1 style="color: red;">❌ EMERGENCY SETUP FAILED</h1>
                <p>' . $e->getMessage() . '</p>
                <p>Check database connection and try again.</p>';
    }
});

// Test maintenance mode
Route::get('/test-maintenance', function() {
    $downFile = storage_path('framework/down');

    $info = [
        'file_exists' => file_exists($downFile),
        'file_path' => $downFile,
        'directory_writable' => is_writable(dirname($downFile)),
        'framework_dir_exists' => is_dir(dirname($downFile)),
    ];

    if (file_exists($downFile)) {
        $content = file_get_contents($downFile);
        $data = @unserialize($content);

        $info['file_size'] = strlen($content);
        $info['is_serialized'] = $data !== false;
        $info['data_type'] = gettype($data);
        $info['data'] = $data;

        if (is_array($data)) {
            return '<h1 style="color: green;">✅ Maintenance Mode ACTIVE</h1>
                    <h3>File Info:</h3>
                    <pre>' . print_r($info, true) . '</pre>
                    <p><a href="' . url('/') . '">Test Frontend</a> | <a href="' . url('/admin/settings/maintenance') . '">Settings</a></p>';
        } else {
            return '<h1 style="color: red;">❌ Maintenance File Corrupt</h1>
                    <pre>' . print_r($info, true) . '</pre>
                    <p><a href="' . url('/admin/settings/maintenance') . '">Fix in Settings</a></p>';
        }
    } else {
        return '<h1 style="color: blue;">🔄 Maintenance Mode INACTIVE</h1>
                <h3>System Info:</h3>
                <pre>' . print_r($info, true) . '</pre>
                <p><a href="' . url('/admin/settings/maintenance') . '">→ Enable Maintenance</a></p>';
    }
});

// Temporary route for setup - Using raw DB queries to avoid model dependencies
Route::get('/setup-database', function() {
    try {
        $pdo = DB::connection()->getPdo();

        // Create home_settings table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS home_settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                section VARCHAR(255) NOT NULL,
                `key` VARCHAR(255) NOT NULL,
                `value` TEXT,
                `type` VARCHAR(255) DEFAULT 'text',
                is_active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_section_key (section, `key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Create general_settings table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS general_settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                `key` VARCHAR(255) NOT NULL UNIQUE,
                `value` TEXT,
                `type` VARCHAR(255) DEFAULT 'text',
                `group` VARCHAR(255) DEFAULT 'general',
                is_active BOOLEAN DEFAULT TRUE,
                description VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_group_active (`group`, is_active)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Seed home_settings data
        $homeSettings = [
            ['hero', 'badge', 'TERPERCAYA SEJAK 2015', 'text'],
            ['hero', 'title', 'Jasa Sedot WC 24 Jam', 'text'],
            ['hero', 'subtitle', 'Profesional & Modern', 'text'],
            ['hero', 'description', 'Layanan darurat WC mampet tersedia 24 jam dengan tim ahli berpengalaman, peralatan canggih, dan harga terjangkau. Solusi cepat untuk masalah WC Anda!', 'textarea'],
            ['hero', 'emergency_phone', '(021) 1234-5678', 'text'],
            ['hero', 'whatsapp', '0812-3456-7890', 'text'],
            ['about', 'title', 'Mengapa Memilih SedotWC?', 'text'],
            ['about', 'description', 'Tim ahli dengan pengalaman 10+ tahun menggunakan peralatan modern untuk memberikan layanan terbaik.', 'textarea'],
            ['stats', 'pelanggan_puas', '1000', 'number'],
            ['stats', 'layanan_24jam', '24/7', 'text'],
            ['stats', 'tahun_pengalaman', '10', 'number'],
            ['stats', 'rating_google', '4.9', 'number'],
            ['cta', 'title', 'Butuh Layanan Sedot WC?', 'text'],
            ['cta', 'description', 'Jangan biarkan masalah WC mengganggu kenyamanan Anda. Tim profesional kami siap membantu kapan saja, di mana saja dengan response time 30 menit!', 'textarea'],
            ['cta', 'emergency_badge', 'DARURAT WC 24 JAM', 'text'],
        ];

        foreach ($homeSettings as $setting) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO home_settings (section, `key`, `value`, `type`) VALUES (?, ?, ?, ?)");
            $stmt->execute($setting);
        }

        // Seed general_settings data
        $generalSettings = [
            ['site_name', 'SedotWC', 'text', 'general', 'Nama website/bisnis'],
            ['site_title', 'Jasa Sedot WC Profesional - Cepat, Bersih & Terpercaya', 'text', 'general', 'Judul website untuk SEO'],
            ['site_description', 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat. Tim berpengalaman dengan peralatan modern.', 'textarea', 'general', 'Deskripsi website untuk meta description'],
            ['site_keywords', 'sedot wc, jasa sedot wc, wc mampet, sedot wc jakarta, jasa sedot wc murah', 'text', 'general', 'Keywords untuk SEO'],
            ['contact_email', 'info@sedotwc.com', 'text', 'general', 'Email kontak utama'],
            ['contact_phone', '(021) 1234-5678', 'text', 'general', 'Nomor telepon utama'],
            ['contact_address', 'Jl. Sudirman No. 123, Jakarta Pusat', 'textarea', 'general', 'Alamat lengkap bisnis'],
            ['maintenance_mode', 'false', 'boolean', 'system', 'Mode maintenance website'],
            ['facebook', 'https://facebook.com/sedotwc', 'text', 'social_media', 'Link Facebook'],
            ['instagram', 'https://instagram.com/sedotwc', 'text', 'social_media', 'Link Instagram'],
            ['whatsapp', 'https://wa.me/6281234567890', 'text', 'social_media', 'Link WhatsApp Business'],
            ['twitter', 'https://twitter.com/sedotwc', 'text', 'social_media', 'Link Twitter'],
        ];

        foreach ($generalSettings as $setting) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO general_settings (`key`, `value`, `type`, `group`, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute($setting);
        }

        return '<h1 style="color: green;">✅ Database Setup Berhasil!</h1>
                <p>Semua tabel dan data default telah dibuat.</p>
                <p><strong>Tabel yang dibuat:</strong></p>
                <ul>
                    <li>✅ home_settings - Untuk konten halaman home</li>
                    <li>✅ general_settings - Untuk pengaturan umum website</li>
                </ul>
                <p><strong>Data yang di-seed:</strong></p>
                <ul>
                    <li>✅ Home page content (hero, about, stats, cta)</li>
                    <li>✅ General settings (site info, contact, social media)</li>
                </ul>
                <p><a href="' . url('/') . '">← Kembali ke Home</a></p>
                <p><a href="' . url('/admin') . '">→ Akses Admin Panel</a></p>';

    } catch (\Exception $e) {
        return '<h1 style="color: red;">❌ Database Setup Gagal</h1>
                <p>Error: ' . $e->getMessage() . '</p>
                <p><a href="' . url('/') . '">← Kembali ke Home</a></p>';
    }
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->middleware('admin')->name('dashboard');

    // Services Management
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->middleware('admin')->names([
        'index' => 'services.index',
        'create' => 'services.create',
        'store' => 'services.store',
        'show' => 'services.show',
        'edit' => 'services.edit',
        'update' => 'services.update',
        'destroy' => 'services.destroy',
    ]);
    Route::patch('/services/{service}/toggle-status', [App\Http\Controllers\Admin\ServiceController::class, 'toggleStatus'])->middleware('admin')->name('services.toggle-status');
    // Orders Management
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->middleware('admin')->except(['create', 'store'])->names([
        'index' => 'orders.index',
        'show' => 'orders.show',
        'edit' => 'orders.edit',
        'update' => 'orders.update',
        'destroy' => 'orders.destroy',
    ]);
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->middleware('admin')->name('orders.update-status');
    Route::post('/orders/bulk-update-status', [App\Http\Controllers\Admin\OrderController::class, 'bulkUpdateStatus'])->middleware('admin')->name('orders.bulk-update-status');
    Route::get('/orders-export', [App\Http\Controllers\Admin\OrderController::class, 'export'])->middleware('admin')->name('orders.export');
    // Customers Management
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class)->middleware('admin')->except(['create', 'store'])->names([
        'index' => 'customers.index',
        'show' => 'customers.show',
        'edit' => 'customers.edit',
        'update' => 'customers.update',
        'destroy' => 'customers.destroy',
    ]);
    Route::patch('/customers/{customer}/toggle-status', [App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->middleware('admin')->name('customers.toggle-status');

    // Blogs Management
    Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class)->middleware('admin')->names([
        'index' => 'blogs.index',
        'create' => 'blogs.create',
        'store' => 'blogs.store',
        'show' => 'blogs.show',
        'edit' => 'blogs.edit',
        'update' => 'blogs.update',
        'destroy' => 'blogs.destroy',
    ]);
    Route::patch('/blogs/{blog}/toggle-status', [App\Http\Controllers\Admin\BlogController::class, 'toggleStatus'])->middleware('admin')->name('blogs.toggle-status');

    // CMS Pages Management
    Route::resource('cms', App\Http\Controllers\Admin\CmsController::class)->parameters([
        'cms' => 'page'
    ])->middleware('admin')->names([
        'index' => 'cms.index',
        'create' => 'cms.create',
        'store' => 'cms.store',
        'show' => 'cms.show',
        'edit' => 'cms.edit',
        'update' => 'cms.update',
        'destroy' => 'cms.destroy',
    ]);
    Route::patch('/cms/{page}/toggle-status', [App\Http\Controllers\Admin\CmsController::class, 'toggleStatus'])->middleware('admin')->name('cms.toggle-status');
    Route::get('/cms/template-fields/{template}', [App\Http\Controllers\Admin\CmsController::class, 'getTemplateFields'])->middleware('admin')->name('cms.template-fields');

    // Media Management
    Route::get('/media', [App\Http\Controllers\Admin\MediaController::class, 'index'])->middleware('admin')->name('media.index');
    Route::get('/media/api/files', [App\Http\Controllers\Admin\MediaController::class, 'apiFiles'])->middleware('admin')->name('media.api.files');
    Route::post('/media/upload', [App\Http\Controllers\Admin\MediaController::class, 'store'])->middleware('admin')->name('media.store');
    Route::post('/media/create-folder', [App\Http\Controllers\Admin\MediaController::class, 'createFolder'])->middleware('admin')->name('media.create-folder');
    Route::get('/media/download/{file}', [App\Http\Controllers\Admin\MediaController::class, 'download'])->middleware('admin')->name('media.download');
    Route::delete('/media', [App\Http\Controllers\Admin\MediaController::class, 'destroy'])->middleware('admin')->name('media.destroy');

    // SEO Tools (specific routes first)
    Route::get('/seo/sitemap', [App\Http\Controllers\Admin\SeoController::class, 'sitemap'])->middleware('admin')->name('seo.sitemap');
    Route::get('/seo/robots', [App\Http\Controllers\Admin\SeoController::class, 'robots'])->middleware('admin')->name('seo.robots');
    Route::post('/seo/robots', [App\Http\Controllers\Admin\SeoController::class, 'updateRobots'])->middleware('admin')->name('seo.update-robots');
    Route::get('/seo/page-speed', [App\Http\Controllers\Admin\SeoController::class, 'pageSpeed'])->middleware('admin')->name('seo.page-speed');

    // SEO Management (resource routes after specific routes)
    Route::resource('seo', App\Http\Controllers\Admin\SeoController::class)->middleware('admin')->names([
        'index' => 'seo.index',
        'create' => 'seo.create',
        'store' => 'seo.store',
        'show' => 'seo.show',
        'edit' => 'seo.edit',
        'update' => 'seo.update',
        'destroy' => 'seo.destroy',
    ]);
    Route::get('/seo-pages', [App\Http\Controllers\Admin\SeoController::class, 'getPages'])->middleware('admin')->name('seo.get-pages');

    // Home Page Management
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->middleware('admin')->name('home.index');
    Route::post('/home', [App\Http\Controllers\Admin\HomeController::class, 'update'])->middleware('admin')->name('home.update');
    Route::get('/home/preview', [App\Http\Controllers\Admin\HomeController::class, 'preview'])->middleware('admin')->name('home.preview');

    // General Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->middleware('admin')->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->middleware('admin')->name('settings.update');

    // Social Media Settings
    Route::get('/settings/social-media', [App\Http\Controllers\Admin\SettingController::class, 'socialMedia'])->middleware('admin')->name('settings.social-media');
    Route::post('/settings/social-media', [App\Http\Controllers\Admin\SettingController::class, 'updateSocialMedia'])->middleware('admin')->name('settings.update-social-media');

    // Logs Management
    Route::get('/settings/logs', [App\Http\Controllers\Admin\SettingController::class, 'logs'])->middleware('admin')->name('settings.logs');
    Route::get('/settings/logs/{filename}', [App\Http\Controllers\Admin\SettingController::class, 'viewLog'])->middleware('admin')->name('settings.view-log');
    Route::post('/settings/logs/{filename}/clear', [App\Http\Controllers\Admin\SettingController::class, 'clearLog'])->middleware('admin')->name('settings.clear-log');
    Route::post('/settings/logs/clear-all', [App\Http\Controllers\Admin\SettingController::class, 'clearAllLogs'])->middleware('admin')->name('settings.clear-all-logs');

    // Backup Management
    Route::get('/settings/backup', [App\Http\Controllers\Admin\SettingController::class, 'backup'])->middleware('admin')->name('settings.backup');
    Route::post('/settings/backup/database', [App\Http\Controllers\Admin\SettingController::class, 'createDatabaseBackup'])->middleware('admin')->name('settings.backup.database');
    Route::post('/settings/backup/web', [App\Http\Controllers\Admin\SettingController::class, 'createWebBackup'])->middleware('admin')->name('settings.backup.web');

    // Maintenance Mode
    Route::get('/settings/maintenance', [App\Http\Controllers\Admin\SettingController::class, 'maintenance'])->middleware('admin')->name('settings.maintenance');
    Route::post('/settings/maintenance', [App\Http\Controllers\Admin\SettingController::class, 'toggleMaintenance'])->middleware('admin')->name('settings.toggle-maintenance');

    // Testimonials Management
    Route::prefix('testimonials')->name('testimonials.')->middleware('admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\TestimonialController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\TestimonialController::class, 'store'])->name('store');
        Route::get('/{testimonial}', [App\Http\Controllers\Admin\TestimonialController::class, 'show'])->name('show');
        Route::get('/{testimonial}/edit', [App\Http\Controllers\Admin\TestimonialController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}', [App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('update');
        Route::delete('/{testimonial}', [App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('destroy');
        Route::patch('/{testimonial}/toggle-status', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\TestimonialController::class, 'bulkAction'])->name('bulk-action');
    });

    // Activity Logs
    Route::get('/settings/activity', [App\Http\Controllers\Admin\SettingController::class, 'activity'])->middleware('admin')->name('settings.activity');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->middleware('admin')->name('notifications.index');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->middleware('admin')->name('notifications.mark-all-read');
    Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->middleware('admin')->name('notifications.mark-read');
});

require __DIR__.'/auth.php';
