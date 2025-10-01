<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Sedot WC',
                'status' => 'active',
            ],
            [
                'name' => 'Perawatan WC',
                'status' => 'active',
            ],
            [
                'name' => 'Kebersihan',
                'status' => 'active',
            ],
            [
                'name' => 'Kesehatan',
                'status' => 'active',
            ],
            [
                'name' => 'Tips',
                'status' => 'active',
            ],
            [
                'name' => 'Layanan',
                'status' => 'active',
            ],
            [
                'name' => 'Teknologi',
                'status' => 'active',
            ],
            [
                'name' => 'Panduan',
                'status' => 'active',
            ],
        ];

        foreach ($tags as $tag) {
            \App\Models\Tag::create($tag);
        }
    }
}
