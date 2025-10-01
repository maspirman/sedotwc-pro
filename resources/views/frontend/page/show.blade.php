@extends('frontend.layout')

@section('title', $page->meta_title ?? $page->title)
@section('meta-description', $page->meta_description ?? Str::limit(strip_tags($page->content), 160))
@section('meta-keywords', $page->meta_keywords)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">{{ $page->title }}</h1>
            </div>

            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn btn-primary btn-custom">
                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.page-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.page-content h1,
.page-content h2,
.page-content h3,
.page-content h4,
.page-content h5,
.page-content h6 {
    color: #007bff;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.page-content p {
    margin-bottom: 1.5rem;
}

.page-content ul,
.page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content li {
    margin-bottom: 0.5rem;
}

.page-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6c757d;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
}

.page-content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
}

.page-content th,
.page-content td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.page-content th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection
