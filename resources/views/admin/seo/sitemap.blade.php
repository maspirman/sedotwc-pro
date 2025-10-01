@extends('admin.layout', [
    'title' => 'Sitemap Generator',
    'subtitle' => 'Generate dan kelola sitemap website'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="bi bi-diagram-3 me-2"></i>Sitemap XML Generator
                </h6>
                <div>
                    <button type="button" class="btn btn-sm btn-success" onclick="downloadSitemap()">
                        <i class="bi bi-download me-1"></i>Download XML
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="copySitemapUrl()">
                        <i class="bi bi-clipboard me-1"></i>Copy URL
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Sitemap URL -->
                <div class="alert alert-info">
                    <strong>Sitemap URL:</strong>
                    <code id="sitemapUrl">{{ url('sitemap.xml') }}</code>
                    <br>
                    <small class="text-muted">Submit URL ini ke Google Search Console dan Bing Webmaster Tools</small>
                </div>

                <!-- Sitemap Preview -->
                <div class="mb-3">
                    <h6>Sitemap Preview:</h6>
                    <div class="border rounded p-3 bg-light" style="font-family: monospace; font-size: 12px; max-height: 400px; overflow-y: auto;">
                        <div>&lt;?xml version="1.0" encoding="UTF-8"?&gt;</div>
                        <div>&lt;urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"&gt;</div>
                        @foreach($sitemapData as $item)
                        <div style="margin-left: 20px;">&lt;url&gt;</div>
                        <div style="margin-left: 40px;">&lt;loc&gt;{{ $item['url'] }}&lt;/loc&gt;</div>
                        <div style="margin-left: 40px;">&lt;lastmod&gt;{{ $item['lastmod'] }}&lt;/lastmod&gt;</div>
                        <div style="margin-left: 40px;">&lt;changefreq&gt;{{ $item['changefreq'] }}&lt;/changefreq&gt;</div>
                        <div style="margin-left: 40px;">&lt;priority&gt;{{ $item['priority'] }}&lt;/priority&gt;</div>
                        <div style="margin-left: 20px;">&lt;/url&gt;</div>
                        @endforeach
                        <div>&lt;/urlset&gt;</div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 text-primary">{{ count($sitemapData) }}</div>
                            <div class="small text-muted">Total URLs</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 text-success">{{ count(array_filter($sitemapData, fn($item) => $item['priority'] == '1.0')) }}</div>
                            <div class="small text-muted">High Priority</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 text-warning">{{ count(array_filter($sitemapData, fn($item) => in_array($item['priority'], ['0.7', '0.8']))) }}</div>
                            <div class="small text-muted">Medium Priority</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 text-info">{{ count(array_filter($sitemapData, fn($item) => $item['priority'] <= '0.6')) }}</div>
                            <div class="small text-muted">Low Priority</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Submit to Search Engines -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-send me-2"></i>Submit ke Search Engine
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="https://search.google.com/search-console" target="_blank" class="btn btn-outline-danger">
                        <i class="bi bi-google me-2"></i>Google Search Console
                    </a>
                    <a href="https://www.bing.com/webmasters" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-microsoft me-2"></i>Bing Webmaster Tools
                    </a>
                    <a href="https://search.yahoo.com/search/submit" target="_blank" class="btn btn-outline-warning">
                        <i class="bi bi-search me-2"></i>Yahoo Search
                    </a>
                </div>

                <hr>

                <h6>Tips Penggunaan Sitemap:</h6>
                <ul class="small mb-0">
                    <li>Update sitemap setiap ada konten baru</li>
                    <li>Submit ke search console minimal sebulan sekali</li>
                    <li>Gunakan HTTPS untuk URL dalam sitemap</li>
                    <li>Maksimal 50.000 URL per sitemap</li>
                </ul>
            </div>
        </div>

        <!-- Sitemap Details -->
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Detail Sitemap
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td><strong>Format:</strong></td>
                        <td>XML Sitemap 0.9</td>
                    </tr>
                    <tr>
                        <td><strong>Encoding:</strong></td>
                        <td>UTF-8</td>
                    </tr>
                    <tr>
                        <td><strong>Last Update:</strong></td>
                        <td>{{ now()->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><span class="badge bg-success">Active</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- URL List Table -->
<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="bi bi-list me-2"></i>Daftar URL dalam Sitemap
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>URL</th>
                        <th>Priority</th>
                        <th>Change Freq</th>
                        <th>Last Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sitemapData as $item)
                    <tr>
                        <td>
                            <a href="{{ $item['url'] }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 400px;">
                                {{ $item['url'] }}
                                <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-{{ $item['priority'] == '1.0' ? 'primary' : ($item['priority'] >= '0.7' ? 'success' : 'secondary') }}">
                                {{ $item['priority'] }}
                            </span>
                        </td>
                        <td>{{ $item['changefreq'] }}</td>
                        <td>{{ $item['lastmod'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function downloadSitemap() {
    const xmlContent = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($sitemapData as $item)
    <url>
        <loc>{{ $item['url'] }}</loc>
        <lastmod>{{ $item['lastmod'] }}</lastmod>
        <changefreq>{{ $item['changefreq'] }}</changefreq>
        <priority>{{ $item['priority'] }}</priority>
    </url>
@endforeach
</urlset>`;

    const blob = new Blob([xmlContent], { type: 'application/xml' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'sitemap.xml';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function copySitemapUrl() {
    const url = document.getElementById('sitemapUrl').textContent;
    navigator.clipboard.writeText(url).then(() => {
        // Simple feedback
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Copied!';
        setTimeout(() => {
            btn.innerHTML = originalText;
        }, 2000);
    });
}
</script>
@endpush
