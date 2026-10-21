<!-- ABOUT: PARTNERS AND CUSTOMER WORDS (hidden when there are none) -->
@if ($partners->isNotEmpty() || $testimonials->isNotEmpty())
<section class="section abt-trust">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">විශ්වාස කරන අය</span>
      <h2>අප මත විශ්වාසය තබන ව්‍යාපාර.</h2>
      <p>තම දවස Zeebroo මත පවත්වාගෙන යන සාප්පු, ආපනශාලා සහ හවුල්කරුවන්, ඔවුන්ගේම වචනවලින්.</p>
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
        <a class="btn btn-line" href="{{ route('partners.index') }}">සියලුම හවුල්කරුවන් සහ ගනුදෙනුකරුවන් <i class="fa-solid fa-arrow-right"></i></a>
      @endif
      @if ($testimonialCount > 0)
        <a class="btn btn-line" href="{{ route('testimonials.index') }}">සමාලෝචන {{ $testimonialCount }} ම කියවන්න <i class="fa-solid fa-arrow-right"></i></a>
      @endif
    </div>
  </div>
</section>
@endif
