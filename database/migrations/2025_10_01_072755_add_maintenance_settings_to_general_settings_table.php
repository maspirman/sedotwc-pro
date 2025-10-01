<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert maintenance settings
        $maintenanceSettings = [
            [
                'key' => 'maintenance_title',
                'value' => 'Website Sedang Dalam Perbaikan',
                'type' => 'text',
                'group' => 'maintenance',
                'description' => 'Judul halaman maintenance',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Kami sedang melakukan perbaikan untuk memberikan pengalaman yang lebih baik. Website akan segera kembali normal.',
                'type' => 'textarea',
                'group' => 'maintenance',
                'description' => 'Pesan yang ditampilkan di halaman maintenance',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_estimated_time',
                'value' => '1-2 jam lagi',
                'type' => 'text',
                'group' => 'maintenance',
                'description' => 'Estimasi waktu kembali online',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_progress',
                'value' => '75',
                'type' => 'number',
                'group' => 'maintenance',
                'description' => 'Progress maintenance (dalam persen)',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_retry',
                'value' => '60',
                'type' => 'number',
                'group' => 'maintenance',
                'description' => 'Waktu refresh otomatis dalam detik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_background_color',
                'value' => '#667eea',
                'type' => 'color',
                'group' => 'maintenance',
                'description' => 'Warna background halaman maintenance',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_show_social_links',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'maintenance',
                'description' => 'Tampilkan link media sosial di halaman maintenance',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($maintenanceSettings as $setting) {
            // Check if setting already exists
            $exists = DB::table('general_settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                DB::table('general_settings')->insert($setting);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            //
        });
    }
};
