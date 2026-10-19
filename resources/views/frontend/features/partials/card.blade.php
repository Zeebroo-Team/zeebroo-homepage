{{-- one feature as a link card; expects $slug and $f --}}
<a class="feat-link reveal" href="{{ route('features.show', $slug) }}">
  <span class="fi"><i class="fa-solid {{ $f['icon'] }}"></i></span>
  <div>
    <b>{{ $f['title'] }}@if ($f['badge']) <span class="badge">{{ $f['badge'] }}</span>@endif</b>
    <small>{{ $f['menu'] }}</small>
  </div>
  <i class="fa-solid fa-arrow-right feat-go"></i>
</a>
