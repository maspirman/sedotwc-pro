@extends('admin.layout')

@section('title', 'Preview Home Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-eye me-2"></i>Preview Home Page
                    </h4>
                    <a href="{{ route('admin.home.index') }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Content
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Ini adalah preview bagaimana home page akan terlihat dengan konten yang telah dikonfigurasi.
                    </div>

                    <div class="border rounded p-3 bg-light" style="min-height: 600px;">
                        <!-- Hero Section Preview -->
                        <div class="mb-4 p-3 bg-gradient-primary text-white rounded">
                            <h3 class="mb-2">{{ $settings['hero']['title'] ?? 'Jasa Sedot WC 24 Jam' }}</h3>
                            <p class="mb-2">{{ $settings['hero']['subtitle'] ?? 'Profesional & Modern' }}</p>
                            <p class="mb-2">{{ $settings['hero']['description'] ?? 'Deskripsi hero section...' }}</p>
                            @if($settings['hero']['badge'] ?? null)
                                <span class="badge bg-warning text-dark">{{ $settings['hero']['badge'] }}</span>
                            @endif
                        </div>

                        <!-- Stats Section Preview -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-primary">{{ $settings['stats']['pelanggan_puas'] ?? '1000' }}+</h4>
                                    <small class="text-muted">Pelanggan Puas</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-success">{{ $settings['stats']['layanan_24jam'] ?? '24/7' }}</h4>
                                    <small class="text-muted">Layanan Darurat</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-warning">{{ $settings['stats']['tahun_pengalaman'] ?? '10' }}+</h4>
                                    <small class="text-muted">Tahun Pengalaman</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-warning">{{ $settings['stats']['rating_google'] ?? '4.9' }}</h4>
                                    <small class="text-muted">Rating Google</small>
                                </div>
                            </div>
                        </div>

                        <!-- About Section Preview -->
                        @if($settings['about']['title'] ?? null)
                        <div class="mb-4">
                            <h4 class="text-success mb-3">{{ $settings['about']['title'] }}</h4>
                            <p>{{ $settings['about']['description'] ?? 'Deskripsi about section...' }}</p>
                        </div>
                        @endif

                        <!-- CTA Section Preview -->
                        @if($settings['cta']['title'] ?? null)
                        <div class="p-3 bg-gradient-danger text-white rounded">
                            <h4 class="mb-2">{{ $settings['cta']['title'] }}</h4>
                            <p class="mb-2">{{ $settings['cta']['description'] ?? 'Deskripsi CTA...' }}</p>
                            @if($settings['cta']['emergency_badge'] ?? null)
                                <span class="badge bg-danger">{{ $settings['cta']['emergency_badge'] }}</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
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

.bg-gradient-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
}
</style>
@endpush
