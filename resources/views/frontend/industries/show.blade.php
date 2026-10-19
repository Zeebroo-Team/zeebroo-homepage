@extends('layouts.frontend')

@section('title', 'Zeebroo for ' . $industry['title'] . ' | Zeebroo')
@section('description', $industry['description'])

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- INDUSTRY HERO -->
<section class="feat-hero">
  <div class="wrap feat-hero-grid">
    <div class="feat-copy">
      <nav class="crumbs" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a><i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('industries.index') }}">Industries</a><i class="fa-solid fa-chevron-right"></i>
        <span aria-current="page">{{ $industry['title'] }}</span>
      </nav>
      <span class="feat-tag"><i class="fa-solid {{ $industry['icon'] }}"></i>{{ $industry['title'] }}@if ($industry['badge']) <em>{{ $industry['badge'] }}</em>@endif</span>
      <h1 class="rise">@include('frontend.components.rise-title', ['text' => $industry['headline']])</h1>
      <p class="feat-lead fade-in">{{ $industry['lead'] }}</p>
      <div class="feat-ctas fade-in" style="--d:.42s">
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-envelope"></i> Book a demo</a>
      </div>
      <ul class="feat-meta fade-in" style="--d:.54s">
        <li><i class="fa-solid fa-check"></i>Set up for {{ $industry['title'] }}</li>
        <li><i class="fa-solid fa-check"></i>Web and desktop</li>
        <li><i class="fa-solid fa-check"></i>Shared, live data</li>
      </ul>
    </div>

    <div class="feat-art fade-in" style="--d:.2s" aria-hidden="true">
      {{-- the industry icon with its three highlights orbiting it --}}
      <div class="feat-orbit">
        <span class="feat-orbit-ic"><i class="fa-solid {{ $industry['icon'] }}"></i></span>
        @foreach ($industry['highlights'] as [$icon, $title])
          <span class="feat-chip feat-chip-{{ $loop->iteration }}"><i class="fa-solid {{ $icon }}"></i>{{ $title }}</span>
        @endforeach
      </div>
    </div>
  </div>
</section>

@if ($industry['scene'])
<!-- INDUSTRY SCENE -->
<section class="wrap feat-scene-wrap">
  <figure class="feat-scene reveal">
    <img src="{{ asset('assets/features/' . $industry['scene']) }}" alt="Zeebroo zebra at work in a {{ strtolower($industry['title']) }}" width="1280" height="768" loading="lazy">
  </figure>
</section>
@endif

<!-- INDUSTRY HIGHLIGHTS -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Why it fits</span>
      <h2>What Zeebroo does for {{ $industry['title'] }}</h2>
    </div>
    <div class="feat-cards">
      @foreach ($industry['highlights'] as [$icon, $title, $text])
        <div class="feat-card reveal">
          <span class="fi"><i class="fa-solid {{ $icon }}"></i></span>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- INDUSTRY CAPABILITIES -->
<section class="section">
  <div class="wrap feat-caps">
    <div class="feat-caps-l reveal">
      <span class="label">Out of the box</span>
      <h2>Everything {{ $industry['title'] }} needs</h2>
      <p>One platform for the counter, the stock room and the books, so nothing is typed twice and every report agrees.</p>
      <a class="btn btn-line" href="{{ route('contact') }}">Ask about {{ $industry['title'] }} <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <ul class="feat-list reveal">
      @foreach ($industry['capabilities'] as $cap)
        <li><span><i class="fa-solid fa-check"></i></span>{{ $cap }}</li>
      @endforeach
    </ul>
  </div>
</section>

<!-- INDUSTRY MODULES + PAGER -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Recommended modules</span>
      <h2>Modules for {{ $industry['title'] }}</h2>
      <p>Start with these and turn on the rest as you grow.</p>
    </div>
    <div class="feat-grid ind-mods">
      @foreach ($modules as $modSlug => $f)
        @include('frontend.features.partials.card', ['slug' => $modSlug, 'f' => $f])
      @endforeach
    </div>

    <nav class="feat-pager" aria-label="More industries">
      <a href="{{ route('industries.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> Previous</small><b>{{ $prev['title'] }}</b></a>
      <a class="feat-pager-all" href="{{ route('industries.index') }}"><i class="fa-solid fa-grip"></i><span>All industries</span></a>
      <a href="{{ route('industries.show', $next['slug']) }}"><small>Next <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['title'] }}</b></a>
    </nav>
  </div>
</section>

@include('frontend.features.partials.cta')
@endsection
