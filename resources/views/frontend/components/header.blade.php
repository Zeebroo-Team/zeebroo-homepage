<header class="nav" id="nav">
  <div class="nav-in">
    <a href="{{ route('home') }}#top" class="logo" aria-label="Zeebroo home"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a>
    <nav class="nav-links" id="navLinks">
      <div class="nav-dd" id="modDD">
        <a href="{{ route('features.index') }}" class="nav-dd-t" aria-haspopup="true">Modules <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="Modules">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-layer-group"></i></span>
              <span class="mega-k">Modules</span>
              <h3>One platform, every module</h3>
              <p>Every module shares the same data, so the register and the ledger always agree.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>Turn modules on or off</li>
                <li><i class="fa-solid fa-check"></i>Shared, live data</li>
                <li><i class="fa-solid fa-check"></i>Works on web and desktop</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>Modules</span><a class="mega-all" href="{{ route('features.index') }}">All {{ $navFeatures->count() }} features <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid mega-grid-all">
                @foreach ($navFeatures as $f)
                  <a href="{{ route('features.show', $f->slug) }}"><span class="mi"><i class="fa-solid {{ $f->icon }}"></i></span><div><b>{{ $f->title }}@if ($f->badge) <span class="badge">{{ $f->badge }}</span>@endif</b><small>{{ $f->menu }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">Need something custom? <a href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-dd" id="indDD">
        <a href="{{ route('industries.index') }}" class="nav-dd-t" aria-haspopup="true">Industries <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="Industries">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-briefcase"></i></span>
              <span class="mega-k">Industries</span>
              <h3>Built for the way you work</h3>
              <p>Zeebroo adapts to your business, not the other way round. Pick yours to see what fits.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>Ready-made setups</li>
                <li><i class="fa-solid fa-check"></i>Only the modules you need</li>
                <li><i class="fa-solid fa-check"></i>Grows from one shop to many</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>Industries we serve</span><a class="mega-all" href="{{ route('industries.index') }}">All {{ $navIndustries->count() }} industries <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid">
                @foreach ($navIndustries as $ind)
                  <a href="{{ route('industries.show', $ind->slug) }}"><span class="mi"><i class="fa-solid {{ $ind->icon }}"></i></span><div><b>{{ $ind->title }}@if ($ind->badge) <span class="badge">{{ $ind->badge }}</span>@endif</b><small>{{ $ind->menu }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">Don't see your industry? <a href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-dd" id="pkgDD">
        <a href="{{ route('packages.index') }}" class="nav-dd-t" aria-haspopup="true">Pricing <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="Pricing">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-box-open"></i></span>
              <span class="mega-k">Pricing</span>
              <h3>A package for every stage</h3>
              <p>Pick the modules you need today and move up to a bigger package as you grow.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>Simple monthly billing</li>
                <li><i class="fa-solid fa-check"></i>Upgrade any time</li>
                <li><i class="fa-solid fa-check"></i>Web and desktop included</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              @inject('packageService', 'App\Services\PackageService')
              @php($megaPackages = $packageService->all())
              <div class="mega-top"><span>Packages</span><a class="mega-all" href="{{ route('packages.index') }}">Compare {{ count($megaPackages) ?: 'all' }} packages <i class="fa-solid fa-arrow-right"></i></a></div>
              @if ($megaPackages)
                <div class="mega-grid mega-pkgs">
                  @foreach ($megaPackages as $slug => $p)
                    <a href="{{ route('packages.show', $slug) }}">
                      <b>{{ $p['name'] }}@if ($p['pos_lite']) <span class="badge">POS Lite</span>@endif</b>
                      <span class="mega-price">{{ $p['price'] }}@unless ($p['is_free'])<small>/month</small>@endunless</span>
                      @if ($p['was'])<s>{{ $p['was'] }}</s>@endif
                      <small>{{ count($p['features']) }} modules included</small>
                    </a>
                  @endforeach
                </div>
              @else
                <p class="mega-empty">See every package and what it includes on the pricing page.</p>
              @endif
              <div class="mega-foot">Need a custom plan? <a href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('contact') }}">Contact</a>
      <div class="nav-dd nav-dd-sm" id="moreDD">
        <button type="button" class="nav-dd-t" aria-haspopup="true" aria-expanded="false">More <i class="fa-solid fa-chevron-down"></i></button>
        <div class="mega mega-sm" role="menu" aria-label="More">
          <div class="mega-in">
            <div class="mega-main">
              <div class="mega-grid">
                <a href="{{ route('home') }}#download"><span class="mi"><i class="fa-solid fa-download"></i></span><div><b>Download</b><small>Get the desktop POS app</small></div></a>
                <a href="https://www.zeebroo.com/tutorial"><span class="mi"><i class="fa-solid fa-book-open"></i></span><div><b>Docs</b><small>Guides and tutorials</small></div></a>
                <a href="{{ route('about') }}"><span class="mi"><i class="fa-solid fa-building"></i></span><div><b>About us</b><small>Who we are and what we do</small></div></a>
                <a href="{{ route('partners.index') }}"><span class="mi"><i class="fa-solid fa-handshake"></i></span><div><b>Partners &amp; clients</b><small>Who we work with</small></div></a>
                <a href="{{ route('testimonials.index') }}"><span class="mi"><i class="fa-solid fa-comment-dots"></i></span><div><b>Testimonials</b><small>What our customers say</small></div></a>
                <a href="{{ route('blog.index') }}"><span class="mi"><i class="fa-solid fa-newspaper"></i></span><div><b>Blog</b><small>News, tips and updates</small></div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="nav-m-cta">
        <a class="btn btn-line" href="https://platform.zeebroo.com/login">Sign in</a>
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </nav>
    <div class="nav-cta">
      <a class="btn btn-line" href="https://platform.zeebroo.com/login">Sign in</a>
      <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started</a>
    </div>
    <button type="button" class="burger" id="burger" aria-label="Open menu" aria-expanded="false" aria-controls="navLinks"><i class="fa-solid fa-bars"></i></button>
  </div>
</header>