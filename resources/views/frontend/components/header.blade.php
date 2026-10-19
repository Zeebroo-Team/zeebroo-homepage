<header class="nav" id="nav">
  <div class="nav-in">
    <a href="{{ route('home') }}#top" class="logo" aria-label="Zeebroo home"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a>
    <nav class="nav-links" id="navLinks">
      <a href="{{ route('home') }}#product">Product</a>
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
              @php($megaFeatures = collect(config('features')))
              <div class="mega-top"><span>Core modules</span><a class="mega-all" href="{{ route('features.index') }}">All {{ $megaFeatures->count() }} features <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid">
                @foreach ($megaFeatures->where('group', 'core') as $slug => $f)
                  <a href="{{ route('features.show', $slug) }}"><span class="mi"><i class="fa-solid {{ $f['icon'] }}"></i></span><div><b>{{ $f['title'] }}@if ($f['badge']) <span class="badge">{{ $f['badge'] }}</span>@endif</b><small>{{ $f['menu'] }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-top mega-top-2"><span>All included, plus</span></div>
              <div class="mega-suite">
                @foreach ($megaFeatures->where('group', 'suite') as $slug => $f)
                  <a href="{{ route('features.show', $slug) }}"><i class="fa-solid {{ $f['icon'] }}"></i>{{ $f['title'] }}@if ($f['badge']) <span class="new">{{ $f['badge'] }}</span>@endif</a>
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
              @php($megaIndustries = config('industries'))
              <div class="mega-top"><span>Industries we serve</span><a class="mega-all" href="{{ route('industries.index') }}">All {{ count($megaIndustries) }} industries <i class="fa-solid fa-arrow-right"></i></a></div>
              <div class="mega-grid">
                @foreach ($megaIndustries as $slug => $ind)
                  <a href="{{ route('industries.show', $slug) }}"><span class="mi"><i class="fa-solid {{ $ind['icon'] }}"></i></span><div><b>{{ $ind['title'] }}@if ($ind['badge']) <span class="badge">{{ $ind['badge'] }}</span>@endif</b><small>{{ $ind['menu'] }}</small></div></a>
                @endforeach
              </div>
              <div class="mega-foot">Don't see your industry? <a href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('home') }}#download">Download</a>
      <a href="https://www.zeebroo.com/tutorial">Docs</a>
      <a href="{{ route('contact') }}">Contact</a>
    </nav>
    <div class="nav-cta">
      <a class="btn btn-line" href="https://platform.zeebroo.com/login">Sign in</a>
      <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started</a>
    </div>
    <button class="burger" id="burger" aria-label="Open menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
  </div>
</header>