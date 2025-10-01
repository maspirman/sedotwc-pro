@extends('admin.layout')

@section('title', 'Pengaturan Umum')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-sliders me-2"></i>Pengaturan Umum
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Site Information -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="bi bi-info-circle me-2"></i>Informasi Website
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Nama Bisnis/Website *</label>
                                        <input type="text" class="form-control" id="site_name" name="site_name"
                                               value="{{ $settings['general']['site_name'] ?? 'SedotWC' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="site_title" class="form-label">Judul Website *</label>
                                        <input type="text" class="form-control" id="site_title" name="site_title"
                                               value="{{ $settings['general']['site_title'] ?? 'Jasa Sedot WC Profesional - Cepat, Bersih & Terpercaya' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="site_keywords" class="form-label">Keywords SEO</label>
                                        <input type="text" class="form-control" id="site_keywords" name="site_keywords"
                                               value="{{ $settings['general']['site_keywords'] ?? 'sedot wc, jasa sedot wc, wc mampet, sedot wc jakarta, jasa sedot wc murah' }}"
                                               placeholder="pisahkan dengan koma">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_description" class="form-label">Deskripsi Website *</label>
                                        <textarea class="form-control" id="site_description" name="site_description" rows="4" required>{{ $settings['general']['site_description'] ?? 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat. Tim berpengalaman dengan peralatan modern.' }}</textarea>
                                        <div class="form-text">Max 500 karakter untuk SEO</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h5 class="text-success mb-3">
                                <i class="bi bi-telephone me-2"></i>Informasi Kontak
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="contact_email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email"
                                               value="{{ $settings['general']['contact_email'] ?? 'info@sedotwc.com' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="contact_phone" class="form-label">Telepon *</label>
                                        <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                               value="{{ $settings['general']['contact_phone'] ?? '(021) 1234-5678' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="contact_address" class="form-label">Alamat *</label>
                                        <textarea class="form-control" id="contact_address" name="contact_address" rows="2" required>{{ $settings['general']['contact_address'] ?? 'Jl. Sudirman No. 123, Jakarta Pusat' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Branding & Assets -->
                        <div class="mb-4">
                            <h5 class="text-warning mb-3">
                                <i class="bi bi-palette me-2"></i>Branding & Assets
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_logo" class="form-label">Logo Utama</label>
                                        <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF, SVG. Max 1MB</div>
                                        @if(isset($settings['branding']['site_logo']) && $settings['branding']['site_logo'])
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['branding']['site_logo']) }}" alt="Logo" class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="site_logo_dark" class="form-label">Logo Dark Mode</label>
                                        <input type="file" class="form-control" id="site_logo_dark" name="site_logo_dark" accept="image/*">
                                        <div class="form-text">Logo untuk background gelap (opsional)</div>
                                        @if(isset($settings['branding']['site_logo_dark']) && $settings['branding']['site_logo_dark'])
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['branding']['site_logo_dark']) }}" alt="Logo Dark" class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_favicon" class="form-label">Favicon</label>
                                        <input type="file" class="form-control" id="site_favicon" name="site_favicon" accept=".ico,.png">
                                        <div class="form-text">Format: ICO atau PNG. Max 512KB</div>
                                        @if(isset($settings['branding']['site_favicon']) && $settings['branding']['site_favicon'])
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['branding']['site_favicon']) }}" alt="Favicon" class="img-thumbnail" style="max-width: 32px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="og_image" class="form-label">OG Image</label>
                                        <input type="file" class="form-control" id="og_image" name="og_image" accept="image/*">
                                        <div class="form-text">Gambar untuk sharing di media sosial (1200x630px)</div>
                                        @if(isset($settings['branding']['og_image']) && $settings['branding']['og_image'])
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['branding']['og_image']) }}" alt="OG Image" class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Emergency Contact -->
                        <div class="mb-4">
                            <h5 class="text-danger mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>Kontak Darurat
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="emergency_phone" class="form-label">Nomor Telepon Darurat</label>
                                        <input type="text" class="form-control" id="emergency_phone" name="emergency_phone"
                                               value="{{ $settings['contact']['emergency_phone'] ?? '(021) 1234-5678' }}"
                                               placeholder="(021) 1234-5678">
                                        <div class="form-text">Nomor yang ditampilkan untuk layanan darurat</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="emergency_whatsapp" class="form-label">Nomor WhatsApp Darurat</label>
                                        <input type="text" class="form-control" id="emergency_whatsapp" name="emergency_whatsapp"
                                               value="{{ $settings['contact']['emergency_whatsapp'] ?? '0812-3456-7890' }}"
                                               placeholder="0812-3456-7890">
                                        <div class="form-text">Nomor WhatsApp untuk layanan darurat</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.img-thumbnail {
    max-height: 100px;
    object-fit: contain;
}
</style>
@endpush

@push('scripts')
<script>
// Character counter for description
document.getElementById('site_description').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;

    // Remove existing counter
    const existingCounter = this.parentNode.querySelector('.char-counter');
    if (existingCounter) {
        existingCounter.remove();
    }

    // Add new counter
    const counter = document.createElement('small');
    counter.className = 'char-counter form-text ' + (currentLength > maxLength ? 'text-danger' : 'text-muted');
    counter.textContent = currentLength + '/' + maxLength + ' karakter';
    this.parentNode.appendChild(counter);
});

// Initialize counter on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('site_description').dispatchEvent(new Event('input'));
});
</script>
@endpush
