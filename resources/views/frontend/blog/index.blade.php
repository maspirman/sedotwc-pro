@extends('frontend.layout')

@section('title', 'Blog & Tips Sedot WC - Informasi Berguna untuk Anda')
@section('meta-description', 'Baca artikel dan tips berguna seputar perawatan WC, kesehatan, dan teknologi modern dalam layanan sedot WC.')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Blog & Tips</h1>
        <p class="lead text-muted">Informasi berguna seputar perawatan WC dan kesehatan</p>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('blog.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? collect() as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="tag" class="form-control">
                            <option value="">Semua Tag</option>
                            @foreach($tags ?? collect() as $tag)
                            <option value="{{ $tag->slug }}" {{ request('tag') === $tag->slug ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Blog Posts -->
    <div class="row">
        @forelse($blogs ?? collect() as $blog)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('storage/blog/plumbing-tips-1.jpg') }}"
                     class="card-img-top"
                     alt="{{ $blog->title }}"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjI1MCIgdmlld0JveD0iMCAwIDQwMCAyNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMjUwIiBmaWxsPSIjZjNmNGY2Ii8+Cjx0ZXh0IHg9IjIwMCIgeT0iMTIwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOWNhM2FmIiBmb250LXNpemU9IjE4IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkFydGlrZWwgQmxvZzwvdGV4dD4KPHRleHQgeD0iMjAwIiB5PSIxNTAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM5Y2EzYWYiIGZvbnQtc2l6ZT0iMTQiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiI+R2FtYmFyIFRpZGFrIFRlcnNlZGlhPC90ZXh0Pgo8L3N2Zz4='">
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge bg-primary">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                        @foreach($blog->tags ?? collect() as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <h5 class="card-title fw-bold">{{ $blog->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                </div>
                <div class="card-footer text-muted">
                    <small>
                        <i class="bi bi-calendar me-1"></i>{{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                        <i class="bi bi-eye ms-2 me-1"></i>{{ $blog->views }} views
                    </small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center text-muted py-5">
                <i class="bi bi-newspaper fs-1 mb-3"></i>
                <h4>Tidak ada artikel ditemukan</h4>
                <p>Coba ubah kriteria pencarian Anda.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($blogs) && $blogs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $blogs->links() }}
    </div>
    @endif
</div>
@endsection
