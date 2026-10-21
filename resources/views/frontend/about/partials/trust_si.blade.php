<!-- ABOUT: PARTNERS AND CUSTOMER WORDS (hidden when there are none) -->
@if ($partners->isNotEmpty() || $testimonials->isNotEmpty())
<section class="section abt-trust">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">අප කෙරෙහි විශ්වාසය</span>
      <h2>Zeebroo භාවිත කරන ව්‍යාපාර.</h2>
      <p>දිනපතා Zeebroo භාවිත කරන වෙළඳසැල්, ආපනශාලා සහ හවුල්කරුවන්ගේ අත්දැකීම්, ඔවුන්ගේම වචනවලින්.</p>
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
        <a class="btn btn-line" href="{{ route('partners.index') }}">සියලුම හවුල්කරුවන් සහ ගනුදෙනුකරුවන් බලන්න <i class="fa-solid fa-arrow-right"></i></a>
      @endif
      @if ($testimonialCount > 0)
        <a class="btn btn-line" href="{{ route('testimonials.index') }}">පාරිභෝගික අදහස් {{ $testimonialCount }}ම කියවන්න <i class="fa-solid fa-arrow-right"></i></a>
      @endif
    </div>
  </div>
</section>
@endif
