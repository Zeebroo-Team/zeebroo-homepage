@if ($feature->capabilities)
<!-- FEATURE CAPABILITIES -->
<section class="section">
  <div class="wrap feat-caps">
    <div class="feat-caps-l reveal">
      <span class="label">Inside the module</span>
      <h2>Everything in {{ $feature->title }}</h2>
      <p>Part of the same platform as the rest of Zeebroo, so nothing is typed twice and every report agrees.</p>
      <a class="btn btn-line" href="{{ route('contact') }}">Ask about {{ $feature->title }} <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <ul class="feat-list reveal">
      @foreach ($feature->capabilities as $cap)
        <li><span><i class="fa-solid fa-check"></i></span>{{ $cap }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif
