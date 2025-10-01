<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomeSetting;

class HomeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Hero Section
            ['section' => 'hero', 'key' => 'badge', 'value' => 'TERPERCAYA SEJAK 2015', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'title', 'value' => 'Jasa Sedot WC 24 Jam', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'subtitle', 'value' => 'Profesional & Modern', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'description', 'value' => 'Layanan darurat WC mampet tersedia 24 jam dengan tim ahli berpengalaman, peralatan canggih, dan harga terjangkau. Solusi cepat untuk masalah WC Anda!', 'type' => 'textarea'],
            ['section' => 'hero', 'key' => 'emergency_phone', 'value' => '(021) 1234-5678', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'whatsapp', 'value' => '0812-3456-7890', 'type' => 'text'],

            // About Section
            ['section' => 'about', 'key' => 'title', 'value' => 'Mengapa Memilih SedotWC?', 'type' => 'text'],
            ['section' => 'about', 'key' => 'description', 'value' => 'Tim ahli dengan pengalaman 10+ tahun menggunakan peralatan modern untuk memberikan layanan terbaik.', 'type' => 'textarea'],

            // Stats Section
            ['section' => 'stats', 'key' => 'pelanggan_puas', 'value' => '1000', 'type' => 'number'],
            ['section' => 'stats', 'key' => 'layanan_24jam', 'value' => '24/7', 'type' => 'text'],
            ['section' => 'stats', 'key' => 'tahun_pengalaman', 'value' => '10', 'type' => 'number'],
            ['section' => 'stats', 'key' => 'rating_google', 'value' => '4.9', 'type' => 'number'],

            // CTA Section
            ['section' => 'cta', 'key' => 'title', 'value' => 'Butuh Layanan Sedot WC?', 'type' => 'text'],
            ['section' => 'cta', 'key' => 'description', 'value' => 'Jangan biarkan masalah WC mengganggu kenyamanan Anda. Tim profesional kami siap membantu kapan saja, di mana saja dengan response time 30 menit!', 'type' => 'textarea'],
            ['section' => 'cta', 'key' => 'emergency_badge', 'value' => 'DARURAT WC 24 JAM', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            HomeSetting::create($setting);
        }
    }
}
