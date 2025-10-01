@extends('admin.layout', ['title' => 'Tambah SEO Setting', 'subtitle' => 'Buat pengaturan SEO untuk halaman website'])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Tambah SEO Setting
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.seo.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipe Halaman</label>
                            <select name="page_type" class="form-select" id="pageTypeSelect" required>
                                <option value="home">Homepage</option>
                                <option value="services">Layanan</option>
                                <option value="blogs">Blog</option>
                                <option value="cms_pages">Halaman CMS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Halaman Spesifik</label>
                            <select name="page_id" class="form-select" id="pageSelect">
                                <option value="">Pilih Halaman</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" maxlength="60">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" maxlength="160"></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.seo.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">Preview SEO</h6>
            </div>
            <div class="card-body">
                <p>Preview akan muncul di sini</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('SEO Create page loaded');
});
</script>
@endpush