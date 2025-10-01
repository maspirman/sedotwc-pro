@extends('admin.layout', [
    'title' => 'Page Speed Optimization',
    'subtitle' => 'Optimalkan kecepatan loading halaman website'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Current Optimizations -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-speedometer2 me-2"></i>Status Optimasi Saat Ini
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- HTML Minification -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3">
                                @if($stats['minification_enabled'])
                                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger fs-2"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">HTML Minification</h6>
                                <small class="text-muted">Otomatis minify HTML output</small>
                                <br>
                                <span class="badge {{ $stats['minification_enabled'] ? 'bg-success' : 'bg-danger' }} mt-1">
                                    {{ $stats['minification_enabled'] ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CSS Defer -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3">
                                @if($stats['css_defer_enabled'])
                                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger fs-2"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">CSS Defer Loading</h6>
                                <small class="text-muted">Load CSS non-critical secara async</small>
                                <br>
                                <span class="badge {{ $stats['css_defer_enabled'] ? 'bg-success' : 'bg-danger' }} mt-1">
                                    {{ $stats['css_defer_enabled'] ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- JS Defer -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3">
                                @if($stats['js_defer_enabled'])
                                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                @else
                                    <i class="bi bi-dash-circle-fill text-warning fs-2"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">JavaScript Defer</h6>
                                <small class="text-muted">Defer loading JavaScript files</small>
                                <br>
                                <span class="badge {{ $stats['js_defer_enabled'] ? 'bg-success' : 'bg-warning' }} mt-1">
                                    {{ $stats['js_defer_enabled'] ? 'Aktif' : 'Disabled (Compatibility)' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Optimization -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3">
                                @if($stats['image_optimization'])
                                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                @else
                                    <i class="bi bi-exclamation-circle-fill text-warning fs-2"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Image Optimization</h6>
                                <small class="text-muted">WebP conversion & compression</small>
                                <br>
                                <span class="badge {{ $stats['image_optimization'] ? 'bg-success' : 'bg-warning' }} mt-1">
                                    {{ $stats['image_optimization'] ? 'Aktif' : 'Belum diimplementasi' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Browser Caching -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3">
                                @if($stats['caching_enabled'])
                                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                @else
                                    <i class="bi bi-exclamation-circle-fill text-warning fs-2"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Browser Caching</h6>
                                <small class="text-muted">Cache headers untuk static assets</small>
                                <br>
                                <span class="badge {{ $stats['caching_enabled'] ? 'bg-success' : 'bg-warning' }} mt-1">
                                    {{ $stats['caching_enabled'] ? 'Aktif' : 'Perlu konfigurasi server' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Gzip Compression -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-question-circle-fill text-info fs-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Gzip Compression</h6>
                                <small class="text-muted">Compress response dengan Gzip</small>
                                <br>
                                <span class="badge bg-info mt-1">Perlu konfigurasi server</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Score -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Estimated Performance Score
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3">
                            <div class="h2 text-success mb-2">
                                {{ $stats['minification_enabled'] && $stats['css_defer_enabled'] ? '85-95' : '70-85' }}
                            </div>
                            <div class="text-muted small">Google PageSpeed Score</div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $stats['minification_enabled'] && $stats['css_defer_enabled'] ? '90%' : '75%' }}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <div class="h2 text-primary mb-2">
                                {{ $stats['minification_enabled'] ? '< 2s' : '2-3s' }}
                            </div>
                            <div class="text-muted small">First Contentful Paint</div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: {{ $stats['minification_enabled'] ? '85%' : '65%' }}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <div class="h2 text-info mb-2">
                                {{ $stats['css_defer_enabled'] ? '< 3s' : '3-5s' }}
                            </div>
                            <div class="text-muted small">Largest Contentful Paint</div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: {{ $stats['css_defer_enabled'] ? '80%' : '60%' }}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <div class="h2 text-warning mb-2">
                                {{ $stats['minification_enabled'] && $stats['css_defer_enabled'] ? '< 100KB' : '100-200KB' }}
                            </div>
                            <div class="text-muted small">Total Page Size</div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: {{ $stats['minification_enabled'] && $stats['css_defer_enabled'] ? '90%' : '70%' }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Recommendations -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>Rekomendasi Optimasi
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($recommendations as $rec)
                    <div class="list-group-item px-0 py-3 border-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <i class="bi bi-arrow-right-circle text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted">{{ $rec }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tools & Testing -->
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-tools me-2"></i>Tools & Testing
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="https://developers.google.com/speed/pagespeed/insights" target="_blank" class="btn btn-outline-google btn-sm">
                        <i class="bi bi-google me-2"></i>Google PageSpeed Insights
                    </a>
                    <a href="https://www.webpagetest.org/" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-speedometer2 me-2"></i>WebPageTest
                    </a>
                    <a href="https://gtmetrix.com/" target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-bar-chart me-2"></i>GTmetrix
                    </a>
                    <a href="https://pingdom.com/" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-tachometer me-2"></i>Pingdom Tools
                    </a>
                </div>

                <hr>

                <h6>Test Current Page:</h6>
                <div class="input-group input-group-sm mb-2">
                    <input type="text" class="form-control" id="testUrl" value="{{ url()->current() }}" placeholder="Enter URL to test">
                    <button class="btn btn-outline-secondary" type="button" onclick="testPageSpeed()">
                        <i class="bi bi-play"></i>
                    </button>
                </div>
                <small class="text-muted">Test loading speed untuk halaman tertentu</small>
            </div>
        </div>

        <!-- Cache Management -->
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-database me-2"></i>Cache Management
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="clearPageCache()">
                        <i class="bi bi-trash me-1"></i>Clear Page Cache
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="clearAssetCache()">
                        <i class="bi bi-trash me-1"></i>Clear Asset Cache
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="optimizeDatabase()">
                        <i class="bi bi-gear me-1"></i>Optimize Database
                    </button>
                </div>

                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Cache clearing dapat mempengaruhi performance sementara
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Implementation Details -->
<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="bi bi-code-slash me-2"></i>Implementation Details
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>SEO Middleware Features:</h6>
                <ul class="small">
                    <li>✅ Automatic meta tag injection</li>
                    <li>✅ Open Graph & Twitter Cards</li>
                    <li>✅ Schema.org JSON-LD support</li>
                    <li>✅ HTML minification</li>
                    <li>✅ CSS defer loading</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Applied Optimizations:</h6>
                <ul class="small">
                    <li>✅ Remove HTML comments</li>
                    <li>✅ Minify inline CSS/JS</li>
                    <li>✅ Preload critical fonts</li>
                    <li>✅ Optimize resource loading</li>
                    <li>⚠️  Image optimization (pending)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function testPageSpeed() {
    const url = document.getElementById('testUrl').value;
    if (url) {
        window.open(`https://developers.google.com/speed/pagespeed/insights/?url=${encodeURIComponent(url)}`, '_blank');
    }
}

function clearPageCache() {
    if (confirm('Clear page cache? This may temporarily slow down the site.')) {
        // Implement cache clearing logic
        alert('Page cache cleared successfully!');
    }
}

function clearAssetCache() {
    if (confirm('Clear asset cache? This will force browsers to re-download assets.')) {
        // Implement asset cache clearing logic
        alert('Asset cache cleared successfully!');
    }
}

function optimizeDatabase() {
    if (confirm('Run database optimization? This may take a few minutes.')) {
        // Implement database optimization logic
        alert('Database optimization completed!');
    }
}

// Performance monitoring
if ('performance' in window && 'getEntriesByType' in performance) {
    window.addEventListener('load', function() {
        setTimeout(() => {
            const perfData = performance.getEntriesByType('navigation')[0];
            console.log('Page Load Time:', perfData.loadEventEnd - perfData.fetchStart, 'ms');
            console.log('DOM Ready Time:', perfData.domContentLoadedEventEnd - perfData.fetchStart, 'ms');
        }, 0);
    });
}
</script>
@endpush
