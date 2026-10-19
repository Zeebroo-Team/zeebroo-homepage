@if ($featuredTestimonials->isNotEmpty())
<!-- TESTIMONIALS -->
<section class="section" id="testimonials">
  <div class="wrap">
    <div class="head reveal">
      <h2>Loved by the people who use it.</h2>
      <p>Owners, managers and teams on what changed after moving to Zeebroo.</p>
    </div>
    <div class="tst-grid reveal">
      @foreach ($featuredTestimonials as $testimonial)
        @include('frontend.testimonials.partials.card', ['testimonial' => $testimonial])
      @endforeach
    </div>
    <a class="btn btn-line tst-more" href="{{ route('testimonials.index') }}">Read all testimonials <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>
@endif
