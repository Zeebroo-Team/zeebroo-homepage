@if ($paginator->hasPages())
  <nav class="pager" role="navigation" aria-label="පිටු අංකනය">
    @if ($paginator->onFirstPage())
      <span class="pager-btn off" aria-disabled="true"><i class="fa-solid fa-arrow-left"></i></span>
    @else
      <a class="pager-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="පෙර පිටුව"><i class="fa-solid fa-arrow-left"></i></a>
    @endif

    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="pager-btn off">{{ $element }}</span>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="pager-btn on" aria-current="page">{{ $page }}</span>
          @else
            <a class="pager-btn" href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <a class="pager-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="ඊළඟ පිටුව"><i class="fa-solid fa-arrow-right"></i></a>
    @else
      <span class="pager-btn off" aria-disabled="true"><i class="fa-solid fa-arrow-right"></i></span>
    @endif
  </nav>
@endif
