@extends('admin.layout')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h3 mb-0">Kelola Layanan</h1>
        <p class="text-muted">Kelola semua layanan sedot WC yang tersedia</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Layanan
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-wrench-adjustable fa-2x text-primary"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Layanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $services->total() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Layanan Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $services->where('status', 'active')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-pause-circle fa-2x text-warning"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Layanan Nonaktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $services->where('status', 'inactive')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Layanan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Total Order</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <i class="bi {{ $service->icon ?: 'bi-wrench-adjustable' }} text-primary fs-4"></i>
                                    @endif
                                </div>
                                <div>
                                    <strong>{{ $service->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $service->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $service->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $service->orders_count ?? 0 }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $service->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $service->status === 'active' ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $service->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi {{ $service->status === 'active' ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
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
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-info-circle fs-1 d-block mb-2"></i>
                                <strong>Belum ada layanan</strong>
                                <br>
                                <small>Klik tombol "Tambah Layanan" untuk membuat layanan pertama</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
        <div class="card-footer bg-light">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
