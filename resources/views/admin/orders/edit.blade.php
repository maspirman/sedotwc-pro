@extends('admin.layout')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h3 mb-0">Edit Order #{{ strtoupper(substr($order->id, -6)) }}</h1>
        <p class="text-muted">Perbarui informasi pesanan "{{ $order->customer_name }}"</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info">
            <i class="bi bi-eye me-1"></i>Lihat Detail
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Order Status -->
                        <div class="col-md-12 mb-4">
                            <label for="status" class="form-label">
                                <i class="bi bi-toggle-on me-1"></i>Status Order <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="in_progress" {{ old('status', $order->status) == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-12 mb-3">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-person me-2"></i>Informasi Pelanggan
                            </h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">
                                <i class="bi bi-person-fill me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                   id="customer_name" name="customer_name"
                                   value="{{ old('customer_name', $order->customer_name) }}"
                                   placeholder="Masukkan nama lengkap" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="customer_phone" class="form-label">
                                <i class="bi bi-telephone me-1"></i>Nomor Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                   id="customer_phone" name="customer_phone"
                                   value="{{ old('customer_phone', $order->customer_phone) }}"
                                   placeholder="081234567890" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="customer_address" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror"
                                      id="customer_address" name="customer_address" rows="3"
                                      placeholder="Masukkan alamat lengkap" required>{{ old('customer_address', $order->customer_address) }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Schedule Information -->
                        <div class="col-md-12 mb-3">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-calendar-event me-2"></i>Jadwal Pekerjaan
                            </h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="scheduled_date" class="form-label">
                                <i class="bi bi-calendar me-1"></i>Tanggal & Waktu
                            </label>
                            <input type="datetime-local" class="form-control @error('scheduled_date') is-invalid @enderror"
                                   id="scheduled_date" name="scheduled_date"
                                   value="{{ old('scheduled_date', $order->scheduled_date ? $order->scheduled_date->format('Y-m-d\TH:i') : '') }}"
                                   min="{{ now()->format('Y-m-d\TH:i') }}">
                            <small class="text-muted">Kosongkan jika belum ada jadwal</small>
                            @error('scheduled_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="total_price" class="form-label">
                                <i class="bi bi-cash me-1"></i>Total Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('total_price') is-invalid @enderror"
                                       id="total_price" name="total_price"
                                       value="{{ old('total_price', $order->total_price) }}"
                                       placeholder="0" min="0" step="1000" required>
                                @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">
                                <i class="bi bi-sticky me-1"></i>Catatan Tambahan
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="4"
                                      placeholder="Tambahkan catatan atau instruksi khusus">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Perbarui Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Service Information (Read-only) -->
@if($order->service)
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-wrench-adjustable me-2"></i>Informasi Layanan (Tidak Dapat Diubah)
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            @if($order->service->image)
                                <img src="{{ asset('storage/' . $order->service->image) }}" alt="{{ $order->service->title }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <i class="bi {{ $order->service->icon ?: 'bi-wrench-adjustable' }} text-primary fs-3 me-3"></i>
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $order->service->title }}</h6>
                                <p class="mb-0 text-muted small">{{ Str::limit($order->service->description, 100) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-muted small">Harga Layanan</div>
                        <div class="fw-bold">Rp {{ number_format($order->service->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format phone number input
    const phoneInput = document.getElementById('customer_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;
        });
    }

    // Auto-format price input
    const priceInput = document.getElementById('total_price');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;
        });
    }
});
</script>
@endpush
