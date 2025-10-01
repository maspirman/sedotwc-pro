@extends('admin.layout')

@section('title', 'Log Files Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>Log Files Management
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Ukuran</th>
                                    <th>Terakhir Dimodifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logFiles as $logFile)
                                <tr>
                                    <td>
                                        <strong>{{ $logFile['name'] }}</strong>
                                        @if($logFile['name'] === 'laravel.log')
                                            <span class="badge bg-primary ms-2">Laravel</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($logFile['size'] / 1024, 1) }} KB</td>
                                    <td>{{ date('d/m/Y H:i:s', $logFile['modified']) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.settings.view-log', $logFile['name']) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <form action="{{ route('admin.settings.clear-log', $logFile['name']) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin mengosongkan file log ini?')">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Clear
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="bi bi-file-earmark-x display-4 mb-3"></i>
                                        <p>Tidak ada file log ditemukan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(count($logFiles) > 0)
                    <div class="mt-4">
                        <div class="alert alert-info">
                            <h6><i class="bi bi-info-circle me-2"></i>Tentang Log Files</h6>
                            <ul class="mb-0">
                                <li><strong>Laravel.log:</strong> File log utama Laravel yang mencatat semua aktivitas sistem</li>
                                <li>Log files membantu debugging dan monitoring aktivitas website</li>
                                <li>Regular clearing log files dapat menghemat space penyimpanan</li>
                                <li>Log files tersimpan di: <code>storage/logs/</code></li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end">
                            <form action="{{ route('admin.settings.clear-all-logs') }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin mengosongkan SEMUA file log?')">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-2"></i>Clear All Logs
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
