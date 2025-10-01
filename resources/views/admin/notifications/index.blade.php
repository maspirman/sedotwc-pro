@extends('admin.layout', [
    'title' => 'Notifikasi',
    'subtitle' => 'Kelola semua notifikasi sistem'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-bell me-2"></i>Daftar Notifikasi
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="markAllAsRead()">
                        <i class="bi bi-check-all me-1"></i>Tandai Semua Dibaca
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="card-header py-2">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="read_status" class="form-select form-select-sm">
                            <option value="all" {{ request('read_status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="unread" {{ request('read_status') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                            <option value="read" {{ request('read_status') === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tipe</label>
                        <select name="type" class="form-select form-select-sm">
                            <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>Semua Tipe</option>
                            @foreach($notificationTypes as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-circle me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                @if($notifications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">Status</th>
                                <th>Tipe</th>
                                <th>Judul</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                            <tr class="{{ $notification->is_read ? 'table-light' : '' }}">
                                <td>
                                    @if($notification->is_read)
                                        <i class="bi bi-check-circle-fill text-success" title="Sudah dibaca"></i>
                                    @else
                                        <span class="badge bg-{{ $notification->color ?? 'primary' }} rounded-circle" style="width: 10px; height: 10px;" title="Belum dibaca"></span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $notification->color ?? 'secondary' }}">
                                        {{ ucfirst($notification->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $notification->title }}</div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="{{ $notification->message }}">
                                        {{ Str::limit($notification->message, 60) }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $notification->created_at->format('d/m/Y H:i') }}
                                        <br>
                                        <span class="text-primary">{{ $notification->created_at->diffForHumans() }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($notification->action_url)
                                        <a href="{{ $notification->action_url }}" class="btn btn-sm btn-outline-primary" title="Buka">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                        @endif
                                        @if(!$notification->is_read)
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="markAsRead({{ $notification->id }})" title="Tandai Dibaca">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->appends(request()->query())->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted">Belum ada notifikasi</h5>
                    <p class="text-muted">Notifikasi akan muncul di sini ketika ada aktivitas sistem.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Gagal menandai notifikasi sebagai dibaca');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses notifikasi');
    });
}

function markAllAsRead() {
    if (confirm('Apakah Anda yakin ingin menandai semua notifikasi sebagai dibaca?')) {
        fetch('/admin/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Gagal menandai semua notifikasi sebagai dibaca');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses notifikasi');
        });
    }
}
</script>
@endpush
