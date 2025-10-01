@extends('frontend.layout')

@section('title', $blog->meta_title ?? $blog->title)
@section('meta-description', $blog->meta_description ?? Str::limit(strip_tags($blog->content), 160))
@section('meta-keywords', $blog->meta_keywords)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Article Header -->
            <div class="card shadow mb-4">
                <div class="card-body p-0">
                    <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('storage/blog/plumbing-maintenance.jpg') }}"
                         class="card-img-top"
                         alt="{{ $blog->title }}"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDgwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjZjNmNGY2Ii8+Cjx0ZXh0IHg9IjQwMCIgeT0iMTkwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOWNhM2FmIiBmb250LXNpemU9IjI0IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkFydGlrZWwgQmxvZzwvdGV4dD4KPHRleHQgeD0iNDAwIiB5PSIyMzAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM5Y2EzYWYiIGZvbnQtc2l6ZT0iMTYiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiI+R2FtYmFyIFRpZGFrIFRlcnNlZGlhPC90ZXh0Pgo8L3N2Zz4='">
                    <div class="p-4">
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                            @foreach($blog->tags ?? collect() as $tag)
                            <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <h1 class="display-5 fw-bold mb-3">{{ $blog->title }}</h1>
                        <div class="text-muted mb-4">
                            <i class="bi bi-calendar me-2"></i>{{ $blog->published_at ? $blog->published_at->format('d F Y') : $blog->created_at->format('d F Y') }}
                            <i class="bi bi-eye ms-3 me-1"></i>{{ $blog->views }} views
                        </div>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="blog-content">
                        @php
                            $content = $blog->content;
                            // If content doesn't contain HTML tags, convert line breaks to paragraphs
                            if (!preg_match('/<[^>]*>/', $content)) {
                                $content = nl2br($content);
                            }
                        @endphp
                        {!! $content !!}
                    </div>
                </div>
            </div>

            <!-- Social Share -->
            <div class="card shadow mt-4">
                <div class="card-body">
                    <h5 class="card-title">Bagikan Artikel Ini</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Author Info -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Tentang Penulis</h5>
                </div>
                <div class="card-body text-center">
                    <img src="https://via.placeholder.com/80x80/007bff/ffffff?text=A" alt="Author" class="rounded-circle mb-3">
                    <h6 class="fw-bold">SedotWC Team</h6>
                    <p class="text-muted small">Tim ahli jasa sedot WC yang berkomitmen memberikan informasi terbaik untuk kesehatan dan kebersihan WC Anda.</p>
                </div>
            </div>

            <!-- Related Articles -->
            @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Artikel Terkait</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedBlogs as $relatedBlog)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="{{ route('blog.show', $relatedBlog->slug) }}" class="text-decoration-none">
                                {{ $relatedBlog->title }}
                            </a>
                        </h6>
                        <small class="text-muted">
                            {{ $relatedBlog->published_at ? $relatedBlog->published_at->diffForHumans() : $relatedBlog->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Categories -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('blog.index') }}" class="list-group-item list-group-item-action px-0">
                            Semua Kategori
                        </a>
                        @foreach(\App\Models\Category::where('status', 'active')->orderBy('name')->get() as $category)
                        <a href="{{ route('blog.category', $category->slug) }}" class="list-group-item list-group-item-action px-0">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Tag Populer</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach(\App\Models\Tag::where('status', 'active')->orderBy('name')->get() as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="badge bg-outline-primary text-decoration-none">
                            {{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Blog
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Pesan Layanan<i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.blog-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.blog-content h2 {
    color: #007bff;
    margin-top: 3rem;
    margin-bottom: 1.5rem;
    font-size: 2rem;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

.blog-content h3 {
    color: #495057;
    margin-top: 2.5rem;
    margin-bottom: 1.2rem;
    font-size: 1.5rem;
    font-weight: 600;
}

.blog-content h4 {
    color: #6c757d;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-size: 1.25rem;
    font-weight: 500;
}

.blog-content p {
    margin-bottom: 1.5rem;
    color: #495057;
}

.blog-content ul,
.blog-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.blog-content li {
    margin-bottom: 0.5rem;
    color: #495057;
}

.blog-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6c757d;
    background-color: #f8f9fa;
    padding: 1rem 1.5rem;
    border-radius: 0.25rem;
}

.blog-content strong {
    font-weight: 600;
    color: #343a40;
}

.blog-content em {
    font-style: italic;
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .blog-content {
        font-size: 1rem;
    }

    .blog-content h2 {
        font-size: 1.5rem;
        margin-top: 2rem;
    }

    .blog-content h3 {
        font-size: 1.25rem;
        margin-top: 2rem;
    }
}
</style>
@endsection
