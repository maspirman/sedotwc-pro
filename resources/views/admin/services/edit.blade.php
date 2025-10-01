@extends('admin.layout')

@include('components.media-selector')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h3 mb-0">Edit Layanan</h1>
        <p class="text-muted">Perbarui informasi layanan "{{ $service->title }}"</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.services.show', $service) }}" class="btn btn-outline-info">
            <i class="bi bi-eye me-1"></i>Lihat
        </a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">
                                <i class="bi bi-tag me-1"></i>Nama Layanan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $service->title) }}"
                                   placeholder="Masukkan nama layanan" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">
                                <i class="bi bi-cash me-1"></i>Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price', $service->price) }}"
                                       placeholder="0" min="0" step="1000" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                <i class="bi bi-toggle-on me-1"></i>Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="icon" class="form-label">
                                <i class="bi bi-star me-1"></i>Icon Bootstrap (Opsional)
                            </label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon" value="{{ old('icon', $service->icon) }}"
                                   placeholder="bi-wrench-adjustable">
                            <small class="text-muted">Masukkan nama icon Bootstrap (contoh: bi-wrench-adjustable, bi-water, dll)</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                <i class="bi bi-image me-1"></i>Gambar Layanan (Opsional)
                            </label>
                            <div class="image-selection-container">
                                <!-- Current Image Preview -->
                                @if($service->image)
                                <div id="currentImagePreview" class="mb-3">
                                    <div class="d-flex align-items-center gap-3 p-3 border rounded bg-light">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" style="max-width: 100px; max-height: 100px; object-fit: cover;" class="rounded">
                                        <div class="flex-grow-1">
                                            <p class="mb-1 fw-bold">Gambar Saat Ini</p>
                                            <small class="text-muted">{{ $service->image }}</small>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeCurrentImage">
                                            <i class="bi bi-x-lg"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                                @endif

                                <!-- New Image Preview -->
                                <div id="imagePreview" class="mb-3" style="display: none;">
                                    <div class="d-flex align-items-center gap-3 p-3 border rounded">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 100px; max-height: 100px; object-fit: cover;" class="rounded">
                                        <div class="flex-grow-1">
                                            <p class="mb-1 fw-bold" id="previewName"></p>
                                            <small class="text-muted" id="previewInfo"></small>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeImage">
                                            <i class="bi bi-x-lg"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                                <!-- Selection Options -->
                                <div class="d-flex gap-2 mb-3">
                                    <button type="button" class="btn btn-outline-primary" id="selectFromMedia">
                                        <i class="bi bi-images me-1"></i>Pilih dari Media Library
                                    </button>
                                    <span class="align-self-center text-muted">atau</span>
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    </div>
                                </div>

                                <!-- Hidden inputs for selected media -->
                                <input type="hidden" name="image_path" id="imagePathInput">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('image_path')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">
                                <i class="bi bi-textarea-resize me-1"></i>Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5"
                                      placeholder="Jelaskan detail layanan yang ditawarkan" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Perbarui Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectFromMediaBtn = document.getElementById('selectFromMedia');
    const imageInput = document.getElementById('image');
    const imagePathInput = document.getElementById('imagePathInput');
    const imagePreview = document.getElementById('imagePreview');
    const currentImagePreview = document.getElementById('currentImagePreview');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');
    const previewInfo = document.getElementById('previewInfo');
    const removeImageBtn = document.getElementById('removeImage');
    const removeCurrentImageBtn = document.getElementById('removeCurrentImage');

    // Handle media selection
    selectFromMediaBtn.addEventListener('click', function() {
        window.openMediaSelector(function(selectedPath) {
            // Set hidden input
            imagePathInput.value = selectedPath;

            // Clear file input
            imageInput.value = '';

            // Hide current image if exists
            if (currentImagePreview) {
                currentImagePreview.style.display = 'none';
            }

            // Update preview
            previewImg.src = '/storage/' + selectedPath;
            previewName.textContent = selectedPath.split('/').pop();
            previewInfo.textContent = 'Dari Media Library';
            imagePreview.style.display = 'block';

            // Disable file input
            imageInput.disabled = true;
        });
    });

    // Handle file input change
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            // Clear media library selection
            imagePathInput.value = '';

            // Hide current image if exists
            if (currentImagePreview) {
                currentImagePreview.style.display = 'none';
            }

            // Update preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                previewInfo.textContent = `File upload • ${(file.size / 1024 / 1024).toFixed(2)} MB`;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);

            // Re-enable file input
            imageInput.disabled = false;
        } else {
            // Hide preview if no file selected
            imagePreview.style.display = 'none';
            // Show current image if exists
            if (currentImagePreview) {
                currentImagePreview.style.display = 'block';
            }
        }
    });

    // Handle remove current image
    if (removeCurrentImageBtn) {
        removeCurrentImageBtn.addEventListener('click', function() {
            if (currentImagePreview) {
                currentImagePreview.style.display = 'none';
            }
            imagePathInput.value = '';
            imageInput.value = '';
            imageInput.disabled = false;
            imagePreview.style.display = 'none';
        });
    }

    // Handle remove new image
    removeImageBtn.addEventListener('click', function() {
        imagePathInput.value = '';
        imageInput.value = '';
        imageInput.disabled = false;
        imagePreview.style.display = 'none';

        // Show current image if exists
        if (currentImagePreview) {
            currentImagePreview.style.display = 'block';
        }
    });
});
</script>
@endpush
