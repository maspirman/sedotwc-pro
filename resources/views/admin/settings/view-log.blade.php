@extends('admin.layout')

@section('title', 'View Log: ' . $filename)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>{{ $filename }}
                    </h4>
                    <div>
                        <a href="{{ route('admin.settings.logs') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <form action="{{ route('admin.settings.clear-log', $filename) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin mengosongkan file log ini?')">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash me-2"></i>Clear Log
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($lines) > 0)
                    <div class="log-container bg-dark text-light p-3 rounded" style="max-height: 600px; overflow-y: auto; font-family: 'Courier New', monospace; font-size: 12px; line-height: 1.4;">
                        @foreach(array_reverse($lines) as $line)
                        <div class="log-line mb-1">
                            {{ htmlspecialchars($line) }}
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3 text-muted">
                        <small>Menampilkan {{ count($lines) }} baris terakhir. Log ditampilkan dari yang terbaru ke terlama.</small>
                    </div>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-file-earmark-x display-4 mb-3"></i>
                        <p>File log kosong atau tidak dapat dibaca</p>
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
.log-container {
    border: 1px solid #dee2e6;
}

.log-line {
    white-space: pre-wrap;
    word-break: break-all;
}

.log-line:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Color coding for different log levels */
.log-line:contains("[ERROR]"),
.log-line:contains("[CRITICAL]"),
.log-line:contains("[ALERT]"),
.log-line:contains("[EMERGENCY]") {
    color: #dc3545;
}

.log-line:contains("[WARNING]") {
    color: #ffc107;
}

.log-line:contains("[INFO]") {
    color: #17a2b8;
}

.log-line:contains("[DEBUG]") {
    color: #6c757d;
}
</style>
@endpush
