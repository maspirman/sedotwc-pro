@extends('admin.layout', [
    'title' => 'Detail Artikel Blog',
    'subtitle' => 'Melihat detail artikel "' . $blog->title . '"'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-newspaper me-2"></i>{{ $blog->title }}
                    </h5>
                    <span class="badge {{ $blog->status === 'published' ? 'bg-success' : 'bg-warning' }} fs-6">
                        {{ $blog->status === 'published' ? 'Published' : 'Draft' }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                @if($blog->featured_image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i class="bi bi-tag me-1"></i>Kategori:</strong>
                        @if($blog->category)
                            <span class="badge bg-secondary">{{ $blog->category->name }}</span>
                        @else
                            <span class="text-muted">Tidak ada kategori</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong><i class="bi bi-eye me-1"></i>Views:</strong>
                        <span class="badge bg-info">{{ number_format($blog->views) }}</span>
                    </div>
                </div>

                @if($blog->published_at)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i class="bi bi-calendar-check me-1"></i>Diterbitkan:</strong>
                        {{ $blog->published_at->format('d F Y, H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong><i class="bi bi-clock me-1"></i>Dibuat:</strong>
                        {{ $blog->created_at->format('d F Y, H:i') }}
                    </div>
                </div>
                @endif

                @if($blog->tags->count() > 0)
                <div class="mb-3">
                    <strong><i class="bi bi-tags me-1"></i>Tag:</strong><br>
                    @foreach($blog->tags as $tag)
                        <span class="badge bg-light text-dark me-1">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif

                <hr>

                <div class="article-content">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- SEO Information -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-search me-2"></i>SEO Information
                </h6>
            </div>
            <div class="card-body">
                @if($blog->meta_title)
                <div class="mb-2">
                    <strong>Meta Title:</strong><br>
                    <small class="text-muted">{{ $blog->meta_title }}</small>
                </div>
                @endif

                @if($blog->meta_description)
                <div class="mb-2">
                    <strong>Meta Description:</strong><br>
                    <small class="text-muted">{{ $blog->meta_description }}</small>
                </div>
                @endif

                @if($blog->meta_keywords)
                <div class="mb-2">
                    <strong>Meta Keywords:</strong><br>
                    <small class="text-muted">{{ $blog->meta_keywords }}</small>
                </div>
                @endif

                @if(!$blog->meta_title && !$blog->meta_description && !$blog->meta_keywords)
                <small class="text-muted">Tidak ada informasi SEO</small>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-gear me-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit Artikel
                </a>

                <form action="{{ route('admin.blogs.toggle-status', $blog) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $blog->status === 'published' ? 'btn-secondary' : 'btn-success' }} w-100">
                        <i class="bi {{ $blog->status === 'published' ? 'bi-pause-circle' : 'bi-check-circle' }} me-1"></i>
                        {{ $blog->status === 'published' ? 'Ubah ke Draft' : 'Publish Artikel' }}
                    </button>
                </form>

                @if($blog->status === 'published')
                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-info">
                    <i class="bi bi-eye me-1"></i>Lihat di Website
                </a>
                @endif

                <hr>

                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i>Hapus Artikel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Artikel
        </a>
    </div>
</div>
@endsection
