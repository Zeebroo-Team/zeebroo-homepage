<nav class="docs-nav" aria-label="API reference">
  <a class="docs-nav-home" href="{{ route('docs.api.index') }}"><i class="fa-solid fa-code"></i> API overview</a>
  @foreach ($apiGroups as $groupKey => $apiGroup)
    <details class="docs-nav-group docs-nav-fold" @if (isset($resource) && $resource['group'] === $groupKey) open @endif>
      <summary class="docs-nav-h"><i class="fa-solid {{ $apiGroup['icon'] }}"></i>{{ $apiGroup['title'] }}<i class="fa-solid fa-chevron-down"></i></summary>
      @foreach ($apiGroup['resources'] as $resourceSlug => $item)
        <a href="{{ route('docs.api.show', $resourceSlug) }}" @class(['on' => $resourceSlug === ($slug ?? null)]) @if ($resourceSlug === ($slug ?? null)) aria-current="page" @endif>
          {{ $item['title'] }}<em>{{ count($item['endpoints']) }}</em>
        </a>
      @endforeach
    </details>
  @endforeach
  <a class="docs-nav-pdf" href="{{ route('docs.index') }}"><i class="fa-solid fa-book-open"></i> User guide</a>
</nav>
