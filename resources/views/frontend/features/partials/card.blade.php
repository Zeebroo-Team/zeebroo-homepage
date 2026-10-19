{{-- one feature as a link card; expects $f (App\Models\Feature) --}}
<a class="feat-link reveal" href="{{ route('features.show', $f->slug) }}">
  <span class="fi"><i class="fa-solid {{ $f->icon }}"></i></span>
  <div>
    <b>{{ $f->title }}@if ($f->badge) <span class="badge">{{ $f->badge }}</span>@endif</b>
    <small>{{ $f->menu }}</small>
  </div>
  <i class="fa-solid fa-arrow-right feat-go"></i>
</a>
