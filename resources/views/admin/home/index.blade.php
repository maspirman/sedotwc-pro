@extends('admin.layout')

@section('title', 'Kelola Konten Home Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-house-door me-2"></i>Kelola Konten Home Page
                    </h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.home.preview') }}" class="btn btn-light btn-sm" target="_blank">
                            <i class="bi bi-eye me-1"></i>Preview
                        </a>
                        <button type="button" id="saveBtn" class="btn btn-success btn-sm d-none">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data" id="homeSettingsForm">
                    @csrf
                    @method('POST')

                    <!-- Navigation Tabs -->
                    <div class="card-header border-0 bg-light">
                        <ul class="nav nav-tabs card-header-tabs" id="homeTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button" role="tab">
                                    <i class="bi bi-star-fill me-1"></i>Hero Section
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">
                                    <i class="bi bi-info-circle me-1"></i>About Section
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab">
                                    <i class="bi bi-graph-up me-1"></i>Statistics
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cta-tab" data-bs-toggle="tab" data-bs-target="#cta" type="button" role="tab">
                                    <i class="bi bi-megaphone me-1"></i>Call-to-Action
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <!-- Tab Content -->
                        <div class="tab-content" id="homeTabsContent">

                            <!-- Hero Section Tab -->
                            <div class="tab-pane fade show active" id="hero" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="hero_badge" name="hero_badge"
                                                           value="{{ $heroSettings['badge'] ?? 'TERPERCAYA SEJAK 2015' }}" placeholder="Badge Terpercaya">
                                                    <label for="hero_badge">
                                                        <i class="bi bi-badge text-primary me-1"></i>Badge Terpercaya
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="hero_title" name="hero_title"
                                                           value="{{ $heroSettings['title'] ?? 'Jasa Sedot WC 24 Jam' }}" placeholder="Judul Utama">
                                                    <label for="hero_title">
                                                        <i class="bi bi-type-h1 text-primary me-1"></i>Judul Utama
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle"
                                                           value="{{ $heroSettings['subtitle'] ?? 'Profesional & Modern' }}" placeholder="Sub Judul">
                                                    <label for="hero_subtitle">
                                                        <i class="bi bi-type-h2 text-primary me-1"></i>Sub Judul
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" id="hero_description" name="hero_description" rows="4"
                                                              placeholder="Deskripsi lengkap tentang layanan Anda">{{ $heroSettings['description'] ?? 'Layanan darurat WC mampet tersedia 24 jam dengan tim ahli berpengalaman, peralatan canggih, dan harga terjangkau. Solusi cepat untuk masalah WC Anda!' }}</textarea>
                                                    <label for="hero_description">
                                                        <i class="bi bi-text-paragraph text-primary me-1"></i>Deskripsi
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="hero_emergency_phone" name="hero_emergency_phone"
                                                           value="{{ $heroSettings['emergency_phone'] ?? '(021) 1234-5678' }}" placeholder="Emergency Phone">
                                                    <label for="hero_emergency_phone">
                                                        <i class="bi bi-telephone text-danger me-1"></i>Emergency Phone
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="hero_whatsapp" name="hero_whatsapp"
                                                           value="{{ $heroSettings['whatsapp'] ?? '0812-3456-7890' }}" placeholder="WhatsApp">
                                                    <label for="hero_whatsapp">
                                                        <i class="bi bi-whatsapp text-success me-1"></i>WhatsApp
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="card border-dashed h-100">
                                            <div class="card-body text-center">
                                                <h6 class="card-title text-muted mb-3">
                                                    <i class="bi bi-image me-1"></i>Gambar Hero
                                                </h6>

                                                <div class="image-upload-area" id="heroImageArea">
                                                    @if(isset($heroSettings['image']) && $heroSettings['image'])
                                                        <div class="current-image mb-3">
                                                            <img src="{{ asset('storage/' . $heroSettings['image']) }}"
                                                                 alt="Hero Image" class="img-fluid rounded shadow-sm"
                                                                 style="max-height: 200px; width: 100%; object-fit: cover;">
                                                        </div>
                                                    @else
                                                        <div class="no-image-placeholder mb-3">
                                                            <div class="text-center p-4 border-dashed rounded">
                                                                <i class="bi bi-image display-4 text-muted"></i>
                                                                <p class="text-muted mt-2">Belum ada gambar</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <input type="file" class="form-control form-control-sm" id="hero_image" name="hero_image" accept="image/*" style="display: none;">
                                                    <button type="button" class="btn btn-outline-primary btn-sm flex-fill" onclick="document.getElementById('hero_image').click()">
                                                        <i class="bi bi-upload me-1"></i>{{ isset($heroSettings['image']) ? 'Ganti' : 'Upload' }}
                                                    </button>
                                                    @if(isset($heroSettings['image']))
                                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeHeroImage()">
                                                            <i class="bi bi-trash me-1"></i>Hapus
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- About Section Tab -->
                            <div class="tab-pane fade" id="about" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="about_title" name="about_title"
                                                           value="{{ $aboutSettings['title'] ?? 'Mengapa Memilih SedotWC?' }}" placeholder="Judul About">
                                                    <label for="about_title">
                                                        <i class="bi bi-type-h1 text-success me-1"></i>Judul About
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" id="about_description" name="about_description" rows="4"
                                                              placeholder="Deskripsi tentang perusahaan Anda">{{ $aboutSettings['description'] ?? 'Tim ahli dengan pengalaman 10+ tahun menggunakan peralatan modern untuk memberikan layanan terbaik.' }}</textarea>
                                                    <label for="about_description">
                                                        <i class="bi bi-text-paragraph text-success me-1"></i>Deskripsi About
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="card border-dashed h-100">
                                            <div class="card-body text-center">
                                                <h6 class="card-title text-muted mb-3">
                                                    <i class="bi bi-image me-1"></i>Gambar About
                                                </h6>

                                                <div class="image-upload-area" id="aboutImageArea">
                                                    @if(isset($aboutSettings['image']) && $aboutSettings['image'])
                                                        <div class="current-image mb-3">
                                                            <img src="{{ asset('storage/' . $aboutSettings['image']) }}"
                                                                 alt="About Image" class="img-fluid rounded shadow-sm"
                                                                 style="max-height: 200px; width: 100%; object-fit: cover;">
                                                        </div>
                                                    @else
                                                        <div class="no-image-placeholder mb-3">
                                                            <div class="text-center p-4 border-dashed rounded">
                                                                <i class="bi bi-image display-4 text-muted"></i>
                                                                <p class="text-muted mt-2">Belum ada gambar</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <input type="file" class="form-control form-control-sm" id="about_image" name="about_image" accept="image/*" style="display: none;">
                                                    <button type="button" class="btn btn-outline-success btn-sm flex-fill" onclick="document.getElementById('about_image').click()">
                                                        <i class="bi bi-upload me-1"></i>{{ isset($aboutSettings['image']) ? 'Ganti' : 'Upload' }}
                                                    </button>
                                                    @if(isset($aboutSettings['image']))
                                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAboutImage()">
                                                            <i class="bi bi-trash me-1"></i>Hapus
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Tab -->
                            <div class="tab-pane fade" id="stats" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-3">
                                        <div class="card h-100 border-warning">
                                            <div class="card-body text-center">
                                                <div class="stat-icon mb-3">
                                                    <i class="bi bi-people-fill display-4 text-warning"></i>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="number" class="form-control text-center fw-bold" id="stats_pelanggan_puas" name="stats_pelanggan_puas"
                                                           value="{{ $statsSettings['pelanggan_puas'] ?? '1000' }}" min="0">
                                                    <label for="stats_pelanggan_puas">Pelanggan Puas</label>
                                                </div>
                                                <small class="text-muted mt-2 d-block">Jumlah pelanggan yang puas</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100 border-info">
                                            <div class="card-body text-center">
                                                <div class="stat-icon mb-3">
                                                    <i class="bi bi-clock-fill display-4 text-info"></i>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control text-center fw-bold" id="stats_layanan_24jam" name="stats_layanan_24jam"
                                                           value="{{ $statsSettings['layanan_24jam'] ?? '24/7' }}">
                                                    <label for="stats_layanan_24jam">Layanan Darurat</label>
                                                </div>
                                                <small class="text-muted mt-2 d-block">Waktu layanan</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100 border-success">
                                            <div class="card-body text-center">
                                                <div class="stat-icon mb-3">
                                                    <i class="bi bi-calendar-check-fill display-4 text-success"></i>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="number" class="form-control text-center fw-bold" id="stats_tahun_pengalaman" name="stats_tahun_pengalaman"
                                                           value="{{ $statsSettings['tahun_pengalaman'] ?? '10' }}" min="0">
                                                    <label for="stats_tahun_pengalaman">Tahun Pengalaman</label>
                                                </div>
                                                <small class="text-muted mt-2 d-block">Pengalaman perusahaan</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card h-100 border-primary">
                                            <div class="card-body text-center">
                                                <div class="stat-icon mb-3">
                                                    <i class="bi bi-star-fill display-4 text-warning"></i>
                                                </div>
                                                <div class="form-floating">
                                                    <input type="number" step="0.1" class="form-control text-center fw-bold" id="stats_rating_google" name="stats_rating_google"
                                                           value="{{ $statsSettings['rating_google'] ?? '4.9' }}" min="0" max="5">
                                                    <label for="stats_rating_google">Rating Google</label>
                                                </div>
                                                <small class="text-muted mt-2 d-block">Rating dari Google</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Tab -->
                            <div class="tab-pane fade" id="cta" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="cta_emergency_badge" name="cta_emergency_badge"
                                                   value="{{ $ctaSettings['emergency_badge'] ?? 'DARURAT WC 24 JAM' }}" placeholder="Emergency Badge">
                                            <label for="cta_emergency_badge">
                                                <i class="bi bi-exclamation-triangle text-danger me-1"></i>Emergency Badge
                                            </label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="cta_title" name="cta_title"
                                                   value="{{ $ctaSettings['title'] ?? 'Butuh Layanan Sedot WC?' }}" placeholder="Judul CTA">
                                            <label for="cta_title">
                                                <i class="bi bi-type-h1 text-danger me-1"></i>Judul Call-to-Action
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="cta_description" name="cta_description" rows="4"
                                                      placeholder="Deskripsi yang menarik untuk call-to-action">{{ $ctaSettings['description'] ?? 'Jangan biarkan masalah WC mengganggu kenyamanan Anda. Tim profesional kami siap membantu kapan saja, di mana saja dengan response time 30 menit!' }}</textarea>
                                            <label for="cta_description">
                                                <i class="bi bi-text-paragraph text-danger me-1"></i>Deskripsi Call-to-Action
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <small><i class="bi bi-info-circle me-1"></i>Perubahan akan disimpan secara otomatis</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan Semua Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.border-dashed {
    border: 2px dashed #dee2e6 !important;
}

.image-upload-area .no-image-placeholder {
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon {
    opacity: 0.7;
}

.form-floating > .form-control:focus,
.form-floating > .form-control:not(:placeholder-shown) {
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    border-bottom-color: #667eea;
    color: #667eea;
    background-color: transparent;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: #667eea;
    color: #667eea;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

@media (max-width: 768px) {
    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }

    .card-footer .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Auto-resize textareas
document.querySelectorAll('textarea').forEach(textarea => {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
});

// Image preview functionality
document.getElementById('hero_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const area = document.getElementById('heroImageArea');
            area.innerHTML = `
                <div class="current-image mb-3">
                    <img src="${e.target.result}" alt="Hero Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('about_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const area = document.getElementById('aboutImageArea');
            area.innerHTML = `
                <div class="current-image mb-3">
                    <img src="${e.target.result}" alt="About Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Remove image functions
function removeHeroImage() {
    if (confirm('Apakah Anda yakin ingin menghapus gambar hero?')) {
        document.getElementById('heroImageArea').innerHTML = `
            <div class="no-image-placeholder mb-3">
                <div class="text-center p-4 border-dashed rounded">
                    <i class="bi bi-image display-4 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada gambar</p>
                </div>
            </div>
        `;

        // Add hidden field to mark for deletion
        let deleteField = document.createElement('input');
        deleteField.type = 'hidden';
        deleteField.name = 'delete_hero_image';
        deleteField.value = '1';
        deleteField.id = 'delete_hero_image';
        document.getElementById('homeSettingsForm').appendChild(deleteField);
    }
}

function removeAboutImage() {
    if (confirm('Apakah Anda yakin ingin menghapus gambar about?')) {
        document.getElementById('aboutImageArea').innerHTML = `
            <div class="no-image-placeholder mb-3">
                <div class="text-center p-4 border-dashed rounded">
                    <i class="bi bi-image display-4 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada gambar</p>
                </div>
            </div>
        `;

        // Add hidden field to mark for deletion
        let deleteField = document.createElement('input');
        deleteField.type = 'hidden';
        deleteField.name = 'delete_about_image';
        deleteField.value = '1';
        deleteField.id = 'delete_about_image';
        document.getElementById('homeSettingsForm').appendChild(deleteField);
    }
}

// Auto-save functionality (optional)
let autoSaveTimeout;
function scheduleAutoSave() {
    clearTimeout(autoSaveTimeout);
    document.getElementById('saveBtn').classList.remove('d-none');
    autoSaveTimeout = setTimeout(() => {
        // Auto-save could be implemented here
        document.getElementById('saveBtn').classList.add('d-none');
    }, 3000);
}

// Add auto-save listeners to all form inputs
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', scheduleAutoSave);
});

// Reset form function
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset semua perubahan?')) {
        document.getElementById('homeSettingsForm').reset();
        location.reload(); // Reload to reset image previews
    }
}

// Form validation
document.getElementById('homeSettingsForm').addEventListener('submit', function(e) {
    // Basic validation
    const requiredFields = ['hero_title', 'hero_description', 'about_title', 'about_description', 'cta_title', 'cta_description'];
    let isValid = true;

    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang diperlukan.');
    }
});
</script>
@endpush
