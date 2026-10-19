<!-- FEATURE HIGHLIGHTS -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Why it helps</span>
      <h2>What {{ $feature['title'] }} does for you</h2>
    </div>
    <div class="feat-cards">
      @foreach ($feature['highlights'] as [$icon, $title, $text])
        <div class="feat-card reveal">
          <span class="fi"><i class="fa-solid {{ $icon }}"></i></span>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
