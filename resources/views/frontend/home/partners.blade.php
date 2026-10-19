@if ($featuredPartners->isNotEmpty())
<!-- PARTNERS -->
<section class="section" id="partners">
  <div class="wrap">
    <div class="head reveal">
      <h2>Trusted by businesses and partners.</h2>
      <p>The companies we build with, and the businesses that run on Zeebroo every day.</p>
    </div>
    <div class="ptn-strip reveal">
      <div class="ptn-track">
        @foreach ([false, true] as $copy)
          <ul class="ptn-row" @if ($copy) aria-hidden="true" @endif>
            @foreach ($featuredPartners as $partner)
              <li title="{{ $partner->name }}">
                @include('frontend.partners.partials.logo', ['partner' => $partner])
                <span>{{ $partner->name }}</span>
              </li>
            @endforeach
          </ul>
        @endforeach
      </div>
    </div>
    <a class="btn btn-line ptn-more" href="{{ route('partners.index') }}">See all partners &amp; clients <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>
@endif
