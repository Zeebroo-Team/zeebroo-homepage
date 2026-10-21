@if ($homePackages)
<!-- PACKAGES & PRICING -->
<section class="section" id="pricing">
  <div class="wrap">
    <div class="head reveal">
      <h2>කුඩා හෝ විශාල ඕනෑම ව්‍යාපාරයකට ගැළපෙන සරල මිල ගණන්.</h2>
      <p>ඔබට අවශ්‍ය සියලුම මොඩියුල එකම පැකේජයකට ඇතුළත් මාසික සැලසුම්. කුඩා පැකේජයකින් ආරම්භ කර, ව්‍යාපාරය වර්ධනය වන විට ඉහළ පැකේජයකට මාරු වන්න.</p>
    </div>
    <div class="pkgs home-pkgs">
      @foreach ($homePackages as $p)
        @php($shown = array_slice($p['features'], 0, 4, true))
        <article class="pkg reveal">
          <div class="pkg-top">
            <div class="pkg-name">
              <h3>{{ $p['name'] }}</h3>
              @if ($p['save'])<span class="pkg-save">{{ $p['save'] }}% ඉතිරියි</span>@endif
            </div>
            <div class="pkg-price">
              <b>{{ $p['price'] }}</b>@unless ($p['is_free'])<span>/මසකට</span>@endunless
            </div>
            @if ($p['was'])<s class="pkg-was">{{ $p['was'] }}/මසකට</s>@endif
            @if ($p['description'])<p>{{ Str::limit($p['description'], 110) }}</p>@endif
          </div>

          <div class="pkg-body">
            <span class="pkg-k">මොඩියුල {{ count($p['features']) }} ක් ඇතුළත් වේ</span>
            <ul>
              @foreach ($shown as $feature)
                <li><span><i class="fa-solid fa-check"></i></span>{{ $feature['label'] }}</li>
              @endforeach
            </ul>
            @if (count($p['features']) > count($shown))
              <span class="pkg-more">+ තවත් මොඩියුල {{ count($p['features']) - count($shown) }} ක්</span>
            @endif
          </div>

          <div class="pkg-btns">
            <a class="btn btn-ink" href="{{ route('packages.show', $p['slug']) }}">විස්තර බලන්න <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>
      @endforeach
    </div>
    <a class="btn btn-line pkg-home-more" href="{{ route('packages.index') }}">සියලුම පැකේජ සසඳා බලන්න <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>
@endif
