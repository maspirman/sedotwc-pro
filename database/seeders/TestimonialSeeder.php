<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Ahmad Rahman',
                'content' => 'Layanan sedot WC sangat cepat dan profesional. Tim datang tepat waktu dan mengerjakan dengan bersih. Harga juga sangat terjangkau. Terima kasih SedotWC!',
                'service_type' => 'Sedot WC Standar',
                'rating' => 5,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Siti Nurhaliza',
                'content' => 'Sudah 3 tahun menggunakan jasa SedotWC untuk apartemen saya. Selalu puas dengan pelayanan mereka. Pekerja ramah dan menggunakan peralatan modern.',
                'service_type' => 'Sedot WC Apartemen',
                'rating' => 5,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Budi Santoso',
                'content' => 'Layanan darurat 24 jam sangat membantu ketika WC rumah saya mampet di malam hari. Tim datang dalam waktu 30 menit dan menyelesaikan masalah dengan baik.',
                'service_type' => 'Sedot WC Darurat 24 Jam',
                'rating' => 5,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Maya Sari',
                'content' => 'Paket premium sangat worth it! Selain sedot WC, area kamar mandi juga dibersihkan sampai bersih mengkilap. Recommended!',
                'service_type' => 'Sedot WC Premium',
                'rating' => 4,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Dedi Kurniawan',
                'content' => 'Harga terjangkau dengan kualitas pelayanan yang baik. Akan menggunakan jasa ini lagi di masa depan.',
                'service_type' => 'Sedot WC + Pembersihan',
                'rating' => 4,
                'status' => 'active',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            \App\Models\Testimonial::create($testimonial);
        }
    }
}
