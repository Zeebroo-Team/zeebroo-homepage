<nav class="docs-nav" aria-label="භාවිත උපදෙස්">
  <a class="docs-nav-home" href="{{ route('docs.index') }}"><i class="fa-solid fa-book-open"></i> සියලු මාර්ගෝපදේශ</a>
  @foreach ($groups as $groupLabel => $pages)
    <div class="docs-nav-group">
      <span class="docs-nav-h">{{ $groupLabel }}</span>
      @foreach ($pages as $pageSlug => $item)
        <a href="{{ route('docs.show', $pageSlug) }}" @class(['on' => $pageSlug === $slug]) @if ($pageSlug === $slug) aria-current="page" @endif>
          <i class="fa-solid {{ $item['icon'] }}"></i>{{ $item['title'] }}
        </a>
      @endforeach
    </div>
  @endforeach
  <a class="docs-nav-pdf" href="{{ asset(config('docs.guide_pdf')) }}" download><i class="fa-solid fa-file-arrow-down"></i> PDF මාර්ගෝපදේශය බාගන්න</a>
  <a class="docs-nav-pdf" href="{{ route('docs.api.index') }}"><i class="fa-solid fa-code"></i> API යොමුව</a>
</nav>
