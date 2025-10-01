@extends('admin.layout', [
    'title' => 'Kelola Blog',
    'subtitle' => 'Kelola artikel blog dan konten website'
])

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-newspaper fa-2x text-primary"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Artikel
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_blogs'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Published
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['published_blogs'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-pencil fa-2x text-warning"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Draft
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['draft_blogs'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-eye fa-2x text-info"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Views
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_views']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="all" {{ request('category_id') == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari Artikel</label>
                <input type="text" name="search" class="form-control" placeholder="Judul atau isi artikel..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Article Button -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Artikel
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Artikel</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($blog->featured_image)
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="rounded me-3" style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ $blog->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit(strip_tags($blog->content), 60) }}</small>
                                    @if($blog->tags->count() > 0)
                                        <br>
                                        <small class="text-info">
                                            @foreach($blog->tags as $tag)
                                                <span class="badge bg-light text-dark me-1">{{ $tag->name }}</span>
                                            @endforeach
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($blog->category)
                                <span class="badge bg-secondary">{{ $blog->category->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $blog->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                {{ $blog->status === 'published' ? 'Published' : 'Draft' }}
                            </span>
                            @if($blog->status === 'published' && $blog->published_at)
                                <br>
                                <small class="text-muted">{{ $blog->published_at->format('d/m/Y') }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ number_format($blog->views) }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $blog->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.blogs.toggle-status', $blog) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $blog->status === 'published' ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $blog->status === 'published' ? 'Ubah ke Draft' : 'Publish' }}">
                                        <i class="bi {{ $blog->status === 'published' ? 'bi-pause-circle' : 'bi-check-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-newspaper fs-1 d-block mb-2"></i>
                                <strong>Belum ada artikel</strong>
                                <br>
                                <small>Klik tombol "Tambah Artikel" untuk membuat artikel pertama</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($blogs->hasPages())
        <div class="card-footer bg-light">
            {{ $blogs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
