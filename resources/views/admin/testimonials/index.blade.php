@extends('admin.layout')

@section('title', 'Kelola Testimonial')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">
                                <i class="bi bi-chat-quote me-2"></i>Kelola Testimonial
                            </h4>
                            <small class="text-muted">Kelola testimonial pelanggan untuk ditampilkan di website</small>
                        </div>
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Testimonial
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="card-body border-bottom">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body text-center">
                                    <div class="fs-2 text-primary mb-2">
                                        <i class="bi bi-chat-quote"></i>
                                    </div>
                                    <h5 class="mb-1">{{ $stats['total'] }}</h5>
                                    <small class="text-muted">Total Testimonial</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body text-center">
                                    <div class="fs-2 text-success mb-2">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <h5 class="mb-1">{{ $stats['active'] }}</h5>
                                    <small class="text-muted">Aktif</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning bg-opacity-10 border-warning">
                                <div class="card-body text-center">
                                    <div class="fs-2 text-warning mb-2">
                                        <i class="bi bi-pause-circle"></i>
                                    </div>
                                    <h5 class="mb-1">{{ $stats['inactive'] }}</h5>
                                    <small class="text-muted">Tidak Aktif</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info bg-opacity-10 border-info">
                                <div class="card-body text-center">
                                    <div class="fs-2 text-info mb-2">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <h5 class="mb-1">{{ number_format($stats['avg_rating'], 1) }}</h5>
                                    <small class="text-muted">Rating Rata-rata</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom bg-light">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Cari</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Nama pelanggan atau isi testimonial...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" id="rating" name="rating">
                                <option value="">Semua Rating</option>
                                @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ str_repeat('★', $i) }} ({{ $i }} bintang)
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Bulk Actions -->
                <form id="bulk-action-form" method="POST" action="{{ route('admin.testimonials.bulk-action') }}">
                    @csrf
                    <div class="card-body border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <input type="checkbox" id="select-all" class="form-check-input">
                                <label for="select-all" class="form-check-label mb-0">Pilih Semua</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-gear me-1"></i>Aksi Massal
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button type="submit" name="action" value="activate" class="dropdown-item" onclick="return confirm('Aktifkan testimonial yang dipilih?')">
                                            <i class="bi bi-check-circle text-success me-2"></i>Aktifkan
                                        </button></li>
                                        <li><button type="submit" name="action" value="deactivate" class="dropdown-item" onclick="return confirm('Nonaktifkan testimonial yang dipilih?')">
                                            <i class="bi bi-pause-circle text-warning me-2"></i>Nonaktifkan
                                        </button></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><button type="submit" name="action" value="delete" class="dropdown-item text-danger" onclick="return confirm('Hapus testimonial yang dipilih? Tindakan ini tidak dapat dibatalkan!')">
                                            <i class="bi bi-trash text-danger me-2"></i>Hapus
                                        </button></li>
                                    </ul>
                                </div>
                            </div>
                            <small class="text-muted">{{ $testimonials->total() }} testimonial ditemukan</small>
                        </div>
                    </div>

                    <!-- Testimonials Table -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50"></th>
                                    <th>Pelanggan</th>
                                    <th>Testimonial</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($testimonials as $testimonial)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="testimonial_ids[]" value="{{ $testimonial->id }}"
                                               class="form-check-input testimonial-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($testimonial->customer_image)
                                            <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                                 alt="{{ $testimonial->customer_name }}"
                                                 class="rounded-circle me-3"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                                            </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $testimonial->customer_name }}</h6>
                                                @if($testimonial->service_type)
                                                <small class="text-muted">{{ $testimonial->service_type }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="max-width: 300px;">
                                            <p class="mb-1 text-truncate">{{ Str::limit($testimonial->content, 100) }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning me-2">
                                                {!! $testimonial->stars !!}
                                            </div>
                                            <span class="badge bg-light text-dark">{{ $testimonial->rating }}/5</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $testimonial->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $testimonial->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $testimonial->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.testimonials.show', $testimonial) }}"
                                               class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.testimonials.toggle-status', $testimonial) }}"
                                                  class="d-inline" onsubmit="return confirm('{{ $testimonial->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} testimonial ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn {{ $testimonial->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                        title="{{ $testimonial->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <i class="bi bi-{{ $testimonial->status === 'active' ? 'pause' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                                  class="d-inline" onsubmit="return confirm('Hapus testimonial ini? Tindakan ini tidak dapat dibatalkan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-chat-quote fs-1 mb-3"></i>
                                            <h5>Tidak ada testimonial</h5>
                                            <p class="mb-3">Belum ada testimonial yang ditambahkan.</p>
                                            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                                                <i class="bi bi-plus-circle me-1"></i>Tambah Testimonial Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($testimonials->hasPages())
                    <div class="card-body border-top">
                        {{ $testimonials->appends(request()->query())->links() }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.testimonial-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Individual checkbox handler
document.querySelectorAll('.testimonial-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const selectAll = document.getElementById('select-all');
        const allCheckboxes = document.querySelectorAll('.testimonial-checkbox');
        const checkedBoxes = document.querySelectorAll('.testimonial-checkbox:checked');

        selectAll.checked = allCheckboxes.length === checkedBoxes.length;
        selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
    });
});
</script>
@endpush
