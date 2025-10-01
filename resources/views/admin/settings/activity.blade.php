@extends('admin.layout')

@section('title', 'Activity Log')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-activity me-2"></i>Activity Log
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Activity log menampilkan aktivitas sistem terbaru dari file Laravel log. Ini membantu monitoring aktivitas website dan debugging masalah.
                    </div>

                    @if(count($activities) > 0)
                    <div class="timeline">
                        @foreach($activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-{{ $activity['level'] === 'ERROR' ? 'danger' : ($activity['level'] === 'WARNING' ? 'warning' : 'info') }}"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge bg-{{ $activity['level'] === 'ERROR' ? 'danger' : ($activity['level'] === 'WARNING' ? 'warning' : 'info') }} me-2">
                                                {{ $activity['level'] }}
                                            </span>
                                            {{ $activity['message'] }}
                                        </h6>
                                        <small class="text-muted">{{ $activity['timestamp'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.settings.logs') }}" class="btn btn-primary">
                            <i class="bi bi-file-earmark-text me-2"></i>Lihat File Log Lengkap
                        </a>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-activity display-4 mb-3"></i>
                        <p>Belum ada aktivitas terbaru atau log file kosong</p>
                        <a href="{{ route('admin.settings.logs') }}" class="btn btn-primary">
                            <i class="bi bi-file-earmark-text me-2"></i>Lihat File Log
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-size: 14px;
}

.badge {
    font-size: 10px;
}
</style>
@endpush
