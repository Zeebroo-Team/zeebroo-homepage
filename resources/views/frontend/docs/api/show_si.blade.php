@extends('layouts.frontend')

@section('title', $resource['title'] . ' API | Zeebroo භාවිත උපදෙස්')
@section('description', $resource['description'])

@push('head')
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $resource['title'] }} API | Zeebroo භාවිත උපදෙස්">
<meta property="og:description" content="{{ $resource['description'] }}">
<meta property="og:url" content="{{ route('docs.api.show', $slug) }}">
<link rel="stylesheet" href="{{ asset('assets/css/docs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/docs.js') }}"></script>
@endpush

@section('content')
<!-- API RESOURCE -->
<div class="docs-page">
  <div class="wrap docs-layout">
    <aside class="docs-side">
      <details class="docs-side-menu" data-docs-menu>
        <summary><span><i class="fa-solid fa-bars-staggered"></i> API සම්පත්</span><i class="fa-solid fa-chevron-down"></i></summary>
        @include('frontend.docs.api.partials.sidebar')
      </details>
    </aside>

    <article class="docs-main">
      <header class="docs-head">
        <nav class="docs-crumbs" aria-label="ඔබ සිටින තැන">
          <a href="{{ route('docs.index') }}"><i class="fa-solid fa-arrow-left"></i> භාවිත උපදෙස්</a>
          <i class="fa-solid fa-chevron-right"></i>
          <a href="{{ route('docs.api.index') }}">API</a>
          <i class="fa-solid fa-chevron-right"></i>
          <span>{{ $group['title'] }}</span>
        </nav>
        <div class="docs-head-row">
          <span class="docs-head-ic"><i class="fa-solid {{ $group['icon'] }}"></i></span>
          <span class="docs-head-num">{{ $group['label'] }}</span>
        </div>
        <h1>{{ $resource['title'] }}</h1>
        <p class="docs-lede">{{ $resource['description'] }}</p>
        <p class="docs-lang-note"><i class="fa-solid fa-language"></i><span>endpoint විස්තර, පරාමිති සහ කේත නියැදි ඉංග්‍රීසියෙන් තබා ඇත්තේ ඒවා කේතය සමඟ සෘජුවම භාවිත කරන බැවිනි.</span></p>
      </header>

      <div class="doc-prose doc-api" data-doc>
        @include('frontend.docs.api.resources.' . $slug)
      </div>

      <nav class="docs-pager" aria-label="සම්පත්">
        @if ($prev)
          <a class="prev" href="{{ route('docs.api.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> පෙර</small><b>{{ $prev['title'] }}</b></a>
        @endif
        @if ($next)
          <a class="next" href="{{ route('docs.api.show', $next['slug']) }}"><small>ඊළඟ <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['title'] }}</b></a>
        @endif
      </nav>
    </article>

    <aside class="docs-toc" aria-label="මෙම පිටුවේ endpoint">
      <span class="docs-nav-h">Endpoints</span>
      <ol class="docs-toc-api">
        @foreach ($resource['endpoints'] as $anchor => [$method, $path, $name])
          <li><a href="#{{ $anchor }}" data-toc="{{ $anchor }}"><span class="method-badge method-{{ Str::lower(Str::before($method, '/')) }}">{{ Str::before($method, '/') }}</span>{{ $name }}</a></li>
        @endforeach
      </ol>
      <a class="docs-toc-top" href="#top"><i class="fa-solid fa-arrow-up"></i> ඉහළට යන්න</a>
    </aside>
  </div>
</div>
@endsection
