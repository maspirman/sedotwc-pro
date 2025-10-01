<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'tags']);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest()->paginate(12);
        $categories = Category::where('status', 'active')->get();

        // Statistics
        $stats = [
            'total_blogs' => Blog::count(),
            'published_blogs' => Blog::where('status', 'published')->count(),
            'draft_blogs' => Blog::where('status', 'draft')->count(),
            'total_views' => Blog::sum('views'),
        ];

        return view('admin.blogs.index', compact('blogs', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        $tags = Tag::where('status', 'active')->get();
        return view('admin.blogs.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_path' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $data = $request->only([
            'title', 'content', 'category_id', 'meta_title',
            'meta_description', 'meta_keywords', 'status'
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        } elseif ($request->published_at) {
            $data['published_at'] = Carbon::parse($request->published_at);
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $imagePath;
        }
        // Handle media library selection
        elseif ($request->featured_image_path) {
            // Validate that the selected image exists in media library
            if (Storage::disk('public')->exists($request->featured_image_path)) {
                $data['featured_image'] = $request->featured_image_path;
            }
        }

        $blog = Blog::create($data);

        // Attach tags
        if ($request->tags) {
            $blog->tags()->attach($request->tags);
        }

        return redirect()->route('admin.blogs.show', $blog)
            ->with('success', 'Artikel blog berhasil dibuat');
    }

    public function show(Blog $blog)
    {
        $blog->load(['category', 'tags']);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Category::where('status', 'active')->get();
        $tags = Tag::where('status', 'active')->get();
        $selectedTags = $blog->tags->pluck('id')->toArray();
        return view('admin.blogs.edit', compact('blog', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_path' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $data = $request->only([
            'title', 'content', 'category_id', 'meta_title',
            'meta_description', 'meta_keywords', 'status'
        ]);

        // Update slug only if title changed
        if ($request->title !== $blog->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->status === 'published' && !$request->published_at && !$blog->published_at) {
            $data['published_at'] = now();
        } elseif ($request->published_at) {
            $data['published_at'] = Carbon::parse($request->published_at);
        }

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if it's not from media library (to avoid deleting shared images)
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image) &&
                !str_starts_with($blog->featured_image, 'blogs/')) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $imagePath = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $imagePath;
        }
        // Handle media library selection
        elseif ($request->featured_image_path) {
            // Delete old image if it's uploaded to blogs folder (not shared media)
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image) &&
                str_starts_with($blog->featured_image, 'blogs/')) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            // Validate that the selected image exists in media library
            if (Storage::disk('public')->exists($request->featured_image_path)) {
                $data['featured_image'] = $request->featured_image_path;
            }
        }

        $blog->update($data);

        // Sync tags
        if ($request->tags) {
            $blog->tags()->sync($request->tags);
        } else {
            $blog->tags()->detach();
        }

        return redirect()->route('admin.blogs.show', $blog)
            ->with('success', 'Artikel blog berhasil diperbarui');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image if exists
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        // Detach tags
        $blog->tags()->detach();

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Artikel blog berhasil dihapus');
    }

    public function toggleStatus(Blog $blog)
    {
        if ($blog->status === 'published') {
            $blog->update(['status' => 'draft']);
            $message = 'Artikel berhasil diubah ke draft';
        } else {
            $blog->update([
                'status' => 'published',
                'published_at' => $blog->published_at ?? now()
            ]);
            $message = 'Artikel berhasil dipublikasikan';
        }

        return redirect()->back()->with('success', $message);
    }
}
