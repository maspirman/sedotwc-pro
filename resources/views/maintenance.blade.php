@extends('frontend.layout')

@section('title', 'Sedang Dalam Maintenance - ' . ($maintenanceData['site_name'] ?? 'SedotWC'))

@section('meta-description', $maintenanceData['message'] ?? 'Website sedang dalam maintenance. Silakan kembali lagi nanti.')

@push('styles')
<style>
.maintenance-page {
    background: linear-gradient(135deg, {{ $maintenanceData['background_color'] ?? '#667eea' }} 0%, #764ba2 100%);
}
</style>
@endpush

@section('content')
<!-- Maintenance Page -->
<div class="maintenance-page min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="maintenance-pattern"></div>

    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="maintenance-card text-center">
                    <!-- Maintenance Icon -->
                    <div class="maintenance-icon mb-4">
                        <i class="bi bi-tools display-1 text-primary"></i>
                    </div>

                    <!-- Site Logo/Name -->
                    <div class="site-info mb-5">
                        <h1 class="display-4 fw-bold text-primary mb-3">
                            {{ $maintenanceData['site_name'] ?? 'SedotWC' }}
                        </h1>
                        <div class="maintenance-badge mb-4">
                            <span class="badge bg-warning text-dark px-4 py-2 fs-6">
                                <i class="bi bi-clock-history me-2"></i>DALAM MAINTENANCE
                            </span>
                        </div>
                    </div>

                    <!-- Maintenance Message -->
                    <div class="maintenance-message mb-5">
                        <h2 class="h3 mb-4 text-muted">
                            {{ $maintenanceData['title'] ?? 'Website Sedang Dalam Perbaikan' }}
                        </h2>
                        <p class="lead text-muted mb-4">
                            {{ $maintenanceData['message'] ?? 'Kami sedang melakukan perbaikan untuk memberikan pengalaman yang lebih baik. Website akan segera kembali normal.' }}
                        </p>
                        <p class="text-muted">
                            <small>
                                Estimasi kembali online: <strong>{{ $maintenanceData['estimated_time'] ?? '1-2 jam lagi' }}</strong>
                            </small>
                        </p>
                    </div>

                    <!-- Progress Indicator -->
                    <div class="maintenance-progress mb-5">
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                 role="progressbar"
                                 style="width: {{ $maintenanceData['progress'] ?? '75' }}%"
                                 aria-valuenow="{{ $maintenanceData['progress'] ?? '75' }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">
                            Progress: {{ $maintenanceData['progress'] ?? '75' }}% selesai
                        </small>
                    </div>

                    <!-- Contact Information -->
                    <div class="contact-info mb-5">
                        <h5 class="mb-4 text-muted">Butuh Bantuan Darurat?</h5>
                        <div class="row g-3 justify-content-center">
                            <div class="col-auto">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $maintenanceData['whatsapp'] ?? '6281234567890') }}"
                                   class="btn btn-whatsapp btn-custom btn-lg" target="_blank">
                                    <i class="bi bi-whatsapp me-2"></i>WhatsApp
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="tel:{{ $maintenanceData['phone'] ?? '+622112345678' }}"
                                   class="btn btn-outline-primary btn-custom btn-lg">
                                    <i class="bi bi-telephone me-2"></i>Telepon
                                </a>
                            </div>
                        </div>
                        <p class="mt-3 mb-0">
                            <small class="text-muted">
                                Layanan emergency tetap tersedia 24 jam
                            </small>
                        </p>
                    </div>

                    <!-- Social Media Links -->
                    @if(isset($maintenanceData['social_links']) && count($maintenanceData['social_links']) > 0)
                    <div class="social-links mb-5">
                        <h6 class="text-muted mb-3">Ikuti Kami</h6>
                        <div class="d-flex justify-content-center gap-3">
                            @foreach($maintenanceData['social_links'] as $social)
                            <a href="{{ $social['url'] }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                <i class="bi bi-{{ $social['icon'] }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Auto Refresh Timer -->
                    <div class="auto-refresh mb-4">
                        <small class="text-muted">
                            Halaman akan diperbarui otomatis dalam
                            <span id="countdown" class="fw-bold text-primary">{{ $maintenanceData['retry'] ?? 60 }}</span>
                            detik
                        </small>
                    </div>

                    <!-- Manual Refresh Button -->
                    <button onclick="window.location.reload()" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i>Refresh Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.maintenance-page {
    position: relative;
}

.maintenance-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    background-size: 100px 100px;
}

.floating-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.floating-shapes .shape-1 {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.floating-shapes .shape-2 {
    width: 60px;
    height: 60px;
    top: 20%;
    right: 10%;
    animation-delay: 2s;
}

.floating-shapes .shape-3 {
    width: 40px;
    height: 40px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.maintenance-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 3rem 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.maintenance-icon {
    animation: pulse 2s infinite;
}

.maintenance-badge .badge {
    animation: bounce 2s infinite;
}

.progress-bar-animated {
    animation: progress 1.5s ease-in-out infinite;
}

@keyframes progress {
    0% { background-position: 0% 0%; }
    100% { background-position: 100% 0%; }
}

.btn-custom {
    border-radius: 50px;
    padding: 12px 24px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-whatsapp {
    background: linear-gradient(45deg, #25d366, #128c7e);
    border: none;
    color: white;
}

.btn-whatsapp:hover {
    background: linear-gradient(45deg, #128c7e, #075e54);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .maintenance-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }

    .display-4 {
        font-size: 2.5rem;
    }

    .btn-custom {
        padding: 10px 20px;
        font-size: 14px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Countdown timer
    let countdown = {{ $maintenanceData['retry'] ?? 60 }};
    const countdownElement = document.getElementById('countdown');

    const timer = setInterval(() => {
        countdown--;
        if (countdownElement) {
            countdownElement.textContent = countdown;
        }

        if (countdown <= 0) {
            clearInterval(timer);
            window.location.reload();
        }
    }, 1000);

    // Add some interactive effects
    const shapes = document.querySelectorAll('.shape');
    shapes.forEach((shape, index) => {
        shape.style.animation = `float ${6 + index}s ease-in-out infinite`;
    });
});
</script>
@endpush
