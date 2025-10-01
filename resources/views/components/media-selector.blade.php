{{-- Media Selector Modal Component --}}
<div class="modal fade" id="mediaSelectorModal" tabindex="-1" aria-labelledby="mediaSelectorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaSelectorModalLabel">
                    <i class="bi bi-images me-2"></i>Pilih Gambar dari Media Library
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="mediaSearch" class="form-control" placeholder="Cari gambar...">
                </div>

                <div id="mediaGrid" class="row" style="max-height: 400px; overflow-y: auto;">
                    <!-- Media files will be loaded here -->
                    <div class="col-12 text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat gambar...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary" id="selectMediaBtn" disabled>
                    <i class="bi bi-check-circle me-1"></i>Pilih Gambar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedMediaPath = null;
    let selectedMediaElement = null;
    let onMediaSelected = null;

    // Media selector modal
    const mediaModal = new bootstrap.Modal(document.getElementById('mediaSelectorModal'));
    const mediaGrid = document.getElementById('mediaGrid');
    const mediaSearch = document.getElementById('mediaSearch');
    const selectMediaBtn = document.getElementById('selectMediaBtn');

    // Load media files
    async function loadMediaFiles(search = '') {
        try {
            const response = await fetch(`/admin/media/api/files?search=${encodeURIComponent(search)}`);
            const data = await response.json();

            if (data.success) {
                renderMediaGrid(data.files);
            } else {
                mediaGrid.innerHTML = '<div class="col-12 text-center py-4"><p class="text-muted">Gagal memuat gambar</p></div>';
            }
        } catch (error) {
            console.error('Error loading media files:', error);
            mediaGrid.innerHTML = '<div class="col-12 text-center py-4"><p class="text-muted">Gagal memuat gambar</p></div>';
        }
    }

    // Render media grid
    function renderMediaGrid(files) {
        if (files.length === 0) {
            mediaGrid.innerHTML = '<div class="col-12 text-center py-4"><p class="text-muted">Tidak ada gambar ditemukan</p></div>';
            return;
        }

        const html = files.map(file => `
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm media-item ${selectedMediaPath === file.path ? 'border-primary' : ''}" style="cursor: pointer;" data-path="${file.path}">
                    <div class="position-relative">
                        <img src="/storage/${file.path}" class="card-img-top" alt="${file.name}" style="height: 100px; object-fit: cover;">
                        ${selectedMediaPath === file.path ? '<div class="position-absolute top-0 end-0 bg-primary text-white rounded-circle p-1 m-1"><i class="bi bi-check-lg"></i></div>' : ''}
                    </div>
                    <div class="card-body p-2">
                        <small class="text-truncate d-block" title="${file.name}">${file.name}</small>
                        <small class="text-muted">${file.size}</small>
                    </div>
                </div>
            </div>
        `).join('');

        mediaGrid.innerHTML = html;

        // Add click handlers
        document.querySelectorAll('.media-item').forEach(item => {
            item.addEventListener('click', function() {
                const path = this.dataset.path;

                // Remove previous selection
                document.querySelectorAll('.media-item').forEach(el => {
                    el.classList.remove('border-primary');
                    const checkIcon = el.querySelector('.position-absolute');
                    if (checkIcon) checkIcon.remove();
                });

                // Add selection to clicked item
                this.classList.add('border-primary');
                const checkIcon = document.createElement('div');
                checkIcon.className = 'position-absolute top-0 end-0 bg-primary text-white rounded-circle p-1 m-1';
                checkIcon.innerHTML = '<i class="bi bi-check-lg"></i>';
                this.querySelector('.position-relative').appendChild(checkIcon);

                selectedMediaPath = path;
                selectMediaBtn.disabled = false;
            });
        });
    }

    // Search functionality
    let searchTimeout;
    mediaSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadMediaFiles(this.value);
        }, 300);
    });

    // Select media button
    selectMediaBtn.addEventListener('click', function() {
        if (selectedMediaPath && onMediaSelected) {
            onMediaSelected(selectedMediaPath);
            mediaModal.hide();
        }
    });

    // Reset modal when closed
    document.getElementById('mediaSelectorModal').addEventListener('hidden.bs.modal', function() {
        selectedMediaPath = null;
        selectedMediaElement = null;
        onMediaSelected = null;
        selectMediaBtn.disabled = true;
        mediaSearch.value = '';
    });

    // Global function to open media selector
    window.openMediaSelector = function(callback, currentElement = null) {
        selectedMediaElement = currentElement;
        onMediaSelected = callback;
        loadMediaFiles();
        mediaModal.show();
    };
});
</script>
@endpush
