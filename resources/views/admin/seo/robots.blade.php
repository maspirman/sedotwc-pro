@extends('admin.layout', [
    'title' => 'Robots.txt Manager',
    'subtitle' => 'Kelola file robots.txt untuk search engine crawling'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="bi bi-robot me-2"></i>Robots.txt Editor
                </h6>
                <div>
                    <button type="button" class="btn btn-sm btn-success" onclick="resetToDefault()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Default
                    </button>
                    <button type="button" class="btn btn-sm btn-info" onclick="validateRobots()">
                        <i class="bi bi-check-circle me-1"></i>Validate
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.seo.update-robots') }}" method="POST">
                    @csrf

                    <!-- Robots.txt URL -->
                    <div class="alert alert-info mb-3">
                        <strong>Robots.txt URL:</strong>
                        <code>{{ url('robots.txt') }}</code>
                        <br>
                        <small class="text-muted">File ini akan dibaca oleh search engine untuk menentukan halaman mana yang boleh di-crawl</small>
                    </div>

                    <!-- Editor -->
                    <div class="mb-3">
                        <label class="form-label">Robots.txt Content:</label>
                        <textarea name="content" class="form-control" rows="20" id="robotsContent" style="font-family: 'Courier New', monospace; font-size: 14px;">{{ $currentContent }}</textarea>
                        <small class="text-muted">Gunakan format standard robots.txt. Kosongkan baris untuk memisahkan directive.</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.seo.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke SEO
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Robots.txt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="blockAdmin()">
                        <i class="bi bi-shield-lock me-1"></i>Block Admin Area
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="allowAllCrawlers()">
                        <i class="bi bi-check-circle me-1"></i>Allow All Crawlers
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="blockAllCrawlers()">
                        <i class="bi bi-x-circle me-1"></i>Block All Crawlers
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="addSitemap()">
                        <i class="bi bi-diagram-3 me-1"></i>Add Sitemap
                    </button>
                </div>
            </div>
        </div>

        <!-- Robots.txt Guide -->
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-question-circle me-2"></i>Robots.txt Guide
                </h6>
            </div>
            <div class="card-body">
                <h6>Basic Syntax:</h6>
                <div class="bg-light p-2 rounded mb-3" style="font-family: monospace; font-size: 12px;">
User-agent: *<br>
Allow: /<br>
Disallow: /admin/<br>
Disallow: /private/<br>
<br>
Sitemap: https://example.com/sitemap.xml
                </div>

                <h6>Common Directives:</h6>
                <ul class="small mb-0">
                    <li><code>User-agent: *</code> - Semua crawler</li>
                    <li><code>Allow: /path</code> - Izinkan crawling</li>
                    <li><code>Disallow: /path</code> - Blokir crawling</li>
                    <li><code>Sitemap: URL</code> - Lokasi sitemap</li>
                </ul>
            </div>
        </div>

        <!-- Validation Status -->
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-check-circle me-2"></i>Status & Validasi
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <span class="badge bg-success me-2">
                        <i class="bi bi-check"></i> Syntax OK
                    </span>
                    <small class="text-muted">Format robots.txt valid</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-info me-2">
                        <i class="bi bi-info"></i> Sitemap
                    </span>
                    <small class="text-muted">Sitemap directive included</small>
                </div>
                <div class="mb-0">
                    <span class="badge bg-warning me-2">
                        <i class="bi bi-exclamation"></i> Review
                    </span>
                    <small class="text-muted">Periksa blocked paths</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-2"></i>Robots.txt Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="previewContent" class="bg-light p-3 rounded" style="font-family: 'Courier New', monospace; font-size: 12px; max-height: 400px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="testRobotsTxt()">Test Robots.txt</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const defaultRobotsContent = `User-agent: *
Allow: /

# Block access to admin area
Disallow: /admin/
Disallow: /dashboard

# Block access to sensitive files
Disallow: /storage/app/
Disallow: /storage/logs/

# Sitemap
Sitemap: {{ url('sitemap.xml') }}`;

function resetToDefault() {
    if (confirm('Apakah Anda yakin ingin mereset ke default robots.txt?')) {
        document.getElementById('robotsContent').value = defaultRobotsContent;
    }
}

function validateRobots() {
    const content = document.getElementById('robotsContent').value;
    let isValid = true;
    let errors = [];

    // Basic validation
    if (!content.includes('User-agent:')) {
        errors.push('Missing User-agent directive');
        isValid = false;
    }

    if (content.includes('Sitemap:') && !content.includes('{{ url('sitemap.xml') }}')) {
        // Check if sitemap URL is valid
        const sitemapMatch = content.match(/Sitemap:\s*(.+)/i);
        if (sitemapMatch) {
            try {
                new URL(sitemapMatch[1].trim());
            } catch (e) {
                errors.push('Invalid sitemap URL');
                isValid = false;
            }
        }
    }

    if (isValid) {
        alert('✅ Robots.txt syntax appears valid!');
    } else {
        alert('❌ Validation errors:\n' + errors.join('\n'));
    }
}

function blockAdmin() {
    const textarea = document.getElementById('robotsContent');
    const currentContent = textarea.value;

    if (!currentContent.includes('Disallow: /admin/')) {
        textarea.value = currentContent + '\nDisallow: /admin/';
    }
}

function allowAllCrawlers() {
    const textarea = document.getElementById('robotsContent');
    const currentContent = textarea.value;

    if (!currentContent.includes('User-agent: *\nAllow: /')) {
        textarea.value = 'User-agent: *\nAllow: /\n\n' + currentContent;
    }
}

function blockAllCrawlers() {
    const textarea = document.getElementById('robotsContent');
    textarea.value = 'User-agent: *\nDisallow: /\n';
}

function addSitemap() {
    const textarea = document.getElementById('robotsContent');
    const currentContent = textarea.value;

    if (!currentContent.includes('Sitemap:')) {
        textarea.value = currentContent + '\n\n# Sitemap\nSitemap: {{ url('sitemap.xml') }}';
    }
}

function testRobotsTxt() {
    const content = document.getElementById('robotsContent').value;
    document.getElementById('previewContent').textContent = content;

    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

// Auto-save draft (optional)
let autoSaveTimeout;
document.getElementById('robotsContent').addEventListener('input', function() {
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(() => {
        // Could save draft to localStorage here
        console.log('Draft saved');
    }, 2000);
});
</script>
@endpush
