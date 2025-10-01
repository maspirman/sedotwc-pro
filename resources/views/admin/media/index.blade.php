@extends('admin.layout', [
    'title' => 'Media Manager',
    'subtitle' => 'Kelola gambar dan file media website'
])

@section('content')
<!-- Breadcrumb Navigation -->
@if($currentPath)
<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.media.index') }}">
                    <i class="bi bi-house"></i> Root
                </a>
            </li>
            @foreach($breadcrumb as $crumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if(!$loop->last)
                        <a href="{{ route('admin.media.index', ['path' => $crumb['path']]) }}">{{ $crumb['name'] }}</a>
                    @else
                        {{ $crumb['name'] }}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
@endif

<!-- Statistics and Actions -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card border-left-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-files fa-2x text-primary"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total File
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_files']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card border-left-info shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-hdd fa-2x text-info"></i>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Ukuran
                        </div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_size'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        @if($currentPath)
            <a href="{{ route('admin.media.index', ['path' => dirname($currentPath) ?: '']) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        @endif
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#folderModal">
            <i class="bi bi-folder-plus me-1"></i>Buat Folder
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-cloud-upload me-2"></i>Upload File
        </button>
        <button type="button" class="btn btn-outline-danger" id="deleteSelected" style="display: none;">
            <i class="bi bi-trash me-1"></i>Hapus Terpilih
        </button>
    </div>
</div>

<!-- File Manager -->
<div class="card shadow-sm">
    <div class="card-body">
        @if($directories || $files)
        <div class="row">
            <!-- Directories -->
            @foreach($directories as $directory)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm directory-item" style="cursor: pointer;" onclick="navigateToFolder('{{ $currentPath ? $currentPath . '/' : '' }}{{ $directory }}')">
                    <div class="card-body text-center p-3">
                        <i class="bi bi-folder text-warning fs-1 mb-2"></i>
                        <h6 class="card-title mb-0 text-truncate" title="{{ $directory }}">{{ $directory }}</h6>
                        <small class="text-muted">Folder</small>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Files -->
            @foreach($files as $file)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm file-item">
                    <div class="position-relative">
                        @if($file['type'] === 'Image')
                            <img src="{{ asset('storage/' . $file['path']) }}" class="card-img-top" alt="{{ $file['name'] }}" style="height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                <i class="bi {{ $file['icon'] }} fs-1 text-muted"></i>
                            </div>
                        @endif

                        <!-- Selection Checkbox -->
                        <div class="position-absolute top-0 start-0 p-1">
                            <input type="checkbox" class="form-check-input file-checkbox" value="{{ $file['path'] }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="position-absolute top-0 end-0 p-1 d-flex gap-1">
                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="btn btn-sm btn-outline-light" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.media.download', $file['path']) }}" class="btn btn-sm btn-outline-light" title="Download">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 text-truncate small" title="{{ $file['name'] }}">{{ $file['name'] }}</h6>
                        <small class="text-muted d-block">{{ $file['type'] }} • {{ $file['size'] }}</small>
                        <small class="text-muted">{{ $file['modified_human'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="bi bi-folder-x text-muted fs-1 d-block mb-3"></i>
            <h5 class="text-muted">Folder Kosong</h5>
            <p class="text-muted">Belum ada file atau folder di lokasi ini</p>
            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#folderModal">
                    <i class="bi bi-folder-plus me-1"></i>Buat Folder
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-upload me-2"></i>Upload File
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-cloud-upload me-2"></i>Upload File
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="path" value="{{ $currentPath }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih File</label>
                        <input type="file" name="files[]" class="form-control" multiple required>
                        <small class="text-muted">Format: JPG, PNG, GIF, PDF, DOC, XLS, dll. Maksimal 5MB per file</small>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-1"></i>
                        File akan diupload ke folder: <code>{{ $currentPath ?: 'root' }}</code>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-1"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Folder Modal -->
<div class="modal fade" id="folderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-folder-plus me-2"></i>Buat Folder Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.media.create-folder') }}" method="POST">
                @csrf
                <input type="hidden" name="path" value="{{ $currentPath }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Folder</label>
                        <input type="text" name="folder_name" class="form-control" required placeholder="Masukkan nama folder">
                        <small class="text-muted">Hanya huruf, angka, underscore, dan strip</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-folder-plus me-1"></i>Buat Folder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteForm" action="{{ route('admin.media.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus item yang dipilih?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <div id="deleteList" class="small text-muted"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileCheckboxes = document.querySelectorAll('.file-checkbox');
    const deleteSelectedBtn = document.getElementById('deleteSelected');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const deleteList = document.getElementById('deleteList');

    // Update delete button visibility
    function updateDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.file-checkbox:checked');
        if (checkedBoxes.length > 0) {
            deleteSelectedBtn.style.display = 'inline-block';
            deleteSelectedBtn.textContent = `Hapus Terpilih (${checkedBoxes.length})`;
        } else {
            deleteSelectedBtn.style.display = 'none';
        }
    }

    // Handle checkbox changes
    fileCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateDeleteButton);
    });

    // Handle delete selected
    deleteSelectedBtn.addEventListener('click', function() {
        const selectedFiles = Array.from(document.querySelectorAll('.file-checkbox:checked')).map(cb => cb.value);
        if (selectedFiles.length === 0) return;

        // Clear existing inputs
        deleteForm.querySelectorAll('input[name="items[]"]').forEach(input => input.remove());

        // Add selected files to form
        selectedFiles.forEach(file => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'items[]';
            input.value = file;
            deleteForm.appendChild(input);
        });

        // Update delete list
        deleteList.innerHTML = selectedFiles.map(file => `<div>• ${file.split('/').pop()}</div>`).join('');

        deleteModal.show();
    });

    // Navigate to folder
    window.navigateToFolder = function(folderPath) {
        window.location.href = '{{ route("admin.media.index") }}?path=' + encodeURIComponent(folderPath);
    };
});
</script>
@endpush
