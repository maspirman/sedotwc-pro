<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Sedot WC Standar',
                'description' => 'Layanan sedot WC dengan peralatan standar untuk rumah tangga',
                'price' => 150000,
                'icon' => 'bi-water',
                'status' => 'active',
            ],
            [
                'title' => 'Sedot WC Premium',
                'description' => 'Layanan sedot WC premium dengan peralatan canggih dan pembersihan menyeluruh',
                'price' => 250000,
                'icon' => 'bi-droplet',
                'status' => 'active',
            ],
            [
                'title' => 'Sedot WC + Pembersihan',
                'description' => 'Paket lengkap sedot WC plus pembersihan area sekitar',
                'price' => 300000,
                'icon' => 'bi-shine',
                'status' => 'active',
            ],
            [
                'title' => 'Sedot WC Darurat 24 Jam',
                'description' => 'Layanan emergency sedot WC tersedia 24 jam untuk keadaan darurat',
                'price' => 400000,
                'icon' => 'bi-exclamation-triangle',
                'status' => 'active',
            ],
            [
                'title' => 'Sedot WC Apartemen',
                'description' => 'Layanan khusus untuk sedot WC di apartemen dan kondominium',
                'price' => 200000,
                'icon' => 'bi-building',
                'status' => 'active',
            ],
        ];

        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }
    }
}
