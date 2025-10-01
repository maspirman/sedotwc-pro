@extends('admin.layout', [
    'title' => 'Edit Pelanggan',
    'subtitle' => 'Perbarui informasi pelanggan ' . $customer->name
])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-person me-2"></i>Informasi Akun
                            </h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person-fill me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', $customer->name) }}"
                                   placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email', $customer->email) }}"
                                   placeholder="Masukkan email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                <i class="bi bi-telephone me-1"></i>Nomor Telepon
                            </label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone"
                                   value="{{ old('phone', $customer->phone) }}"
                                   placeholder="081234567890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1"></i>Password Baru (Opsional)
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Biarkan kosong jika tidak ingin mengubah">
                            <small class="text-muted">Minimal 8 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password Baru
                            </label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation"
                                   placeholder="Konfirmasi password baru">
                        </div>

                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-geo-alt me-2"></i>Informasi Alamat
                            </h5>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">
                                <i class="bi bi-house me-1"></i>Alamat Lengkap
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="4"
                                      placeholder="Masukkan alamat lengkap">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <span class="badge {{ $customer->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                Status: {{ $customer->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Perbarui Pelanggan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Customer Statistics (Read-only) -->
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>Statistik Pelanggan (Informasi Tambahan)
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-primary mb-0">{{ $customer->orders()->count() }}</h4>
                            <small class="text-muted">Total Order</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-success mb-0">{{ $customer->orders()->where('status', 'completed')->count() }}</h4>
                            <small class="text-muted">Order Selesai</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-info mb-0">{{ $customer->orders()->where('status', 'pending')->count() }}</h4>
                            <small class="text-muted">Order Pending</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-success mb-0">Rp {{ number_format($customer->orders()->where('status', 'completed')->sum('total_price'), 0, ',', '.') }}</h4>
                        <small class="text-muted">Total Pengeluaran</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format phone number input
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;
        });
    }
});
</script>
@endpush
