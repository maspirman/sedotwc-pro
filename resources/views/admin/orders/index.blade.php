@extends('admin.layout')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h3 mb-0">Kelola Order</h1>
        <p class="text-muted">Pantau dan kelola semua pesanan layanan</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="bi bi-download me-1"></i>Export
        </button>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
            <i class="bi bi-check-circle me-1"></i>Update Status Massal
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    @php
        $statusStats = [
            'pending' => ['label' => 'Menunggu Konfirmasi', 'icon' => 'bi-clock', 'color' => 'warning'],
            'confirmed' => ['label' => 'Dikonfirmasi', 'icon' => 'bi-check-circle', 'color' => 'info'],
            'in_progress' => ['label' => 'Sedang Dikerjakan', 'icon' => 'bi-gear', 'color' => 'primary'],
            'completed' => ['label' => 'Selesai', 'icon' => 'bi-check-circle-fill', 'color' => 'success'],
            'cancelled' => ['label' => 'Dibatalkan', 'icon' => 'bi-x-circle', 'color' => 'danger'],
        ];
    @endphp

    @foreach($statusStats as $status => $config)
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-left-{{ $config['color'] }} shadow-sm">
            <div class="card-body text-center">
                <i class="bi {{ $config['icon'] }} fa-2x text-{{ $config['color'] }} mb-2"></i>
                <h5 class="mb-0">{{ $statusCounts[$status] ?? 0 }}</h5>
                <small class="text-muted">{{ $config['label'] }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari Pelanggan</label>
                <input type="text" name="search" class="form-control" placeholder="Nama atau nomor telepon..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" class="form-check-input">
                        </th>
                        <th>ID Order</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->id }}">
                        </td>
                        <td>
                            <code>#{{ strtoupper(substr($order->id, -6)) }}</code>
                            <br>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <strong>{{ $order->customer_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                            @if($order->user)
                                <br>
                                <small class="text-primary">
                                    <i class="bi bi-person-circle me-1"></i>{{ $order->user->name }}
                                </small>
                            @endif
                        </td>
                        <td>
                            @if($order->service)
                                {{ $order->service->title }}
                            @else
                                <span class="text-muted">Layanan tidak ditemukan</span>
                            @endif
                        </td>
                        <td>
                            @if($order->scheduled_date)
                                {{ $order->scheduled_date->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->status_badge }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Status Update Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($order->status !== 'confirmed')
                                        <li>
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check-circle text-info me-1"></i>Konfirmasi
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($order->status !== 'in_progress')
                                        <li>
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-gear text-primary me-1"></i>Mulai Kerja
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($order->status !== 'completed')
                                        <li>
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i>Selesai
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($order->status !== 'cancelled')
                                        <li>
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-x-circle text-danger me-1"></i>Batalkan
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>

                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-info-circle fs-1 d-block mb-2"></i>
                                <strong>Belum ada order</strong>
                                <br>
                                <small>Order dari pelanggan akan muncul di sini</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="card-footer bg-light">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Update Status Massal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkUpdateForm" action="{{ route('admin.orders.bulk-update-status') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-1"></i>
                        Pilih order yang ingin diubah statusnya dan pilih status baru.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <select name="status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="confirmed">Dikonfirmasi</option>
                            <option value="in_progress">Sedang Dikerjakan</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order Terpilih</label>
                        <div id="selectedOrders" class="border rounded p-2 bg-light">
                            <small class="text-muted">Belum ada order yang dipilih</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success" id="bulkUpdateBtn" disabled>
                        <i class="bi bi-check-circle me-1"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-download me-2"></i>Export Data Order
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Export data order berdasarkan filter yang sedang aktif.</p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-1"></i>
                    Data akan di-export dalam format JSON untuk saat ini.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-primary">
                    <i class="bi bi-download me-1"></i>Export Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');
    const selectedOrdersDiv = document.getElementById('selectedOrders');
    const bulkUpdateForm = document.getElementById('bulkUpdateForm');

    function updateSelectedOrders() {
        const selectedCheckboxes = document.querySelectorAll('.order-checkbox:checked');
        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

        if (selectedIds.length > 0) {
            selectedOrdersDiv.innerHTML = `<small class="text-primary">${selectedIds.length} order dipilih</small>`;
            bulkUpdateBtn.disabled = false;
        } else {
            selectedOrdersDiv.innerHTML = '<small class="text-muted">Belum ada order yang dipilih</small>';
            bulkUpdateBtn.disabled = true;
        }

        // Add hidden inputs for selected orders
        const existingInputs = bulkUpdateForm.querySelectorAll('input[name="order_ids[]"]');
        existingInputs.forEach(input => input.remove());

        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_ids[]';
            input.value = id;
            bulkUpdateForm.appendChild(input);
        });
    }

    selectAllCheckbox.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedOrders();
    });

    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(orderCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(orderCheckboxes).some(cb => cb.checked);

            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;

            updateSelectedOrders();
        });
    });
});
</script>
@endpush
