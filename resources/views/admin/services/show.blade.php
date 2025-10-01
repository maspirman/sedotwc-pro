@extends('admin.layout')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h3 mb-0">{{ $service->title }}</h1>
        <p class="text-muted">Detail lengkap layanan sedot WC</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informasi Layanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Layanan</label>
                        <p class="mb-0 fw-bold">{{ $service->title }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Harga</label>
                        <p class="mb-0 fw-bold text-primary fs-5">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Status</label>
                        <p class="mb-0">
                            <span class="badge {{ $service->status === 'active' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                {{ $service->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Total Order</label>
                        <p class="mb-0 fw-bold">{{ $service->orders->count() }}</p>
                    </div>
                    @if($service->icon)
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Icon</label>
                        <p class="mb-0">
                            <i class="bi {{ $service->icon }} me-2"></i>{{ $service->icon }}
                        </p>
                    </div>
                    @endif
                    @if($service->image)
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Gambar</label>
                        <p class="mb-0">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        </p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Slug</label>
                        <p class="mb-0">
                            <code>{{ $service->slug }}</code>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Dibuat</label>
                        <p class="mb-0">{{ $service->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-textarea-resize me-2"></i>Deskripsi Layanan
                </h5>
            </div>
            <div class="card-body">
                <div class="description-content">
                    {!! nl2br(e($service->description)) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-1"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $service->status === 'active' ? 'btn-outline-secondary' : 'btn-outline-success' }} w-100">
                            <i class="bi {{ $service->status === 'active' ? 'bi-pause-circle' : 'bi-play-circle' }} me-1"></i>
                            {{ $service->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} Layanan
                        </button>
                    </form>

                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline-warning w-100">
                        <i class="bi bi-pencil me-1"></i>Edit Layanan
                    </a>

                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Hapus Layanan
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-bar-chart me-1"></i>Statistik
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary mb-0">{{ $service->orders->count() }}</h4>
                            <small class="text-muted">Total Order</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-0">{{ $service->orders->where('status', 'completed')->count() }}</h4>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        @if($service->orders->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-clock-history me-1"></i>Order Terbaru
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($service->orders->take(5) as $order)
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="fw-bold">{{ $order->customer_name }}</small>
                                <br>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <span class="badge {{ $order->status_badge ?? 'bg-secondary' }}">
                                {{ $order->status_label ?? $order->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($service->orders->count() > 5)
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">{{ $service->orders->count() - 5 }} order lainnya...</small>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus layanan <strong>"{{ $service->title }}"</strong>?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Hapus Layanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format price input
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;
        });
    }
});
</script>
@endpush
