{{-- every active industry as a link tile; used on the home page and /industries --}}
<div class="inds reveal">
  @foreach ($navIndustries as $ind)
    <a class="ind" href="{{ route('industries.show', $ind->slug) }}"><span class="ii"><i class="fa-solid {{ $ind->icon }}"></i></span><div><h3>{{ $ind->title }}@if ($ind->badge) <span class="badge">{{ $ind->badge }}</span>@endif</h3><p>{{ $ind->menu }}</p></div></a>
  @endforeach
</div>
