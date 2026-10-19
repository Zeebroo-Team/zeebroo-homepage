<!-- FEATURE HERO -->
<section class="feat-hero">
  <div class="wrap feat-hero-grid">
    <div class="feat-copy">
      <nav class="crumbs" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a><i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('features.index') }}">Features</a><i class="fa-solid fa-chevron-right"></i>
        <span aria-current="page">{{ $feature['title'] }}</span>
      </nav>
      <span class="feat-tag"><i class="fa-solid {{ $feature['icon'] }}"></i>{{ $feature['title'] }}@if ($feature['badge']) <em>{{ $feature['badge'] }}</em>@endif</span>
      <h1>{{ $feature['headline'] }}</h1>
      <p class="feat-lead">{{ $feature['lead'] }}</p>
      <div class="feat-ctas">
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-envelope"></i> Book a demo</a>
      </div>
      <ul class="feat-meta">
        <li><i class="fa-solid fa-check"></i>{{ $feature['group'] === 'core' ? 'Core module' : 'Included in Zeebroo' }}</li>
        <li><i class="fa-solid fa-check"></i>Web and desktop</li>
        <li><i class="fa-solid fa-check"></i>Shared, live data</li>
      </ul>
    </div>

    <div class="feat-art" aria-hidden="true">
      @if ($feature['spot'])
        <img src="{{ asset('assets/features/' . $feature['spot']) }}" alt="" width="344" height="347" fetchpriority="high">
      @else
        {{-- no spot illustration: the module icon with its three highlights orbiting it --}}
        <div class="feat-orbit">
          <span class="feat-orbit-ic"><i class="fa-solid {{ $feature['icon'] }}"></i></span>
          @foreach ($feature['highlights'] as [$icon, $title])
            <span class="feat-chip feat-chip-{{ $loop->iteration }}"><i class="fa-solid {{ $icon }}"></i>{{ $title }}</span>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
