@extends('frontend.layout')

@section('title', $page->meta_title ?? $page->title)
@section('meta-description', $page->meta_description ?? Str::limit(strip_tags($page->getTemplateData('hero_description', '')), 160))
@section('meta-keywords', $page->meta_keywords)

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3">{{ $page->getTemplateData('hero_title', $page->title) }}</h1>
                @if($page->getTemplateData('hero_description'))
                    <p class="lead text-muted">{{ $page->getTemplateData('hero_description') }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                Informasi Kontak
                            </h3>

                            @php
                                $contactInfo = $page->getTemplateData('contact_info', []);
                            @endphp

                            @if(isset($contactInfo['phone']) && $contactInfo['phone'])
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-telephone text-primary me-3" style="font-size: 1.2rem;"></i>
                                    <div>
                                        <div class="fw-semibold">Telepon</div>
                                        <a href="tel:{{ $contactInfo['phone'] }}" class="text-decoration-none">{{ $contactInfo['phone'] }}</a>
                                    </div>
                                </div>
                            @endif

                            @if(isset($contactInfo['email']) && $contactInfo['email'])
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-envelope text-primary me-3" style="font-size: 1.2rem;"></i>
                                    <div>
                                        <div class="fw-semibold">Email</div>
                                        <a href="mailto:{{ $contactInfo['email'] }}" class="text-decoration-none">{{ $contactInfo['email'] }}</a>
                                    </div>
                                </div>
                            @endif

                            @if(isset($contactInfo['address']) && $contactInfo['address'])
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-geo-alt text-primary me-3" style="font-size: 1.2rem;"></i>
                                    <div>
                                        <div class="fw-semibold">Alamat</div>
                                        <div>{{ $contactInfo['address'] }}</div>
                                    </div>
                                </div>
                            @endif

                            <!-- Social Media -->
                            @php
                                $socialMedia = $page->getTemplateData('social_media', []);
                            @endphp

                            @if(is_array($socialMedia) && !empty($socialMedia))
                                <div class="mt-4">
                                    <h5 class="mb-3">Media Sosial</h5>
                                    <div class="d-flex gap-2">
                                        @foreach($socialMedia as $social)
                                            @if(isset($social['platform']) && isset($social['url']))
                                                @php
                                                    $platform = strtolower($social['platform']);
                                                    $iconClass = match($platform) {
                                                        'facebook' => 'bi-facebook',
                                                        'twitter' => 'bi-twitter',
                                                        'instagram' => 'bi-instagram',
                                                        'linkedin' => 'bi-linkedin',
                                                        'youtube' => 'bi-youtube',
                                                        'whatsapp' => 'bi-whatsapp',
                                                        default => 'bi-globe'
                                                    };
                                                @endphp
                                                <a href="{{ $social['url'] }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi {{ $iconClass }}"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">
                                <i class="bi bi-clock text-primary me-2"></i>
                                Jam Operasional
                            </h3>

                            @php
                                $businessHours = $page->getTemplateData('business_hours', []);
                            @endphp

                            @if(is_array($businessHours) && !empty($businessHours))
                                @foreach($businessHours as $hours)
                                    @if(isset($hours['day']))
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-medium">{{ $hours['day'] ?? 'Hari' }}</span>
                                            @if(isset($hours['is_closed']) && $hours['is_closed'])
                                                <span class="text-danger">Tutup</span>
                                            @elseif(isset($hours['open_time']) && isset($hours['close_time']))
                                                <span class="text-muted">{{ $hours['open_time'] }} - {{ $hours['close_time'] }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Informasi jam operasional belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">
                                <i class="bi bi-envelope-paper text-primary me-2"></i>
                                Kirim Pesan
                            </h3>

                            <form action="#" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="subject" class="form-label">Subjek *</label>
                                        <input type="text" class="form-control" id="subject" name="subject" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="message" class="form-label">Pesan *</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-send me-2"></i>Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 0.75rem;
}

.card-body {
    padding: 2rem;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
}
</style>
@endsection
