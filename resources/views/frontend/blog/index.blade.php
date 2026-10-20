@extends('layouts.frontend')

@php
  $heading = $category?->name ?? ($tag ? '#' . $tag->name : null);
  $isFiltered = $category || $tag || $search !== '';
  $posts = $blogs->getCollection();
  $showLead = ! $isFiltered && $blogs->onFirstPage() && $posts->isNotEmpty();
  $lead = $showLead ? $posts->first() : null;
  $side = $showLead ? $posts->slice(1, 2) : collect();
  $rest = $showLead ? $posts->slice(3) : $posts;
@endphp

@section('title', ($heading ? $heading . ' | ' : '') . 'Blog | Zeebroo: news, tips and updates')
@section('description', $category?->description ?: 'News, product updates and practical tips for running your shop, stock, money and people with Zeebroo.')

@push('head')
<link rel="canonical" href="{{ url()->current() }}">
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
<script src="{{ asset('assets/js/blog.js') }}"></script>
@endpush

@section('content')
<!-- BLOG INDEX -->
<section class="blog-index">
  <div class="wrap">
    <div class="blog-top">
      <div class="head">
        <span class="label">{{ $tag ? 'Tag' : ($category ? 'Category' : 'Blog') }}</span>
        @if ($heading)
          <h1 class="rise"><span class="line"><span>{{ $heading }}</span></span></h1>
          @if ($category?->description)<p class="fade-in">{{ $category->description }}</p>@endif
        @else
          <h1 class="rise"><span class="line"><span>News, tips and <span class="mark">updates.</span></span></span></h1>
          <p class="fade-in">Product news, practical guides and stories from businesses that run on Zeebroo.</p>
        @endif
      </div>
      <form class="blog-search" method="get" action="{{ url()->current() }}" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search posts" aria-label="Search posts">
      </form>
    </div>

    <div class="blog-cats-wrap" data-cats>
      <button type="button" class="blog-cats-btn prev" data-cats-step="-1" aria-label="Scroll categories left" tabindex="-1"><i class="fa-solid fa-chevron-left"></i></button>
      <nav class="blog-cats" aria-label="Blog categories">
        <a href="{{ route('blog.index') }}" @class(['on' => ! $category && ! $tag])>All</a>
        @foreach ($categories as $c)
          <a href="{{ route('blog.category', $c->slug) }}" @class(['on' => $category?->is($c)])>{{ $c->name }} <em>{{ $c->blogs_count }}</em></a>
        @endforeach
        @if ($tag)
          <a href="{{ route('blog.tag', $tag->slug) }}" class="on">#{{ $tag->name }}</a>
        @endif
      </nav>
      <button type="button" class="blog-cats-btn next" data-cats-step="1" aria-label="Scroll categories right" tabindex="-1"><i class="fa-solid fa-chevron-right"></i></button>
    </div>

    @if ($search !== '' && $blogs->isNotEmpty())
      <p class="blog-result">
        {{ $blogs->total() }} {{ Str::plural('post', $blogs->total()) }} matching <b>"{{ $search }}"</b>
        <a href="{{ url()->current() }}">Clear search <i class="fa-solid fa-xmark"></i></a>
      </p>
    @endif

    @if ($blogs->isEmpty())
      <div class="blog-empty">
        <span class="fi"><i class="fa-solid fa-newspaper"></i></span>
        <b>No posts {{ $search !== '' ? 'match "' . $search . '"' : 'here yet' }}</b>
        <p>Check back soon, or browse <a href="{{ route('blog.index') }}">all posts</a>.</p>
      </div>
    @else
      @if ($lead)
        <div @class(['blog-lead', 'solo' => $side->isEmpty()])>
          @include('frontend.blog.partials.card', ['post' => $lead, 'variant' => 'lead'])
          @if ($side->isNotEmpty())
            <div class="blog-side">
              @foreach ($side as $post)
                @include('frontend.blog.partials.card', ['post' => $post, 'variant' => 'mini'])
              @endforeach
            </div>
          @endif
        </div>
      @endif

      @if ($rest->isNotEmpty())
        @if ($lead)
          <div class="feat-sec-h blog-more-h"><span>More posts</span><em>{{ $blogs->total() - 3 }}</em></div>
        @endif
        <div class="blog-grid">
          @foreach ($rest as $post)
            @include('frontend.blog.partials.card', ['post' => $post])
          @endforeach
        </div>
      @endif

      {{ $blogs->links() }}
    @endif
  </div>
</section>
@endsection
