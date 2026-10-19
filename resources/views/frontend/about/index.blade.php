@extends('layouts.frontend')

@section('title', 'About Us | Zeebroo')
@section('description', 'Zeebroo is one platform for sales, stock, bills, staff and growth. Meet the team, the mission and the values behind the software that runs busy businesses.')

@push('head')
<link rel="canonical" href="{{ route('about') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
  @include('frontend.about.partials.hero')
  @include('frontend.about.partials.story')
  @include('frontend.about.partials.values')
  @include('frontend.about.partials.compare')
  @include('frontend.about.partials.platform')
  @include('frontend.about.partials.process')
  @include('frontend.about.partials.trust')
  @include('frontend.about.partials.cta')
@endsection
