<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing services and users to avoid foreign key errors
        $services = \App\Models\Service::where('status', 'active')->get();
        $customers = \App\Models\User::where('role', 'customer')->get();

        if ($services->isEmpty() || $customers->isEmpty()) {
            $this->command->error('No active services or customer users found. Please run ServiceSeeder and create some customers first.');
            return;
        }

        // Create some dummy orders with different statuses
        $orders = [
            [
                'customer_name' => 'Ahmad Rahman',
                'customer_phone' => '081234567890',
                'customer_address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'service_id' => $services->first()->id,
                'user_id' => $customers->first()->id,
                'status' => 'pending',
                'scheduled_date' => now()->addDays(1),
                'notes' => 'WC mampet dan bau tidak sedap',
                'total_price' => 150000,
                'created_at' => now()->subDays(2),
            ],
            [
                'customer_name' => 'Siti Nurhaliza',
                'customer_phone' => '081987654321',
                'customer_address' => 'Jl. Thamrin No. 45, Jakarta Selatan',
                'service_id' => $services->count() > 1 ? $services[1]->id : $services->first()->id,
                'user_id' => $customers->count() > 1 ? $customers[1]->id : $customers->first()->id,
                'status' => 'confirmed',
                'scheduled_date' => now()->addDays(2),
                'notes' => 'WC di kamar mandi utama perlu dibersihkan',
                'total_price' => 200000,
                'created_at' => now()->subDays(1),
            ],
            [
                'customer_name' => 'Budi Santoso',
                'customer_phone' => '081345678901',
                'customer_address' => 'Jl. Gatot Subroto No. 67, Jakarta Barat',
                'service_id' => $services->first()->id,
                'user_id' => $customers->count() > 2 ? $customers[2]->id : $customers->first()->id,
                'status' => 'in_progress',
                'scheduled_date' => now(),
                'notes' => 'WC di dapur mampet setelah hujan',
                'total_price' => 180000,
                'created_at' => now()->subHours(6),
            ],
            [
                'customer_name' => 'Maya Sari',
                'customer_phone' => '081456789012',
                'customer_address' => 'Jl. MH Thamrin No. 89, Jakarta Pusat',
                'service_id' => $services->count() > 2 ? $services[2]->id : $services->first()->id,
                'user_id' => $customers->count() > 3 ? $customers[3]->id : $customers->first()->id,
                'status' => 'completed',
                'scheduled_date' => now()->subDays(1),
                'notes' => 'Pembersihan rutin WC apartemen',
                'total_price' => 250000,
                'created_at' => now()->subDays(3),
            ],
            [
                'customer_name' => 'Rudi Hartono',
                'customer_phone' => '081567890123',
                'customer_address' => 'Jl. Sudirman No. 200, Jakarta Pusat',
                'service_id' => $services->count() > 1 ? $services[1]->id : $services->first()->id,
                'user_id' => $customers->count() > 4 ? $customers[4]->id : $customers->first()->id,
                'status' => 'completed',
                'scheduled_date' => now()->subDays(2),
                'notes' => 'Perbaikan dan pembersihan WC kantor',
                'total_price' => 300000,
                'created_at' => now()->subDays(4),
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'customer_phone' => '081678901234',
                'customer_address' => 'Jl. Rasuna Said No. 150, Jakarta Selatan',
                'service_id' => $services->first()->id,
                'user_id' => $customers->count() > 5 ? $customers[5]->id : $customers->first()->id,
                'status' => 'cancelled',
                'scheduled_date' => now()->addDays(3),
                'notes' => 'WC di rumah perlu diperbaiki',
                'total_price' => 220000,
                'created_at' => now()->subDays(1),
            ],
            [
                'customer_name' => 'Agus Salim',
                'customer_phone' => '081789012345',
                'customer_address' => 'Jl. Jendral Sudirman No. 75, Jakarta Timur',
                'service_id' => $services->count() > 2 ? $services[2]->id : $services->first()->id,
                'user_id' => $customers->count() > 6 ? $customers[6]->id : $customers->first()->id,
                'status' => 'pending',
                'scheduled_date' => now()->addDays(4),
                'notes' => 'Pembersihan WC setelah renovasi',
                'total_price' => 275000,
                'created_at' => now()->subHours(12),
            ],
            [
                'customer_name' => 'Nina Kurnia',
                'customer_phone' => '081890123456',
                'customer_address' => 'Jl. Fatmawati No. 30, Jakarta Selatan',
                'service_id' => $services->count() > 1 ? $services[1]->id : $services->first()->id,
                'user_id' => $customers->count() > 7 ? $customers[7]->id : $customers->first()->id,
                'status' => 'confirmed',
                'scheduled_date' => now()->addDays(1),
                'notes' => 'WC di restoran perlu dibersihkan secara menyeluruh',
                'total_price' => 350000,
                'created_at' => now()->subHours(18),
            ],
            [
                'customer_name' => 'Hendra Wijaya',
                'customer_phone' => '081901234567',
                'customer_address' => 'Jl. Casablanca No. 50, Jakarta Selatan',
                'service_id' => $services->first()->id,
                'user_id' => $customers->count() > 8 ? $customers[8]->id : $customers->first()->id,
                'status' => 'completed',
                'scheduled_date' => now()->subDays(5),
                'notes' => 'Perbaikan pipa WC yang bocor',
                'total_price' => 400000,
                'created_at' => now()->subDays(6),
            ],
            [
                'customer_name' => 'Linda Susanti',
                'customer_phone' => '081012345678',
                'customer_address' => 'Jl. Kuningan No. 25, Jakarta Selatan',
                'service_id' => $services->count() > 2 ? $services[2]->id : $services->first()->id,
                'user_id' => $customers->count() > 9 ? $customers[9]->id : $customers->first()->id,
                'status' => 'in_progress',
                'scheduled_date' => now()->subDays(1),
                'notes' => 'Pembersihan deep clean WC rumah',
                'total_price' => 320000,
                'created_at' => now()->subHours(8),
            ],
        ];

        foreach ($orders as $orderData) {
            \App\Models\Order::create($orderData);
        }
    }
}
