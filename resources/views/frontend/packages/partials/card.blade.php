{{-- one package as a pricing card; expects $p --}}
@php($shown = array_slice($p['features'], 0, 6, true))
<article class="pkg reveal">
  <div class="pkg-top">
    <div class="pkg-name">
      <h3>{{ $p['name'] }}</h3>
      @if ($p['save'])<span class="pkg-save">Save {{ $p['save'] }}%</span>@endif
    </div>
    @if ($p['pos_lite'])<span class="pkg-tag"><i class="fa-solid fa-desktop"></i>Works with POS Lite</span>@endif
    <div class="pkg-price">
      <b>{{ $p['price'] }}</b>@unless ($p['is_free'])<span>/month</span>@endunless
    </div>
    @if ($p['was'])<s class="pkg-was">{{ $p['was'] }}/month</s>@endif
    @if ($p['description'])<p>{{ $p['description'] }}</p>@endif
  </div>

  <div class="pkg-body">
    <span class="pkg-k">{{ count($p['features']) }} modules included</span>
    <ul>
      @foreach ($shown as $feature)
        <li><span><i class="fa-solid fa-check"></i></span>{{ $feature['label'] }}</li>
      @endforeach
    </ul>
    @if (count($p['features']) > count($shown))
      <a class="pkg-more" href="{{ route('packages.show', $p['slug']) }}">+{{ count($p['features']) - count($shown) }} more modules</a>
    @endif
  </div>

  <div class="pkg-btns">
    <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
    <a class="btn btn-line" href="{{ route('packages.show', $p['slug']) }}">Details</a>
  </div>
</article>
