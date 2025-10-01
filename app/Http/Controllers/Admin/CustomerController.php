<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $customers = $query->withCount(['orders' => function($query) {
            $query->where('status', '!=', 'cancelled');
        }])->latest()->paginate(15);

        // Statistics
        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'active_customers' => User::where('role', 'customer')->whereNotNull('email_verified_at')->count(),
            'inactive_customers' => User::where('role', 'customer')->whereNull('email_verified_at')->count(),
            'total_orders' => Order::whereHas('user', function($q) {
                $q->where('role', 'customer');
            })->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'customer';

        User::create($data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function show(User $customer)
    {
        // Ensure user is customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load(['orders' => function($query) {
            $query->with('service')->latest()->take(10);
        }]);

        // Statistics
        $stats = [
            'total_orders' => $customer->orders()->count(),
            'completed_orders' => $customer->orders()->where('status', 'completed')->count(),
            'pending_orders' => $customer->orders()->where('status', 'pending')->count(),
            'total_spent' => $customer->orders()->where('status', 'completed')->sum('total_price'),
            'last_order' => $customer->orders()->latest()->first(),
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    public function edit(User $customer)
    {
        // Ensure user is customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        // Ensure user is customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy(User $customer)
    {
        // Ensure user is customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus pelanggan yang memiliki riwayat pesanan');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }

    public function toggleStatus(User $customer)
    {
        // Ensure user is customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        if ($customer->email_verified_at) {
            $customer->update(['email_verified_at' => null]);
            $message = 'Pelanggan berhasil dinonaktifkan';
        } else {
            $customer->update(['email_verified_at' => now()]);
            $message = 'Pelanggan berhasil diaktifkan';
        }

        return redirect()->back()->with('success', $message);
    }
}
