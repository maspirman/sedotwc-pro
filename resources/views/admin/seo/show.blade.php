@extends('admin.layout', [
    'title' => 'Detail SEO Setting',
    'subtitle' => 'Informasi lengkap pengaturan SEO'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- SEO Information -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>SEO Setting Details
                </h6>
                <div>
                    <a href="{{ route('admin.seo.edit', $seoSetting) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.seo.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Page Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Informasi Halaman</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 140px;">Tipe Halaman:</td>
                                <td>
                                    @php
                                        $pageTypeLabels = [
                                            'home' => 'Homepage',
                                            'services' => 'Layanan',
                                            'blogs' => 'Blog',
                                            'cms_pages' => 'Halaman CMS'
                                        ];
                                    @endphp
                                    <span class="badge bg-primary">{{ $pageTypeLabels[$seoSetting->page_type] ?? $seoSetting->page_type }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Halaman:</td>
                                <td>{{ $seoSetting->page ? $seoSetting->page->title : 'Homepage' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Dibuat:</td>
                                <td>{{ $seoSetting->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Diupdate:</td>
                                <td>{{ $seoSetting->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Status SEO</h6>
                        <div class="d-flex gap-2 mb-2">
                            @if($seoSetting->meta_title && $seoSetting->meta_description)
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle me-1"></i>Meta Complete
                                </span>
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Meta Incomplete
                                </span>
                            @endif

                            @if($seoSetting->og_title || $seoSetting->og_description)
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-share me-1"></i>Open Graph
                                </span>
                            @endif

                            @if($seoSetting->twitter_title || $seoSetting->twitter_description)
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-twitter me-1"></i>Twitter Cards
                                </span>
                            @endif
                        </div>

                        @if($seoSetting->schema_ld)
                            <div class="mb-2">
                                <span class="badge bg-secondary fs-6">
                                    <i class="bi bi-code-slash me-1"></i>Schema.org
                                </span>
                            </div>
                        @endif

                        @if($seoSetting->noindex || $seoSetting->nofollow)
                            <div class="alert alert-warning py-2">
                                <small class="mb-0">
                                    @if($seoSetting->noindex)<strong>Noindex</strong> aktif @endif
                                    @if($seoSetting->noindex && $seoSetting->nofollow) • @endif
                                    @if($seoSetting->nofollow)<strong>Nofollow</strong> aktif @endif
                                </small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Meta Tags -->
                <h6 class="text-primary mb-3">Meta Tags</h6>
                <div class="row mb-4">
                    <div class="col-md-12">
                        @if($seoSetting->meta_title)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Title:</label>
                            <div class="border p-2 bg-light rounded">
                                {{ $seoSetting->meta_title }}
                                <small class="text-muted d-block">{{ strlen($seoSetting->meta_title) }}/60 karakter</small>
                            </div>
                        </div>
                        @endif

                        @if($seoSetting->meta_description)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Description:</label>
                            <div class="border p-2 bg-light rounded">
                                {{ $seoSetting->meta_description }}
                                <small class="text-muted d-block">{{ strlen($seoSetting->meta_description) }}/160 karakter</small>
                            </div>
                        </div>
                        @endif

                        @if($seoSetting->meta_keywords)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Meta Keywords:</label>
                            <div class="border p-2 bg-light rounded">
                                {{ $seoSetting->meta_keywords }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Open Graph -->
                @if($seoSetting->og_title || $seoSetting->og_description || $seoSetting->og_image)
                <h6 class="text-primary mb-3">Open Graph (Facebook)</h6>
                <div class="row mb-4">
                    <div class="col-md-12">
                        @if($seoSetting->og_title)
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Title:</label>
                            <div class="border p-2 bg-light rounded">{{ $seoSetting->og_title }}</div>
                        </div>
                        @endif

                        @if($seoSetting->og_description)
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Description:</label>
                            <div class="border p-2 bg-light rounded">{{ $seoSetting->og_description }}</div>
                        </div>
                        @endif

                        @if($seoSetting->og_image)
                        <div class="mb-3">
                            <label class="form-label fw-bold">OG Image:</label>
                            <div class="border p-2 bg-light rounded">
                                <a href="{{ $seoSetting->og_image }}" target="_blank">{{ $seoSetting->og_image }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Twitter Cards -->
                @if($seoSetting->twitter_title || $seoSetting->twitter_description || $seoSetting->twitter_image)
                <h6 class="text-primary mb-3">Twitter Cards</h6>
                <div class="row mb-4">
                    <div class="col-md-12">
                        @if($seoSetting->twitter_title)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Twitter Title:</label>
                            <div class="border p-2 bg-light rounded">{{ $seoSetting->twitter_title }}</div>
                        </div>
                        @endif

                        @if($seoSetting->twitter_description)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Twitter Description:</label>
                            <div class="border p-2 bg-light rounded">{{ $seoSetting->twitter_description }}</div>
                        </div>
                        @endif

                        @if($seoSetting->twitter_image)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Twitter Image:</label>
                            <div class="border p-2 bg-light rounded">
                                <a href="{{ $seoSetting->twitter_image }}" target="_blank">{{ $seoSetting->twitter_image }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Schema.org -->
                @if($seoSetting->schema_ld)
                <h6 class="text-primary mb-3">Schema.org JSON-LD</h6>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Structured Data:</label>
                            <pre class="border p-3 bg-light rounded"><code>{{ json_encode($seoSetting->schema_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Search Preview -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-search me-2"></i>Google Preview
                </h6>
            </div>
            <div class="card-body">
                <div class="google-preview">
                    <div class="title" style="font-size: 20px; color: #1a0dab; line-height: 1.3; margin-bottom: 5px;">
                        {{ $seoSetting->meta_title ?: 'Page Title' }}
                    </div>
                    <div class="url" style="color: #006621; font-size: 14px; margin-bottom: 5px;">
                        {{ url()->current() }}
                    </div>
                    <div class="description" style="color: #545454; font-size: 14px; line-height: 1.4;">
                        {{ $seoSetting->meta_description ?: 'Page description appears here...' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Facebook Preview -->
        @if($seoSetting->og_title || $seoSetting->og_description || $seoSetting->og_image)
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-facebook me-2"></i>Facebook Preview
                </h6>
            </div>
            <div class="card-body">
                @if($seoSetting->og_image)
                <img src="{{ $seoSetting->og_image }}" alt="OG Image" class="img-fluid mb-2" style="max-height: 200px; width: 100%; object-fit: cover;">
                @endif
                <div class="fb-preview">
                    <div class="title" style="font-weight: 600; color: #1d2129; margin-bottom: 5px;">
                        {{ $seoSetting->og_title ?: $seoSetting->meta_title ?: 'Page Title' }}
                    </div>
                    <div class="description" style="color: #606770; font-size: 14px;">
                        {{ $seoSetting->og_description ?: $seoSetting->meta_description ?: 'Page description...' }}
                    </div>
                    <div class="url" style="color: #606770; font-size: 12px; margin-top: 5px;">
                        {{ url()->current() }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-gear me-2"></i>Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.seo.edit', $seoSetting) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Edit SEO Setting
                    </a>
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash me-1"></i>Hapus SEO Setting
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.seo.destroy', $seoSetting) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus SEO setting untuk halaman <strong>{{ $seoSetting->page ? $seoSetting->page->title : 'Homepage' }}</strong>?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
