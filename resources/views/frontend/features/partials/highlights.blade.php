@if ($feature->highlights)
<!-- FEATURE HIGHLIGHTS -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Why it helps</span>
      <h2>What {{ $feature->title }} does for you</h2>
    </div>
    <div class="feat-cards">
      @foreach ($feature->highlights as $h)
        <div class="feat-card reveal">
          <span class="fi"><i class="fa-solid {{ $h['icon'] }}"></i></span>
          <h3>{{ $h['title'] }}</h3>
          @if ($h['text'])<p>{{ $h['text'] }}</p>@endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
