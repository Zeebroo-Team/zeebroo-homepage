@if ($feature->capabilities)
<!-- FEATURE CAPABILITIES -->
<section class="section">
  <div class="wrap feat-caps">
    <div class="feat-caps-l reveal">
      <span class="label">මොඩියුලය තුළ</span>
      <h2>{{ $feature->title }} හි ඇති සියල්ල</h2>
      <p>Zeebroo හි අනෙක් සියල්ල සමඟ එකම වේදිකාවේ කොටසක් නිසා, කිසිවක් දෙවරක් ටයිප් කිරීමට අවශ්‍ය නැති අතර සෑම වාර්තාවක්ම එකඟ වේ.</p>
      <a class="btn btn-line" href="{{ route('contact') }}">{{ $feature->title }} ගැන විමසන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <ul class="feat-list reveal">
      @foreach ($feature->capabilities as $cap)
        <li><span><i class="fa-solid fa-check"></i></span>{{ $cap }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif
