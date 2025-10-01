# 🚽 SedotWC - CMS Laravel untuk Bisnis Jasa Sedot WC

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

</div>

---

## 📖 Tentang Project / About Project

### 🇮🇩 Bahasa Indonesia

**SedotWC** adalah Content Management System (CMS) berbasis Laravel yang dirancang khusus untuk bisnis jasa sedot WC dan sanitasi. Sistem ini menyediakan panel administrasi yang lengkap untuk mengelola layanan, pesanan, blog, halaman CMS, testimoni, dan pengaturan website secara mudah dan profesional.

Dibuat dengan framework Laravel 12 dan menggunakan Laravel Breeze untuk autentikasi, project ini menawarkan interface yang modern dan user-friendly dengan dukungan SEO lengkap, media management, backup system, dan mode maintenance.

### 🇬🇧 English

**SedotWC** is a Laravel-based Content Management System (CMS) specifically designed for septic tank cleaning and sanitation service businesses. This system provides a comprehensive admin panel to manage services, orders, blogs, CMS pages, testimonials, and website settings easily and professionally.

Built with Laravel 12 framework and using Laravel Breeze for authentication, this project offers a modern and user-friendly interface with full SEO support, media management, backup system, and maintenance mode.

---

## ✨ Fitur Utama / Key Features

### 🇮🇩 Bahasa Indonesia

- **🔐 Autentikasi & Otorisasi**
  - Login/Register dengan Laravel Breeze
  - Role management (Admin & User)
  - Profile management

- **📋 Manajemen Layanan**
  - CRUD layanan jasa
  - Status aktif/non-aktif
  - Kategori layanan
  - Harga dan deskripsi lengkap

- **📦 Manajemen Pesanan**
  - Tracking status pesanan
  - Update status (pending, processing, completed, cancelled)
  - Bulk update status
  - Export data pesanan
  - Detail pelanggan

- **✍️ Blog & Konten**
  - CRUD artikel blog
  - Kategori & Tags
  - Featured image
  - Rich text editor (Summernote)
  - SEO-friendly URLs

- **📄 CMS Pages**
  - Template-based page builder
  - Dynamic form fields
  - Custom templates support
  - Preview mode

- **⭐ Testimonials**
  - Manajemen testimoni pelanggan
  - Rating system
  - Foto pelanggan
  - Bulk actions

- **🎨 Media Management**
  - Upload gambar
  - File manager
  - Folder organization
  - Download files

- **🔍 SEO Tools**
  - Meta tags management
  - Sitemap generator
  - Robots.txt editor
  - Page speed insights
  - Per-page SEO settings

- **⚙️ Pengaturan Website**
  - General settings
  - Home page settings
  - Social media links
  - Contact information
  - Maintenance mode

- **💾 Backup System**
  - Database backup
  - Web files backup
  - Automated backup downloads

- **📊 Dashboard & Analytics**
  - Statistics overview
  - Recent orders
  - Quick actions
  - Activity logs

### 🇬🇧 English

- **🔐 Authentication & Authorization**
  - Login/Register with Laravel Breeze
  - Role management (Admin & User)
  - Profile management

- **📋 Service Management**
  - CRUD service operations
  - Active/inactive status
  - Service categories
  - Pricing and detailed descriptions

- **📦 Order Management**
  - Order status tracking
  - Status updates (pending, processing, completed, cancelled)
  - Bulk status updates
  - Order data export
  - Customer details

- **✍️ Blog & Content**
  - Blog article CRUD
  - Categories & Tags
  - Featured images
  - Rich text editor (Summernote)
  - SEO-friendly URLs

- **📄 CMS Pages**
  - Template-based page builder
  - Dynamic form fields
  - Custom template support
  - Preview mode

- **⭐ Testimonials**
  - Customer testimonials management
  - Rating system
  - Customer photos
  - Bulk actions

- **🎨 Media Management**
  - Image upload
  - File manager
  - Folder organization
  - File downloads

- **🔍 SEO Tools**
  - Meta tags management
  - Sitemap generator
  - Robots.txt editor
  - Page speed insights
  - Per-page SEO settings

- **⚙️ Website Settings**
  - General settings
  - Home page settings
  - Social media links
  - Contact information
  - Maintenance mode

- **💾 Backup System**
  - Database backup
  - Web files backup
  - Automated backup downloads

- **📊 Dashboard & Analytics**
  - Statistics overview
  - Recent orders
  - Quick actions
  - Activity logs

---

## 🛠️ Tech Stack

- **Backend Framework:** Laravel 12.x
- **PHP Version:** 8.2+
- **Authentication:** Laravel Breeze
- **Frontend:** Blade Templates + TailwindCSS 3.x
- **Database:** SQLite (MySQL/PostgreSQL compatible)
- **Rich Text Editor:** Summernote
- **Icons:** Font Awesome
- **Build Tool:** Vite
- **Package Manager:** Composer & NPM

---

## 📋 Requirements / Persyaratan

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL
- Web Server (Apache/Nginx)

---

## 🚀 Instalasi / Installation

### 🇮🇩 Bahasa Indonesia

1. **Clone Repository**
   ```bash
   git clone https://github.com/yourusername/sedotwc.git
   cd sedotwc
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   
   Edit file `.env` dan sesuaikan dengan database Anda:
   ```env
   DB_CONNECTION=sqlite
   # Atau jika menggunakan MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=sedotwc
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

5. **Jalankan Migration & Seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   # Atau untuk development:
   npm run dev
   ```

7. **Jalankan Server**
   ```bash
   php artisan serve
   ```

8. **Akses Website**
   - Frontend: `http://localhost:8000`
   - Admin Panel: `http://localhost:8000/admin/dashboard`

### 🇬🇧 English

1. **Clone Repository**
   ```bash
   git clone https://github.com/yourusername/sedotwc.git
   cd sedotwc
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   
   Edit `.env` file and configure your database:
   ```env
   DB_CONNECTION=sqlite
   # Or if using MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=sedotwc
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   # Or for development:
   npm run dev
   ```

7. **Start Server**
   ```bash
   php artisan serve
   ```

8. **Access Website**
   - Frontend: `http://localhost:8000`
   - Admin Panel: `http://localhost:8000/admin/dashboard`

---

## 🔑 Default Credentials / Kredensial Default

### Admin Account
- **Email:** `admin@sedotwc.com`
- **Password:** `password`

> ⚠️ **Penting/Important:** Segera ubah password default setelah login pertama / Change the default password immediately after first login!

---

## 📁 Struktur Project / Project Structure

```
sedotwc/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   └── Frontend/       # Frontend controllers
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form requests
│   ├── Models/                 # Eloquent models
│   └── Services/               # Business logic services
├── config/
│   └── cms_templates.php       # CMS template configurations
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Data seeders
├── public/
│   └── assets/                 # Public assets (CSS, JS, images)
├── resources/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── views/                  # Blade templates
│       ├── admin/              # Admin panel views
│       ├── frontend/           # Frontend views
│       └── layouts/            # Layout templates
├── routes/
│   ├── web.php                 # Web routes
│   └── auth.php                # Authentication routes
└── storage/
    ├── app/public/             # Uploaded files
    └── backups/                # Backup files
```

---

## 🎯 Panduan Penggunaan / Usage Guide

### 🇮🇩 Bahasa Indonesia

#### Mengelola Layanan
1. Login ke admin panel
2. Navigasi ke **Services** > **All Services**
3. Klik **Add New Service** untuk menambah layanan baru
4. Isi form dengan detail layanan (nama, deskripsi, harga, kategori, dll)
5. Upload gambar layanan
6. Klik **Save** untuk menyimpan

#### Mengelola Pesanan
1. Navigasi ke **Orders** > **All Orders**
2. Lihat daftar semua pesanan
3. Klik pesanan untuk melihat detail
4. Update status pesanan sesuai progress
5. Export data pesanan jika diperlukan

#### Mengelola Blog
1. Navigasi ke **Blog** > **All Posts**
2. Klik **Add New Post** untuk artikel baru
3. Tulis judul, konten, dan pilih kategori/tags
4. Upload featured image
5. Atur SEO settings (meta title, description, keywords)
6. Publish atau save as draft

#### Mengatur Homepage
1. Navigasi ke **Settings** > **Home Page**
2. Edit konten hero section, stats, about, CTA
3. Upload gambar jika diperlukan
4. Klik **Save Changes**

#### Mode Maintenance
1. Navigasi ke **Settings** > **Maintenance**
2. Toggle maintenance mode ON/OFF
3. Atur pesan maintenance custom
4. Admin tetap bisa akses saat mode maintenance aktif

### 🇬🇧 English

#### Managing Services
1. Login to admin panel
2. Navigate to **Services** > **All Services**
3. Click **Add New Service** to add new service
4. Fill form with service details (name, description, price, category, etc)
5. Upload service image
6. Click **Save** to save

#### Managing Orders
1. Navigate to **Orders** > **All Orders**
2. View all orders list
3. Click order to view details
4. Update order status according to progress
5. Export order data if needed

#### Managing Blog
1. Navigate to **Blog** > **All Posts**
2. Click **Add New Post** for new article
3. Write title, content, and choose categories/tags
4. Upload featured image
5. Set SEO settings (meta title, description, keywords)
6. Publish or save as draft

#### Setting Homepage
1. Navigate to **Settings** > **Home Page**
2. Edit hero section, stats, about, CTA content
3. Upload images if needed
4. Click **Save Changes**

#### Maintenance Mode
1. Navigate to **Settings** > **Maintenance**
2. Toggle maintenance mode ON/OFF
3. Set custom maintenance message
4. Admin can still access during maintenance mode

---

## 🔧 Konfigurasi / Configuration

### CMS Templates

Tambahkan custom template di `config/cms_templates.php`:

```php
'custom_template' => [
    'name' => 'Custom Template',
    'description' => 'Template description',
    'fields' => [
        'field_name' => [
            'type' => 'text',
            'label' => 'Field Label',
            'required' => true,
        ],
    ],
],
```

### SEO Middleware

SEO middleware otomatis menambahkan meta tags ke setiap halaman. Konfigurasi per-page di admin panel.

---

## 📝 Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Watch Assets
```bash
npm run dev
```

### Build for Production
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Storage Permission Error
```bash
chmod -R 775 storage bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🤝 Contributing / Kontribusi

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License / Lisensi

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Author / Pembuat

**mas pirman**

Created on: October 1, 2025

---

## 🙏 Acknowledgments / Ucapan Terima Kasih

- [Laravel Framework](https://laravel.com)
- [Laravel Breeze](https://laravel.com/docs/breeze)
- [TailwindCSS](https://tailwindcss.com)
- [Summernote Editor](https://summernote.org)
- [Font Awesome](https://fontawesome.com)

---

## 📞 Support / Dukungan

Jika Anda menemukan bug atau memiliki saran, silakan buat [issue](https://github.com/yourusername/sedotwc/issues) baru.

If you find a bug or have suggestions, please create a new [issue](https://github.com/yourusername/sedotwc/issues).

---

<div align="center">

⭐ Jangan lupa beri star jika project ini membantu! / Don't forget to star if this project helps you!

Made with ❤️ by mas pirman

</div>

