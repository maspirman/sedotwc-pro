<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Notification::create([
            'type' => 'order',
            'title' => 'Order Baru Masuk',
            'message' => 'Ada order baru dari Ahmad Rahman untuk layanan Sedot WC Premium',
            'icon' => 'bi-receipt',
            'color' => 'success',
            'action_url' => '/admin/orders',
            'is_read' => false,
        ]);

        \App\Models\Notification::create([
            'type' => 'payment',
            'title' => 'Pembayaran Dikonfirmasi',
            'message' => 'Pembayaran order #00123 telah berhasil diverifikasi',
            'icon' => 'bi-cash',
            'color' => 'info',
            'action_url' => '/admin/orders/123',
            'is_read' => false,
        ]);

        \App\Models\Notification::create([
            'type' => 'system',
            'title' => 'Maintenance Selesai',
            'message' => 'Mode maintenance telah dinonaktifkan, website kembali normal',
            'icon' => 'bi-tools',
            'color' => 'warning',
            'action_url' => '/admin/settings/maintenance',
            'is_read' => true,
            'read_at' => now()->subDays(1),
        ]);

        \App\Models\Notification::create([
            'type' => 'order',
            'title' => 'Order Pending Review',
            'message' => 'Ada 3 order yang masih pending konfirmasi',
            'icon' => 'bi-clock',
            'color' => 'warning',
            'action_url' => '/admin/orders?status=pending',
            'is_read' => false,
        ]);

        \App\Models\Notification::create([
            'type' => 'backup',
            'title' => 'Backup Database Berhasil',
            'message' => 'Backup database harian telah berhasil dibuat pada ' . now()->format('d/m/Y H:i'),
            'icon' => 'bi-database',
            'color' => 'primary',
            'action_url' => '/admin/settings/backup',
            'is_read' => true,
            'read_at' => now()->subHours(2),
        ]);
    }
}
