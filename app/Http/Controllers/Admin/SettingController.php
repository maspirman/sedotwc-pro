<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class SettingController extends Controller
{
    public function index()
    {
        // Get all settings grouped
        $settings = GeneralSetting::getAll();
        $socialMedia = GeneralSetting::getSocialMedia();

        return view('admin.settings.index', compact('settings', 'socialMedia'));
    }

    public function update(Request $request)
    {
        $request->validate([
            // General Settings
            'site_name' => 'required|string|max:255',
            'site_title' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string',

            // Branding & Assets
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'site_favicon' => 'nullable|file|mimes:ico,png|max:512',
            'site_logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',

            // Emergency Contact
            'emergency_phone' => 'nullable|string|max:20',
            'emergency_whatsapp' => 'nullable|string|max:20',
        ]);

        try {
            // Update general settings
            GeneralSetting::setValue('site_name', $request->site_name, 'text', 'general');
            GeneralSetting::setValue('site_title', $request->site_title, 'text', 'general');
            GeneralSetting::setValue('site_description', $request->site_description, 'textarea', 'general');
            GeneralSetting::setValue('site_keywords', $request->site_keywords, 'text', 'general');
            GeneralSetting::setValue('contact_email', $request->contact_email, 'text', 'general');
            GeneralSetting::setValue('contact_phone', $request->contact_phone, 'text', 'general');
            GeneralSetting::setValue('contact_address', $request->contact_address, 'textarea', 'general');

            // Update emergency contact
            GeneralSetting::setValue('emergency_phone', $request->emergency_phone, 'text', 'contact');
            GeneralSetting::setValue('emergency_whatsapp', $request->emergency_whatsapp, 'text', 'contact');

            // Handle file uploads
            if ($request->hasFile('site_logo')) {
                $logoPath = $request->file('site_logo')->store('logo', 'public');
                GeneralSetting::setValue('site_logo', $logoPath, 'image', 'branding');
            }

            if ($request->hasFile('site_favicon')) {
                $faviconPath = $request->file('site_favicon')->store('favicon', 'public');
                GeneralSetting::setValue('site_favicon', $faviconPath, 'image', 'branding');
            }

            if ($request->hasFile('site_logo_dark')) {
                $logoDarkPath = $request->file('site_logo_dark')->store('logo', 'public');
                GeneralSetting::setValue('site_logo_dark', $logoDarkPath, 'image', 'branding');
            }

            if ($request->hasFile('og_image')) {
                $ogImagePath = $request->file('og_image')->store('og', 'public');
                GeneralSetting::setValue('og_image', $ogImagePath, 'image', 'branding');
            }

            // Clear cache
            GeneralSetting::clearCache();

            return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function socialMedia()
    {
        $socialMedia = GeneralSetting::getSocialMedia();
        return view('admin.settings.social-media', compact('socialMedia'));
    }

    public function updateSocialMedia(Request $request)
    {
        $request->validate([
            'social_media' => 'required|array',
            'social_media.*.platform' => 'required|string|max:50',
            'social_media.*.url' => 'required|url',
            'social_media.*.description' => 'nullable|string|max:100',
        ]);

        try {
            // Delete existing social media
            GeneralSetting::where('group', 'social_media')->delete();

            // Add new social media
            foreach ($request->social_media as $social) {
                GeneralSetting::create([
                    'key' => strtolower($social['platform']),
                    'value' => $social['url'],
                    'type' => 'text',
                    'group' => 'social_media',
                    'description' => $social['description'] ?? $social['platform'],
                    'is_active' => true,
                ]);
            }

            GeneralSetting::clearCache();

            return redirect()->back()->with('success', 'Sosial media berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logs()
    {
        $logFiles = [];
        $logPath = storage_path('logs');

        if (is_dir($logPath)) {
            $files = scandir($logPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'log') {
                    $filePath = $logPath . '/' . $file;
                    $logFiles[] = [
                        'name' => $file,
                        'size' => filesize($filePath),
                        'modified' => filemtime($filePath),
                        'path' => $filePath,
                    ];
                }
            }

            // Sort by modified date (newest first)
            usort($logFiles, function($a, $b) {
                return $b['modified'] - $a['modified'];
            });
        }

        return view('admin.settings.logs', compact('logFiles'));
    }

    public function viewLog($filename)
    {
        $logPath = storage_path('logs/' . $filename);

        if (!file_exists($logPath)) {
            abort(404);
        }

        $content = file_get_contents($logPath);
        $lines = array_reverse(explode("\n", trim($content))); // Show latest entries first

        return view('admin.settings.view-log', compact('filename', 'lines'));
    }

    public function clearLog($filename)
    {
        $logPath = storage_path('logs/' . $filename);

        if (!file_exists($logPath)) {
            return redirect()->back()->with('error', 'File log tidak ditemukan.');
        }

        try {
            file_put_contents($logPath, '');
            Log::info("Log file cleared: {$filename}", ['user' => auth()->user()->name ?? 'System']);

            return redirect()->back()->with('success', 'Log file berhasil dikosongkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengosongkan log: ' . $e->getMessage());
        }
    }

    public function clearAllLogs()
    {
        $logPath = storage_path('logs');
        $clearedFiles = [];

        if (!is_dir($logPath)) {
            return redirect()->back()->with('error', 'Directory logs tidak ditemukan.');
        }

        try {
            foreach (scandir($logPath) as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'log') {
                    $filePath = $logPath . '/' . $file;
                    file_put_contents($filePath, '');
                    $clearedFiles[] = $file;
                }
            }

            Log::info("All log files cleared", ['user' => auth()->user()->name ?? 'System', 'files' => $clearedFiles]);

            return redirect()->back()->with('success', 'Semua file log berhasil dikosongkan (' . count($clearedFiles) . ' file).');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengosongkan log: ' . $e->getMessage());
        }
    }

    public function backup()
    {
        return view('admin.settings.backup');
    }

    public function createDatabaseBackup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('backups/database/' . $filename);

            // Ensure directory exists
            $backupDir = dirname($path);
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Get database configuration
            $dbHost = config('database.connections.mysql.host');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');

            // Create backup using mysqldump
            $command = sprintf(
                'mysqldump --host=%s --user=%s --password=%s %s > %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbUser),
                escapeshellarg($dbPass),
                escapeshellarg($dbName),
                escapeshellarg($path)
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                Log::info("Database backup created: {$filename}", ['user' => auth()->user()->name ?? 'System']);
                return response()->download($path)->deleteFileAfterSend();
            } else {
                throw new \Exception('Failed to create database backup');
            }

        } catch (\Exception $e) {
            Log::error("Database backup failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat backup database: ' . $e->getMessage());
        }
    }

    public function createWebBackup()
    {
        try {
            $filename = 'web_backup_' . date('Y-m-d_H-i-s') . '.zip';
            $zipPath = storage_path('backups/web/' . $filename);

            // Ensure directory exists
            $backupDir = dirname($zipPath);
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Create ZIP archive
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                $this->addFolderToZip($zip, base_path(), '');
                $zip->close();

                Log::info("Web backup created: {$filename}", ['user' => auth()->user()->name ?? 'System']);
                return response()->download($zipPath)->deleteFileAfterSend();
            } else {
                throw new \Exception('Failed to create ZIP archive');
            }

        } catch (\Exception $e) {
            Log::error("Web backup failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat backup web: ' . $e->getMessage());
        }
    }

    private function addFolderToZip($zip, $folder, $zipPath)
    {
        $files = scandir($folder);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $filePath = $folder . '/' . $file;
            $relativePath = $zipPath . $file;

            if (is_dir($filePath)) {
                $zip->addEmptyDir($relativePath . '/');
                $this->addFolderToZip($zip, $filePath, $relativePath . '/');
            } else {
                // Skip large files, cache files, etc.
                if (filesize($filePath) > 50 * 1024 * 1024) continue; // Skip files > 50MB
                if (strpos($filePath, '/storage/logs/') !== false) continue;
                if (strpos($filePath, '/vendor/') !== false) continue;
                if (strpos($filePath, '/node_modules/') !== false) continue;
                if (strpos($filePath, '/.git/') !== false) continue;

                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    public function maintenance()
    {
        // Get maintenance mode status from database only (ignore Laravel's built-in file)
        $isMaintenance = GeneralSetting::getValue('maintenance_mode', 'false') === 'true';

        // Clean up any conflicting Laravel maintenance file
        $downFile = storage_path('framework/down');
        if (file_exists($downFile) && !$isMaintenance) {
            @unlink($downFile);
        }

        // Get maintenance settings
        $maintenanceSettings = [
            'title' => GeneralSetting::getValue('maintenance_title', 'Website Sedang Dalam Perbaikan'),
            'message' => GeneralSetting::getValue('maintenance_message', 'Kami sedang melakukan perbaikan untuk memberikan pengalaman yang lebih baik. Website akan segera kembali normal.'),
            'estimated_time' => GeneralSetting::getValue('maintenance_estimated_time', '1-2 jam lagi'),
            'progress' => GeneralSetting::getValue('maintenance_progress', '75'),
            'retry' => GeneralSetting::getValue('maintenance_retry', '60'),
            'background_color' => GeneralSetting::getValue('maintenance_background_color', '#667eea'),
            'show_social_links' => GeneralSetting::getValue('maintenance_show_social_links', 'true') === 'true',
        ];

        return view('admin.settings.maintenance', compact('isMaintenance', 'maintenanceSettings'));
    }

    public function toggleMaintenance(Request $request)
    {
        $isMaintenance = $request->input('maintenance_mode') === '1' || $request->boolean('maintenance_mode');

        try {
            // Save maintenance settings
            if ($request->has('maintenance_title')) {
                GeneralSetting::setValue('maintenance_title', $request->maintenance_title, 'text', 'maintenance');
            }
            if ($request->has('maintenance_message')) {
                GeneralSetting::setValue('maintenance_message', $request->maintenance_message, 'textarea', 'maintenance');
            }
            if ($request->has('maintenance_estimated_time')) {
                GeneralSetting::setValue('maintenance_estimated_time', $request->maintenance_estimated_time, 'text', 'maintenance');
            }
            if ($request->has('maintenance_progress')) {
                GeneralSetting::setValue('maintenance_progress', $request->maintenance_progress, 'number', 'maintenance');
            }
            if ($request->has('maintenance_retry')) {
                GeneralSetting::setValue('maintenance_retry', $request->maintenance_retry, 'number', 'maintenance');
            }
            if ($request->has('maintenance_background_color')) {
                GeneralSetting::setValue('maintenance_background_color', $request->maintenance_background_color, 'color', 'maintenance');
            }
            if ($request->has('maintenance_show_social_links')) {
                GeneralSetting::setValue('maintenance_show_social_links', $request->boolean('maintenance_show_social_links') ? 'true' : 'false', 'boolean', 'maintenance');
            }

            // Update maintenance mode status in database only
            GeneralSetting::setValue('maintenance_mode', $isMaintenance ? 'true' : 'false', 'boolean', 'system');

            // Clean up any existing Laravel maintenance file to prevent conflicts
            $downFile = storage_path('framework/down');
            if (file_exists($downFile)) {
                @unlink($downFile);
            }

            // Log the action
            if ($isMaintenance) {
                Log::info("Custom maintenance mode enabled", [
                    'user' => auth()->user()->name ?? 'System',
                    'settings' => [
                        'title' => $request->maintenance_title,
                        'message' => $request->maintenance_message,
                        'estimated_time' => $request->maintenance_estimated_time,
                    ]
                ]);
            } else {
                Log::info("Custom maintenance mode disabled", [
                    'user' => auth()->user()->name ?? 'System'
                ]);
            }

            GeneralSetting::clearCache();

            return redirect()->back()->with('success',
                $isMaintenance ? 'Maintenance mode diaktifkan.' : 'Maintenance mode dinonaktifkan.'
            );

        } catch (\Exception $e) {
            // Clean up any corrupt files
            if (file_exists($downFile)) {
                unlink($downFile);
            }

            Log::error("Maintenance mode error: " . $e->getMessage(), [
                'user' => auth()->user()->name ?? 'System',
                'is_maintenance' => $isMaintenance,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function activity()
    {
        // Get recent activities from logs (simplified version)
        $activities = [];

        // Check Laravel log for recent activities
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $lines = array_slice(file($logPath), -50); // Get last 50 lines
            $lines = array_reverse($lines); // Show latest first

            foreach ($lines as $line) {
                if (preg_match('/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\].*\.(\w+): (.*)/', $line, $matches)) {
                    $activities[] = [
                        'timestamp' => $matches[1],
                        'level' => $matches[2],
                        'message' => $matches[3],
                    ];
                }
            }
        }

        return view('admin.settings.activity', compact('activities'));
    }
}
