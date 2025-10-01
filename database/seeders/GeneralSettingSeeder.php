<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GeneralSetting;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'SedotWC',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nama website/bisnis'
            ],
            [
                'key' => 'site_title',
                'value' => 'Jasa Sedot WC Profesional - Cepat, Bersih & Terpercaya',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Judul website untuk SEO'
            ],
            [
                'key' => 'site_description',
                'value' => 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat. Tim berpengalaman dengan peralatan modern.',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Deskripsi website untuk meta description'
            ],
            [
                'key' => 'site_keywords',
                'value' => 'sedot wc, jasa sedot wc, wc mampet, sedot wc jakarta, jasa sedot wc murah',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Keywords untuk SEO'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@sedotwc.com',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Email kontak utama'
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 1234-5678',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nomor telepon utama'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Alamat lengkap bisnis'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'system',
                'description' => 'Mode maintenance website'
            ],

            // Branding & Assets
            [
                'key' => 'site_logo',
                'value' => '/images/logo.png',
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Logo utama website'
            ],
            [
                'key' => 'site_favicon',
                'value' => '/favicon.ico',
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Favicon website'
            ],
            [
                'key' => 'site_logo_dark',
                'value' => '/images/logo-dark.png',
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Logo untuk background gelap'
            ],
            [
                'key' => 'og_image',
                'value' => '/images/og-image.jpg',
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Gambar untuk Open Graph sharing'
            ],

            // Contact Information
            [
                'key' => 'emergency_phone',
                'value' => '(021) 1234-5678',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor telepon darurat'
            ],
            [
                'key' => 'emergency_whatsapp',
                'value' => '0812-3456-7890',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor WhatsApp darurat'
            ],

            // Social Media Default
            [
                'key' => 'facebook',
                'value' => 'https://facebook.com/sedotwc',
                'type' => 'text',
                'group' => 'social_media',
                'description' => 'Link Facebook'
            ],
            [
                'key' => 'instagram',
                'value' => 'https://instagram.com/sedotwc',
                'type' => 'text',
                'group' => 'social_media',
                'description' => 'Link Instagram'
            ],
            [
                'key' => 'whatsapp_business',
                'value' => 'https://wa.me/6281234567890',
                'type' => 'text',
                'group' => 'social_media',
                'description' => 'Link WhatsApp Business'
            ],
            [
                'key' => 'twitter',
                'value' => 'https://twitter.com/sedotwc',
                'type' => 'text',
                'group' => 'social_media',
                'description' => 'Link Twitter'
            ],
        ];

        foreach ($settings as $setting) {
            GeneralSetting::create($setting);
        }
    }
}
