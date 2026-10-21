@if ($featuredTestimonials->isNotEmpty())
<!-- TESTIMONIALS -->
<section class="section" id="testimonials">
  <div class="wrap">
    <div class="head reveal">
      <h2>Zeebroo භාවිත කරන්නන් එයට ඇත්තටම ප්‍රිය කරනවා.</h2>
      <p>Zeebroo වෙත මාරු වීමෙන් පසු තම ව්‍යාපාරයේ ඇති වූ වෙනස ගැන ව්‍යාපාර හිමිකරුවන්, කළමනාකරුවන් සහ කාර්ය මණ්ඩල පවසන දේ.</p>
    </div>
    <div class="tst-grid reveal">
      @foreach ($featuredTestimonials as $testimonial)
        @include('frontend.testimonials.partials.card', ['testimonial' => $testimonial])
      @endforeach
    </div>
    <a class="btn btn-line tst-more" href="{{ route('testimonials.index') }}">සියලුම ප්‍රතිචාර කියවන්න <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>
@endif
