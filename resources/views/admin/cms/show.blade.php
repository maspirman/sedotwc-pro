@extends('admin.layout', [
    'title' => 'Detail Halaman CMS',
    'subtitle' => 'Melihat detail halaman "' . $page->title . '"'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark me-2"></i>{{ $page->title }}
                    </h5>
                    <span class="badge {{ $page->status === 'active' ? 'bg-success' : 'bg-secondary' }} fs-6">
                        {{ $page->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i class="bi bi-link-45deg me-1"></i>Slug:</strong>
                        <code>{{ $page->slug }}</code>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="bi bi-layout-text-window me-1"></i>Template:</strong>
                        <span class="badge bg-light text-dark">{{ $page->template }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i class="bi bi-calendar-check me-1"></i>Dibuat:</strong>
                        {{ $page->created_at->format('d F Y, H:i') }}
                    </div>
                    <div class="col-md-6">
                        <strong><i class="bi bi-clock me-1"></i>Terakhir Update:</strong>
                        {{ $page->updated_at->format('d F Y, H:i') }}
                    </div>
                </div>

                <hr>

                <div class="cms-content-preview">
                    <h4 class="mb-3">Preview Konten</h4>
                    @if($page->template === 'default')
                        <div class="border rounded p-3 bg-light">
                            {!! $page->content !!}
                        </div>
                    @else
                        <div class="page-preview-iframe" style="border: 1px solid #dee2e6; border-radius: 4px; overflow: auto; height: 380px; width: 100%; display: flex; justify-content: center;">
                            <iframe src="{{ route('page.show', $page) }}"
                                    width="900"
                                    height="1600"
                                    frameborder="0"
                                    scrolling="no"
                                    style="pointer-events: none; transform: scale(0.45); transform-origin: top center; width: 2000px; height: 3556px; flex-shrink: 0;">
                                <p>Browser Anda tidak mendukung iframe.</p>
                            </iframe>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Preview menampilkan tampilan halaman di website
                            </small>
                        </div>
                    @endif
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
                @if($page->meta_title)
                <div class="mb-2">
                    <strong>Meta Title:</strong><br>
                    <small class="text-muted">{{ $page->meta_title }}</small>
                    <br>
                    <small class="text-info">{{ strlen($page->meta_title) }}/60 karakter</small>
                </div>
                @endif

                @if($page->meta_description)
                <div class="mb-2">
                    <strong>Meta Description:</strong><br>
                    <small class="text-muted">{{ $page->meta_description }}</small>
                    <br>
                    <small class="text-info">{{ strlen($page->meta_description) }}/160 karakter</small>
                </div>
                @endif

                @if($page->meta_keywords)
                <div class="mb-2">
                    <strong>Meta Keywords:</strong><br>
                    <small class="text-muted">{{ $page->meta_keywords }}</small>
                </div>
                @endif

                @if(!$page->meta_title && !$page->meta_description && !$page->meta_keywords)
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
                <a href="{{ route('admin.cms.edit', $page) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit Halaman
                </a>

                <form action="{{ route('admin.cms.toggle-status', $page) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $page->status === 'active' ? 'btn-secondary' : 'btn-success' }} w-100">
                        <i class="bi {{ $page->status === 'active' ? 'bi-pause-circle' : 'bi-play-circle' }} me-1"></i>
                        {{ $page->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} Halaman
                    </button>
                </form>

                @if($page->status === 'active')
                <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="btn btn-info">
                    <i class="bi bi-eye me-1"></i>Lihat di Website
                </a>
                @endif

                <hr>

                <form action="{{ route('admin.cms.destroy', $page) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i>Hapus Halaman
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Halaman
        </a>
    </div>
</div>
@endsection

<style>
.cms-content-preview {
    max-width: 100%;
}

.cms-content-preview h1,
.cms-content-preview h2,
.cms-content-preview h3,
.cms-content-preview h4,
.cms-content-preview h5,
.cms-content-preview h6 {
    color: #007bff;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.cms-content-preview p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

.cms-content-preview ul,
.cms-content-preview ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.cms-content-preview li {
    margin-bottom: 0.5rem;
}

.cms-content-preview strong {
    font-weight: 600;
}

.cms-content-preview em {
    font-style: italic;
}
</style>
