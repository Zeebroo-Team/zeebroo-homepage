<!-- ABOUT: PARTNERS AND CUSTOMER WORDS (hidden when there are none) -->
@if ($partners->isNotEmpty() || $testimonials->isNotEmpty())
<section class="section abt-trust">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Trusted by</span>
      <h2>Businesses that count on us.</h2>
      <p>The shops, restaurants and partners who run their day on Zeebroo, in their own words.</p>
    </div>

    @if ($partners->isNotEmpty())
      <ul class="abt-logos reveal">
        @foreach ($partners as $partner)
          <li title="{{ $partner->name }}">
            @include('frontend.partners.partials.logo', ['partner' => $partner])
            <span>{{ $partner->name }}</span>
          </li>
        @endforeach
      </ul>
    @endif

    @if ($testimonials->isNotEmpty())
      <div class="tst-grid">
        @foreach ($testimonials as $testimonial)
          @include('frontend.testimonials.partials.card', ['testimonial' => $testimonial])
        @endforeach
      </div>
    @endif

    <div class="abt-trust-links">
      @if ($partnerCount > 0)
        <a class="btn btn-line" href="{{ route('partners.index') }}">All partners &amp; clients <i class="fa-solid fa-arrow-right"></i></a>
      @endif
      @if ($testimonialCount > 0)
        <a class="btn btn-line" href="{{ route('testimonials.index') }}">Read all {{ $testimonialCount }} {{ Str::plural('review', $testimonialCount) }} <i class="fa-solid fa-arrow-right"></i></a>
      @endif
    </div>
  </div>
</section>
@endif
