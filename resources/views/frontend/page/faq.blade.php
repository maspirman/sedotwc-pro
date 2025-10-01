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
                @if($page->getTemplateData('introduction'))
                    <p class="lead text-muted mt-3">{{ $page->getTemplateData('introduction') }}</p>
                @endif
            </div>

            <!-- FAQ Accordion -->
            <div class="accordion" id="faqAccordion">
                @php
                    $faqs = $page->getTemplateData('faqs', []);
                    $index = 0;
                @endphp

                @if(is_array($faqs) && !empty($faqs))
                    @foreach($faqs as $faq)
                        @if(isset($faq['question']) && isset($faq['answer']))
                            <div class="accordion-item mb-3 shadow-sm">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $index }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $index }}">
                                        <i class="bi bi-question-circle me-2 text-primary"></i>
                                        {{ $faq['question'] }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}"
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                     aria-labelledby="heading{{ $index }}"
                                     data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! $faq['answer'] !!}
                                    </div>
                                </div>
                            </div>
                            @php $index++; @endphp
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-info-circle text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">Belum ada FAQ</h4>
                        <p class="text-muted">FAQ akan segera ditambahkan.</p>
                    </div>
                @endif
            </div>

            <!-- Contact CTA -->
            <div class="text-center mt-5">
                <div class="card bg-light border-0">
                    <div class="card-body py-4">
                        <h5 class="card-title mb-3">Masih ada pertanyaan?</h5>
                        <p class="card-text text-muted mb-4">
                            Jika pertanyaan Anda belum terjawab, jangan ragu untuk menghubungi kami.
                        </p>
                        <a href="{{ route('page.show', 'kontak') }}" class="btn btn-primary btn-lg">
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
    color: #0d6efd;
    background-color: #e7f3ff;
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
    color: #0d6efd;
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
</style>

<script>
// Add smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        const element = document.querySelector(hash);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            // Expand the FAQ item if it's collapsed
            const collapseElement = element.closest('.accordion-collapse');
            if (collapseElement && !collapseElement.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(collapseElement, {
                    show: true
                });
            }
        }
    }
});
</script>
@endsection
