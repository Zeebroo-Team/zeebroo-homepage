@extends('layouts.frontend')

@php
  $heading = $category?->name ?? ($tag ? '#' . $tag->name : null);
@endphp

@section('title', ($heading ? $heading . ' | ' : '') . 'Blog | Zeebroo: news, tips and updates')
@section('description', $category?->description ?: 'News, product updates and practical tips for running your shop, stock, money and people with Zeebroo.')

@push('head')
<link rel="canonical" href="{{ url()->current() }}">
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- BLOG INDEX -->
<section class="blog-index">
  <div class="wrap">
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

    <div class="blog-bar">
      <nav class="blog-cats" aria-label="Blog categories">
        <a href="{{ route('blog.index') }}" @class(['on' => ! $category && ! $tag])>All</a>
        @foreach ($categories as $c)
          <a href="{{ route('blog.category', $c->slug) }}" @class(['on' => $category?->is($c)])>{{ $c->name }} <em>{{ $c->blogs_count }}</em></a>
        @endforeach
        @if ($tag)
          <a href="{{ route('blog.tag', $tag->slug) }}" class="on">#{{ $tag->name }}</a>
        @endif
      </nav>
      <form class="blog-search" method="get" action="{{ url()->current() }}" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="Search posts" aria-label="Search posts">
      </form>
    </div>

    @if ($blogs->isEmpty())
      <div class="blog-empty">
        <span class="fi"><i class="fa-solid fa-newspaper"></i></span>
        <b>No posts {{ $search !== '' ? 'match "' . $search . '"' : 'here yet' }}</b>
        <p>Check back soon, or browse <a href="{{ route('blog.index') }}">all posts</a>.</p>
      </div>
    @else
      <div class="blog-grid">
        @foreach ($blogs as $post)
          @include('frontend.blog.partials.card', ['post' => $post])
        @endforeach
      </div>

      {{ $blogs->links() }}
    @endif
  </div>
</section>
@endsection
