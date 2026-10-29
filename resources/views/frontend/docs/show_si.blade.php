@extends('layouts.frontend')

@section('title', $page['title'] . ' | Zeebroo භාවිත උපදෙස්')
@section('description', $page['description'])

@push('head')
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $page['title'] }} | Zeebroo භාවිත උපදෙස්">
<meta property="og:description" content="{{ $page['description'] }}">
<meta property="og:url" content="{{ route('docs.show', $slug) }}">
<link rel="stylesheet" href="{{ asset('assets/css/docs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/docs.js') }}"></script>
@endpush

@section('content')
<!-- DOCS PAGE -->
<div class="docs-page">
  <div class="wrap docs-layout">
    <aside class="docs-side">
      <details class="docs-side-menu" data-docs-menu>
        <summary><span><i class="fa-solid fa-bars-staggered"></i> පරිච්ඡේද</span><i class="fa-solid fa-chevron-down"></i></summary>
        @include('frontend.docs.partials.sidebar')
      </details>
    </aside>

    <article class="docs-main">
      <header class="docs-head">
        <nav class="docs-crumbs" aria-label="ඔබ සිටින තැන">
          <a href="{{ route('docs.index') }}"><i class="fa-solid fa-arrow-left"></i> භාවිත උපදෙස්</a>
          <i class="fa-solid fa-chevron-right"></i>
          <span>{{ $page['title'] }}</span>
        </nav>
        <div class="docs-head-row">
          <span class="docs-head-ic"><i class="fa-solid {{ $page['icon'] }}"></i></span>
          <span class="docs-head-num">{{ ctype_digit($page['number']) ? 'පරිච්ඡේදය ' . $page['number'] : 'නව යාවත්කාලීන · ' . config('docs.version') }}</span>
        </div>
        <h1>{{ $page['title'] }}</h1>
        <p class="docs-lede">{{ $page['description'] }}</p>
        <div class="docs-meta">
          <span><i class="fa-regular fa-clock"></i>කියවීමට මිනිත්තු {{ $readingMinutes }}ක්</span>
          <span><i class="fa-solid fa-list-ul"></i>මාතෘකා {{ count($page['sections']) }}</span>
          <span><i class="fa-solid fa-circle-check"></i>{{ config('docs.version') }} සඳහා යාවත්කාලීනයි</span>
          <button type="button" class="docs-meta-btn" data-docs-print><i class="fa-solid fa-print"></i>මුද්‍රණය කරන්න</button>
        </div>
        <p class="docs-lang-note"><i class="fa-solid fa-language"></i><span>ඇප් එකේ බොත්තම් සහ මෙනු නම් ඉංග්‍රීසියෙන් ඇති බැවින්, ඔබට පහසුවෙන් සොයාගැනීමට ඒවා මෙහි <b>ඉංග්‍රීසියෙන්ම</b> පෙන්වා ඇත.</span></p>
      </header>

      <div class="doc-prose" data-doc>
        {!! $body !!}
      </div>

      <div class="docs-end">
        <span class="fi"><i class="fa-solid fa-headset"></i></span>
        <div>
          <b>තවමත් ගැටලුවක් තිබේද?</b>
          <p>ඔබ කිරීමට උත්සාහ කළ දේ අපට කියන්න. අපේ සහාය කණ්ඩායම ඔබට පියවරෙන් පියවර උදව් කරයි.</p>
        </div>
        <a class="btn btn-ink" href="{{ route('contact') }}">සහාය ලබාගන්න <i class="fa-solid fa-arrow-right"></i></a>
      </div>

      <nav class="docs-pager" aria-label="පරිච්ඡේද">
        @if ($prev)
          <a class="prev" href="{{ route('docs.show', $prev['slug']) }}"><small><i class="fa-solid fa-arrow-left"></i> පෙර</small><b>{{ $prev['title'] }}</b></a>
        @endif
        @if ($next)
          <a class="next" href="{{ route('docs.show', $next['slug']) }}"><small>ඊළඟ <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next['title'] }}</b></a>
        @endif
      </nav>
    </article>

    <aside class="docs-toc" aria-label="මෙම පිටුවේ">
      <span class="docs-nav-h">මෙම පිටුවේ</span>
      <ol>
        @foreach ($page['sections'] as $anchor => $heading)
          <li><a href="#{{ $anchor }}" data-toc="{{ $anchor }}">{{ $heading }}</a></li>
        @endforeach
      </ol>
      <a class="docs-toc-top" href="#top"><i class="fa-solid fa-arrow-up"></i> ඉහළට යන්න</a>
    </aside>
  </div>
</div>

<dialog class="docs-zoom" id="docsZoom" aria-label="තිර රූපය">
  <button type="button" data-zoom-close aria-label="වසන්න"><i class="fa-solid fa-xmark"></i></button>
  <img src="" alt="">
</dialog>
@endsection
