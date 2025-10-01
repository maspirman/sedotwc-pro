@extends('admin.layout')

@section('title', 'Backup Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-database me-2"></i>Backup Management
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Backup database akan membuat file SQL yang berisi semua data. Backup web akan membuat file ZIP berisi semua file website (kecuali cache dan vendor).
                    </div>

                    <div class="row">
                        <!-- Database Backup -->
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-database me-2"></i>Database Backup
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Buat backup dari semua data database dalam format SQL.</p>
                                    <ul class="list-unstyled">
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Menggunakan mysqldump</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Format SQL lengkap</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Siap restore</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Download otomatis</li>
                                    </ul>
                                    <form action="{{ route('admin.settings.backup.database') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-download me-2"></i>Backup Database
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Web Files Backup -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-file-zip me-2"></i>Web Files Backup
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Buat backup dari semua file website dalam format ZIP.</p>
                                    <ul class="list-unstyled">
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Format ZIP terkompresi</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Kecuali cache & vendor</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Maksimal 50MB per file</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Download otomatis</li>
                                    </ul>
                                    <form action="{{ route('admin.settings.backup.web') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-download me-2"></i>Backup Web Files
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backup History -->
                    <div class="mt-4">
                        <h5>Backup History</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipe Backup</th>
                                        <th>File Name</th>
                                        <th>Ukuran</th>
                                        <th>Waktu Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $backupFiles = [];
                                        $dbBackupDir = storage_path('backups/database');
                                        $webBackupDir = storage_path('backups/web');

                                        // Get database backups
                                        if (is_dir($dbBackupDir)) {
                                            foreach (scandir($dbBackupDir) as $file) {
                                                if ($file !== '.' && $file !== '..') {
                                                    $filePath = $dbBackupDir . '/' . $file;
                                                    $backupFiles[] = [
                                                        'type' => 'Database',
                                                        'name' => $file,
                                                        'path' => $filePath,
                                                        'size' => filesize($filePath),
                                                        'time' => filemtime($filePath),
                                                    ];
                                                }
                                            }
                                        }

                                        // Get web backups
                                        if (is_dir($webBackupDir)) {
                                            foreach (scandir($webBackupDir) as $file) {
                                                if ($file !== '.' && $file !== '..') {
                                                    $filePath = $webBackupDir . '/' . $file;
                                                    $backupFiles[] = [
                                                        'type' => 'Web Files',
                                                        'name' => $file,
                                                        'path' => $filePath,
                                                        'size' => filesize($filePath),
                                                        'time' => filemtime($filePath),
                                                    ];
                                                }
                                            }
                                        }

                                        // Sort by time (newest first)
                                        usort($backupFiles, function($a, $b) {
                                            return $b['time'] - $a['time'];
                                        });

                                        $backupFiles = array_slice($backupFiles, 0, 20); // Show only latest 20
                                    @endphp

                                    @forelse($backupFiles as $backup)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $backup['type'] === 'Database' ? 'primary' : 'success' }}">
                                                {{ $backup['type'] }}
                                            </span>
                                        </td>
                                        <td>{{ $backup['name'] }}</td>
                                        <td>{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td>
                                        <td>{{ date('d/m/Y H:i', $backup['time']) }}</td>
                                        <td>
                                            <a href="{{ route('admin.settings.backup.download', ['type' => strtolower(str_replace(' ', '_', $backup['type'])), 'file' => $backup['name']]) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada file backup</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
