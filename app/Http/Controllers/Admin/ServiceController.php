<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('orders')->latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_path' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'description', 'price', 'icon', 'status']);
        $data['slug'] = Str::slug($request->title);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
        }
        // Handle media library selection
        elseif ($request->image_path) {
            // Validate that the selected image exists in media library
            if (Storage::disk('public')->exists($request->image_path)) {
                $data['image'] = $request->image_path;
            }
        }

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function show(Service $service)
    {
        $service->load(['orders' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_path' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['title', 'description', 'price', 'icon', 'status']);

        // Update slug only if title changed
        if ($request->title !== $service->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it's not from media library (to avoid deleting shared images)
            if ($service->image && Storage::disk('public')->exists($service->image) &&
                !str_starts_with($service->image, 'services/')) {
                Storage::disk('public')->delete($service->image);
            }

            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
        }
        // Handle media library selection
        elseif ($request->image_path) {
            // Delete old image if it's uploaded to services folder (not shared media)
            if ($service->image && Storage::disk('public')->exists($service->image) &&
                str_starts_with($service->image, 'services/')) {
                Storage::disk('public')->delete($service->image);
            }

            // Validate that the selected image exists in media library
            if (Storage::disk('public')->exists($request->image_path)) {
                $data['image'] = $request->image_path;
            }
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    public function destroy(Service $service)
    {
        // Delete image if exists
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus');
    }

    public function toggleStatus(Service $service)
    {
        $service->update([
            'status' => $service->status === 'active' ? 'inactive' : 'active'
        ]);

        $message = $service->status === 'active' ? 'Layanan berhasil diaktifkan' : 'Layanan berhasil dinonaktifkan';

        return redirect()->back()->with('success', $message);
    }
}
