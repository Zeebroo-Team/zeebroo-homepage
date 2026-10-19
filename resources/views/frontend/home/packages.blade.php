@if ($homePackages)
<!-- PACKAGES & PRICING -->
<section class="section" id="pricing">
  <div class="wrap">
    <div class="head reveal">
      <h2>Simple pricing for every stage.</h2>
      <p>Monthly packages that bundle the modules you need. Start small and move up as your business grows.</p>
    </div>
    <div class="pkgs home-pkgs">
      @foreach ($homePackages as $p)
        @php($shown = array_slice($p['features'], 0, 4, true))
        <article class="pkg reveal">
          <div class="pkg-top">
            <div class="pkg-name">
              <h3>{{ $p['name'] }}</h3>
              @if ($p['save'])<span class="pkg-save">Save {{ $p['save'] }}%</span>@endif
            </div>
            <div class="pkg-price">
              <b>{{ $p['price'] }}</b>@unless ($p['is_free'])<span>/month</span>@endunless
            </div>
            @if ($p['was'])<s class="pkg-was">{{ $p['was'] }}/month</s>@endif
            @if ($p['description'])<p>{{ Str::limit($p['description'], 110) }}</p>@endif
          </div>

          <div class="pkg-body">
            <span class="pkg-k">{{ count($p['features']) }} modules included</span>
            <ul>
              @foreach ($shown as $feature)
                <li><span><i class="fa-solid fa-check"></i></span>{{ $feature['label'] }}</li>
              @endforeach
            </ul>
            @if (count($p['features']) > count($shown))
              <span class="pkg-more">+{{ count($p['features']) - count($shown) }} more modules</span>
            @endif
          </div>

          <div class="pkg-btns">
            <a class="btn btn-ink" href="{{ route('packages.show', $p['slug']) }}">View details <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>
      @endforeach
    </div>
    <a class="btn btn-line pkg-home-more" href="{{ route('packages.index') }}">Compare all packages <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>
@endif
