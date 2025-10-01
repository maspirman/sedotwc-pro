@extends('admin.layout', [
    'title' => 'Edit Halaman CMS',
    'subtitle' => 'Edit halaman "' . $page->title . '"'
])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.cms.update', $page) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-pencil me-2"></i>Informasi Halaman
                            </h5>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">
                                <i class="bi bi-type me-1"></i>Judul Halaman <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title', $page->title) }}"
                                   placeholder="Masukkan judul halaman" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="template" class="form-label">
                                <i class="bi bi-layout-text-window me-1"></i>Template <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('template') is-invalid @enderror"
                                    id="template" name="template" required>
                                <option value="">Pilih Template</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template['key'] }}" {{ old('template', $page->template) == $template['key'] ? 'selected' : '' }}>
                                        {{ $template['name'] }}
                                        @if($template['description'])
                                            - {{ $template['description'] }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                <i class="bi bi-toggle-on me-1"></i>Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="active" {{ old('status', $page->status) == 'active' ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                                <option value="inactive" {{ old('status', $page->status) == 'inactive' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Template Content Section -->
                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-textarea-resize me-2"></i>Isi Halaman
                            </h5>
                        </div>

                        <!-- Default Template Content -->
                        <div id="default-template" class="col-md-12 mb-4 template-content" data-template="default">
                            <label for="content" class="form-label">
                                <i class="bi bi-textarea-resize me-1"></i>Isi Halaman <span class="text-danger">*</span>
                            </label>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Editor kaya fitur: <strong>Bold</strong>, <em>Italic</em>, daftar, link, gambar, tabel, fullscreen mode
                                </small>
                            </div>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content"
                                      placeholder="Tulis isi halaman di sini..." required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- FAQ Template Content -->
                        <div id="faq-template" class="col-md-12 mb-4 template-content" data-template="faq" style="display: none;">
                            <label class="form-label">Daftar FAQ <span class="text-danger">*</span></label>
                            <small class="text-muted d-block mb-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Tambahkan pertanyaan dan jawaban yang sering ditanyakan
                            </small>
                            <div class="faq-items">
                                <!-- FAQ items will be added here -->
                                @php
                                    $faqs = old('faq', $page->getTemplateData('faqs', []));
                                    if (is_array($faqs) && !empty($faqs)) {
                                        foreach ($faqs as $index => $faq) {
                                @endphp
                                <div class="faq-item border rounded p-3 mb-3" data-index="{{ $index }}">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">FAQ {{ $index + 1 }}</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFaqItem(this)">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Pertanyaan</label>
                                            <input type="text" class="form-control" name="faq[{{ $index }}][question]"
                                                   value="{{ $faq['question'] ?? '' }}" placeholder="Masukkan pertanyaan" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Jawaban</label>
                                            <textarea class="form-control richtext-editor" name="faq[{{ $index }}][answer]" rows="4"
                                                      placeholder="Masukkan jawaban" required>{{ $faq['answer'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @php
                                        }
                                    }
                                @endphp
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addFaqItem()">
                                <i class="bi bi-plus-circle me-1"></i>Tambah FAQ
                            </button>
                        </div>

                        <!-- Contact Template Content -->
                        <div id="contact-template" class="col-md-12 mb-4 template-content" data-template="contact" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="contact-hero-title" class="form-label">Judul Hero Section</label>
                                    <input type="text" class="form-control" id="contact-hero-title" name="contact[hero_title]"
                                           value="{{ old('contact.hero_title', $page->getTemplateData('hero_title')) }}" placeholder="Hubungi Kami">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="contact-hero-description" class="form-label">Deskripsi Hero Section</label>
                                    <textarea class="form-control" id="contact-hero-description" name="contact[hero_description]" rows="3"
                                              placeholder="Kami siap membantu Anda">{{ old('contact.hero_description', $page->getTemplateData('hero_description')) }}</textarea>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <h6 class="border-bottom pb-2">Informasi Kontak</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact-phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="contact-phone" name="contact[phone]"
                                           value="{{ old('contact.phone', $page->getTemplateData('phone')) }}" placeholder="+62 xxx xxxx xxxx">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="contact-email" name="contact[email]"
                                           value="{{ old('contact.email', $page->getTemplateData('email')) }}" placeholder="contact@example.com">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="contact-address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="contact-address" name="contact[address]" rows="3"
                                              placeholder="Jl. Contoh No. 123, Kota, Provinsi">{{ old('contact.address', $page->getTemplateData('address')) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- About Template Content -->
                        <div id="about-template" class="col-md-12 mb-4 template-content" data-template="about" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="about-hero-title" class="form-label">Judul Hero</label>
                                    <input type="text" class="form-control" id="about-hero-title" name="about[hero_title]"
                                           value="{{ old('about.hero_title', $page->getTemplateData('hero_title')) }}" placeholder="Tentang Kami">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="about-hero-description" class="form-label">Deskripsi Hero</label>
                                    <textarea class="form-control" id="about-hero-description" name="about[hero_description]" rows="3"
                                              placeholder="Cerita perusahaan kami...">{{ old('about.hero_description', $page->getTemplateData('hero_description')) }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="about-company-story" class="form-label">Cerita Perusahaan</label>
                                    <textarea class="form-control richtext-editor" id="about-company-story" name="about[company_story]" rows="5"
                                              placeholder="Jelaskan sejarah dan visi perusahaan">{{ old('about.company_story', $page->getTemplateData('company_story')) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Terms Template Content -->
                        <div id="terms-template" class="col-md-12 mb-4 template-content" data-template="terms" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="terms-last-updated" class="form-label">Terakhir Diupdate</label>
                                    <input type="date" class="form-control" id="terms-last-updated" name="terms[last_updated]"
                                           value="{{ old('terms.last_updated', $page->getTemplateData('last_updated')) }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="terms-introduction" class="form-label">Pendahuluan</label>
                                    <textarea class="form-control" id="terms-introduction" name="terms[introduction]" rows="3"
                                              placeholder="Pendahuluan syarat dan ketentuan">{{ old('terms.introduction', $page->getTemplateData('introduction')) }}</textarea>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">Bagian Syarat & Ketentuan</label>
                                    <div class="terms-sections">
                                        <!-- Terms sections will be added here -->
                                        @php
                                            $termsSections = old('terms.sections', $page->getTemplateData('sections', []));
                                            if (is_array($termsSections) && !empty($termsSections)) {
                                                foreach ($termsSections as $index => $section) {
                                        @endphp
                                        <div class="terms-section border rounded p-3 mb-3" data-index="{{ $index }}">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Bagian {{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTermsSection(this)">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Judul Bagian</label>
                                                    <input type="text" class="form-control" name="terms[sections][{{ $index }}][title]"
                                                           value="{{ $section['title'] ?? '' }}" placeholder="Judul bagian" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Isi Bagian</label>
                                                    <textarea class="form-control richtext-editor" name="terms[sections][{{ $index }}][content]" rows="6"
                                                              placeholder="Isi dari bagian ini" required>{{ $section['content'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                                }
                                            }
                                        @endphp
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTermsSection()">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Bagian
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy Template Content -->
                        <div id="privacy-template" class="col-md-12 mb-4 template-content" data-template="privacy" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="privacy-effective-date" class="form-label">Tanggal Efektif</label>
                                    <input type="date" class="form-control" id="privacy-effective-date" name="privacy[effective_date]"
                                           value="{{ old('privacy.effective_date', $page->getTemplateData('effective_date')) }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="privacy-introduction" class="form-label">Pendahuluan</label>
                                    <textarea class="form-control" id="privacy-introduction" name="privacy[introduction]" rows="3"
                                              placeholder="Pendahuluan kebijakan privasi">{{ old('privacy.introduction', $page->getTemplateData('introduction')) }}</textarea>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">Bagian Kebijakan Privasi</label>
                                    <div class="privacy-sections">
                                        <!-- Privacy sections will be added here -->
                                        @php
                                            $privacySections = old('privacy.sections', $page->getTemplateData('sections', []));
                                            if (is_array($privacySections) && !empty($privacySections)) {
                                                foreach ($privacySections as $index => $section) {
                                        @endphp
                                        <div class="privacy-section border rounded p-3 mb-3" data-index="{{ $index }}">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Bagian {{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePrivacySection(this)">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Judul Bagian</label>
                                                    <input type="text" class="form-control" name="privacy[sections][{{ $index }}][title]"
                                                           value="{{ $section['title'] ?? '' }}" placeholder="Judul bagian" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Isi Bagian</label>
                                                    <textarea class="form-control richtext-editor" name="privacy[sections][{{ $index }}][content]" rows="6"
                                                              placeholder="Isi dari bagian ini" required>{{ $section['content'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                                }
                                            }
                                        @endphp
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addPrivacySection()">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Bagian
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <h5 class="border-bottom pb-2">
                                <i class="bi bi-search me-2"></i>SEO Optimization
                            </h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meta_title" class="form-label">
                                <i class="bi bi-search me-1"></i>Meta Title
                            </label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title"
                                   value="{{ old('meta_title', $page->meta_title) }}"
                                   placeholder="Title untuk SEO" maxlength="60">
                            <small class="text-muted">Maksimal 60 karakter untuk hasil pencarian</small>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meta_description" class="form-label">
                                <i class="bi bi-card-text me-1"></i>Meta Description
                            </label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3"
                                      placeholder="Deskripsi untuk SEO" maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                            <small class="text-muted">Maksimal 160 karakter untuk hasil pencarian</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="meta_keywords" class="form-label">
                                <i class="bi bi-key me-1"></i>Meta Keywords
                            </label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords"
                                   value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                   placeholder="keyword1, keyword2, keyword3">
                            <small class="text-muted">Pisahkan dengan koma</small>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.cms.show', $page) }}" class="btn btn-outline-info">
                            <i class="bi bi-eye me-1"></i>Lihat
                        </a>
                        <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Update Halaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<!-- Summernote CDN -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    console.log('jQuery ready, initializing CMS edit components...');

    // Auto-generate meta title from page title
    $('#title').on('input', function() {
        const title = $(this).val();
        if (!$('#meta_title').val()) {
            $('#meta_title').val(title.substring(0, 60));
        }
    });

    // Handle template change - SIMPLE VERSION
    $('#template').on('change', function() {
        const selectedTemplate = $(this).val();
        showTemplateContent(selectedTemplate);
    });

    // Initialize with current template
    const currentTemplate = '{{ $page->template }}';
    if (currentTemplate) {
        showTemplateContent(currentTemplate);
    }

    // Initialize Summernote for default content and richtext fields
    initializeSummernote();

    function showTemplateContent(template) {
        // Hide all template content sections
        $('.template-content').hide();

        // Show the selected template content
        $(`#${template}-template`).show();

        // Initialize richtext editors for the shown template
        initializeTemplateEditors(template);
    }

    function initializeTemplateEditors(template) {
        if (template === 'default') {
            // Initialize main Summernote editor
            if (!$('#content').hasClass('summernote-initialized')) {
                $('#content').addClass('summernote-initialized');
                $('#content').summernote({
                    height: 500,
                    placeholder: 'Tulis isi halaman di sini...',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            }
        } else {
            // Initialize richtext editors in the template
            $(`#${template}-template .richtext-editor`).each(function() {
                const $editor = $(this);
                if (!$editor.hasClass('summernote-initialized')) {
                    $editor.addClass('summernote-initialized');
                    $editor.summernote({
                        height: 300,
                        toolbar: [
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link']],
                            ['view', ['codeview']]
                        ]
                    });
                }
            });
        }
    }

    function initializeSummernote() {
        // Initialize default content editor if visible
        if ($('#default-template').is(':visible')) {
            $('#content').summernote({
                height: 500,
                placeholder: 'Tulis isi halaman di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }
    }
});

// FAQ Functions
function addFaqItem() {
    const index = $('.faq-item').length;
    const faqHtml = `
        <div class="faq-item border rounded p-3 mb-3" data-index="${index}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">FAQ ${index + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFaqItem(this)">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <input type="text" class="form-control" name="faq[${index}][question]" placeholder="Masukkan pertanyaan" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Jawaban</label>
                    <textarea class="form-control richtext-editor" name="faq[${index}][answer]" rows="4" placeholder="Masukkan jawaban" required></textarea>
                </div>
            </div>
        </div>
    `;

    $('.faq-items').append(faqHtml);

    // Initialize Summernote for the new FAQ answer
    const $newFaq = $('.faq-items .faq-item').last();
    $newFaq.find('.richtext-editor').summernote({
        height: 200,
        toolbar: [
            ['font', ['bold', 'underline']],
            ['para', ['ul', 'ol']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
}

function removeFaqItem(button) {
    $(button).closest('.faq-item').remove();
    updateFaqIndices();
}

function updateFaqIndices() {
    $('.faq-item').each(function(index) {
        const $item = $(this);
        $item.data('index', index);
        $item.find('h6').text(`FAQ ${index + 1}`);
        $item.find('input, textarea').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
            }
        });
    });
}

// Terms Functions
function addTermsSection() {
    const index = $('.terms-section').length;
    const sectionHtml = `
        <div class="terms-section border rounded p-3 mb-3" data-index="${index}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Bagian ${index + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTermsSection(this)">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Judul Bagian</label>
                    <input type="text" class="form-control" name="terms[sections][${index}][title]" placeholder="Judul bagian" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Isi Bagian</label>
                    <textarea class="form-control richtext-editor" name="terms[sections][${index}][content]" rows="6" placeholder="Isi dari bagian ini" required></textarea>
                </div>
            </div>
        </div>
    `;

    $('.terms-sections').append(sectionHtml);

    // Initialize Summernote for the new section content
    const $newSection = $('.terms-sections .terms-section').last();
    $newSection.find('.richtext-editor').summernote({
        height: 250,
        toolbar: [
            ['font', ['bold', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
}

function removeTermsSection(button) {
    $(button).closest('.terms-section').remove();
    updateTermsIndices();
}

function updateTermsIndices() {
    $('.terms-section').each(function(index) {
        const $item = $(this);
        $item.data('index', index);
        $item.find('h6').text(`Bagian ${index + 1}`);
        $item.find('input, textarea').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/sections\[\d+\]/, `sections[${index}]`));
            }
        });
    });
}

// Privacy Functions
function addPrivacySection() {
    const index = $('.privacy-section').length;
    const sectionHtml = `
        <div class="privacy-section border rounded p-3 mb-3" data-index="${index}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Bagian ${index + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePrivacySection(this)">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Judul Bagian</label>
                    <input type="text" class="form-control" name="privacy[sections][${index}][title]" placeholder="Judul bagian" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Isi Bagian</label>
                    <textarea class="form-control richtext-editor" name="privacy[sections][${index}][content]" rows="6" placeholder="Isi dari bagian ini" required></textarea>
                </div>
            </div>
        </div>
    `;

    $('.privacy-sections').append(sectionHtml);

    // Initialize Summernote for the new section content
    const $newSection = $('.privacy-sections .privacy-section').last();
    $newSection.find('.richtext-editor').summernote({
        height: 250,
        toolbar: [
            ['font', ['bold', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
}

function removePrivacySection(button) {
    $(button).closest('.privacy-section').remove();
    updatePrivacyIndices();
}

function updatePrivacyIndices() {
    $('.privacy-section').each(function(index) {
        const $item = $(this);
        $item.data('index', index);
        $item.find('h6').text(`Bagian ${index + 1}`);
        $item.find('input, textarea').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/sections\[\d+\]/, `sections[${index}]`));
            }
        });
    });
}
</script>
@endpush
