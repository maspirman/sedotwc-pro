@extends('admin.layout')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h3 mb-0">Order #{{ strtoupper(substr($order->id, -6)) }}</h1>
        <p class="text-muted">Detail lengkap pesanan layanan</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Edit Order
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Order Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informasi Order
                </h5>
                <span class="badge bg-{{ $order->status_badge }} fs-6">
                    {{ $order->status_label }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">ID Order</label>
                        <p class="mb-0 fw-bold">
                            <code>#{{ strtoupper(substr($order->id, -6)) }}</code>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Tanggal Order</label>
                        <p class="mb-0">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Jadwal Pekerjaan</label>
                        <p class="mb-0">
                            @if($order->scheduled_date)
                                {{ $order->scheduled_date->format('d F Y, H:i') }}
                            @else
                                <span class="text-muted">Belum dijadwalkan</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Total Pembayaran</label>
                        <p class="mb-0 fw-bold text-success fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-person me-2"></i>Informasi Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <p class="mb-0 fw-bold">{{ $order->customer_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nomor Telepon</label>
                        <p class="mb-0">
                            <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                                <i class="bi bi-telephone me-1"></i>{{ $order->customer_phone }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted">Alamat</label>
                        <p class="mb-0">{{ nl2br(e($order->customer_address)) }}</p>
                    </div>
                    @if($order->user)
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Akun Terdaftar</label>
                        <p class="mb-0">
                            <span class="badge bg-primary">
                                <i class="bi bi-person-check me-1"></i>{{ $order->user->name }}
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Service Information -->
        @if($order->service)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-wrench-adjustable me-2"></i>Informasi Layanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="d-flex align-items-center">
                            @if($order->service->image)
                                <img src="{{ asset('storage/' . $order->service->image) }}" alt="{{ $order->service->title }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <i class="bi {{ $order->service->icon ?: 'bi-wrench-adjustable' }} text-primary fs-2 me-3"></i>
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $order->service->title }}</h5>
                                <p class="mb-0 text-muted">{{ Str::limit($order->service->description, 100) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Harga Layanan</label>
                        <p class="mb-0 fw-bold">Rp {{ number_format($order->service->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Status Layanan</label>
                        <p class="mb-0">
                            <span class="badge {{ $order->service->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $order->service->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($order->notes)
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-sticky me-2"></i>Catatan Tambahan
                </h5>
            </div>
            <div class="card-body">
                <div class="notes-content">
                    {!! nl2br(e($order->notes)) !!}
                </div>
            </div>
        </div>
        @endif
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
                    <!-- Status Update Actions -->
                    @if($order->status !== 'confirmed')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-info w-100">
                            <i class="bi bi-check-circle me-1"></i>Konfirmasi Order
                        </button>
                    </form>
                    @endif

                    @if($order->status !== 'in_progress')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-gear me-1"></i>Mulai Pekerjaan
                        </button>
                    </form>
                    @endif

                    @if($order->status !== 'completed')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle-fill me-1"></i>Selesaikan Order
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-warning w-100">
                        <i class="bi bi-pencil me-1"></i>Edit Order
                    </a>

                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Hapus Order
                    </button>
                </div>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-timeline me-1"></i>Status Timeline
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-circle-fill text-warning me-2"></i>
                            <div class="flex-grow-1">
                                <small class="fw-bold">Order Dibuat</small>
                                <br>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>

                    @if(in_array($order->status, ['confirmed', 'in_progress', 'completed', 'cancelled']))
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-circle-fill text-info me-2"></i>
                            <div class="flex-grow-1">
                                <small class="fw-bold">Dikonfirmasi</small>
                                <br>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(in_array($order->status, ['in_progress', 'completed', 'cancelled']))
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-circle-fill text-primary me-2"></i>
                            <div class="flex-grow-1">
                                <small class="fw-bold">Sedang Dikerjakan</small>
                                <br>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->status === 'completed')
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-circle-fill text-success me-2"></i>
                            <div class="flex-grow-1">
                                <small class="fw-bold">Selesai</small>
                                <br>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @elseif($order->status === 'cancelled')
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-circle-fill text-danger me-2"></i>
                            <div class="flex-grow-1">
                                <small class="fw-bold">Dibatalkan</small>
                                <br>
                                <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-receipt me-1"></i>Ringkasan Order
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Harga Layanan</span>
                    <span>Rp {{ number_format($order->service ? $order->service->price : $order->total_price, 0, ',', '.') }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
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
                <p>Apakah Anda yakin ingin menghapus order <strong>"#{{ strtoupper(substr($order->id, -6)) }}"</strong>?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Hapus Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
