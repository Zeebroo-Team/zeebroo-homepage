@extends('layouts.frontend')

@php($metaTitle = $feature->meta_title ?: $feature->title)
@php($metaDescription = $feature->meta_description ?: \Illuminate\Support\Str::limit((string) $feature->lead, 160))

@section('title', $metaTitle . ' | Zeebroo')
@section('description', $metaDescription)

@push('head')
<link rel="canonical" href="{{ route('features.show', $feature->slug) }}">
@if ($feature->meta_keywords)<meta name="keywords" content="{{ $feature->meta_keywords }}">@endif
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ route('features.show', $feature->slug) }}">
@if ($ogImage = $feature->scene_url ?: $feature->spot_url ?: $feature->screenshots->first()?->url)<meta property="og:image" content="{{ $ogImage }}">@endif
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
