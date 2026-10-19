<!-- ABOUT: HERO -->
<section class="abt-hero">
  <div class="wrap">
    <div class="abt-hero-in">
      <div class="head">
        <span class="label">About Zeebroo</span>
        <h1 class="rise"><span class="line"><span>We build the system</span></span><span class="line"><span>behind <span class="mark">busy counters.</span></span></span></h1>
        <p class="fade-in">Zeebroo is one platform for sales, stock, bills, staff and growth. We make it for shop owners, restaurants and growing companies who would rather serve customers than reconcile spreadsheets.</p>
        <div class="abt-hero-ctas fade-in" style="--d:.45s">
          <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Start with Zeebroo <i class="fa-solid fa-arrow-right"></i></a>
          <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-calendar"></i> Book a demo</a>
        </div>
      </div>
      <div class="abt-hero-art fade-in" style="--d:.5s">
        <img src="{{ asset('assets/mascot.webp') }}" alt="Zeebroo mascot: a zebra in a suit holding a briefcase" width="481" height="731">
      </div>
    </div>

    <div class="ptn-stats abt-stats reveal">
      <div><b>{{ $features->count() }}</b><span>Built-in {{ Str::plural('module', $features->count()) }}</span></div>
      <div><b>{{ $industries->count() }}</b><span>{{ Str::plural('Industry', $industries->count()) }} served</span></div>
      @if ($partnerCount > 0)
        <div><b>{{ $partnerCount }}</b><span>Partners &amp; clients</span></div>
      @endif
      @if ($averageRating !== null)
        <div><b>{{ number_format($averageRating, 1) }}<i class="fa-solid fa-star"></i></b><span>Average rating</span></div>
      @else
        <div><b>4</b><span>Platforms: web, Windows, macOS, Linux</span></div>
      @endif
    </div>
  </div>
</section>
