@extends('admin.layout', [
    'title' => 'SEO Management',
    'subtitle' => 'Kelola SEO untuk semua halaman website'
])

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-file-earmark-text fa-2x text-primary"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total SEO Settings
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_settings'] }}</div>
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
                        <i class="bi bi-house fa-2x text-success"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Home SEO
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['home_seo'] }}</div>
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
                        <i class="bi bi-newspaper fa-2x text-info"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Blog SEO
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['blog_seo'] }}</div>
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
                        <i class="bi bi-wrench-adjustable fa-2x text-warning"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Service SEO
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['service_seo'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.seo.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tipe Halaman</label>
                <select name="page_type" class="form-select">
                    <option value="all" {{ request('page_type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                    <option value="home" {{ request('page_type') == 'home' ? 'selected' : '' }}>Homepage</option>
                    <option value="services" {{ request('page_type') == 'services' ? 'selected' : '' }}>Layanan</option>
                    <option value="blogs" {{ request('page_type') == 'blogs' ? 'selected' : '' }}>Blog</option>
                    <option value="cms_pages" {{ request('page_type') == 'cms_pages' ? 'selected' : '' }}>CMS Pages</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cari SEO Setting</label>
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan title atau description..." value="{{ request('search') }}">
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

<!-- Add SEO Setting Button -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('admin.seo.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah SEO Setting
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Halaman</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Status SEO</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seoSettings as $seo)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @php
                                    $pageIcon = match($seo->page_type) {
                                        'home' => 'bi-house text-primary',
                                        'services' => 'bi-wrench-adjustable text-success',
                                        'blogs' => 'bi-newspaper text-info',
                                        'cms_pages' => 'bi-file-text text-warning',
                                        default => 'bi-file-earmark text-muted'
                                    };
                                    $pageTitle = $seo->page ? $seo->page->title : 'Homepage';
                                    $pageTypeLabel = match($seo->page_type) {
                                        'home' => 'Homepage',
                                        'services' => 'Layanan',
                                        'blogs' => 'Blog',
                                        'cms_pages' => 'CMS Page',
                                        default => 'Unknown'
                                    };
                                @endphp
                                <i class="bi {{ $pageIcon }} me-3 fs-5"></i>
                                <div>
                                    <strong>{{ $pageTitle }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $pageTypeLabel }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($seo->meta_title)
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $seo->meta_title }}">
                                    {{ $seo->meta_title }}
                                </div>
                                <small class="text-muted">{{ strlen($seo->meta_title) }}/60</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($seo->meta_description)
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $seo->meta_description }}">
                                    {{ $seo->meta_description }}
                                </div>
                                <small class="text-muted">{{ strlen($seo->meta_description) }}/160</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($seo->meta_title && $seo->meta_description)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Complete
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Incomplete
                                    </span>
                                @endif
                                @if($seo->og_title || $seo->og_description)
                                    <span class="badge bg-info">
                                        <i class="bi bi-share me-1"></i>Open Graph
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">{{ $seo->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.seo.show', $seo) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.seo.edit', $seo) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.seo.destroy', $seo) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEO setting ini?')">
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
                                <i class="bi bi-search fs-1 d-block mb-2"></i>
                                <strong>Belum ada SEO setting</strong>
                                <br>
                                <small>Klik tombol "Tambah SEO Setting" untuk mengoptimalkan halaman website</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($seoSettings->hasPages())
        <div class="card-footer bg-light">
            {{ $seoSettings->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- SEO Tips Card -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>Tips SEO
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Meta Title</h6>
                        <ul class="small mb-3">
                            <li>Maksimal 60 karakter</li>
                            <li>Sertakan kata kunci utama</li>
                            <li>Jadikan unik dan menarik</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Meta Description</h6>
                        <ul class="small mb-3">
                            <li>Maksimal 160 karakter</li>
                            <li>Jelaskan isi halaman</li>
                            <li>Sertakan call-to-action</li>
                        </ul>
                    </div>
                </div>
                <div class="alert alert-light border">
                    <strong>Open Graph</strong> dan <strong>Twitter Cards</strong> akan membuat halaman Anda terlihat lebih menarik saat dibagikan di media sosial.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
