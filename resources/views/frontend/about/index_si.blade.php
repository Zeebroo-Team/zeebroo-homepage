@extends('layouts.frontend')

@section('title', 'අප ගැන | Zeebroo')
@section('description', 'Zeebroo යනු විකුණුම්, තොගය, බිල්පත්, කාර්ය මණ්ඩලය සහ වර්ධනය සඳහා එකම වේදිකාවකි. කාර්යබහුල ව්‍යාපාර පවත්වාගෙන යන මෘදුකාංගය පිටුපස සිටින කණ්ඩායම, මෙහෙවර සහ වටිනාකම් හඳුනාගන්න.')

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
