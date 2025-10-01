@extends('admin.layout')

@section('title', 'Maintenance Mode')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-tools me-2"></i>Maintenance Mode
                    </h4>
                </div>
                <div class="card-body">
                    @if($isMaintenance)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Maintenance Mode sedang AKTIF!</strong> Website tidak dapat diakses oleh pengunjung.
                    </div>
                    @else
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        Website berjalan normal.
                    </div>
                    @endif

                    <form action="{{ route('admin.settings.toggle-maintenance') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Maintenance Page Customization -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="bi bi-palette me-2"></i>Kustomisasi Halaman Maintenance
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="maintenance_title" class="form-label">Judul Halaman</label>
                                                    <input type="text" class="form-control" id="maintenance_title"
                                                           name="maintenance_title" value="{{ $maintenanceSettings['title'] }}">
                                                    <div class="form-text">Judul yang ditampilkan di halaman maintenance</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="maintenance_estimated_time" class="form-label">Estimasi Waktu</label>
                                                    <input type="text" class="form-control" id="maintenance_estimated_time"
                                                           name="maintenance_estimated_time" value="{{ $maintenanceSettings['estimated_time'] }}">
                                                    <div class="form-text">Contoh: "1-2 jam lagi", "Besok pagi"</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="maintenance_message" class="form-label">Pesan Maintenance</label>
                                            <textarea class="form-control" id="maintenance_message" name="maintenance_message"
                                                      rows="3">{{ $maintenanceSettings['message'] }}</textarea>
                                            <div class="form-text">Pesan yang akan ditampilkan kepada pengunjung</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="maintenance_progress" class="form-label">Progress (%)</label>
                                                    <input type="number" class="form-control" id="maintenance_progress"
                                                           name="maintenance_progress" value="{{ $maintenanceSettings['progress'] }}"
                                                           min="0" max="100">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="maintenance_retry" class="form-label">Auto Refresh (detik)</label>
                                                    <input type="number" class="form-control" id="maintenance_retry"
                                                           name="maintenance_retry" value="{{ $maintenanceSettings['retry'] }}"
                                                           min="30" max="3600">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="maintenance_background_color" class="form-label">Warna Background</label>
                                                    <input type="color" class="form-control form-control-color" id="maintenance_background_color"
                                                           name="maintenance_background_color" value="{{ $maintenanceSettings['background_color'] }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="maintenance_show_social_links"
                                                       name="maintenance_show_social_links" value="1" {{ $maintenanceSettings['show_social_links'] ? 'checked' : '' }}>
                                                <label class="form-check-label" for="maintenance_show_social_links">
                                                    Tampilkan link media sosial di halaman maintenance
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="maintenance_mode" class="form-label">
                                        Status Maintenance Mode
                                    </label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode"
                                               name="maintenance_mode" value="1" {{ $isMaintenance ? 'checked' : '' }}>
                                        <input type="hidden" name="maintenance_mode" value="0">
                                        <label class="form-check-label" for="maintenance_mode">
                                            {{ $isMaintenance ? 'Nonaktifkan' : 'Aktifkan' }} Maintenance Mode
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Informasi Maintenance Mode</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="bi bi-info-circle text-info me-2"></i>Admin masih bisa mengakses website</li>
                                            <li><i class="bi bi-info-circle text-info me-2"></i>Pengunjung melihat halaman maintenance</li>
                                            <li><i class="bi bi-info-circle text-info me-2"></i>API endpoints tetap berfungsi</li>
                                            <li><i class="bi bi-info-circle text-info-2"></i>Semua route frontend diblokir</li>
                                        </ul>
                                    </div>
                                </div>

                                @if($isMaintenance)
                                <div class="alert alert-info mt-3">
                                    <strong>Maintenance aktif sejak:</strong><br>
                                    {{ now()->format('d/m/Y H:i:s') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/') }}" target="_blank" class="btn btn-info">
                                <i class="bi bi-eye me-2"></i>Preview Website
                            </a>
                            <button type="submit" class="btn btn-{{ $isMaintenance ? 'success' : 'warning' }}">
                                <i class="bi bi-{{ $isMaintenance ? 'check-circle' : 'tools' }} me-2"></i>
                                {{ $isMaintenance ? 'Nonaktifkan Maintenance' : 'Aktifkan Maintenance' }}
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
// Update form when checkbox changes
document.getElementById('maintenance_mode').addEventListener('change', function() {
    const submitBtn = document.querySelector('button[type="submit"]');
    const hiddenInput = document.querySelector('input[type="hidden"][name="maintenance_mode"]');
    const isChecked = this.checked;

    // Update hidden input value
    if (hiddenInput) {
        hiddenInput.value = isChecked ? '1' : '0';
    }

    // Update button appearance
    submitBtn.className = `btn btn-${isChecked ? 'warning' : 'success'}`;
    submitBtn.innerHTML = `<i class="bi bi-${isChecked ? 'tools' : 'check-circle'} me-2"></i>${isChecked ? 'Aktifkan Maintenance' : 'Nonaktifkan Maintenance'}`;
});
</script>
@endpush
