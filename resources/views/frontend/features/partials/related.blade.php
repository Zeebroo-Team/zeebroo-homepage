<!-- RELATED FEATURES -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Works well with</span>
      <h2>Better together</h2>
      <p>{{ $feature['title'] }} shares its data with these modules out of the box.</p>
    </div>
    <div class="feat-grid">
      @foreach ($related as $relSlug => $f)
        @include('frontend.features.partials.card', ['slug' => $relSlug, 'f' => $f])
      @endforeach
    </div>

    <nav class="feat-pager" aria-label="More features">
      <a href="{{ route('features.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> Previous</small><b>{{ $prev['title'] }}</b></a>
      <a class="feat-pager-all" href="{{ route('features.index') }}"><i class="fa-solid fa-grip"></i><span>All features</span></a>
      <a href="{{ route('features.show', $next['slug']) }}"><small>Next <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['title'] }}</b></a>
    </nav>
  </div>
</section>
