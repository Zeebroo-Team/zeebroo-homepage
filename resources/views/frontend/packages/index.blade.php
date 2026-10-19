@extends('layouts.frontend')

@section('title', 'Pricing | Zeebroo: packages for every stage of your business')
@section('description', 'Compare Zeebroo packages: monthly plans that bundle POS, stock, accounts, bills, CRM, HR and more. Pick what you need and upgrade as you grow.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PACKAGES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">Pricing</span>
      <h1 class="rise"><span class="line"><span>Pick the package that <span class="mark">fits.</span></span></span></h1>
      <p class="fade-in">Every package runs on web and desktop with shared, live data. Start with what you need today and move up as your business grows.</p>
    </div>

    @if ($packages)
      <div class="feat-sec-h"><span>Packages</span><em>{{ count($packages) }}</em></div>
      <div class="pkgs">
        @foreach ($packages as $p)
          @include('frontend.packages.partials.card', ['p' => $p])
        @endforeach
      </div>
      <p class="pkg-note">Prices are per business, billed monthly. Cancel or change package any time.</p>

      <div class="feat-sec-h pkg-compare-h"><span>Compare packages</span><em>{{ count($features) }} modules</em></div>
      @include('frontend.packages.partials.compare')
    @else
      <div class="pkg-empty reveal">
        <span><i class="fa-solid fa-box-open"></i></span>
        <h3>Pricing is loading slowly right now</h3>
        <p>We couldn't fetch the latest packages. Refresh in a minute, or ask us and we'll send them over.</p>
        <a class="btn btn-ink" href="{{ route('contact') }}">Talk to our team <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    @endif
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
