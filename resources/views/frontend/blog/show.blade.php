@extends('layouts.frontend')

@section('title', ($blog->meta_title ?: $blog->title) . ' | Zeebroo Blog')
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
@endpush

@section('content')
<!-- BLOG POST -->
<article class="blog-post">
  <div class="wrap">
    <header class="blog-post-head">
      <a class="blog-back" href="{{ route('blog.index') }}"><i class="fa-solid fa-arrow-left"></i> All posts</a>
      @if ($blog->category)
        <a class="chip" href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }}</a>
      @endif
      <h1 class="rise"><span class="line"><span>{{ $blog->title }}</span></span></h1>
      <div class="blog-post-meta fade-in">
        @if ($blog->author_name)<span><i class="fa-regular fa-user"></i>{{ $blog->author_name }}</span>@endif
        <span><i class="fa-regular fa-calendar"></i><time datetime="{{ $blog->published_at->toDateString() }}">{{ $blog->published_at->format('F j, Y') }}</time></span>
        <span><i class="fa-regular fa-clock"></i>{{ $blog->reading_minutes }} min read</span>
      </div>
    </header>

    @if ($blog->image_url)
      <figure class="blog-post-img fade-in"><img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"></figure>
    @endif

    <div class="blog-prose">{!! $blog->description !!}</div>

    @if ($blog->tags->isNotEmpty())
      <div class="blog-tags">
        @foreach ($blog->tags as $t)
          <a href="{{ route('blog.tag', $t->slug) }}">#{{ $t->name }}</a>
        @endforeach
      </div>
    @endif
  </div>
</article>

@if ($related->isNotEmpty())
  <section class="blog-related">
    <div class="wrap">
      <div class="feat-sec-h"><span>Keep reading</span><em>{{ $related->count() }}</em></div>
      <div class="blog-grid">
        @foreach ($related as $post)
          @include('frontend.blog.partials.card', ['post' => $post])
        @endforeach
      </div>
    </div>
  </section>
@endif
@endsection
