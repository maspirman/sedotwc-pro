@extends('admin.layout', [
    'title' => 'Edit SEO Setting',
    'subtitle' => 'Perbarui pengaturan SEO untuk halaman website'
])

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit SEO Setting
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.seo.update', $seoSetting) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Page Type Information (Read-only) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipe Halaman</label>
                            <input type="text" class="form-control" value="@php
                                $pageTypeLabels = [
                                    'home' => 'Homepage',
                                    'services' => 'Layanan',
                                    'blogs' => 'Blog',
                                    'cms_pages' => 'Halaman CMS'
                                ];
                                echo $pageTypeLabels[$seoSetting->page_type] ?? $seoSetting->page_type;
                            @endphp" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Halaman</label>
                            <input type="text" class="form-control" value="{{ $seoSetting->page ? $seoSetting->page->title : 'Homepage' }}" readonly>
                        </div>
                    </div>

                    <!-- Basic SEO -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $seoSetting->meta_title) }}" maxlength="60" placeholder="Judul halaman untuk SEO">
                            <small class="text-muted">Maksimal 60 karakter. <span id="titleCount">{{ strlen(old('meta_title', $seoSetting->meta_title ?? '')) }}</span>/60</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" maxlength="160" placeholder="Deskripsi halaman untuk SEO">{{ old('meta_description', $seoSetting->meta_description) }}</textarea>
                            <small class="text-muted">Maksimal 160 karakter. <span id="descCount">{{ strlen(old('meta_description', $seoSetting->meta_description ?? '')) }}</span>/160</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $seoSetting->meta_keywords) }}" placeholder="kata kunci, dipisahkan, dengan, koma">
                            <small class="text-muted">Pisahkan dengan koma, maksimal 10 kata kunci</small>
                        </div>
                    </div>

                    <!-- Open Graph -->
                    <h6 class="mb-3 text-primary">
                        <i class="bi bi-share me-2"></i>Open Graph (Facebook)
                    </h6>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">OG Title</label>
                            <input type="text" name="og_title" class="form-control" value="{{ old('og_title', $seoSetting->og_title) }}" maxlength="60" placeholder="Judul untuk Facebook sharing">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">OG Description</label>
                            <textarea name="og_description" class="form-control" rows="2" maxlength="160" placeholder="Deskripsi untuk Facebook sharing">{{ old('og_description', $seoSetting->og_description) }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">OG Image URL</label>
                            <input type="url" name="og_image" class="form-control" value="{{ old('og_image', $seoSetting->og_image) }}" placeholder="https://example.com/image.jpg">
                            <small class="text-muted">URL gambar untuk preview Facebook (1200x630px recommended)</small>
                        </div>
                    </div>

                    <!-- Twitter Cards -->
                    <h6 class="mb-3 text-primary">
                        <i class="bi bi-twitter me-2"></i>Twitter Cards
                    </h6>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Twitter Title</label>
                            <input type="text" name="twitter_title" class="form-control" value="{{ old('twitter_title', $seoSetting->twitter_title) }}" maxlength="60" placeholder="Judul untuk Twitter sharing">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Twitter Description</label>
                            <textarea name="twitter_description" class="form-control" rows="2" maxlength="160" placeholder="Deskripsi untuk Twitter sharing">{{ old('twitter_description', $seoSetting->twitter_description) }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Twitter Image URL</label>
                            <input type="url" name="twitter_image" class="form-control" value="{{ old('twitter_image', $seoSetting->twitter_image) }}" placeholder="https://example.com/image.jpg">
                            <small class="text-muted">URL gambar untuk preview Twitter (1200x600px recommended)</small>
                        </div>
                    </div>

                    <!-- Advanced Settings -->
                    <h6 class="mb-3 text-primary">
                        <i class="bi bi-gear me-2"></i>Pengaturan Lanjutan
                    </h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="noindex" value="1" class="form-check-input" id="noindexCheck" {{ old('noindex', $seoSetting->noindex) ? 'checked' : '' }}>
                                <label class="form-check-label" for="noindexCheck">
                                    Noindex
                                </label>
                            </div>
                            <small class="text-muted d-block">Larang mesin pencari mengindeks halaman ini</small>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="nofollow" value="1" class="form-check-input" id="nofollowCheck" {{ old('nofollow', $seoSetting->nofollow) ? 'checked' : '' }}>
                                <label class="form-check-label" for="nofollowCheck">
                                    Nofollow
                                </label>
                            </div>
                            <small class="text-muted d-block">Larang mesin pencari mengikuti link di halaman ini</small>
                        </div>
                    </div>

                    <!-- Schema.org JSON-LD -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Schema.org JSON-LD (Advanced)</label>
                            <textarea name="schema_ld" class="form-control" rows="6" placeholder='{"@context": "https://schema.org", "@type": "Organization", "name": "Your Company"}' id="schemaTextarea">{{ old('schema_ld', $seoSetting->schema_ld ? json_encode($seoSetting->schema_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                            <small class="text-muted">JSON-LD structured data untuk rich snippets</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.seo.show', $seoSetting) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Update SEO Setting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Preview Card -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-eye me-2"></i>Preview SEO
                </h6>
            </div>
            <div class="card-body">
                <div id="seoPreview">
                    <div class="mb-3">
                        <strong>Search Result Preview:</strong>
                    </div>
                    <div style="font-size: 18px; color: #1a0dab; margin-bottom: 5px;" id="previewTitle">{{ old('meta_title', $seoSetting->meta_title) ?: 'Page Title' }}</div>
                    <div style="color: #006621; margin-bottom: 5px;" id="previewUrl">{{ url()->current() }}</div>
                    <div style="color: #545454; font-size: 14px;" id="previewDesc">{{ old('meta_description', $seoSetting->meta_description) ?: 'Page description appears here...' }}</div>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>Tips SEO
                </h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Meta title maksimal 60 karakter</li>
                    <li>Meta description maksimal 160 karakter</li>
                    <li>Sertakan kata kunci utama</li>
                    <li>OG image minimal 1200x630px</li>
                    <li>Twitter image minimal 1200x600px</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="meta_title"]');
    const descTextarea = document.querySelector('textarea[name="meta_description"]');

    // Character counters
    function updateCounters() {
        const titleCount = document.getElementById('titleCount');
        const descCount = document.getElementById('descCount');

        if (titleInput && titleCount) {
            titleCount.textContent = titleInput.value.length;
            titleCount.style.color = titleInput.value.length > 60 ? 'red' : '';
        }

        if (descTextarea && descCount) {
            descCount.textContent = descTextarea.value.length;
            descCount.style.color = descTextarea.value.length > 160 ? 'red' : '';
        }
    }

    // Live preview
    function updatePreview() {
        const previewTitle = document.getElementById('previewTitle');
        const previewDesc = document.getElementById('previewDesc');

        if (titleInput && previewTitle) {
            previewTitle.textContent = titleInput.value || 'Page Title';
        }

        if (descTextarea && previewDesc) {
            previewDesc.textContent = descTextarea.value || 'Page description appears here...';
        }
    }

    // JSON validation for schema
    document.getElementById('schemaTextarea').addEventListener('blur', function() {
        if (this.value.trim()) {
            try {
                JSON.parse(this.value);
                this.classList.remove('is-invalid');
            } catch (e) {
                this.classList.add('is-invalid');
            }
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Event listeners
    titleInput.addEventListener('input', updateCounters);
    titleInput.addEventListener('input', updatePreview);
    descTextarea.addEventListener('input', updateCounters);
    descTextarea.addEventListener('input', updatePreview);

    // Initialize
    updateCounters();
    updatePreview();
});
</script>
@endpush