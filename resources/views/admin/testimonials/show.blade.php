@extends('admin.layout')

@section('title', 'Detail Testimonial - ' . $testimonial->customer_name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">
                                <i class="bi bi-eye me-2"></i>Detail Testimonial
                            </h4>
                            <small class="text-muted">Detail lengkap testimonial dari {{ $testimonial->customer_name }}</small>
                        </div>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                @if($testimonial->customer_image)
                                <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                     alt="{{ $testimonial->customer_name }}"
                                     class="rounded-circle me-4"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4"
                                     style="width: 80px; height: 80px;">
                                    <span class="fw-bold fs-2">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div>
                                    <h3 class="mb-1">{{ $testimonial->customer_name }}</h3>
                                    @if($testimonial->service_type)
                                    <p class="text-muted mb-2">{{ $testimonial->service_type }}</p>
                                    @endif
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2 fs-5">
                                            {!! $testimonial->stars !!}
                                        </div>
                                        <span class="badge bg-light text-dark">{{ $testimonial->rating }}/5 bintang</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-end">
                                <span class="badge fs-6 px-3 py-2 {{ $testimonial->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $testimonial->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Dibuat: {{ $testimonial->created_at->format('d/m/Y H:i') }}<br>
                                        Diupdate: {{ $testimonial->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial Content -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-chat-quote me-2"></i>Testimonial
                            </h5>
                            <blockquote class="blockquote mb-0">
                                <p class="fs-5 lh-base">"{{ $testimonial->content }}"</p>
                            </blockquote>
                        </div>
                    </div>

                    <!-- Service Info -->
                    @if($testimonial->service_type)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-tools me-2"></i>Jenis Layanan
                                    </h6>
                                    <p class="mb-0">{{ $testimonial->service_type }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-star me-2"></i>Rating
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2 fs-4">
                                            {!! $testimonial->stars !!}
                                        </div>
                                        <span class="fs-5">{{ $testimonial->rating }}/5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Image Info -->
                    @if($testimonial->customer_image)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-image me-2"></i>Foto Pelanggan
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                         alt="{{ $testimonial->customer_name }}"
                                         class="img-fluid rounded shadow">
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        Path: <code>storage/{{ $testimonial->customer_image }}</code><br>
                                        URL: <code>{{ asset('storage/' . $testimonial->customer_image) }}</code>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Preview on Website -->
                    <div class="card bg-info bg-opacity-10 border-info mb-4">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-eye me-2"></i>Pratinjau di Website
                            </h6>
                            <p class="mb-2">Testimonial ini akan tampil seperti ini di halaman depan website:</p>

                            <div class="border rounded p-3 bg-white">
                                <div class="d-flex align-items-center mb-2">
                                    @if($testimonial->customer_image)
                                    <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                         alt="{{ $testimonial->customer_name }}"
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px;">
                                        <span class="fw-bold">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $testimonial->customer_name }}</h6>
                                        <small class="text-muted">Pelanggan {{ $testimonial->service_type }}</small>
                                    </div>
                                </div>
                                <div class="text-warning mb-2">
                                    {!! $testimonial->stars !!}
                                </div>
                                <p class="mb-0 fst-italic">"{{ Str::limit($testimonial->content, 150) }}"</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            @if($testimonial->status === 'active')
                            <form method="POST" action="{{ route('admin.testimonials.toggle-status', $testimonial) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-warning" onclick="return confirm('Nonaktifkan testimonial ini?')">
                                    <i class="bi bi-pause-circle me-1"></i>Nonaktifkan
                                </button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.testimonials.toggle-status', $testimonial) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success" onclick="return confirm('Aktifkan testimonial ini?')">
                                    <i class="bi bi-check-circle me-1"></i>Aktifkan
                                </button>
                            </form>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus testimonial ini? Tindakan ini tidak dapat dibatalkan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
