<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;
    protected $tags;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create test category
        $this->category = Category::factory()->create([
            'status' => 'active',
        ]);

        // Create test tags
        $this->tags = Tag::factory()->count(3)->create([
            'status' => 'active',
        ]);

        Storage::fake('public');
    }

    /** @test */
    public function admin_can_view_blog_index()
    {
        Blog::factory()->count(5)->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.blogs.index'));

        $response->assertStatus(200);
        $response->assertViewHas('blogs');
        $response->assertViewHas('categories');
        $response->assertViewHas('stats');
    }

    /** @test */
    public function admin_can_create_blog()
    {
        $blogData = [
            'title' => 'Test Blog Post',
            'content' => '<p>This is a test blog content.</p>',
            'category_id' => $this->category->id,
            'meta_title' => 'Test Meta Title',
            'meta_description' => 'Test meta description for SEO',
            'meta_keywords' => 'test, blog, keywords',
            'status' => 'published',
            'published_at' => now()->toDateString(),
            'tags' => $this->tags->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.blogs.store'), $blogData);

        $response->assertRedirect(route('admin.blogs.show', Blog::first()));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Blog Post',
            'status' => 'published',
        ]);

        $blog = Blog::first();
        $this->assertEquals($this->tags->count(), $blog->tags()->count());
    }

    /** @test */
    public function admin_can_create_blog_with_featured_image()
    {
        $file = UploadedFile::fake()->image('featured.jpg');

        $blogData = [
            'title' => 'Blog with Image',
            'content' => '<p>Content with image</p>',
            'category_id' => $this->category->id,
            'featured_image' => $file,
            'status' => 'published',
            'published_at' => now()->toDateString(),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.blogs.store'), $blogData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $blog = Blog::first();
        $this->assertNotNull($blog->featured_image);
        Storage::disk('public')->assertExists($blog->featured_image);
    }

    /** @test */
    public function admin_can_view_blog_details()
    {
        $blog = Blog::factory()->create([
            'category_id' => $this->category->id,
        ]);
        $blog->tags()->attach($this->tags->pluck('id'));

        $response = $this->actingAs($this->admin)->get(route('admin.blogs.show', $blog));

        $response->assertStatus(200);
        $response->assertViewHas('blog');
        $response->assertSee($blog->title);
    }

    /** @test */
    public function admin_can_update_blog()
    {
        $blog = Blog::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $updateData = [
            'title' => 'Updated Blog Title',
            'content' => '<p>Updated content</p>',
            'category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now()->toDateString(),
            'tags' => $this->tags->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.blogs.update', $blog), $updateData);

        $response->assertRedirect(route('admin.blogs.show', $blog));
        $response->assertSessionHas('success');

        $blog->refresh();
        $this->assertEquals('Updated Blog Title', $blog->title);
        $this->assertEquals($this->tags->count(), $blog->tags()->count());
    }

    /** @test */
    public function admin_can_delete_blog()
    {
        $blog = Blog::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.blogs.destroy', $blog));

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }

    /** @test */
    public function admin_can_toggle_blog_status()
    {
        $blog = Blog::factory()->create([
            'status' => 'draft',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.blogs.toggle-status', $blog));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $blog->refresh();
        $this->assertEquals('published', $blog->status);
        $this->assertNotNull($blog->published_at);
    }

    /** @test */
    public function frontend_can_view_published_blogs()
    {
        Blog::factory()->count(3)->create([
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $this->category->id,
        ]);

        Blog::factory()->create([
            'status' => 'draft',
            'category_id' => $this->category->id,
        ]);

        $response = $this->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertViewHas('blogs');

        $blogs = $response->viewData('blogs');
        $this->assertCount(3, $blogs); // Only published blogs should be shown
    }

    /** @test */
    public function frontend_can_filter_blogs_by_category()
    {
        $category1 = Category::factory()->create(['status' => 'active']);
        $category2 = Category::factory()->create(['status' => 'active']);

        Blog::factory()->count(2)->create([
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $category1->id,
        ]);

        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $category2->id,
        ]);

        $response = $this->get(route('blog.category', $category1->slug));

        $response->assertStatus(200);
        $response->assertViewHas('blogs');
        $response->assertViewHas('category', $category1);

        $blogs = $response->viewData('blogs');
        $this->assertCount(2, $blogs);
    }

    /** @test */
    public function frontend_can_search_blogs()
    {
        Blog::factory()->create([
            'title' => 'Laravel Testing Guide',
            'content' => 'Learn how to test Laravel applications',
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $this->category->id,
        ]);

        Blog::factory()->create([
            'title' => 'Vue.js Components',
            'content' => 'Building reusable Vue components',
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $this->category->id,
        ]);

        $response = $this->get(route('blog.index', ['search' => 'Laravel']));

        $response->assertStatus(200);

        $blogs = $response->viewData('blogs');
        $this->assertCount(1, $blogs);
        $this->assertEquals('Laravel Testing Guide', $blogs->first()->title);
    }

    /** @test */
    public function frontend_can_view_blog_detail()
    {
        $blog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $this->category->id,
            'views' => 10,
        ]);

        $response = $this->get(route('blog.show', $blog->slug));

        $response->assertStatus(200);
        $response->assertViewHas('blog', $blog);
        $response->assertViewHas('relatedBlogs');

        $blog->refresh();
        $this->assertEquals(11, $blog->views); // Views should be incremented
    }

    /** @test */
    public function frontend_cannot_view_draft_blog()
    {
        $blog = Blog::factory()->create([
            'status' => 'draft',
            'category_id' => $this->category->id,
        ]);

        $response = $this->get(route('blog.show', $blog->slug));

        $response->assertStatus(404);
    }

    /** @test */
    public function frontend_cannot_view_future_published_blog()
    {
        $blog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDays(1),
            'category_id' => $this->category->id,
        ]);

        $response = $this->get(route('blog.show', $blog->slug));

        $response->assertStatus(404);
    }

    /** @test */
    public function blog_slug_is_automatically_generated()
    {
        $blog = Blog::factory()->create([
            'title' => 'Test Blog Title',
            'category_id' => $this->category->id,
        ]);

        $this->assertEquals('test-blog-title', $blog->slug);
    }

    /** @test */
    public function blog_model_scopes_work_correctly()
    {
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDays(1),
            'category_id' => $this->category->id,
        ]);

        Blog::factory()->create([
            'status' => 'draft',
            'category_id' => $this->category->id,
        ]);

        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDays(1),
            'category_id' => $this->category->id,
        ]);

        $publishedBlogs = Blog::published()->get();
        $draftBlogs = Blog::draft()->get();

        $this->assertCount(1, $publishedBlogs);
        $this->assertCount(1, $draftBlogs);
    }

    /** @test */
    public function blog_increment_views_works()
    {
        $blog = Blog::factory()->create([
            'views' => 5,
            'category_id' => $this->category->id,
        ]);

        $blog->incrementViews();

        $this->assertEquals(6, $blog->fresh()->views);
    }

    /** @test */
    public function validation_fails_with_invalid_data()
    {
        $invalidData = [
            'title' => '',
            'content' => '',
            'category_id' => 999, // Non-existent category
            'status' => 'invalid_status',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.blogs.store'), $invalidData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['title', 'content', 'category_id', 'status']);
    }

    /** @test */
    public function admin_can_filter_blogs_by_status()
    {
        Blog::factory()->count(2)->create([
            'status' => 'published',
            'category_id' => $this->category->id,
        ]);

        Blog::factory()->create([
            'status' => 'draft',
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.blogs.index', ['status' => 'published']));

        $response->assertStatus(200);

        $blogs = $response->viewData('blogs');
        $this->assertCount(2, $blogs);
        $blogs->each(function ($blog) {
            $this->assertEquals('published', $blog->status);
        });
    }

    /** @test */
    public function admin_can_filter_blogs_by_category()
    {
        $category2 = Category::factory()->create(['status' => 'active']);

        Blog::factory()->count(2)->create([
            'category_id' => $this->category->id,
        ]);

        Blog::factory()->create([
            'category_id' => $category2->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.blogs.index', ['category_id' => $this->category->id]));

        $response->assertStatus(200);

        $blogs = $response->viewData('blogs');
        $this->assertCount(2, $blogs);
        $blogs->each(function ($blog) {
            $this->assertEquals($this->category->id, $blog->category_id);
        });
    }
}
