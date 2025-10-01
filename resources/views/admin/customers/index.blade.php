@extends('admin.layout', [
    'title' => 'Kelola Pelanggan',
    'subtitle' => 'Kelola data pelanggan dan riwayat order'
])

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-people fa-2x text-primary"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_customers'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pelanggan Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['active_customers'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-clock fa-2x text-warning"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Belum Verifikasi
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['inactive_customers'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-receipt fa-2x text-info"></i>
                    </div>
    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Order
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_orders'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Cari Pelanggan</label>
                <input type="text" name="search" class="form-control" placeholder="Nama, email, atau telepon..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif (Terverifikasi)</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Belum Verifikasi</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Reset
                        </a>
                    @endif
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
                        <th>Pelanggan</th>
                        <th>Kontak</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Daftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $customer->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($customer->phone)
                                <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                    <i class="bi bi-telephone me-1"></i>{{ $customer->phone }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                            @if($customer->address)
                                <br>
                                <small class="text-muted">{{ Str::limit($customer->address, 30) }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="text-center">
                                <div class="fw-bold text-primary">{{ $customer->orders_count }}</div>
                                <small class="text-muted">order</small>
                            </div>
                        </td>
                        <td>
                            @if($customer->email_verified_at)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock me-1"></i>Belum Verifikasi
                                </span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $customer->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($customer->phone)
                                <a href="tel:{{ $customer->phone }}" class="btn btn-sm btn-outline-info" title="Telepon">
                                    <i class="bi bi-telephone"></i>
                                </a>
                                @endif
                                <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $customer->email_verified_at ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $customer->email_verified_at ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi {{ $customer->email_verified_at ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>
                                @if($customer->orders_count == 0)
                                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                <strong>Belum ada pelanggan</strong>
                                <br>
                                <small>Pelanggan yang mendaftar akan muncul di sini</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div class="card-footer bg-light">
            {{ $customers->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
