@extends('frontend.layout')

@section('title', $page->meta_title ?? $page->title)
@section('meta-description', $page->meta_description ?? Str::limit(strip_tags($page->getTemplateData('introduction', '')), 160))
@section('meta-keywords', $page->meta_keywords)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">{{ $page->title }}</h1>
                @if($page->getTemplateData('effective_date'))
                    <p class="text-muted mt-3">
                        <i class="bi bi-calendar me-1"></i>
                        Berlaku sejak: {{ \Carbon\Carbon::parse($page->getTemplateData('effective_date'))->format('d F Y') }}
                    </p>
                @endif
            </div>

            <!-- Introduction -->
            @if($page->getTemplateData('introduction'))
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0">
                            <i class="bi bi-shield-check me-2"></i>
                            {!! $page->getTemplateData('introduction') !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Privacy Sections -->
            @php
                $sections = $page->getTemplateData('sections', []);
            @endphp

            @if(is_array($sections) && !empty($sections))
                <div class="accordion" id="privacyAccordion">
                    @foreach($sections as $index => $section)
                        @if(isset($section['title']) && isset($section['content']))
                            <div class="accordion-item mb-3 shadow-sm">
                                <h2 class="accordion-header" id="privacyHeading{{ $index }}">
                                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#privacyCollapse{{ $index }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="privacyCollapse{{ $index }}">
                                        <span class="badge bg-success me-3">{{ $index + 1 }}</span>
                                        {{ $section['title'] }}
                                    </button>
                                </h2>
                                <div id="privacyCollapse{{ $index }}"
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                     aria-labelledby="privacyHeading{{ $index }}"
                                     data-bs-parent="#privacyAccordion">
                                    <div class="accordion-body">
                                        {!! $section['content'] !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-shield text-muted" style="font-size: 3rem;"></i>
                    <h4 class="text-muted mt-3">Konten belum tersedia</h4>
                    <p class="text-muted">Konten kebijakan privasi akan segera ditambahkan.</p>
                </div>
            @endif

            <!-- Contact CTA -->
            <div class="text-center mt-5">
                <div class="card bg-light border-0">
                    <div class="card-body py-4">
                        <h5 class="card-title mb-3">Ada pertanyaan tentang kebijakan privasi?</h5>
                        <p class="card-text text-muted mb-4">
                            Jika Anda memiliki pertanyaan tentang bagaimana kami menangani data Anda, hubungi kami.
                        </p>
                        <a href="{{ route('page.show', 'kontak') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}

.accordion-button:not(.collapsed) {
    color: #198754;
    background-color: #e8f5e8;
}

.accordion-body {
    padding: 1.5rem;
    line-height: 1.6;
}

.accordion-body h1,
.accordion-body h2,
.accordion-body h3,
.accordion-body h4,
.accordion-body h5,
.accordion-body h6 {
    color: #198754;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.accordion-body p {
    margin-bottom: 1rem;
}

.accordion-body ul,
.accordion-body ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.accordion-body li {
    margin-bottom: 0.5rem;
}

.badge {
    min-width: 30px;
    font-size: 0.9rem;
}

.alert {
    border-radius: 0.5rem;
}

@media (max-width: 768px) {
    .accordion-body {
        padding: 1rem;
    }
}
</style>
@endsection
