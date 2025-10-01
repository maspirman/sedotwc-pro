<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tips Perawatan WC',
                'description' => 'Artikel tentang cara merawat dan membersihkan WC',
                'status' => 'active',
            ],
            [
                'name' => 'Layanan Sedot WC',
                'description' => 'Informasi tentang berbagai layanan sedot WC yang tersedia',
                'status' => 'active',
            ],
            [
                'name' => 'Kesehatan dan Kebersihan',
                'description' => 'Artikel tentang pentingnya kebersihan WC untuk kesehatan',
                'status' => 'active',
            ],
            [
                'name' => 'Teknologi Modern',
                'description' => 'Perkembangan teknologi dalam layanan sedot WC',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
