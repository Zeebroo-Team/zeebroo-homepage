@extends('layouts.frontend')

@php($metaTitle = $feature->meta_title ?: $feature->title)
@php($metaDescription = $feature->meta_description ?: \Illuminate\Support\Str::limit((string) $feature->lead, 160))

@section('title', $metaTitle . ' | Zeebroo')
@section('description', $metaDescription)

{{-- the canonical tag comes from the layout: /features/{slug} and /si/{path} each point to themselves --}}
@php($englishUrl = route('features.show', $feature->slug))

{{-- share preview: config/social.php overrides, else the page's own meta and illustration --}}
@php($social = config('social.features.'.$feature->slug, []))
@php($suffix = app()->getLocale() === config('app.fallback_locale') ? '' : '_'.app()->getLocale())
@php($ogTitle = $social['title'.$suffix] ?? $metaTitle)
@php($ogDescription = $social['description'.$suffix] ?? $metaDescription)
@php($twitterDescription = $social['twitter_description'.$suffix] ?? $ogDescription)
@php($ogImage = isset($social['image']) && is_file(public_path($social['image'])) ? asset($social['image']) : ($feature->scene_url ?: $feature->spot_url ?: $feature->screenshots->first()?->url))
@php($ogLocale = app()->getLocale() === 'si' ? 'si_LK' : 'en_LK')

@push('head')
<meta name="robots" content="index, follow">
{{-- a Sinhala hreflang is only listed for features with their own Sinhala address (Feature::SINHALA_PATHS) --}}
<link rel="alternate" hreflang="en-LK" href="{{ $englishUrl }}">
@if ($feature->sinhala_url)<link rel="alternate" hreflang="si-LK" href="{{ $feature->sinhala_url }}">@endif
<link rel="alternate" hreflang="x-default" href="{{ $englishUrl }}">
@if ($feature->meta_keywords)<meta name="keywords" content="{{ $feature->meta_keywords }}">@endif
<meta property="og:type" content="website">
<meta property="og:site_name" content="Zeebroo">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
@if ($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif
<meta property="og:locale" content="{{ $ogLocale }}">
@if ($feature->sinhala_url)<meta property="og:locale:alternate" content="{{ $ogLocale === 'si_LK' ? 'en_LK' : 'si_LK' }}">@endif

<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
@if ($ogImage)<meta name="twitter:image" content="{{ $ogImage }}">@endif
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
    @include('frontend.features.partials.hero')
    @include('frontend.features.partials.scene')
    @include('frontend.features.partials.highlights')
    @include('frontend.features.partials.screenshots')
    @include('frontend.features.partials.capabilities')
    @include('frontend.features.partials.related')
    @include('frontend.features.partials.cta')
@endsection
