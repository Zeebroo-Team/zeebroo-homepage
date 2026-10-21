@extends('layouts.frontend')

@php($metaTitle = $industry->meta_title ?: $industry->title . ' සඳහා Zeebroo')
@php($metaDescription = $industry->meta_description ?: \Illuminate\Support\Str::limit((string) $industry->lead, 160))

@section('title', $metaTitle . ' | Zeebroo')
@section('description', $metaDescription)

@push('head')
<link rel="canonical" href="{{ route('industries.show', $industry->slug) }}">
@if ($industry->meta_keywords)<meta name="keywords" content="{{ $industry->meta_keywords }}">@endif
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ route('industries.show', $industry->slug) }}">
@if ($industry->scene_url)<meta property="og:image" content="{{ $industry->scene_url }}">@endif
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- INDUSTRY HERO -->
<section class="feat-hero">
  <div class="wrap feat-hero-grid">
    <div class="feat-copy">
      <nav class="crumbs" aria-label="පිටු මාර්ගය">
        <a href="{{ route('home') }}">මුල් පිටුව</a><i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('industries.index') }}">ව්‍යාපාර ක්ෂේත්‍ර</a><i class="fa-solid fa-chevron-right"></i>
        <span aria-current="page">{{ $industry->title }}</span>
      </nav>
      <span class="feat-tag"><i class="fa-solid {{ $industry->icon }}"></i>{{ $industry->title }}@if ($industry->badge) <em>{{ $industry->badge }}</em>@endif</span>
      <h1 class="rise">@include('frontend.components.rise-title', ['text' => (string) $industry->headline])</h1>
      <p class="feat-lead fade-in">{{ $industry->lead }}</p>
      <div class="feat-ctas fade-in" style="--d:.42s">
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-envelope"></i> ආදර්ශනයක් වෙන් කරන්න</a>
      </div>
      <ul class="feat-meta fade-in" style="--d:.54s">
        <li><i class="fa-solid fa-check"></i>{{ $industry->title }} සඳහා සකසා ඇත</li>
        <li><i class="fa-solid fa-check"></i>වෙබ් සහ ඩෙස්ක්ටොප්</li>
        <li><i class="fa-solid fa-check"></i>බෙදාගත්, සජීවී දත්ත</li>
      </ul>
    </div>

    <div class="feat-art fade-in" style="--d:.2s" aria-hidden="true">
      {{-- the industry icon with its three highlights orbiting it --}}
      <div class="feat-orbit">
        <span class="feat-orbit-ic"><i class="fa-solid {{ $industry->icon }}"></i></span>
        @foreach (array_slice($industry->highlights ?? [], 0, 3) as $h)
          <span class="feat-chip feat-chip-{{ $loop->iteration }}"><i class="fa-solid {{ $h['icon'] }}"></i>{{ $h['title'] }}</span>
        @endforeach
      </div>
    </div>
  </div>
</section>

@if ($industry->scene_url)
<!-- INDUSTRY SCENE -->
<section class="wrap feat-scene-wrap">
  <figure class="feat-scene reveal">
    <img src="{{ $industry->scene_url }}" alt="{{ $industry->title }} තුළ වැඩ කරන Zeebroo සීබ්‍රා" width="1280" height="768" loading="lazy">
  </figure>
</section>
@endif

<!-- INDUSTRY HIGHLIGHTS -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">එය ගැළපෙන්නේ ඇයි</span>
      <h2>{{ $industry->title }} සඳහා Zeebroo කරන දේ</h2>
    </div>
    <div class="feat-cards">
      @foreach ($industry->highlights ?? [] as $h)
        <div class="feat-card reveal">
          <span class="fi"><i class="fa-solid {{ $h['icon'] }}"></i></span>
          <h3>{{ $h['title'] }}</h3>
          <p>{{ $h['text'] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- INDUSTRY CAPABILITIES -->
<section class="section">
  <div class="wrap feat-caps">
    <div class="feat-caps-l reveal">
      <span class="label">සූදානම් කර ඇත</span>
      <h2>{{ $industry->title }} සඳහා අවශ්‍ය සියල්ල</h2>
      <p>කවුන්ටරය, ගබඩා කාමරය සහ ගිණුම් පොත් සඳහා එකම වේදිකාවක් නිසා, කිසිවක් දෙවරක් ටයිප් කිරීමට අවශ්‍ය නැති අතර සෑම වාර්තාවක්ම එකඟ වේ.</p>
      <a class="btn btn-line" href="{{ route('contact') }}">{{ $industry->title }} ගැන විමසන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <ul class="feat-list reveal">
      @foreach ($industry->capabilities ?? [] as $cap)
        <li><span><i class="fa-solid fa-check"></i></span>{{ $cap }}</li>
      @endforeach
    </ul>
  </div>
</section>

<!-- INDUSTRY MODULES + PAGER -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">නිර්දේශිත මොඩියුල</span>
      <h2>{{ $industry->title }} සඳහා මොඩියුල</h2>
      <p>මේවායින් ආරම්භ කර, වර්ධනය වන විට ඉතිරිය සක්‍රිය කරන්න.</p>
    </div>
    <div class="feat-grid ind-mods">
      @foreach ($modules as $f)
        @include('frontend.features.partials.card', ['f' => $f])
      @endforeach
    </div>

    <nav class="feat-pager" aria-label="තවත් ක්ෂේත්‍ර">
      <a href="{{ route('industries.show', $prev->slug) }}"><small><i class="fa-solid fa-arrow-left"></i> පෙර</small><b>{{ $prev->title }}</b></a>
      <a class="feat-pager-all" href="{{ route('industries.index') }}"><i class="fa-solid fa-grip"></i><span>සියලුම ක්ෂේත්‍ර</span></a>
      <a href="{{ route('industries.show', $next->slug) }}"><small>ඊළඟ <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next->title }}</b></a>
    </nav>
  </div>
</section>

@include('frontend.features.partials.cta')
@endsection
