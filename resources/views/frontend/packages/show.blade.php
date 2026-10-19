@extends('layouts.frontend')

@section('title', $package['name'] . ' | Zeebroo pricing')
@section('description', 'Zeebroo ' . $package['name'] . ': ' . $package['price'] . ($package['is_free'] ? '' : ' a month') . ' for ' . count($package['features']) . ' modules, including ' . implode(', ', array_slice(array_column($package['features'], 'label'), 0, 3)) . '.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PACKAGE HERO -->
<section class="feat-hero">
  <div class="wrap feat-hero-grid">
    <div class="feat-copy">
      <nav class="crumbs" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a><i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('packages.index') }}">Pricing</a><i class="fa-solid fa-chevron-right"></i>
        <span aria-current="page">{{ $package['name'] }}</span>
      </nav>
      <span class="feat-tag"><i class="fa-solid fa-box-open"></i>{{ count($package['features']) }} modules @if ($package['save'])<em>Save {{ $package['save'] }}%</em>@endif</span>
      <h1 class="rise">@include('frontend.components.rise-title', ['text' => $package['name']])</h1>
      <div class="pkg-price pkg-price-lg fade-in">
        <b>{{ $package['price'] }}</b>@unless ($package['is_free'])<span>/month</span>@endunless
        @if ($package['was'])<s class="pkg-was">{{ $package['was'] }}</s>@endif
      </div>
      <p class="feat-lead fade-in">{{ $package['description'] ?: 'Everything in ' . $package['name'] . ' shares the same live data, so your sales, stock and books always agree.' }}</p>
      <div class="feat-ctas fade-in" style="--d:.42s">
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="{{ route('packages.index') }}">Compare packages</a>
      </div>
      <ul class="feat-meta fade-in" style="--d:.54s">
        <li><i class="fa-solid fa-check"></i>Billed monthly</li>
        <li><i class="fa-solid fa-check"></i>Web and desktop</li>
        @if ($package['pos_lite'])<li><i class="fa-solid fa-check"></i>Works with POS Lite</li>@endif
      </ul>
    </div>

    <div class="feat-art fade-in" style="--d:.2s" aria-hidden="true">
      {{-- the package with its first three modules orbiting it --}}
      <div class="feat-orbit">
        <span class="feat-orbit-ic"><i class="fa-solid fa-box-open"></i></span>
        @foreach (array_slice($package['features'], 0, 3) as $feature)
          <span class="feat-chip feat-chip-{{ $loop->iteration }}"><i class="fa-solid {{ $feature['icon'] }}"></i>{{ $feature['label'] }}</span>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- PACKAGE MODULES -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">What's included</span>
      <h2>{{ count($package['features']) }} modules in {{ $package['name'] }}</h2>
      <p>Each one is ready the moment your business is set up. Open any module to see what it does.</p>
    </div>
    <div class="feat-grid ind-mods">
      @foreach ($package['features'] as $feature)
        @if ($feature['slug'])
          <a class="feat-link reveal" href="{{ route('features.show', $feature['slug']) }}">
            <span class="fi"><i class="fa-solid {{ $feature['icon'] }}"></i></span>
            <div><b>{{ $feature['label'] }}</b>@if ($feature['menu'])<small>{{ $feature['menu'] }}</small>@endif</div>
            <i class="fa-solid fa-arrow-right feat-go"></i>
          </a>
        @else
          <div class="feat-link reveal">
            <span class="fi"><i class="fa-solid {{ $feature['icon'] }}"></i></span>
            <div><b>{{ $feature['label'] }}</b></div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
</section>

@if ($missing)
<!-- PACKAGE UPGRADE HINT -->
<section class="section">
  <div class="wrap feat-caps">
    <div class="feat-caps-l reveal">
      <span class="label">Need more?</span>
      <h2>Unlock more with a bigger package</h2>
      <p>These modules come with other Zeebroo packages. Upgrade any time and your data comes with you.</p>
      <a class="btn btn-line" href="{{ route('packages.index') }}">Compare packages <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <ul class="feat-list pkg-missing reveal">
      @foreach ($missing as $feature)
        <li><span><i class="fa-solid fa-plus"></i></span>{{ $feature['label'] }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif

@if ($prev || $next)
<section class="wrap pkg-pager">
  <nav class="feat-pager" aria-label="More packages">
    @if ($prev)
      <a href="{{ route('packages.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> Previous</small><b>{{ $prev['name'] }}</b></a>
    @else
      <span></span>
    @endif
    <a class="feat-pager-all" href="{{ route('packages.index') }}"><i class="fa-solid fa-grip"></i><span>All packages</span></a>
    @if ($next)
      <a href="{{ route('packages.show', $next['slug']) }}"><small>Next <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['name'] }}</b></a>
    @else
      <span></span>
    @endif
  </nav>
</section>
@endif

@include('frontend.features.partials.cta')
@endsection
