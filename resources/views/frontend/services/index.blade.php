@extends('frontend.layout')

@section('title', 'Layanan Sedot WC - Pilih Layanan Terbaik untuk Anda')
@section('meta-description', 'Berbagai layanan sedot WC profesional dengan harga terjangkau. Pilih layanan yang sesuai kebutuhan Anda dari sedot WC standar hingga premium.')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Layanan Kami</h1>
        <p class="lead text-muted">Pilih layanan sedot WC yang sesuai dengan kebutuhan Anda</p>
    </div>

    <div class="row g-4">
        @forelse($services ?? collect() as $service)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card service-card h-100 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi {{ $service->icon ?? 'bi-water' }} text-primary fs-1"></i>
                    </div>
                    <h5 class="card-title fw-bold">{{ $service->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($service->description, 100) }}</p>
                    <div class="h4 text-primary fw-bold mb-3">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                    <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary btn-custom">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center text-muted">
                <p>Tidak ada layanan tersedia saat ini.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
