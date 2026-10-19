<!-- ABOUT: WHAT WE BUILD / WHO WE SERVE -->
@if ($features->isNotEmpty() || $industries->isNotEmpty())
<section class="section abt-platform">
  <div class="wrap">
    @if ($features->isNotEmpty())
      <div class="abt-split abt-split-h reveal">
        <div>
          <span class="label">What we build</span>
          <h2>Everything a business runs on.</h2>
        </div>
        <p>{{ $features->count() }} {{ Str::plural('module', $features->count()) }}, one login, one set of numbers. Turn on only what you need today and switch on the rest as you grow.</p>
      </div>
      <div class="abt-chips">
        @foreach ($features as $feature)
          <a class="abt-chip reveal" href="{{ route('features.show', $feature->slug) }}">
            <span class="mi"><i class="fa-solid {{ $feature->icon }}"></i></span>
            <div><b>{{ $feature->title }}</b><small>{{ $feature->menu }}</small></div>
            <i class="fa-solid fa-arrow-right abt-go"></i>
          </a>
        @endforeach
      </div>
    @endif

    @if ($industries->isNotEmpty())
      <div class="abt-split abt-split-h abt-ind-h reveal">
        <div>
          <span class="label">Who we serve</span>
          <h2>Made for the way you work.</h2>
        </div>
        <p>Ready-made setups for {{ $industries->count() }} {{ Str::plural('industry', $industries->count()) }}, so you start with the right modules switched on from the first day.</p>
      </div>
      <div class="abt-inds">
        @foreach ($industries as $industry)
          <a class="abt-ind reveal" href="{{ route('industries.show', $industry->slug) }}">
            <i class="fa-solid {{ $industry->icon }}"></i>{{ $industry->title }}
          </a>
        @endforeach
        <a class="abt-ind is-more reveal" href="{{ route('contact') }}"><i class="fa-solid fa-plus"></i>Don't see yours? Talk to us</a>
      </div>
    @endif
  </div>
</section>
@endif
