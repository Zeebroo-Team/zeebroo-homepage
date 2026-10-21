@extends('layouts.frontend')

@section('title', ($blog->meta_title ?: $blog->title) . ' | Zeebroo ලිපි')
@section('description', $blog->meta_description ?: $blog->excerpt)

@push('head')
<link rel="canonical" href="{{ route('blog.show', $blog->slug) }}">
@if ($blog->meta_keywords)<meta name="keywords" content="{{ $blog->meta_keywords }}">@endif
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
<meta property="og:description" content="{{ $blog->meta_description ?: $blog->excerpt }}">
<meta property="og:url" content="{{ route('blog.show', $blog->slug) }}">
@if ($blog->image_url)<meta property="og:image" content="{{ $blog->image_url }}">@endif
<meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
<meta name="twitter:card" content="{{ $blog->image_url ? 'summary_large_image' : 'summary' }}">
<script type="application/ld+json">{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'BlogPosting',
  'headline' => $blog->title,
  'description' => $blog->meta_description ?: $blog->excerpt,
  'image' => $blog->image_url,
  'datePublished' => $blog->published_at->toIso8601String(),
  'dateModified' => $blog->updated_at->toIso8601String(),
  'author' => ['@type' => 'Person', 'name' => $blog->author_name ?: 'Zeebroo'],
  'publisher' => ['@type' => 'Organization', 'name' => 'Zeebroo'],
  'mainEntityOfPage' => route('blog.show', $blog->slug),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
<script src="{{ asset('assets/js/blog.js') }}"></script>
@endpush

@php
  $postUrl = route('blog.show', $blog->slug);
  $shareLinks = [
      ['label' => 'X හි බෙදාගන්න', 'icon' => 'fa-x-twitter', 'href' => 'https://twitter.com/intent/tweet?' . http_build_query(['url' => $postUrl, 'text' => $blog->title])],
      ['label' => 'LinkedIn හි බෙදාගන්න', 'icon' => 'fa-linkedin-in', 'href' => 'https://www.linkedin.com/sharing/share-offsite/?' . http_build_query(['url' => $postUrl])],
      ['label' => 'Facebook හි බෙදාගන්න', 'icon' => 'fa-facebook-f', 'href' => 'https://www.facebook.com/sharer/sharer.php?' . http_build_query(['u' => $postUrl])],
  ];
  $hasSidebar = $related->isNotEmpty() || $recent->isNotEmpty();
@endphp

@section('content')
<div class="blog-progress" data-progress aria-hidden="true"><span></span></div>

<!-- BLOG POST -->
<div class="blog-post">
  <div class="wrap">
    <header class="blog-post-head">
      <nav class="blog-crumbs" aria-label="පිටු මාර්ගය">
        <a href="{{ route('blog.index') }}"><i class="fa-solid fa-arrow-left"></i> ලිපි</a>
        @if ($blog->category)
          <i class="fa-solid fa-chevron-right"></i>
          <a href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }}</a>
        @endif
      </nav>
      <h1 class="rise"><span class="line"><span>{{ $blog->title }}</span></span></h1>
      @if ($blog->meta_description)<p class="blog-post-lede fade-in">{{ $blog->meta_description }}</p>@endif
      <div class="blog-post-meta fade-in">
        @if ($blog->author_name)
          <span class="blog-author">
            <span class="blog-avatar">{{ Str::upper(Str::substr($blog->author_name, 0, 1)) }}</span>
            <b>{{ $blog->author_name }}</b>
          </span>
        @endif
        <time datetime="{{ $blog->published_at->toDateString() }}">{{ $blog->published_at->translatedFormat('Y F j') }}</time>
        <span>කියවීමට මිනිත්තු {{ $blog->reading_minutes }}</span>
      </div>
    </header>

    <div @class(['blog-post-layout', 'solo' => ! $hasSidebar])>
      <article class="blog-post-main" data-post>
        @if ($blog->image_url)
          <figure class="blog-post-img fade-in"><img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"></figure>
        @endif

        <div class="blog-prose">{!! $blog->description !!}</div>

        <footer class="blog-post-foot">
          @if ($blog->tags->isNotEmpty())
            <div class="blog-tags">
              @foreach ($blog->tags as $t)
                <a href="{{ route('blog.tag', $t->slug) }}">#{{ $t->name }}</a>
              @endforeach
            </div>
          @endif
          <div class="blog-share">
            <span>බෙදාගන්න</span>
            @foreach ($shareLinks as $link)
              <a href="{{ $link['href'] }}" target="_blank" rel="noopener" aria-label="{{ $link['label'] }}"><i class="fa-brands {{ $link['icon'] }}"></i></a>
            @endforeach
            <button type="button" data-copy="{{ $postUrl }}" aria-label="සබැඳිය පිටපත් කරන්න"><i class="fa-solid fa-link"></i><em>පිටපත් විය</em></button>
          </div>
        </footer>
      </article>

      @if ($hasSidebar)
        <aside class="blog-aside">
          @if ($related->isNotEmpty())
            <section class="blog-aside-box">
              <h2 class="blog-aside-h">{{ $blog->category ? 'අදාළ ලිපි' : 'තවත් ලිපි' }}</h2>
              @foreach ($related as $post)
                <a class="blog-aside-post" href="{{ route('blog.show', $post->slug) }}">
                  <span class="blog-aside-art">
                    @if ($post->image_url)
                      <img src="{{ $post->image_url }}" alt="" loading="lazy">
                    @else
                      <i class="fa-solid fa-newspaper"></i>
                    @endif
                  </span>
                  <span class="blog-aside-txt">
                    <b>{{ $post->title }}</b>
                    <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('Y M j') }}</time>
                  </span>
                </a>
              @endforeach
              @if ($blog->category)
                <a class="feat-more" href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }} හි තවත් <i class="fa-solid fa-arrow-right"></i></a>
              @endif
            </section>
          @endif

          @if ($recent->isNotEmpty())
            <section class="blog-aside-box">
              <h2 class="blog-aside-h">මෑත ලිපි</h2>
              <ol class="blog-aside-list">
                @foreach ($recent as $post)
                  <li>
                    <a href="{{ route('blog.show', $post->slug) }}">
                      <b>{{ $post->title }}</b>
                      <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('Y M j') }}</time>
                    </a>
                  </li>
                @endforeach
              </ol>
              <a class="feat-more" href="{{ route('blog.index') }}">සියලුම ලිපි <i class="fa-solid fa-arrow-right"></i></a>
            </section>
          @endif
        </aside>
      @endif
    </div>
  </div>
</div>
@endsection
