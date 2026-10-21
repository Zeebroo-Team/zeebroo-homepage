{{-- one partner / client card on /partners. Needs: $partner --}}
<article class="ptn-card">
  <div class="ptn-logo">@include('frontend.partners.partials.logo', ['partner' => $partner])</div>
  <div class="ptn-body">
    <h3>{{ $partner->name }}</h3>
    @if ($partner->tagline)<p class="ptn-tag">{{ $partner->tagline }}</p>@endif
    @if ($partner->description)<p>{{ $partner->description }}</p>@endif
  </div>
  @if ($partner->location || $partner->since_year || $partner->website_url)
    <ul class="ptn-meta">
      @if ($partner->location)<li><i class="fa-solid fa-location-dot"></i>{{ $partner->location }}</li>@endif
      @if ($partner->since_year)<li><i class="fa-solid fa-handshake"></i>{{ $partner->since_year }} සිට</li>@endif
      @if ($partner->website_url)<li><a href="{{ $partner->website_url }}" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-arrow-up-right-from-square"></i>{{ $partner->website_host }}</a></li>@endif
    </ul>
  @endif
</article>
