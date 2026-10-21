<header class="nav" id="nav">
  <div class="nav-in">
    <a href="{{ route('home') }}#top" class="logo" aria-label="Zeebroo මුල් පිටුව"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a>
    <nav class="nav-links" id="navLinks">
      <div class="nav-dd" id="modDD">
        <a href="{{ route('features.index') }}" class="nav-dd-t" aria-haspopup="true">මොඩියුල <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="මොඩියුල">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-layer-group"></i></span>
              <span class="mega-k">මොඩියුල</span>
              <h3>ඔබේ ව්‍යාපාරයට අවශ්‍ය සියල්ල එකම තැනක</h3>
              <p>සියලුම මොඩියුල එකම දත්ත භාවිත කරන නිසා, ඔබේ කැෂියර් ලාච්චුවේ මුදලුයි ගිණුම් පොතේ ගණනුයි හැමවිටම ගැලපෙනවා.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>ඔබට අවශ්‍ය මොඩියුල පමණක් ක්‍රියාත්මක කරගන්න</li>
                <li><i class="fa-solid fa-check"></i>හැමවිටම යාවත්කාලීන වන දත්ත</li>
                <li><i class="fa-solid fa-check"></i>වෙබ් එකේ සහ පරිගණකයේ දෙකේම භාවිත කළ හැකියි</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">දැන්ම පටන් ගන්න <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>මොඩියුල</span><a class="mega-all" href="{{ route('features.index') }}">සියල්ල බලන්න ({{ $navFeatures->count() }}) <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid mega-grid-all">
                @foreach ($navFeatures as $f)
                  <a href="{{ route('features.show', $f->slug) }}"><span class="mi"><i class="fa-solid {{ $f->icon }}"></i></span><div><b>{{ $f->title }}@if ($f->badge) <span class="badge">{{ $f->badge }}</span>@endif</b><small>{{ $f->menu }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">ඔබේ ව්‍යාපාරයටම ගැලපෙන විදියට සකස් කරගන්න ඕනෙද? <a href="{{ route('contact') }}">අපට කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-dd" id="indDD">
        <a href="{{ route('industries.index') }}" class="nav-dd-t" aria-haspopup="true">ව්‍යාපාර වර්ග <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="ව්‍යාපාර වර්ග">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-briefcase"></i></span>
              <span class="mega-k">ව්‍යාපාර වර්ග</span>
              <h3>ඔබ වැඩ කරන විදියටම හදපු පද්ධතියක්</h3>
              <p>ඔබ Zeebroo එකට හැඩගැසෙන්න ඕනේ නැහැ, Zeebroo ඔබේ ව්‍යාපාරයට හැඩගැසෙනවා. ඔබේ ව්‍යාපාර වර්ගය තෝරලා ඔබට ගැලපෙන දේ බලන්න.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>ඉක්මනින් පටන් ගන්න කලින්ම සකස් කළ සැකසුම්</li>
                <li><i class="fa-solid fa-check"></i>ඔබට අවශ්‍ය දේ පමණයි</li>
                <li><i class="fa-solid fa-check"></i>එක කඩයක සිට ශාඛා ගණනාවක් දක්වා ඔබ සමඟම වැඩෙනවා</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">දැන්ම පටන් ගන්න <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>අපි සහාය දෙන ව්‍යාපාර</span><a class="mega-all" href="{{ route('industries.index') }}">සියල්ල බලන්න ({{ $navIndustries->count() }}) <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid">
                @foreach ($navIndustries as $ind)
                  <a href="{{ route('industries.show', $ind->slug) }}"><span class="mi"><i class="fa-solid {{ $ind->icon }}"></i></span><div><b>{{ $ind->title }}@if ($ind->badge) <span class="badge">{{ $ind->badge }}</span>@endif</b><small>{{ $ind->menu }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">ඔබේ ව්‍යාපාරය මෙතන නැද්ද? <a href="{{ route('contact') }}">අපට කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-dd" id="pkgDD">
        <a href="{{ route('packages.index') }}" class="nav-dd-t" aria-haspopup="true">මිල ගණන් <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="මිල ගණන්">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-box-open"></i></span>
              <span class="mega-k">මිල ගණන්</span>
              <h3>ඔබේ ව්‍යාපාරයේ හැම පියවරකටම ගැලපෙන පැකේජයක්</h3>
              <p>අද ඔබට අවශ්‍ය දේ පමණක් තෝරාගන්න. ව්‍යාපාරය වැඩෙනකොට ලොකු පැකේජයකට මාරු වෙන්න.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>සරල මාසික ගෙවීම්</li>
                <li><i class="fa-solid fa-check"></i>ඕනෑම වෙලාවක ඉහළ පැකේජයකට මාරු වෙන්න</li>
                <li><i class="fa-solid fa-check"></i>වෙබ් සහ පරිගණක යෙදුම දෙකම ඇතුළත්</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">දැන්ම පටන් ගන්න <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              @inject('packageService', 'App\Services\PackageService')
              @php($megaPackages = $packageService->all())
              <div class="mega-top"><span>පැකේජ</span><a class="mega-all" href="{{ route('packages.index') }}">{{ $megaPackages ? 'පැකේජ ' . count($megaPackages) . ' සසඳා බලන්න' : 'සියලුම පැකේජ සසඳා බලන්න' }} <i class="fa-solid fa-arrow-right"></i></a></div>
              @if ($megaPackages)
                <div class="mega-grid mega-pkgs">
                  @foreach ($megaPackages as $slug => $p)
                    <a href="{{ route('packages.show', $slug) }}">
                      <b>{{ $p['name'] }}@if ($p['pos_lite']) <span class="badge">POS Lite</span>@endif</b>
                      <span class="mega-price">{{ $p['price'] }}@unless ($p['is_free'])<small>/මසකට</small>@endunless</span>
                      @if ($p['was'])<s>{{ $p['was'] }}</s>@endif
                      <small>මොඩියුල {{ count($p['features']) }} ක් ඇතුළත්</small>
                    </a>
                  @endforeach
                </div>
              @else
                <p class="mega-empty">සියලුම පැකේජ සහ ඒවායේ ලැබෙන දේ මිල ගණන් පිටුවෙන් බලන්න.</p>
              @endif
              <div class="mega-foot">ඔබටම ගැලපෙන විශේෂ පැකේජයක් ඕනෙද? <a href="{{ route('contact') }}">අපට කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('contact') }}">අපව අමතන්න</a>
      <div class="nav-dd nav-dd-sm" id="moreDD">
        <button type="button" class="nav-dd-t" aria-haspopup="true" aria-expanded="false">තවත් <i class="fa-solid fa-chevron-down"></i></button>
        <div class="mega mega-sm" role="menu" aria-label="තවත්">
          <div class="mega-in">
            <div class="mega-main">
              <div class="mega-grid">
                <a href="{{ route('home') }}#download"><span class="mi"><i class="fa-solid fa-download"></i></span><div><b>බාගන්න</b><small>පරිගණකයට POS යෙදුම ලබාගන්න</small></div></a>
                <a href="https://www.zeebroo.com/tutorial"><span class="mi"><i class="fa-solid fa-book-open"></i></span><div><b>භාවිත කරන හැටි</b><small>පියවරෙන් පියවර උපදෙස්</small></div></a>
                <a href="{{ route('about') }}"><span class="mi"><i class="fa-solid fa-building"></i></span><div><b>අපි ගැන</b><small>අපි කවුද, අපි කරන්නේ මොනවාද</small></div></a>
                <a href="{{ route('partners.index') }}"><span class="mi"><i class="fa-solid fa-handshake"></i></span><div><b>හවුල්කරුවන් සහ ගනුදෙනුකරුවන්</b><small>අපිත් එක්ක එකට වැඩ කරන අය</small></div></a>
                <a href="{{ route('testimonials.index') }}"><span class="mi"><i class="fa-solid fa-comment-dots"></i></span><div><b>පාරිභෝගික අදහස්</b><small>අපේ පාරිභෝගිකයන් කියන දේ</small></div></a>
                <a href="{{ route('blog.index') }}"><span class="mi"><i class="fa-solid fa-newspaper"></i></span><div><b>බ්ලොග්</b><small>පුවත්, උපදෙස් සහ අලුත් තොරතුරු</small></div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-m-cta">
        <a class="btn btn-line" href="https://platform.zeebroo.com/login">පිවිසෙන්න</a>
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">දැන්ම පටන් ගන්න <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </nav>
    <div class="nav-cta">
      <a class="btn btn-line" href="https://platform.zeebroo.com/login">පිවිසෙන්න</a>
      <a class="btn btn-ink" href="https://platform.zeebroo.com/register">පටන් ගන්න</a>
    </div>
    <button type="button" class="burger" id="burger" aria-label="මෙනුව විවෘත කරන්න" data-label-open="මෙනුව විවෘත කරන්න" data-label-close="මෙනුව වසන්න" aria-expanded="false" aria-controls="navLinks"><i class="fa-solid fa-bars"></i></button>
  </div>
</header>
