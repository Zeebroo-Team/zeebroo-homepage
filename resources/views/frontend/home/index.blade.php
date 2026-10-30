@extends('layouts.frontend')

@include('frontend.components.organization-schema')

{{-- the home page's canonical keeps the trailing slash: https://zeebroo.com/ --}}
@php($canonical = route('home').'/')

{{-- title, description and share image can be changed in /admin/seo; empty fields keep the site-wide defaults --}}
@section('title', $seoPage?->localized('meta_title') ?? config('social.default.title'))
@section('description', $seoPage?->localized('meta_description') ?? config('social.default.description'))
@include('frontend.components.social-meta')

@push('head')
<link rel="preload" as="image" href="{{ asset('assets/mascot.webp') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/script.js') }}"></script>
@endpush

@section('content')
    @include('frontend.home.hero')
    @include('frontend.home.benefits')
    @include('frontend.home.modules')
    @include('frontend.home.finance')
    @include('frontend.home.industries')
    @include('frontend.home.partners')
    @include('frontend.home.testimonials')
    @include('frontend.home.packages')
    @include('frontend.home.steps')
    @include('frontend.home.manifesto')
    @include('frontend.home.faq')
    @include('frontend.home.cta')
    @include('frontend.home.temp')

 @endsection