@if ($feature->capabilities)
<!-- FEATURE CAPABILITIES -->
<section class="section">
  <div class="wrap feat-caps">
    <div class="feat-caps-l reveal">
      <span class="label">මොඩියුලයේ අඩංගු දේ</span>
      <h2>{{ $feature->title }} මගින් ලැබෙන පහසුකම්</h2>
      <p>මෙය Zeebroo හි අනෙකුත් මොඩියුල සමඟ එකම පද්ධතියේ කොටසක් බැවින්, කිසිදු තොරතුරක් දෙවරක් ඇතුළත් කිරීමට අවශ්‍ය නැත. සියලුම වාර්තා එකිනෙකට ගැළපේ.</p>
      <a class="btn btn-line" href="{{ route('contact') }}">{{ $feature->title }} පිළිබඳ විමසන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <ul class="feat-list reveal">
      @foreach ($feature->capabilities as $cap)
        <li><span><i class="fa-solid fa-check"></i></span>{{ $cap }}</li>
      @endforeach
    </ul>
  </div>
</section>
@endif
