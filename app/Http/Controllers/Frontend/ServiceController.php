<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Order;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'active')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('frontend.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        // Increment views if needed
        // $service->incrementViews();

        return view('frontend.services.show', compact('service'));
    }

    public function storeOrder(Request $request, Service $service)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'scheduled_date' => 'required|date|after:today',
            'scheduled_time' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Combine date and time
            $scheduledDateTime = $request->scheduled_date . ' ' . $request->scheduled_time . ':00';

            $order = Order::create([
                'user_id' => Auth::id(), // null for guest orders
                'service_id' => $service->id,
                'status' => 'pending',
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'scheduled_date' => $scheduledDateTime,
                'notes' => $request->notes,
                'total_price' => $service->price,
            ]);

            // Create notifications for all admin users
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                Notification::create([
                    'type' => 'order',
                    'title' => 'Pesanan Layanan Baru',
                    'message' => "Pesanan baru dari {$request->customer_name} untuk {$service->title}. " .
                                "Jadwal: " . Carbon::parse($scheduledDateTime)->format('d/m/Y H:i') . ". " .
                                "Total: Rp " . number_format($service->price, 0, ',', '.'),
                    'icon' => 'bi-receipt',
                    'color' => 'success',
                    'action_url' => route('admin.orders.show', $order),
                    'user_id' => $admin->id,
                    'data' => [
                        'order_id' => $order->id,
                        'service_id' => $service->id,
                        'customer_name' => $request->customer_name,
                        'customer_phone' => $request->customer_phone,
                        'scheduled_date' => $scheduledDateTime,
                        'total_price' => $service->price,
                    ],
                    'is_read' => false,
                ]);
            }

            return redirect()->back()->with('success',
                'Pesanan Anda telah berhasil dikirim! Kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi. ' .
                'Nomor pesanan: #' . str_pad($order->id, 6, '0', STR_PAD_LEFT)
            );

        } catch (\Exception $e) {
            return redirect()->back()->with('error',
                'Terjadi kesalahan saat mengirim pesanan. Silakan coba lagi atau hubungi kami langsung.'
            )->withInput();
        }
    }
}
