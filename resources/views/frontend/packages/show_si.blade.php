@extends('layouts.frontend')

@section('title', $package['name'] . ' | Zeebroo මිල ගණන්')
@section('description', 'Zeebroo ' . $package['name'] . ': මොඩියුල ' . count($package['features']) . ' ක් සඳහා ' . $package['price'] . ($package['is_free'] ? '' : ' මසකට') . ', ' . implode(', ', array_slice(array_column($package['features'], 'label'), 0, 3)) . ' ඇතුළුව.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PACKAGE HERO -->
<section class="feat-hero">
  <div class="wrap feat-hero-grid">
    <div class="feat-copy">
      <nav class="crumbs" aria-label="පිටු මාර්ගය">
        <a href="{{ route('home') }}">මුල් පිටුව</a><i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('packages.index') }}">මිල ගණන්</a><i class="fa-solid fa-chevron-right"></i>
        <span aria-current="page">{{ $package['name'] }}</span>
      </nav>
      <span class="feat-tag"><i class="fa-solid fa-box-open"></i>මොඩියුල {{ count($package['features']) }} @if ($package['save'])<em>{{ $package['save'] }}% ඉතිරි කරන්න</em>@endif</span>
      <h1 class="rise">@include('frontend.components.rise-title', ['text' => $package['name']])</h1>
      <div class="pkg-price pkg-price-lg fade-in">
        <b>{{ $package['price'] }}</b>@unless ($package['is_free'])<span>/මසකට</span>@endunless
        @if ($package['was'])<s class="pkg-was">{{ $package['was'] }}</s>@endif
      </div>
      <p class="feat-lead fade-in">{{ $package['description'] ?: $package['name'] . ' හි සියල්ල එකම සජීවී දත්ත බෙදාගන්නා නිසා, ඔබේ විකුණුම්, තොගය සහ ගිණුම් පොත් සැමවිටම එකඟ වේ.' }}</p>
      <div class="feat-ctas fade-in" style="--d:.42s">
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="{{ route('packages.index') }}">පැකේජ සසඳන්න</a>
      </div>
      <ul class="feat-meta fade-in" style="--d:.54s">
        <li><i class="fa-solid fa-check"></i>මාසිකව අය කෙරේ</li>
        <li><i class="fa-solid fa-check"></i>වෙබ් සහ ඩෙස්ක්ටොප්</li>
        @if ($package['pos_lite'])<li><i class="fa-solid fa-check"></i>POS Lite සමඟ ක්‍රියා කරයි</li>@endif
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
      <span class="label">ඇතුළත් දේ</span>
      <h2>{{ $package['name'] }} හි මොඩියුල {{ count($package['features']) }}</h2>
      <p>ඔබේ ව්‍යාපාරය සැකසූ සැණින් සෑම එකක්ම සූදානම්. එය කරන දේ බැලීමට ඕනෑම මොඩියුලයක් විවෘත කරන්න.</p>
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
      <span class="label">තවත් අවශ්‍යද?</span>
      <h2>විශාල පැකේජයකින් තවත් දේ ලබාගන්න</h2>
      <p>මෙම මොඩියුල වෙනත් Zeebroo පැකේජ සමඟ ලැබේ. ඕනෑම වේලාවක උසස් කරන්න, ඔබේ දත්තද ඔබ සමඟම පැමිණේ.</p>
      <a class="btn btn-line" href="{{ route('packages.index') }}">පැකේජ සසඳන්න <i class="fa-solid fa-arrow-right"></i></a>
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
  <nav class="feat-pager" aria-label="තවත් පැකේජ">
    @if ($prev)
      <a href="{{ route('packages.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> පෙර</small><b>{{ $prev['name'] }}</b></a>
    @else
      <span></span>
    @endif
    <a class="feat-pager-all" href="{{ route('packages.index') }}"><i class="fa-solid fa-grip"></i><span>සියලුම පැකේජ</span></a>
    @if ($next)
      <a href="{{ route('packages.show', $next['slug']) }}"><small>ඊළඟ <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['name'] }}</b></a>
    @else
      <span></span>
    @endif
  </nav>
</section>
@endif

@include('frontend.features.partials.cta')
@endsection
