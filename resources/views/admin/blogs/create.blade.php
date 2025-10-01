@extends('admin.layout', [
    'title' => 'Tambah Artikel Blog',
    'subtitle' => 'Buat artikel blog baru untuk website'
])

@include('components.media-selector')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-pencil me-2"></i>Informasi Artikel
                            </h5>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">
                                <i class="bi bi-type me-1"></i>Judul Artikel <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title') }}"
                                   placeholder="Masukkan judul artikel" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">
                                <i class="bi bi-tag me-1"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                <i class="bi bi-toggle-on me-1"></i>Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan sebagai Draf)</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Terbitkan)</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="published_at" class="form-label">
                                <i class="bi bi-calendar me-1"></i>Tanggal Terbit
                            </label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at"
                                   value="{{ old('published_at') }}">
                            <small class="text-muted">Kosongkan untuk terbit otomatis saat publish</small>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-image me-1"></i>Gambar Utama
                            </label>
                            <div class="image-selection-container">
                                <!-- Image Preview -->
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
                                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                               id="featured_image" name="featured_image" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    </div>
                                </div>

                                <!-- Hidden inputs for selected media -->
                                <input type="hidden" name="featured_image_path" id="imagePathInput">
                            </div>
                            @error('featured_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('featured_image_path')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="content" class="form-label">
                                <i class="bi bi-textarea-resize me-1"></i>Isi Artikel <span class="text-danger">*</span>
                            </label>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Editor kaya fitur: <strong>Bold</strong>, <em>Italic</em>, daftar, link, gambar, tabel, fullscreen mode
                                </small>
                            </div>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content"
                                      placeholder="Tulis isi artikel di sini..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-tags me-2"></i>Tag dan SEO
                            </h5>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="tags" class="form-label">
                                <i class="bi bi-tags me-1"></i>Tag
                            </label>
                            <select class="form-select" id="tags" name="tags[]" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih tag yang relevan untuk artikel ini</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meta_title" class="form-label">
                                <i class="bi bi-search me-1"></i>Meta Title
                            </label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title"
                                   value="{{ old('meta_title') }}"
                                   placeholder="Title untuk SEO" maxlength="60">
                            <small class="text-muted">Maksimal 60 karakter untuk hasil pencarian</small>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meta_description" class="form-label">
                                <i class="bi bi-card-text me-1"></i>Meta Description
                            </label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3"
                                      placeholder="Deskripsi untuk SEO" maxlength="160">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">Maksimal 160 karakter untuk hasil pencarian</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="meta_keywords" class="form-label">
                                <i class="bi bi-key me-1"></i>Meta Keywords
                            </label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords"
                                   value="{{ old('meta_keywords') }}"
                                   placeholder="keyword1, keyword2, keyword3">
                            <small class="text-muted">Pisahkan dengan koma</small>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<!-- Summernote CDN -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    console.log('jQuery ready, initializing components...');

    // Initialize Select2 for tags
    $('#tags').select2({
        placeholder: 'Pilih tag...',
        allowClear: true,
        tags: true
    });

    // Wait a bit for all scripts to load, then initialize Summernote
    setTimeout(function() {
        console.log('Initializing Summernote...');
        $('#content').summernote({
            height: 400,
            placeholder: 'Tulis isi artikel di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    console.log('Summernote initialized successfully!');
                },
                onChange: function(contents, $editable) {
                    console.log('Summernote content changed');
                }
            }
        });
    }, 500);

    // Auto-generate meta title from article title
    $('#title').on('input', function() {
        const title = $(this).val();
        if (!$('#meta_title').val()) {
            $('#meta_title').val(title.substring(0, 60));
        }
    });

    // Media selection functionality
    const selectFromMediaBtn = document.getElementById('selectFromMedia');
    const featuredImageInput = document.getElementById('featured_image');
    const imagePathInput = document.getElementById('imagePathInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');
    const previewInfo = document.getElementById('previewInfo');
    const removeImageBtn = document.getElementById('removeImage');

    // Handle media selection
    selectFromMediaBtn.addEventListener('click', function() {
        window.openMediaSelector(function(selectedPath) {
            // Set hidden input
            imagePathInput.value = selectedPath;

            // Clear file input
            featuredImageInput.value = '';

            // Update preview
            previewImg.src = '/storage/' + selectedPath;
            previewName.textContent = selectedPath.split('/').pop();
            previewInfo.textContent = 'Dari Media Library';
            imagePreview.style.display = 'block';

            // Disable file input
            featuredImageInput.disabled = true;
        });
    });

    // Handle file input change
    featuredImageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];

            // Clear media library selection
            imagePathInput.value = '';

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
            featuredImageInput.disabled = false;
        } else {
            // Hide preview if no file selected
            imagePreview.style.display = 'none';
        }
    });

    // Handle remove image
    removeImageBtn.addEventListener('click', function() {
        imagePathInput.value = '';
        featuredImageInput.value = '';
        featuredImageInput.disabled = false;
        imagePreview.style.display = 'none';
    });
});
</script>
@endpush
