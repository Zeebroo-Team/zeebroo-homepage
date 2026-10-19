@extends('layouts.frontend')

@section('title', 'Industries | Zeebroo: built for the way your industry works')
@section('description', 'See how Zeebroo fits restaurants, retail stores, ecommerce, manufacturing, spare parts, wholesale, non-profits, pharmacies and hotels.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- INDUSTRIES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">Industries</span>
      <h1>Built for the way your industry works.</h1>
      <p>Zeebroo adapts to your business, not the other way round. Pick your industry to see the modules and workflows that fit it.</p>
    </div>

    <div class="feat-sec-h"><span>All industries</span><em>{{ count($industries) }}</em></div>
    @include('frontend.industries.partials.grid')
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
