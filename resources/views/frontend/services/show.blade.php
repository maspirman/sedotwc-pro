@extends('frontend.layout')

@section('title', $service->title . ' - Layanan Sedot WC Profesional')
@section('meta-description', Str::limit(strip_tags($service->description), 160))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi {{ $service->icon ?? 'bi-water' }} text-primary fs-1 mb-3"></i>
                        <h1 class="display-5 fw-bold">{{ $service->title }}</h1>
                        <div class="h2 text-primary fw-bold mb-4">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                    </div>

                    <div class="mb-4">
                        <h3 class="h4 fw-bold mb-3">Deskripsi Layanan</h3>
                        <p class="lead">{{ $service->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="h4 fw-bold mb-3">Keunggulan Layanan</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle-fill text-success fs-5 me-3 mt-1"></i>
                                    <div>
                                        <strong>Tim Profesional</strong>
                                        <p class="text-muted mb-0 small">Teknisi berpengalaman dan tersertifikasi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle-fill text-success fs-5 me-3 mt-1"></i>
                                    <div>
                                        <strong>Peralatan Modern</strong>
                                        <p class="text-muted mb-0 small">Menggunakan teknologi terkini</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle-fill text-success fs-5 me-3 mt-1"></i>
                                    <div>
                                        <strong>Garansi Kepuasan</strong>
                                        <p class="text-muted mb-0 small">100% puas atau uang kembali</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-check-circle-fill text-success fs-5 me-3 mt-1"></i>
                                    <div>
                                        <strong>Layanan 24 Jam</strong>
                                        <p class="text-muted mb-0 small">Tersedia untuk keadaan darurat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="#orderForm" class="btn btn-primary btn-custom btn-lg">
                            <i class="bi bi-telephone me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Kontak</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone text-primary me-3 fs-5"></i>
                        <div>
                            <strong>Telepon</strong><br>
                            <a href="tel:+622112345678" class="text-decoration-none">(021) 1234-5678</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-whatsapp text-success me-3 fs-5"></i>
                        <div>
                            <strong>WhatsApp</strong><br>
                            <a href="https://wa.me/6281234567890" class="text-decoration-none" target="_blank">0812-3456-7890</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-0">
                        <i class="bi bi-envelope text-info me-3 fs-5"></i>
                        <div>
                            <strong>Email</strong><br>
                            <a href="mailto:info@sedotwc.com" class="text-decoration-none">info@sedotwc.com</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Layanan Lainnya</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('services.index') }}" class="list-group-item list-group-item-action px-0">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Semua Layanan
                        </a>
                        <a href="{{ route('home') }}" class="list-group-item list-group-item-action px-0">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Form -->
    <div id="orderForm" class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">Pesan Layanan {{ $service->title }}</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('services.order', $service) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="customer_address" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="customer_address" name="customer_address" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="scheduled_date" class="form-label">Tanggal Layanan</label>
                                <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="scheduled_time" class="form-label">Waktu Layanan</label>
                                <select class="form-control" id="scheduled_time" name="scheduled_time" required>
                                    <option value="">Pilih Waktu</option>
                                    <option value="09:00">09:00 - 12:00</option>
                                    <option value="13:00">13:00 - 16:00</option>
                                    <option value="16:00">16:00 - 19:00</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Jelaskan kondisi WC atau permintaan khusus..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-custom btn-lg">
                                    <i class="bi bi-send me-2"></i>Kirim Pesanan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
