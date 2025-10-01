<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating !== '') {
            $query->where('rating', $request->rating);
        }

        // Search by customer name or content
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('service_type', 'like', "%{$search}%");
            });
        }

        $testimonials = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Testimonial::count(),
            'active' => Testimonial::where('status', 'active')->count(),
            'inactive' => Testimonial::where('status', 'inactive')->count(),
            'avg_rating' => Testimonial::avg('rating'),
        ];

        return view('admin.testimonials.index', compact('testimonials', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'service_type' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['customer_name', 'content', 'service_type', 'rating', 'status']);

        // Handle image upload
        if ($request->hasFile('customer_image')) {
            $imageName = time() . '_' . $request->file('customer_image')->getClientOriginalName();
            $imagePath = $request->file('customer_image')->storeAs('testimonials', $imageName, 'public');
            $data['customer_image'] = $imagePath;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'service_type' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['customer_name', 'content', 'service_type', 'rating', 'status']);

        // Handle image upload
        if ($request->hasFile('customer_image')) {
            // Delete old image if exists
            if ($testimonial->customer_image && Storage::disk('public')->exists($testimonial->customer_image)) {
                Storage::disk('public')->delete($testimonial->customer_image);
            }

            $imageName = time() . '_' . $request->file('customer_image')->getClientOriginalName();
            $imagePath = $request->file('customer_image')->storeAs('testimonials', $imageName, 'public');
            $data['customer_image'] = $imagePath;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete image if exists
        if ($testimonial->customer_image && Storage::disk('public')->exists($testimonial->customer_image)) {
            Storage::disk('public')->delete($testimonial->customer_image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial berhasil dihapus.');
    }

    /**
     * Toggle testimonial status
     */
    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update([
            'status' => $testimonial->status === 'active' ? 'inactive' : 'active'
        ]);

        $statusText = $testimonial->status === 'active' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Testimonial {$statusText}.");
    }

    /**
     * Bulk actions for testimonials
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('testimonial_ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih testimonial terlebih dahulu.');
        }

        switch ($action) {
            case 'activate':
                Testimonial::whereIn('id', $ids)->update(['status' => 'active']);
                $message = 'Testimonial berhasil diaktifkan.';
                break;

            case 'deactivate':
                Testimonial::whereIn('id', $ids)->update(['status' => 'inactive']);
                $message = 'Testimonial berhasil dinonaktifkan.';
                break;

            case 'delete':
                $testimonials = Testimonial::whereIn('id', $ids)->get();
                foreach ($testimonials as $testimonial) {
                    if ($testimonial->customer_image && Storage::disk('public')->exists($testimonial->customer_image)) {
                        Storage::disk('public')->delete($testimonial->customer_image);
                    }
                }
                Testimonial::whereIn('id', $ids)->delete();
                $message = 'Testimonial berhasil dihapus.';
                break;

            default:
                return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        return redirect()->back()->with('success', $message);
    }
}
