@extends('admin.layout', [
    'title' => 'Kelola CMS Pages',
    'subtitle' => 'Kelola halaman statis website (About, Contact, FAQ, dll)'
])

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-file-text fa-2x text-primary"></i>
                    </div>
    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Halaman
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_pages'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Halaman Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['active_pages'] }}</div>
</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-pause-circle fa-2x text-warning"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Halaman Nonaktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['inactive_pages'] }}</div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

<!-- Quick Pages Overview -->
@if($pages->count() <= 6)
<div class="row mb-4">
    @foreach($pages as $page)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                @php
                    $iconMap = [
                        'about' => 'bi-info-circle text-primary',
                        'contact' => 'bi-telephone text-success',
                        'faq' => 'bi-question-circle text-warning',
                        'terms' => 'bi-file-earmark-text text-info',
                        'privacy' => 'bi-shield-check text-secondary',
                        'default' => 'bi-file-earmark text-muted'
                    ];
                    $icon = $iconMap[$page->template] ?? $iconMap['default'];
                @endphp
                <i class="bi {{ $icon }} fs-1 mb-3"></i>
                <h5 class="card-title">{{ $page->title }}</h5>
                <p class="card-text text-muted">{{ Str::limit(strip_tags($page->content), 100) }}</p>
                <div class="mt-3">
                    <span class="badge {{ $page->status === 'active' ? 'bg-success' : 'bg-secondary' }} me-2">
                        {{ $page->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <small class="text-muted">Update: {{ $page->updated_at->format('d/m/Y') }}</small>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.cms.show', $page) }}" class="btn btn-sm btn-outline-primary me-1" title="Lihat">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.cms.edit', $page) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($pages->count() < 3)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-dashed">
            <div class="card-body text-center d-flex align-items-center justify-content-center">
                <div>
                    <i class="bi bi-plus-circle text-muted fs-1 mb-3"></i>
                    <h6 class="text-muted">Tambah Halaman Baru</h6>
                    <a href="{{ route('admin.cms.create') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Buat Halaman
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.cms.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Template</label>
                <select name="template" class="form-select">
                    <option value="all" {{ request('template') == 'all' ? 'selected' : '' }}>Semua Template</option>
                    @foreach($templates as $template)
                        <option value="{{ $template['key'] }}" {{ request('template') == $template['key'] ? 'selected' : '' }}>
                            {{ $template['name'] }}
                            @if($template['description'])
                                - {{ $template['description'] }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari Halaman</label>
                <input type="text" name="search" class="form-control" placeholder="Judul atau isi halaman..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
</div>

<!-- Add Page Button -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('admin.cms.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Halaman
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Halaman</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>SEO</th>
                        <th>Terakhir Update</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @php
                                    $iconMap = [
                                        'about' => 'bi-info-circle text-primary',
                                        'contact' => 'bi-telephone text-success',
                                        'faq' => 'bi-question-circle text-warning',
                                        'terms' => 'bi-file-earmark-text text-info',
                                        'privacy' => 'bi-shield-check text-secondary',
                                        'default' => 'bi-file-earmark text-muted'
                                    ];
                                    $icon = $iconMap[$page->template] ?? $iconMap['default'];
                                @endphp
                                <i class="bi {{ $icon }} me-3 fs-5"></i>
                                <div>
                                    <strong>{{ $page->title }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <code>{{ $page->slug }}</code>
                                    </small>
                                    <br>
                                    <small class="text-muted">{{ $page->getPreviewText() }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ App\Models\CmsPage::getTemplateName($page->template) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $page->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $page->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            @if($page->meta_title || $page->meta_description)
                                <span class="badge bg-info">
                                    <i class="bi bi-check-circle me-1"></i>Optimized
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Need SEO
                                </span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $page->updated_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.cms.show', $page) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.cms.edit', $page) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.cms.toggle-status', $page) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $page->status === 'active' ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $page->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi {{ $page->status === 'active' ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                </button>
                                </form>
                                <form action="{{ route('admin.cms.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
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
                                <i class="bi bi-file-earmark fs-1 d-block mb-2"></i>
                                <strong>Belum ada halaman CMS</strong>
                                <br>
                                <small>Klik tombol "Tambah Halaman" untuk membuat halaman pertama</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
        <div class="card-footer bg-light">
            {{ $pages->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
