@extends('admin.layout', [
    'title' => 'Detail Pelanggan',
    'subtitle' => 'Informasi lengkap pelanggan ' . $customer->name
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Customer Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-person me-2"></i>Informasi Pelanggan
                </h5>
                <span class="badge {{ $customer->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                    {{ $customer->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <p class="mb-0 fw-bold fs-5">{{ $customer->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Email</label>
                        <p class="mb-0">
                            <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                <i class="bi bi-envelope me-1"></i>{{ $customer->email }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nomor Telepon</label>
                        <p class="mb-0">
                            @if($customer->phone)
                                <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                    <i class="bi bi-telephone me-1"></i>{{ $customer->phone }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Tanggal Daftar</label>
                        <p class="mb-0">{{ $customer->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted">Alamat</label>
                        <p class="mb-0">
                            @if($customer->address)
                                {{ nl2br(e($customer->address)) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-receipt me-2"></i>Riwayat Order Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($customer->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Order</th>
                                    <th>Layanan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders->take(10) as $order)
                                <tr>
                                    <td>
                                        <code>#{{ strtoupper(substr($order->id, -6)) }}</code>
                                    </td>
                                    <td>
                                        @if($order->service)
                                            {{ $order->service->title }}
                                        @else
                                            <span class="text-muted">Layanan tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($customer->orders->count() > 10)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.orders.index', ['search' => $customer->phone ?: $customer->name]) }}" class="btn btn-outline-primary">
                                Lihat Semua Order ({{ $customer->orders->count() }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle fs-1 d-block mb-2"></i>
                        <strong>Belum ada order</strong>
                        <br>
                        <small>Pelanggan belum melakukan pemesanan layanan</small>
                    </div>
                @endif
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
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-warning w-100">
                        <i class="bi bi-pencil me-1"></i>Edit Pelanggan
                    </a>

                    @if($customer->phone)
                    <a href="tel:{{ $customer->phone }}" class="btn btn-info w-100">
                        <i class="bi bi-telephone me-1"></i>Telepon Pelanggan
                    </a>
                    @endif

                    <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $customer->email_verified_at ? 'btn-outline-secondary' : 'btn-outline-success' }} w-100">
                            <i class="bi {{ $customer->email_verified_at ? 'bi-pause-circle' : 'bi-play-circle' }} me-1"></i>
                            {{ $customer->email_verified_at ? 'Nonaktifkan' : 'Aktifkan' }} Akun
                        </button>
                    </form>

                    @if($customer->orders_count == 0)
                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Hapus Pelanggan
                    </button>
                    @endif
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
                            <h4 class="text-primary mb-0">{{ $stats['total_orders'] }}</h4>
                            <small class="text-muted">Total Order</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-0">{{ $stats['completed_orders'] }}</h4>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
                <hr class="my-3">
                <div class="text-center">
                    <div class="text-muted small mb-1">Total Pengeluaran</div>
                    <h5 class="text-success mb-0">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>

        <!-- Last Order -->
        @if($stats['last_order'])
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-clock-history me-1"></i>Order Terakhir
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold">{{ $stats['last_order']->service ? $stats['last_order']->service->title : 'Layanan tidak ditemukan' }}</span>
                    <span class="badge bg-{{ $stats['last_order']->status_badge }}">{{ $stats['last_order']->status_label }}</span>
                </div>
                <div class="text-muted small mb-2">{{ $stats['last_order']->created_at->format('d F Y, H:i') }}</div>
                <div class="fw-bold text-success">Rp {{ number_format($stats['last_order']->total_price, 0, ',', '.') }}</div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
@if($customer->orders_count == 0)
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
                <p>Apakah Anda yakin ingin menghapus pelanggan <strong>"{{ $customer->name }}"</strong>?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Hapus Pelanggan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
