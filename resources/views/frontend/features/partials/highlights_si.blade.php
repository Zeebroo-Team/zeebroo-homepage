@if ($feature->highlights)
<!-- FEATURE HIGHLIGHTS -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">එය උපකාර වන්නේ ඇයි</span>
      <h2>{{ $feature->title }} ඔබට කරන දේ</h2>
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
