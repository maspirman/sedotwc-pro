@extends('admin.layout')

@section('title', 'Pengaturan Sosial Media')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-share me-2"></i>Pengaturan Sosial Media
                    </h4>
                    <button type="button" class="btn btn-success btn-sm" onclick="addSocialMedia()">
                        <i class="bi bi-plus me-2"></i>Tambah Sosial Media
                    </button>
                </div>
                <div class="card-body">
                    <form id="socialMediaForm" action="{{ route('admin.settings.update-social-media') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div id="socialMediaContainer">
                            @foreach($socialMedia as $index => $social)
                            <div class="social-media-item border rounded p-3 mb-3" data-index="{{ $index }}">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label">Platform</label>
                                        <select class="form-select platform-select" name="social_media[{{ $index }}][platform]" required>
                                            <option value="">Pilih Platform</option>
                                            <option value="facebook" {{ $social['platform'] === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="instagram" {{ $social['platform'] === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                            <option value="twitter" {{ $social['platform'] === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                            <option value="youtube" {{ $social['platform'] === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                            <option value="linkedin" {{ $social['platform'] === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                            <option value="tiktok" {{ $social['platform'] === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                            <option value="whatsapp" {{ $social['platform'] === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                            <option value="telegram" {{ $social['platform'] === 'telegram' ? 'selected' : '' }}>Telegram</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">URL</label>
                                        <input type="url" class="form-control" name="social_media[{{ $index }}][url]"
                                               value="{{ $social['url'] }}" placeholder="https://" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Deskripsi (Opsional)</label>
                                        <input type="text" class="form-control" name="social_media[{{ $index }}][description]"
                                               value="{{ $social['description'] }}" placeholder="Contoh: Follow kami di Facebook">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeSocialMedia(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if(count($socialMedia) === 0)
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-share display-4 mb-3"></i>
                            <p>Belum ada sosial media yang dikonfigurasi</p>
                            <button type="button" class="btn btn-success" onclick="addSocialMedia()">
                                <i class="bi bi-plus me-2"></i>Tambah Sosial Media Pertama
                            </button>
                        </div>
                        @endif

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Sosial Media
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let socialMediaIndex = {{ count($socialMedia) }};

function addSocialMedia() {
    const container = document.getElementById('socialMediaContainer');
    const item = document.createElement('div');
    item.className = 'social-media-item border rounded p-3 mb-3';
    item.setAttribute('data-index', socialMediaIndex);

    item.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label">Platform</label>
                <select class="form-select platform-select" name="social_media[${socialMediaIndex}][platform]" required>
                    <option value="">Pilih Platform</option>
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="twitter">Twitter</option>
                    <option value="youtube">YouTube</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="tiktok">TikTok</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="telegram">Telegram</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">URL</label>
                <input type="url" class="form-control" name="social_media[${socialMediaIndex}][url]" placeholder="https://" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Deskripsi (Opsional)</label>
                <input type="text" class="form-control" name="social_media[${socialMediaIndex}][description]" placeholder="Contoh: Follow kami di Facebook">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeSocialMedia(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(item);
    socialMediaIndex++;
}

function removeSocialMedia(button) {
    const item = button.closest('.social-media-item');
    item.remove();

    // Re-index remaining items
    const items = document.querySelectorAll('.social-media-item');
    items.forEach((item, index) => {
        item.setAttribute('data-index', index);
        const selects = item.querySelectorAll('select, input');
        selects.forEach(select => {
            const name = select.getAttribute('name');
            if (name) {
                select.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
            }
        });
    });
    socialMediaIndex = items.length;
}

// Update platform icons when platform changes
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('platform-select')) {
        // Could add platform-specific icons here if needed
    }
});
</script>
@endpush
