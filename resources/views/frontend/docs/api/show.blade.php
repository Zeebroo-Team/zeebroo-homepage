@extends('layouts.frontend')

@section('title', $resource['title'] . ' API | Zeebroo Docs')
@section('description', $resource['description'])

@push('head')
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $resource['title'] }} API | Zeebroo Docs">
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
        <summary><span><i class="fa-solid fa-bars-staggered"></i> API resources</span><i class="fa-solid fa-chevron-down"></i></summary>
        @include('frontend.docs.api.partials.sidebar')
      </details>
    </aside>

    <article class="docs-main">
      <header class="docs-head">
        <nav class="docs-crumbs" aria-label="Breadcrumb">
          <a href="{{ route('docs.index') }}"><i class="fa-solid fa-arrow-left"></i> Docs</a>
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
      </header>

      <div class="doc-prose doc-api" data-doc>
        @include('frontend.docs.api.resources.' . $slug)
      </div>

      <nav class="docs-pager" aria-label="Resources">
        @if ($prev)
          <a class="prev" href="{{ route('docs.api.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> Previous</small><b>{{ $prev['title'] }}</b></a>
        @endif
        @if ($next)
          <a class="next" href="{{ route('docs.api.show', $next['slug']) }}"><small>Next <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['title'] }}</b></a>
        @endif
      </nav>
    </article>

    <aside class="docs-toc" aria-label="Endpoints on this page">
      <span class="docs-nav-h">Endpoints</span>
      <ol class="docs-toc-api">
        @foreach ($resource['endpoints'] as $anchor => [$method, $path, $name])
          <li><a href="#{{ $anchor }}" data-toc="{{ $anchor }}"><span class="method-badge method-{{ Str::lower(Str::before($method, '/')) }}">{{ Str::before($method, '/') }}</span>{{ $name }}</a></li>
        @endforeach
      </ol>
      <a class="docs-toc-top" href="#top"><i class="fa-solid fa-arrow-up"></i> Back to top</a>
    </aside>
  </div>
</div>
@endsection
