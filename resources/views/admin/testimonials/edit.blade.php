@extends('admin.layout')

@section('title', 'Edit Testimonial - ' . $testimonial->customer_name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">
                                <i class="bi bi-pencil me-2"></i>Edit Testimonial
                            </h4>
                            <small class="text-muted">Edit testimonial dari {{ $testimonial->customer_name }}</small>
                        </div>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Customer Name -->
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">
                                    Nama Pelanggan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name" name="customer_name"
                                       value="{{ old('customer_name', $testimonial->customer_name) }}" required>
                                @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Service Type -->
                            <div class="col-md-6">
                                <label for="service_type" class="form-label">Jenis Layanan</label>
                                <select class="form-select @error('service_type') is-invalid @enderror"
                                        id="service_type" name="service_type">
                                    <option value="">Pilih jenis layanan</option>
                                    <option value="Sedot WC Standar" {{ old('service_type', $testimonial->service_type) === 'Sedot WC Standar' ? 'selected' : '' }}>Sedot WC Standar</option>
                                    <option value="Sedot WC Premium" {{ old('service_type', $testimonial->service_type) === 'Sedot WC Premium' ? 'selected' : '' }}>Sedot WC Premium</option>
                                    <option value="Sedot WC + Pembersihan" {{ old('service_type', $testimonial->service_type) === 'Sedot WC + Pembersihan' ? 'selected' : '' }}>Sedot WC + Pembersihan</option>
                                    <option value="Sedot WC Darurat 24 Jam" {{ old('service_type', $testimonial->service_type) === 'Sedot WC Darurat 24 Jam' ? 'selected' : '' }}>Sedot WC Darurat 24 Jam</option>
                                    <option value="Sedot WC Apartemen" {{ old('service_type', $testimonial->service_type) === 'Sedot WC Apartemen' ? 'selected' : '' }}>Sedot WC Apartemen</option>
                                </select>
                                @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Rating <span class="text-danger">*</span>
                                </label>
                                <div class="rating-stars">
                                    @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                           {{ old('rating', $testimonial->rating) == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" title="{{ $i }} stars">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                    @endfor
                                </div>
                                <small class="text-muted">Pilih rating dari 1 sampai 5 bintang</small>
                                @error('rating')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status', $testimonial->status) === 'active' ? 'selected' : '' }}>Aktif - Ditampilkan di website</option>
                                    <option value="inactive" {{ old('status', $testimonial->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif - Disembunyikan</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Customer Image -->
                            <div class="col-12">
                                <label for="customer_image" class="form-label">Foto Pelanggan</label>
                                <input type="file" class="form-control @error('customer_image') is-invalid @enderror"
                                       id="customer_image" name="customer_image" accept="image/*">
                                <div class="form-text">
                                    Upload foto pelanggan baru (format: JPG, PNG, GIF, maksimal 2MB).
                                    Jika tidak diupload, foto lama akan tetap digunakan.
                                </div>
                                @error('customer_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Current Image Preview -->
                                @if($testimonial->customer_image)
                                <div class="mt-3">
                                    <label class="form-label">Foto Saat Ini:</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                             alt="{{ $testimonial->customer_name }}"
                                             class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                        <div>
                                            <small class="text-muted">Foto akan diganti jika Anda upload foto baru</small>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="mt-3">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                         style="width: 60px; height: 60px;">
                                        <span class="fw-bold fs-4">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                                    </div>
                                    <small class="text-muted ms-2">Saat ini menggunakan inisial nama</small>
                                </div>
                                @endif

                                <!-- New Image Preview -->
                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <label class="form-label">Pratinjau Foto Baru:</label>
                                    <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-12">
                                <label for="content" class="form-label">
                                    Isi Testimonial <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content" name="content" rows="4"
                                          placeholder="Masukkan testimonial dari pelanggan..." required>{{ old('content', $testimonial->content) }}</textarea>
                                <div class="form-text">
                                    Maksimal 1000 karakter. Testimonial akan ditampilkan di halaman depan website.
                                </div>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <span id="char-count">{{ strlen(old('content', $testimonial->content)) }}</span>/1000 karakter
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.testimonials.show', $testimonial) }}" class="btn btn-outline-info">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Update Testimonial
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.rating-stars {
    display: flex;
    gap: 5px;
}

.rating-stars input[type="radio"] {
    display: none;
}

.rating-stars label {
    font-size: 24px;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-stars input[type="radio"]:checked ~ label,
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #ffc107;
}

.rating-stars input[type="radio"]:checked ~ label {
    color: #ffc107;
}

.rating-stars label:hover ~ input[type="radio"]:checked ~ label {
    color: #ffc107;
}
</style>
@endpush

@push('scripts')
<script>
// Character count for testimonial content
document.getElementById('content').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('char-count').textContent = count;

    if (count > 1000) {
        this.value = this.value.substring(0, 1000);
        document.getElementById('char-count').textContent = 1000;
    }
});

// Image preview
document.getElementById('customer_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Update rating display
document.querySelectorAll('input[name="rating"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const rating = this.value;
        console.log('Rating selected:', rating);
    });
});
</script>
@endpush
