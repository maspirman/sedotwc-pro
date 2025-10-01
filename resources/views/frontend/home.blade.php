@extends('frontend.layout')

@section('title', ($homeSettings['hero']['title'] ?? 'Jasa Sedot WC Profesional') . ' - Cepat, Bersih & Terpercaya')
@section('meta-description', $homeSettings['hero']['description'] ?? 'Jasa sedot WC profesional dengan harga terjangkau. Layanan 24 jam untuk keadaan darurat. Tim berpengalaman dengan peralatan modern. Pesan sekarang!')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-white position-relative overflow-hidden mb-4">
    <div class="container position-relative mt-5 pt-4 mb-2">
            <!-- Background Pattern -->
        <div class="hero-pattern"></div>
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <div class="container position-relative mt-3">
            <div class="row align-items-center min-vh-80">
                <div class="col-lg-6 animate-fade-in-left">
                    @if($homeSettings['hero']['badge'] ?? null)
                    <div class="hero-badge mb-3">
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="bi bi-star-fill me-1"></i>{{ $homeSettings['hero']['badge'] }}
                        </span>
                    </div>
                    @endif
                    <h1 class="display-3 fw-bold mb-4 lh-1">
                        {{ $homeSettings['hero']['title'] ?? 'Jasa Sedot WC 24 Jam' }} <span class="text-gradient">{{ $homeSettings['hero']['subtitle'] ?? 'Profesional & Modern' }}</span>
                    </h1>
                    <p class="lead mb-4 opacity-90 fs-5">
                        {{ $homeSettings['hero']['description'] ?? 'Layanan darurat WC mampet tersedia 24 jam dengan tim ahli berpengalaman, peralatan canggih, dan harga terjangkau. Solusi cepat untuk masalah WC Anda!' }}
                    </p>

                    <!-- Emergency Contact -->
                    <div class="emergency-contact bg-white bg-opacity-10 backdrop-blur-sm rounded-4 p-4 mb-4 border border-white border-opacity-20">
                        <div class="d-flex align-items-center">
                            <div class="emergency-icon me-3">
                                <i class="bi bi-telephone-fill text-warning fs-3"></i>
                            </div>
                            <div>
                                <small class="text-uppercase fw-bold text-warning">Emergency Call</small>
                                <div class="h5 mb-0 text-white">{{ $homeSettings['hero']['emergency_phone'] ?? '(021) 1234-5678' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $homeSettings['hero']['whatsapp'] ?? '6281234567890') }}" class="btn btn-whatsapp btn-custom btn-lg pulse-animation" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp Sekarang
                        </a>
                        <a href="#services" class="btn btn-outline-light btn-custom btn-lg">
                            <i class="bi bi-info-circle me-2"></i>Lihat Layanan
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="row g-4">
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <div class="stat-number h2 mb-1 text-warning fw-bold">{{ $homeSettings['stats']['pelanggan_puas'] ?? '1000' }}+</div>
                                <small class="text-light opacity-75">Pelanggan Puas</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <div class="stat-number h2 mb-1 text-warning fw-bold">{{ $homeSettings['stats']['layanan_24jam'] ?? '24/7' }}</div>
                                <small class="text-light opacity-75">Layanan Darurat</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <div class="stat-number h2 mb-1 text-warning fw-bold">{{ $homeSettings['stats']['rating_google'] ?? '4.9' }}</div>
                                <small class="text-light opacity-75">Rating Google</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 animate-fade-in-right">
                    <div class="hero-image-container position-relative">
                        <div class="hero-image-wrapper">
                            <img src="{{ $homeSettings['hero']['image'] ? asset('storage/' . $homeSettings['hero']['image']) : asset('storage/hero/plumber-hero.jpg') }}"
                                alt="Sedot WC Professional Service"
                                class="img-fluid hero-main-image rounded-4 shadow-lg"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDYwMCA1MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI2MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjZjNmNGY2Ii8+Cjx0ZXh0IHg9IjMwMCIgeT0iMjUwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOWNhM2FmIiBmb250LXNpemU9IjI0IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkphc2EgU2Vkb3QgV0M8L3RleHQ+Cjx0ZXh0IHg9IjMwMCIgeT0iMjkwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOWNhM2FmIiBmb250LXNpemU9IjE2IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkdhbWJhciBUaWRhayBUZXJzZWRpYTwvdGV4dD4KPC9zdmc+'">
                        </div>

                        <!-- Floating Cards -->
                        <div class="floating-card card-1">
                            <div class="card bg-white shadow-lg border-0 p-3 rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success text-white rounded-3 me-3">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted mb-0">Response Time</small>
                                        <div class="fw-bold text-dark">30 Menit</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="floating-card card-2">
                            <div class="card bg-white shadow-lg border-0 p-3 rounded-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-primary text-white rounded-3 me-3">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted mb-0">Peralatan</small>
                                        <div class="fw-bold text-dark">Modern</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5 bg-light-custom position-relative">
    <div class="container">
        <div class="text-center mb-5">
            <div class="badge bg-primary text-white px-3 py-2 mb-3">
                <i class="bi bi-tools me-1"></i>LAYANAN PROFESIONAL
            </div>
            <h2 class="display-5 fw-bold mb-3">Layanan <span class="text-primary">Sedot WC</span> Kami</h2>
            <p class="lead text-muted mb-4">Pilih layanan sedot WC yang sesuai dengan kebutuhan Anda dengan harga terjangkau dan garansi kepuasan</p>
        </div>

        <div class="row g-4">
            @forelse($services ?? collect() as $service)
            <div class="col-md-6 col-lg-3">
                <div class="card service-card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="service-icon">
                            <i class="bi {{ $service->icon ?? 'bi-water' }}"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">{{ $service->title }}</h5>
                        <p class="card-text text-muted mb-4">{{ Str::limit($service->description, 80) }}</p>

                        <!-- Price Badge -->
                        <div class="price-badge mb-4">
                            <span class="h4 text-primary fw-bold mb-0">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                            <small class="text-muted d-block">per layanan</small>
                        </div>

                        <!-- Features -->
                        <div class="features mb-4">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small class="text-muted">24 Jam</small>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small class="text-muted">Garansi</small>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small class="text-muted">Profesional</small>
                            </div>
                        </div>

                        <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary btn-custom w-100">
                            <i class="bi bi-whatsapp me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center text-muted py-5">
                    <div class="loading-spinner mb-3"></div>
                    <p>Layanan sedang dimuat...</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Service Stats -->
        <div class="row mt-5 pt-5">
            <div class="col-md-3 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-people-fill text-primary fs-1 mb-3"></i>
                    <h3 class="fw-bold text-primary">{{ $homeSettings['stats']['pelanggan_puas'] ?? '1000' }}+</h3>
                    <p class="text-muted mb-0">Pelanggan Puas</p>
                </div>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-clock-fill text-success fs-1 mb-3"></i>
                    <h3 class="fw-bold text-success">{{ $homeSettings['stats']['layanan_24jam'] ?? '24/7' }}</h3>
                    <p class="text-muted mb-0">Layanan Darurat</p>
                </div>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-tools text-warning fs-1 mb-3"></i>
                    <h3 class="fw-bold text-warning">{{ $homeSettings['stats']['tahun_pengalaman'] ?? '10' }}+</h3>
                    <p class="text-muted mb-0">Tahun Pengalaman</p>
                </div>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-star-fill text-warning fs-1 mb-3"></i>
                    <h3 class="fw-bold text-warning">{{ $homeSettings['stats']['rating_google'] ?? '4.9' }}</h3>
                    <p class="text-muted mb-0">Rating Google</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('services.index') }}" class="btn btn-outline-primary btn-custom btn-lg">
                <i class="bi bi-grid me-2"></i>Lihat Semua Layanan
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold mb-4">{{ $homeSettings['about']['title'] ?? 'Mengapa Memilih SedotWC?' }}</h2>
                <div class="row g-4">
                    <div class="col-6">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold">Berpengalaman</h6>
                                <p class="text-muted mb-0">Tim ahli dengan pengalaman 10+ tahun</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold">Peralatan Modern</h6>
                                <p class="text-muted mb-0">Menggunakan teknologi terkini</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold">Harga Terjangkau</h6>
                                <p class="text-muted mb-0">Kualitas premium dengan harga bersaing</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold">Garansi Kepuasan</h6>
                                <p class="text-muted mb-0">100% puas atau uang kembali</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ $homeSettings['about']['image'] ? asset('storage/' . $homeSettings['about']['image']) : 'https://via.placeholder.com/600x400/e9ecef/6c757d?text=Professional+Service' }}"
                     alt="Professional Service" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <div class="badge bg-primary text-white px-3 py-2 mb-3">
                <i class="bi bi-chat-quote me-1"></i>TESTIMONI PELANGGAN
            </div>
            <h2 class="display-5 fw-bold mb-3">Apa Kata Pelanggan Kami</h2>
            <p class="lead text-muted">Pengalaman pelanggan yang telah menggunakan layanan SedotWC</p>
        </div>

        @if(($testimonials ?? collect())->count() > 0)
        <div id="testimonialCarousel" class="carousel slide testimonial-carousel" data-bs-ride="carousel" data-bs-interval="5000">
            <!-- Carousel Indicators -->
            @if(($testimonials ?? collect())->count() > 1)
            <div class="carousel-indicators mb-4">
                @foreach($testimonials as $index => $testimonial)
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-label="Testimonial {{ $index + 1 }}"></button>
                @endforeach
            </div>
            @endif

            <div class="carousel-inner">
                @foreach($testimonials as $index => $testimonial)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="testimonial-card card border-0 shadow-lg p-4 p-md-5 bg-white">
                                <div class="card-body text-center">
                                    <!-- Rating Stars -->
                                    <div class="rating-stars mb-4">
                                        <div class="stars-display d-inline-block">
                                            {!! $testimonial->stars !!}
                                        </div>
                                        <div class="rating-number badge bg-warning text-dark ms-2 px-2 py-1">
                                            {{ $testimonial->rating }}/5
                                        </div>
                                    </div>

                                    <!-- Testimonial Content -->
                                    <blockquote class="blockquote mb-4">
                                        <p class="mb-0 fs-5 lh-base text-dark">"{{ $testimonial->content }}"</p>
                                    </blockquote>

                                    <!-- Customer Info -->
                                    <div class="customer-info d-flex align-items-center justify-content-center">
                                        <div class="customer-avatar me-3">
                                            @if($testimonial->customer_image)
                                            <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                                 alt="{{ $testimonial->customer_name }}"
                                                 class="rounded-circle border border-3 border-primary"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                            <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center border border-3 border-primary"
                                                 style="width: 60px; height: 60px;">
                                                <span class="fw-bold fs-4">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="customer-details text-start">
                                            <h6 class="mb-1 fw-bold text-dark">{{ $testimonial->customer_name }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $testimonial->service_type }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            @if(($testimonials ?? collect())->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Previous testimonial</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Next testimonial</span>
            </button>
            @endif
        </div>

        <!-- Testimonial Stats -->
        <div class="row mt-5 pt-4">
            <div class="col-md-4 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-people-fill text-primary fs-1 mb-3"></i>
                    <h4 class="fw-bold text-primary">{{ $testimonials->count() }}</h4>
                    <p class="text-muted mb-0">Testimoni</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-star-fill text-warning fs-1 mb-3"></i>
                    <h4 class="fw-bold text-warning">{{ number_format($testimonials->avg('rating'), 1) }}</h4>
                    <p class="text-muted mb-0">Rating Rata-rata</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="stat-item">
                    <i class="bi bi-heart-fill text-danger fs-1 mb-3"></i>
                    <h4 class="fw-bold text-danger">100%</h4>
                    <p class="text-muted mb-0">Kepuasan</p>
                </div>
            </div>
        </div>
        @else
        <div class="text-center text-muted py-5">
            <div class="loading-spinner mb-3"></div>
            <p>Testimoni sedang dimuat...</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 cta-section text-white position-relative">
    <div class="cta-pattern"></div>
    <div class="container text-center position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if($homeSettings['cta']['emergency_badge'] ?? null)
                <div class="emergency-indicator mb-4">
                    <div class="pulse-ring"></div>
                    <div class="pulse-dot bg-danger"></div>
                    <span class="badge bg-danger text-white ms-2 px-3 py-2">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $homeSettings['cta']['emergency_badge'] }}
                    </span>
                </div>
                @endif

                <h2 class="display-5 fw-bold mb-4">{{ $homeSettings['cta']['title'] ?? 'Butuh Layanan Sedot WC?' }}</h2>
                <p class="lead mb-5 opacity-90">
                    {{ $homeSettings['cta']['description'] ?? 'Jangan biarkan masalah WC mengganggu kenyamanan Anda. Tim profesional kami siap membantu kapan saja, di mana saja dengan response time 30 menit!' }}
                </p>

                <!-- Contact Options -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="contact-card bg-white bg-opacity-10 backdrop-blur-sm rounded-4 p-4 border border-white border-opacity-20 h-100">
                            <div class="contact-icon mb-3">
                                <i class="bi bi-whatsapp text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Chat WhatsApp</h5>
                            <p class="mb-4 opacity-75">Response tercepat dengan konsultasi gratis</p>
                            <a href="https://wa.me/6281234567890" class="btn btn-whatsapp btn-custom btn-lg w-100" target="_blank">
                                <i class="bi bi-whatsapp me-2"></i>0812-3456-7890
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-card bg-white bg-opacity-10 backdrop-blur-sm rounded-4 p-4 border border-white border-opacity-20 h-100">
                            <div class="contact-icon mb-3">
                                <i class="bi bi-telephone text-primary fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Telepon Langsung</h5>
                            <p class="mb-4 opacity-75">Untuk keadaan darurat dan informasi</p>
                        <a href="tel:+622112345678" class="btn btn-outline-light btn-custom btn-lg w-100">
                                <i class="bi bi-telephone me-2"></i>(021) 1234-5678
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Trust Signals -->
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="trust-signals bg-white bg-opacity-5 backdrop-blur-sm rounded-4 p-4">
                            <div class="row text-center g-4">
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-shield-check text-success fs-4 me-2"></i>
                                        <span class="fw-bold text-success">Terpercaya</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-clock text-warning fs-4 me-2"></i>
                                        <span class="fw-bold text-warning">24 Jam</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-cash text-primary fs-4 me-2"></i>
                                        <span class="fw-bold text-primary">Harga Murah</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="bi bi-star-fill text-warning fs-4 me-2"></i>
                                        <span class="fw-bold text-warning">Rating 4.9</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Preview Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Blog & Tips</h2>
            <p class="lead text-muted">Informasi berguna seputar perawatan WC dan kesehatan</p>
        </div>

        <div class="row g-4">
            @forelse($latestBlogs ?? collect() as $blog)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('storage/blog/plumbing-tips-1.jpg') }}"
                         class="card-img-top"
                         alt="{{ $blog->title }}"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjI1MCIgdmlld0JveD0iMCAwIDQwMCAyNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMjUwIiBmaWxsPSIjZjNmNGY2Ii8+Cjx0ZXh0IHg9IjIwMCIgeT0iMTIwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjOWNhM2FmIiBmb250LXNpemU9IjE4IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkFydGlrZWwgQmxvZzwvdGV4dD4KPHRleHQgeD0iMjAwIiB5PSIxNTAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM5Y2EzYWYiIGZvbnQtc2l6ZT0iMTQiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiI+R2FtYmFyIFRpZGFrIFRlcnNlZGlhPC90ZXh0Pgo8L3N2Zz4='">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $blog->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                    <div class="card-footer text-muted">
                        <small>{{ $blog->published_at ? $blog->published_at->diffForHumans() : $blog->created_at->diffForHumans() }} • {{ $blog->category->name ?? 'Uncategorized' }}</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center text-muted">
                    <p>Artikel blog sedang dimuat...</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('blog.index') }}" class="btn btn-outline-primary btn-custom btn-lg">
                <i class="bi bi-newspaper me-2"></i>Baca Blog Lainnya
            </a>
        </div>
    </div>
</section>
@endsection
