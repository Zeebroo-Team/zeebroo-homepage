{{-- one testimonial card, used on the home page and /testimonials. Needs: $testimonial --}}
<figure class="tst-card">
  <div class="tst-stars" role="img" aria-label="{{ $testimonial->rating }} out of 5 stars">
    @for ($i = 1; $i <= \App\Models\Testimonial::MAX_RATING; $i++)
      <i @class(['fa-solid fa-star', 'off' => $i > $testimonial->rating]) aria-hidden="true"></i>
    @endfor
  </div>
  <blockquote>“{{ $testimonial->message }}”</blockquote>
  <figcaption>
    @if ($testimonial->image_url)
      <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" width="48" height="48" loading="lazy">
    @else
      <span class="tst-initials" aria-hidden="true">{{ $testimonial->initials }}</span>
    @endif
    <div>
      <b>{{ $testimonial->name }}</b>
      @if ($testimonial->position)<small>{{ $testimonial->position }}</small>@endif
    </div>
  </figcaption>
</figure>
