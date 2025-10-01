<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published()->with(['category', 'tags']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(9);

        // Get categories and tags for filters
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $tags = Tag::where('status', 'active')->orderBy('name')->get();

        return view('frontend.blog.index', compact('blogs', 'categories', 'tags'));
    }

    public function category(Category $category)
    {
        $blogs = Blog::published()
                    ->where('category_id', $category->id)
                    ->with(['category', 'tags'])
                    ->orderBy('published_at', 'desc')
                    ->paginate(9);

        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $tags = Tag::where('status', 'active')->orderBy('name')->get();

        return view('frontend.blog.index', compact('blogs', 'categories', 'tags', 'category'));
    }

    public function show(Blog $blog)
    {
        // Only show published blogs
        if ($blog->status !== 'published' || !$blog->published_at || $blog->published_at->isFuture()) {
            abort(404);
        }

        // Increment views
        $blog->incrementViews();

        // Get related blogs
        $relatedBlogs = Blog::published()
                           ->where('category_id', $blog->category_id)
                           ->where('id', '!=', $blog->id)
                           ->orderBy('published_at', 'desc')
                           ->take(3)
                           ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs'));
    }
}
