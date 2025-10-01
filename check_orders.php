<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;

echo "=== CHECKING ORDERS ===\n";
echo "Total Orders: " . Order::count() . "\n\n";

echo "Orders by Status:\n";
$statusCounts = Order::select('status', \DB::raw('count(*) as count'))
    ->groupBy('status')
    ->get();

foreach ($statusCounts as $status) {
    echo "- {$status->status}: {$status->count}\n";
}

echo "\nRecent Orders:\n";
$recentOrders = Order::with(['service', 'user'])->latest()->take(5)->get();

foreach ($recentOrders as $order) {
    $serviceTitle = $order->service ? $order->service->title : 'N/A';
    echo "- {$order->customer_name} ({$order->status}) - {$serviceTitle} - Rp" . number_format($order->total_price, 0, ',', '.') . "\n";
}

echo "\nTotal Revenue: Rp" . number_format(Order::where('status', 'completed')->sum('total_price'), 0, ',', '.') . "\n";
