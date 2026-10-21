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
              <h3>එකම වේදිකාවක්, සියලුම මොඩියුල</h3>
              <p>සෑම මොඩියුලයක්ම එකම දත්ත බෙදාගන්නා නිසා, මුදල් ලාච්චුව සහ ලෙජරය සැමවිටම එකඟ වේ.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>මොඩියුල සක්‍රිය හෝ අක්‍රිය කරන්න</li>
                <li><i class="fa-solid fa-check"></i>බෙදාගත්, සජීවී දත්ත</li>
                <li><i class="fa-solid fa-check"></i>වෙබ් සහ ඩෙස්ක්ටොප් දෙකෙහිම ක්‍රියා කරයි</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>මොඩියුල</span><a class="mega-all" href="{{ route('features.index') }}">විශේෂාංග {{ $navFeatures->count() }} ම <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid mega-grid-all">
                @foreach ($navFeatures as $f)
                  <a href="{{ route('features.show', $f->slug) }}"><span class="mi"><i class="fa-solid {{ $f->icon }}"></i></span><div><b>{{ $f->title }}@if ($f->badge) <span class="badge">{{ $f->badge }}</span>@endif</b><small>{{ $f->menu }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">විශේෂයෙන් සකස් කළ දෙයක් අවශ්‍යද? <a href="{{ route('contact') }}">අප හා කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-dd" id="indDD">
        <a href="{{ route('industries.index') }}" class="nav-dd-t" aria-haspopup="true">ව්‍යාපාර ක්ෂේත්‍ර <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="ව්‍යාපාර ක්ෂේත්‍ර">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-briefcase"></i></span>
              <span class="mega-k">ව්‍යාපාර ක්ෂේත්‍ර</span>
              <h3>ඔබ වැඩ කරන ආකාරයටම නිර්මාණය කළා</h3>
              <p>Zeebroo ඔබේ ව්‍යාපාරයට ගැලපේ, ඔබ Zeebroo ට ගැලපිය යුතු නැහැ. ඔබට ගැළපෙන දේ බැලීමට ඔබේ ක්ෂේත්‍රය තෝරන්න.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>සූදානම් කළ සැකසුම්</li>
                <li><i class="fa-solid fa-check"></i>ඔබට අවශ්‍ය මොඩියුල පමණයි</li>
                <li><i class="fa-solid fa-check"></i>එක් සාප්පුවක සිට බොහෝ ශාඛා දක්වා වර්ධනය වේ</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>අප සේවය කරන ක්ෂේත්‍ර</span><a class="mega-all" href="{{ route('industries.index') }}">ක්ෂේත්‍ර {{ $navIndustries->count() }} ම <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid">
                @foreach ($navIndustries as $ind)
                  <a href="{{ route('industries.show', $ind->slug) }}"><span class="mi"><i class="fa-solid {{ $ind->icon }}"></i></span><div><b>{{ $ind->title }}@if ($ind->badge) <span class="badge">{{ $ind->badge }}</span>@endif</b><small>{{ $ind->menu }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">ඔබේ ක්ෂේත්‍රය මෙහි නැද්ද? <a href="{{ route('contact') }}">අප හා කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a></div>
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
              <h3>සෑම අදියරකටම පැකේජයක්</h3>
              <p>අද ඔබට අවශ්‍ය මොඩියුල තෝරාගෙන, ව්‍යාපාරය වර්ධනය වන විට විශාල පැකේජයකට මාරු වන්න.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>සරල මාසික ගෙවීම්</li>
                <li><i class="fa-solid fa-check"></i>ඕනෑම වේලාවක උසස් කරන්න</li>
                <li><i class="fa-solid fa-check"></i>වෙබ් සහ ඩෙස්ක්ටොප් ඇතුළත්</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              @inject('packageService', 'App\Services\PackageService')
              @php($megaPackages = $packageService->all())
              <div class="mega-top"><span>පැකේජ</span><a class="mega-all" href="{{ route('packages.index') }}">{{ $megaPackages ? 'පැකේජ ' . count($megaPackages) . ' සසඳන්න' : 'සියලුම පැකේජ සසඳන්න' }} <i class="fa-solid fa-arrow-right"></i></a></div>
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
                <p class="mega-empty">සෑම පැකේජයක්ම සහ එහි ඇතුළත් දේ මිල ගණන් පිටුවෙන් බලන්න.</p>
              @endif
              <div class="mega-foot">විශේෂ සැලැස්මක් අවශ්‍යද? <a href="{{ route('contact') }}">අප හා කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('contact') }}">සම්බන්ධ වන්න</a>
      <div class="nav-dd nav-dd-sm" id="moreDD">
        <button type="button" class="nav-dd-t" aria-haspopup="true" aria-expanded="false">තවත් <i class="fa-solid fa-chevron-down"></i></button>
        <div class="mega mega-sm" role="menu" aria-label="තවත්">
          <div class="mega-in">
            <div class="mega-main">
              <div class="mega-grid">
                <a href="{{ route('home') }}#download"><span class="mi"><i class="fa-solid fa-download"></i></span><div><b>බාගන්න</b><small>ඩෙස්ක්ටොප් POS යෙදුම ලබාගන්න</small></div></a>
                <a href="https://www.zeebroo.com/tutorial"><span class="mi"><i class="fa-solid fa-book-open"></i></span><div><b>මාර්ගෝපදේශ</b><small>උපදෙස් සහ නිබන්ධන</small></div></a>
                <a href="{{ route('about') }}"><span class="mi"><i class="fa-solid fa-building"></i></span><div><b>අප ගැන</b><small>අප කවුද, අප කරන්නේ කුමක්ද</small></div></a>
                <a href="{{ route('partners.index') }}"><span class="mi"><i class="fa-solid fa-handshake"></i></span><div><b>හවුල්කරුවන් සහ ගනුදෙනුකරුවන්</b><small>අප සමඟ වැඩ කරන අය</small></div></a>
                <a href="{{ route('testimonials.index') }}"><span class="mi"><i class="fa-solid fa-comment-dots"></i></span><div><b>ප්‍රතිචාර</b><small>අපේ ගනුදෙනුකරුවන් පවසන දේ</small></div></a>
                <a href="{{ route('blog.index') }}"><span class="mi"><i class="fa-solid fa-newspaper"></i></span><div><b>බ්ලොග්</b><small>පුවත්, උපදෙස් සහ යාවත්කාලීන කිරීම්</small></div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-m-cta">
        <a class="btn btn-line" href="https://platform.zeebroo.com/login">පිවිසෙන්න</a>
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </nav>
    <div class="nav-cta">
      <a class="btn btn-line" href="https://platform.zeebroo.com/login">පිවිසෙන්න</a>
      <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න</a>
    </div>
    <button type="button" class="burger" id="burger" aria-label="මෙනුව විවෘත කරන්න" data-label-open="මෙනුව විවෘත කරන්න" data-label-close="මෙනුව වසන්න" aria-expanded="false" aria-controls="navLinks"><i class="fa-solid fa-bars"></i></button>
  </div>
</header>