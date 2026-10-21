@if ($featuredTestimonials->isNotEmpty())
<!-- TESTIMONIALS -->
<section class="section" id="testimonials">
  <div class="wrap">
    <div class="head reveal">
      <h2>එය භාවිත කරන අය එයට ප්‍රිය කරති.</h2>
      <p>Zeebroo වෙත මාරු වූ පසු වෙනස් වූ දේ ගැන හිමිකරුවන්, කළමනාකරුවන් සහ කණ්ඩායම්.</p>
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
