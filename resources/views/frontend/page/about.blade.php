@extends('frontend.layout')

@section('title', $page->meta_title ?? $page->title)
@section('meta-description', $page->meta_description ?? Str::limit(strip_tags($page->getTemplateData('hero_description', '')), 160))
@section('meta-keywords', $page->meta_keywords)

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    @if($page->getTemplateData('hero_image'))
        <div class="row justify-content-center mb-5">
            <div class="col-lg-12">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $page->getTemplateData('hero_image')) }}"
                         alt="{{ $page->title }}"
                         class="img-fluid rounded shadow mb-4"
                         style="max-height: 400px; width: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3">{{ $page->getTemplateData('hero_title', $page->title) }}</h1>
                @if($page->getTemplateData('hero_description'))
                    <p class="lead text-muted">{{ $page->getTemplateData('hero_description') }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Company Story -->
            @if($page->getTemplateData('company_story'))
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-5">
                        <h2 class="card-title mb-4 text-center">Cerita Kami</h2>
                        <div class="content">
                            {!! $page->getTemplateData('company_story') !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mission & Vision -->
            @php
                $missionVision = $page->getTemplateData('mission_vision', []);
            @endphp

            @if((isset($missionVision['mission']) && $missionVision['mission']) || (isset($missionVision['vision']) && $missionVision['vision']))
                <div class="row mb-5">
                    @if(isset($missionVision['mission']) && $missionVision['mission'])
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body p-4 text-center">
                                    <i class="bi bi-target text-primary mb-3" style="font-size: 3rem;"></i>
                                    <h3 class="card-title mb-3">Misi Kami</h3>
                                    <p class="card-text">{{ $missionVision['mission'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($missionVision['vision']) && $missionVision['vision'])
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body p-4 text-center">
                                    <i class="bi bi-eye text-primary mb-3" style="font-size: 3rem;"></i>
                                    <h3 class="card-title mb-3">Visi Kami</h3>
                                    <p class="card-text">{{ $missionVision['vision'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Timeline -->
            @php
                $timeline = $page->getTemplateData('timeline', []);
            @endphp

            @if(is_array($timeline) && !empty($timeline))
                <div class="mb-5">
                    <h2 class="text-center mb-5">Perjalanan Kami</h2>
                    <div class="timeline">
                        @foreach($timeline as $index => $item)
                            @if(isset($item['year']) && isset($item['title']))
                                <div class="timeline-item {{ $index % 2 === 0 ? 'left' : 'right' }}">
                                    <div class="timeline-content card shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="timeline-year badge bg-primary mb-3">{{ $item['year'] }}</div>
                                            <h4 class="card-title mb-3">{{ $item['title'] }}</h4>
                                            @if(isset($item['description']) && $item['description'])
                                                <p class="card-text">{{ $item['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Team -->
            @php
                $team = $page->getTemplateData('team', []);
            @endphp

            @if(is_array($team) && !empty($team))
                <div class="mb-5">
                    <h2 class="text-center mb-5">Tim Kami</h2>
                    <div class="row">
                        @foreach($team as $member)
                            @if(isset($member['name']) && isset($member['position']))
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow-sm h-100 text-center">
                                        <div class="card-body p-4">
                                            @if(isset($member['photo']) && $member['photo'])
                                                <img src="{{ asset('storage/' . $member['photo']) }}"
                                                     alt="{{ $member['name'] }}"
                                                     class="rounded-circle mb-3"
                                                     style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                     style="width: 120px; height: 120px;">
                                                    <i class="bi bi-person text-white" style="font-size: 3rem;"></i>
                                                </div>
                                            @endif

                                            <h5 class="card-title mb-1">{{ $member['name'] }}</h5>
                                            <p class="text-primary fw-semibold mb-3">{{ $member['position'] }}</p>

                                            @if(isset($member['bio']) && $member['bio'])
                                                <p class="card-text text-muted">{{ $member['bio'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

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
.card {
    border: none;
    border-radius: 0.75rem;
}

.card-body {
    padding: 2rem;
}

.content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.content h1,
.content h2,
.content h3,
.content h4,
.content h5,
.content h6 {
    color: #0d6efd;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.content p {
    margin-bottom: 1.5rem;
}

.content ul,
.content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.content li {
    margin-bottom: 0.5rem;
}

/* Timeline Styles */
.timeline {
    position: relative;
    padding: 2rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #0d6efd;
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    width: 50%;
}

.timeline-item.left {
    left: 0;
    padding-right: 2rem;
    text-align: right;
}

.timeline-item.right {
    left: 50%;
    padding-left: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    top: 50%;
    width: 20px;
    height: 20px;
    background: #0d6efd;
    border-radius: 50%;
    transform: translateY(-50%);
}

.timeline-item.left::before {
    right: -10px;
}

.timeline-item.right::before {
    left: -10px;
}

.timeline-content {
    border: none;
    border-radius: 0.75rem;
}

.timeline-year {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

@media (max-width: 768px) {
    .timeline::before {
        left: 20px;
    }

    .timeline-item {
        width: 100%;
        left: 0 !important;
        padding-left: 3rem !important;
        padding-right: 0 !important;
        text-align: left !important;
    }

    .timeline-item::before {
        left: 10px !important;
        right: auto !important;
    }

    .timeline-item.left::before {
        left: 10px;
    }
}
</style>
@endsection
