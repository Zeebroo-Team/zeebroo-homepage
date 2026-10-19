{{-- headline that rises in on load, with the last word highlighted. Use inside <h1 class="rise"> --}}
@php
  $words = explode(' ', trim($text));
  $last = array_pop($words);
@endphp
<span class="line"><span>@if ($words){{ implode(' ', $words) }} @endif<span class="mark">{{ $last }}</span></span></span>
