<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $currentPath = $request->get('path', '');
        $basePath = 'public';

        // Get files and directories
        $fullPath = $basePath . ($currentPath ? '/' . $currentPath : '');
        $disk = Storage::disk('public');

        // Get directories
        $directories = [];
        try {
            if ($disk->exists($currentPath)) {
                $directories = $disk->directories($currentPath);
                // Get only direct subdirectories (not nested paths)
                $directories = array_map(function($dir) use ($currentPath) {
                    return str_replace($currentPath . '/', '', $dir);
                }, $directories);
                // Filter out nested directories
                $directories = array_filter($directories, function($dir) {
                    return !str_contains($dir, '/');
                });
            }
        } catch (\Exception $e) {
            // Handle case where directory doesn't exist or other errors
            $directories = [];
        }

        // Get files in current directory
        $files = [];
        try {
            if ($disk->exists($currentPath)) {
                $fileList = $disk->files($currentPath);
                foreach ($fileList as $file) {
                    $files[] = $this->getFileInfo($file, $disk);
                }
            }
        } catch (\Exception $e) {
            // Handle case where directory doesn't exist or other errors
            $files = [];
        }

        // Sort files by modification time (newest first)
        usort($files, function($a, $b) {
            return $b['modified'] <=> $a['modified'];
        });

        // Breadcrumb navigation
        $breadcrumb = $this->buildBreadcrumb($currentPath);

        // Storage stats
        $stats = $this->getStorageStats();

        return view('admin.media.index', compact('files', 'directories', 'currentPath', 'breadcrumb', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|max:5120', // 5MB max per file
            'path' => 'nullable|string',
        ]);

        $uploadPath = $request->path ?? '';
        $uploadedFiles = [];
        $errors = [];

        foreach ($request->file('files') as $file) {
            try {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                $safeFileName = $this->sanitizeFileName($fileName) . '.' . $extension;

                // Check if file already exists and create unique name if needed
                $counter = 1;
                $finalFileName = $safeFileName;
                while (Storage::disk('public')->exists($uploadPath . '/' . $finalFileName)) {
                    $finalFileName = $this->sanitizeFileName($fileName) . '_' . $counter . '.' . $extension;
                    $counter++;
                }

                $path = $file->storeAs($uploadPath, $finalFileName, 'public');
                $uploadedFiles[] = $path;
            } catch (\Exception $e) {
                $errors[] = $originalName . ': ' . $e->getMessage();
            }
        }

        $message = count($uploadedFiles) . ' file berhasil diupload';
        if (!empty($errors)) {
            $message .= '. Error: ' . implode(', ', $errors);
        }

        return redirect()->back()->with('success', $message);
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9_\-\s]+$/',
            'path' => 'nullable|string',
        ]);

        $folderName = $this->sanitizeFileName($request->folder_name);
        $path = ($request->path ? $request->path . '/' : '') . $folderName;

        if (Storage::disk('public')->exists($path)) {
            return redirect()->back()->with('error', 'Folder sudah ada');
        }

        Storage::disk('public')->makeDirectory($path);

        return redirect()->back()->with('success', 'Folder berhasil dibuat');
    }

    public function download($file)
    {
        if (!Storage::disk('public')->exists($file)) {
            abort(404);
        }

        return Storage::disk('public')->download($file);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'required|string',
        ]);

        $deleted = 0;
        $errors = [];

        foreach ($request->items as $item) {
            try {
                if (Storage::disk('public')->exists($item)) {
                    if (Storage::disk('public')->delete($item)) {
                        $deleted++;
                    }
                } else {
                    $errors[] = $item . ' tidak ditemukan';
                }
            } catch (\Exception $e) {
                $errors[] = $item . ': ' . $e->getMessage();
            }
        }

        $message = $deleted . ' item berhasil dihapus';
        if (!empty($errors)) {
            $message .= '. Error: ' . implode(', ', $errors);
        }

        return redirect()->back()->with('success', $message);
    }

    private function getFileInfo($file, $disk)
    {
        $path = storage_path('app/public/' . $file);
        $size = $disk->size($file);
        $lastModified = $disk->lastModified($file);
        $mimeType = $disk->mimeType($file);

        return [
            'name' => basename($file),
            'path' => $file,
            'size' => $this->formatBytes($size),
            'size_bytes' => $size,
            'modified' => $lastModified,
            'modified_human' => date('d/m/Y H:i', $lastModified),
            'type' => $this->getFileType($mimeType),
            'icon' => $this->getFileIcon($mimeType),
            'extension' => pathinfo($file, PATHINFO_EXTENSION),
        ];
    }

    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    private function getFileType($mimeType)
    {
        if (str_contains($mimeType, 'image/')) return 'Image';
        if (str_contains($mimeType, 'video/')) return 'Video';
        if (str_contains($mimeType, 'audio/')) return 'Audio';
        if (str_contains($mimeType, 'pdf')) return 'PDF';
        if (str_contains($mimeType, 'document') || str_contains($mimeType, 'word')) return 'Document';
        if (str_contains($mimeType, 'spreadsheet') || str_contains($mimeType, 'excel')) return 'Spreadsheet';
        if (str_contains($mimeType, 'text/')) return 'Text';
        return 'File';
    }

    private function getFileIcon($mimeType)
    {
        if (str_contains($mimeType, 'image/')) return 'bi-file-earmark-image';
        if (str_contains($mimeType, 'video/')) return 'bi-file-earmark-play';
        if (str_contains($mimeType, 'audio/')) return 'bi-file-earmark-music';
        if (str_contains($mimeType, 'pdf')) return 'bi-file-earmark-pdf';
        if (str_contains($mimeType, 'document') || str_contains($mimeType, 'word')) return 'bi-file-earmark-word';
        if (str_contains($mimeType, 'spreadsheet') || str_contains($mimeType, 'excel')) return 'bi-file-earmark-excel';
        if (str_contains($mimeType, 'text/')) return 'bi-file-earmark-text';
        return 'bi-file-earmark';
    }

    private function sanitizeFileName($filename)
    {
        // Remove or replace problematic characters
        $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $filename);
        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);
        // Remove leading/trailing underscores
        $filename = trim($filename, '_');

        return $filename;
    }

    private function buildBreadcrumb($path)
    {
        if (empty($path)) return [];

        $parts = explode('/', $path);
        $breadcrumb = [];
        $currentPath = '';

        foreach ($parts as $part) {
            if (!empty($part)) {
                $currentPath .= ($currentPath ? '/' : '') . $part;
                $breadcrumb[] = [
                    'name' => $part,
                    'path' => $currentPath,
                ];
            }
        }

        return $breadcrumb;
    }

    public function apiFiles(Request $request)
    {
        $search = $request->get('search', '');
        $disk = Storage::disk('public');

        // Get all files
        $allFiles = $disk->allFiles();

        // Filter images and apply search
        $imageFiles = [];
        foreach ($allFiles as $file) {
            $mimeType = $disk->mimeType($file);
            if (str_contains($mimeType, 'image/')) {
                $fileName = basename($file);

                // Apply search filter
                if (empty($search) || str_contains(strtolower($fileName), strtolower($search))) {
                    $imageFiles[] = $this->getFileInfo($file, $disk);
                }
            }
        }

        // Sort by modification time (newest first)
        usort($imageFiles, function($a, $b) {
            return $b['modified'] <=> $a['modified'];
        });

        return response()->json([
            'success' => true,
            'files' => array_slice($imageFiles, 0, 100) // Limit to 100 files for performance
        ]);
    }

    private function getStorageStats()
    {
        $disk = Storage::disk('public');
        $totalSize = 0;
        $fileCount = 0;

        $allFiles = $disk->allFiles();
        foreach ($allFiles as $file) {
            $totalSize += $disk->size($file);
            $fileCount++;
        }

        return [
            'total_files' => $fileCount,
            'total_size' => $this->formatBytes($totalSize),
            'total_size_bytes' => $totalSize,
        ];
    }
}
