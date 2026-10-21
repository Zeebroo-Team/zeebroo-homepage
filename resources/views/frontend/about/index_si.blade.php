@extends('layouts.frontend')

@section('title', 'අප ගැන | Zeebroo')
@section('description', 'විකුණුම්, තොග, බිල්පත්, සේවක කළමනාකරණය සහ ව්‍යාපාර වර්ධනය එකම තැනකින් පාලනය කළ හැකි Zeebroo පිටුපස සිටින කණ්ඩායම, අපගේ අරමුණ සහ වටිනාකම් පිළිබඳ දැනගන්න.')

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
