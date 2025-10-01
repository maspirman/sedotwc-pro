<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Models\Blog;
use App\Models\CmsPage;
use App\Models\Service;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        $query = SeoSetting::with('page');

        // Filter by page type
        if ($request->filled('page_type') && $request->page_type !== 'all') {
            $query->where('page_type', $request->page_type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('meta_title', 'like', "%{$search}%")
                  ->orWhere('meta_description', 'like', "%{$search}%");
            });
        }

        $seoSettings = $query->latest()->paginate(15);

        // Get available pages for each type
        $availablePages = [
            'home' => [['id' => null, 'title' => 'Homepage']],
            'services' => Service::where('status', 'active')->select('id', 'title')->get()->toArray(),
            'blogs' => Blog::select('id', 'title')->get()->toArray(),
            'cms_pages' => CmsPage::select('id', 'title')->get()->toArray(),
        ];

        // Statistics
        $stats = [
            'total_settings' => SeoSetting::count(),
            'home_seo' => SeoSetting::where('page_type', 'home')->count(),
            'blog_seo' => SeoSetting::where('page_type', 'blogs')->count(),
            'service_seo' => SeoSetting::where('page_type', 'services')->count(),
            'cms_seo' => SeoSetting::where('page_type', 'cms_pages')->count(),
        ];

        return view('admin.seo.index', compact('seoSettings', 'availablePages', 'stats'));
    }

    public function create()
    {
        $pageTypes = [
            'home' => 'Homepage',
            'services' => 'Layanan',
            'blogs' => 'Blog',
            'cms_pages' => 'Halaman CMS',
        ];

        // Get available pages for each type
        $availablePages = [
            'home' => [['id' => null, 'title' => 'Homepage']],
            'services' => Service::where('status', 'active')->select('id', 'title')->get()->toArray(),
            'blogs' => Blog::select('id', 'title')->get()->toArray(),
            'cms_pages' => CmsPage::select('id', 'title')->get()->toArray(),
        ];

        return view('admin.seo.create', compact('pageTypes', 'availablePages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_type' => 'required|string|in:home,services,blogs,cms_pages',
            'page_id' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:500',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:160',
            'twitter_image' => 'nullable|string|max:500',
            'schema_ld' => 'nullable|string',
            'noindex' => 'boolean',
            'nofollow' => 'boolean',
        ]);

        // Check if SEO setting already exists for this page
        $existing = SeoSetting::where('page_type', $request->page_type)
                             ->where('page_id', $request->page_id)
                             ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'SEO setting untuk halaman ini sudah ada. Silakan edit yang sudah ada.');
        }

        $data = $request->only([
            'page_type', 'page_id', 'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'og_image', 'twitter_title', 'twitter_description',
            'twitter_image', 'noindex', 'nofollow'
        ]);

        // Parse schema_ld JSON if provided
        if ($request->filled('schema_ld')) {
            $data['schema_ld'] = json_decode($request->schema_ld, true);
        }

        SeoSetting::create($data);

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO setting berhasil dibuat');
    }

    public function show(SeoSetting $seoSetting)
    {
        $seoSetting->load('page');
        return view('admin.seo.show', compact('seoSetting'));
    }

    public function edit(SeoSetting $seoSetting)
    {
        $pageTypes = [
            'home' => 'Homepage',
            'services' => 'Layanan',
            'blogs' => 'Blog',
            'cms_pages' => 'Halaman CMS',
        ];

        // Get available pages for each type
        $availablePages = [
            'home' => [['id' => null, 'title' => 'Homepage']],
            'services' => Service::where('status', 'active')->select('id', 'title')->get()->toArray(),
            'blogs' => Blog::select('id', 'title')->get()->toArray(),
            'cms_pages' => CmsPage::select('id', 'title')->get()->toArray(),
        ];

        return view('admin.seo.edit', compact('seoSetting', 'pageTypes', 'availablePages'));
    }

    public function update(Request $request, SeoSetting $seoSetting)
    {
        $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:500',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:160',
            'twitter_image' => 'nullable|string|max:500',
            'schema_ld' => 'nullable|string',
            'noindex' => 'boolean',
            'nofollow' => 'boolean',
        ]);

        $data = $request->only([
            'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'og_image', 'twitter_title', 'twitter_description',
            'twitter_image', 'noindex', 'nofollow'
        ]);

        // Parse schema_ld JSON if provided
        if ($request->filled('schema_ld')) {
            $data['schema_ld'] = json_decode($request->schema_ld, true);
        }

        $seoSetting->update($data);

        return redirect()->route('admin.seo.show', $seoSetting)
            ->with('success', 'SEO setting berhasil diperbarui');
    }

    public function destroy(SeoSetting $seoSetting)
    {
        $seoSetting->delete();

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO setting berhasil dihapus');
    }

    public function getPages(Request $request)
    {
        $pageType = $request->page_type;

        $pages = match($pageType) {
            'home' => [['id' => null, 'title' => 'Homepage']],
            'services' => Service::where('status', 'active')->select('id', 'title')->get()->toArray(),
            'blogs' => Blog::select('id', 'title')->get()->toArray(),
            'cms_pages' => CmsPage::select('id', 'title')->get()->toArray(),
            default => [],
        };

        return response()->json($pages);
    }

    /**
     * Generate and display sitemap
     */
    public function sitemap()
    {
        $sitemapData = $this->generateSitemapData();

        return view('admin.seo.sitemap', compact('sitemapData'));
    }

    /**
     * Robots.txt management
     */
    public function robots()
    {
        $robotsPath = public_path('robots.txt');
        $currentContent = '';

        if (file_exists($robotsPath)) {
            $currentContent = file_get_contents($robotsPath);
        } else {
            // Default robots.txt content
            $currentContent = $this->getDefaultRobotsContent();
        }

        return view('admin.seo.robots', compact('currentContent'));
    }

    /**
     * Update robots.txt
     */
    public function updateRobots(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $robotsPath = public_path('robots.txt');

        if (file_put_contents($robotsPath, $request->content)) {
            return redirect()->back()->with('success', 'Robots.txt berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui robots.txt');
    }

    /**
     * Page speed optimization dashboard
     */
    public function pageSpeed()
    {
        $stats = [
            'minification_enabled' => true,
            'css_defer_enabled' => true,
            'js_defer_enabled' => false, // Disabled for compatibility
            'image_optimization' => false, // Not implemented yet
            'caching_enabled' => false, // Not implemented yet
        ];

        $recommendations = [
            'Enable Gzip compression in web server',
            'Use CDN for static assets',
            'Optimize images (WebP format)',
            'Enable browser caching',
            'Minify CSS and JavaScript files',
        ];

        return view('admin.seo.page-speed', compact('stats', 'recommendations'));
    }

    /**
     * Generate sitemap data
     */
    private function generateSitemapData()
    {
        $data = [];

        // Homepage
        $data[] = [
            'url' => url('/'),
            'priority' => '1.0',
            'changefreq' => 'daily',
            'lastmod' => now()->format('Y-m-d'),
        ];

        // Services
        $services = Service::where('status', 'active')->get();
        foreach ($services as $service) {
            $data[] = [
                'url' => route('services.show', $service->slug),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $service->updated_at->format('Y-m-d'),
            ];
        }

        // Blogs
        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            $data[] = [
                'url' => route('blog.show', $blog->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => $blog->updated_at->format('Y-m-d'),
            ];
        }

        // CMS Pages
        $cmsPages = CmsPage::where('status', 'active')->get();
        foreach ($cmsPages as $page) {
            $data[] = [
                'url' => route('page.show', $page->slug),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => $page->updated_at->format('Y-m-d'),
            ];
        }

        return $data;
    }

    /**
     * Get default robots.txt content
     */
    private function getDefaultRobotsContent()
    {
        return "User-agent: *
Allow: /

# Block access to admin area
Disallow: /admin/
Disallow: /dashboard

# Block access to sensitive files
Disallow: /storage/app/
Disallow: /storage/logs/

# Sitemap
Sitemap: " . url('sitemap.xml');
    }
}
