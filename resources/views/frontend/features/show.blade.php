@extends('layouts.frontend')

@section('title', $feature['title'] . ' | Zeebroo')
@section('description', $feature['description'])

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
    @include('frontend.features.partials.hero')
    @include('frontend.features.partials.scene')
    @include('frontend.features.partials.highlights')
    @include('frontend.features.partials.capabilities')
    @include('frontend.features.partials.related')
    @include('frontend.features.partials.cta')
@endsection
