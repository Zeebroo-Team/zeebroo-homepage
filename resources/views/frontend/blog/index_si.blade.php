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

@section('title', ($heading ? $heading . ' | ' : '') . 'බ්ලොග් | Zeebroo: පුවත්, උපදෙස් සහ යාවත්කාලීන කිරීම්')
@section('description', $category?->description ?: 'Zeebroo සමඟ ඔබේ සාප්පුව, තොගය, මුදල් සහ කාර්ය මණ්ඩලය කළමනාකරණය සඳහා පුවත්, නිෂ්පාදන යාවත්කාලීන කිරීම් සහ ප්‍රායෝගික උපදෙස්.')

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
        <span class="label">{{ $tag ? 'ටැගය' : ($category ? 'කාණ්ඩය' : 'බ්ලොග්') }}</span>
        @if ($heading)
          <h1 class="rise"><span class="line"><span>{{ $heading }}</span></span></h1>
          @if ($category?->description)<p class="fade-in">{{ $category->description }}</p>@endif
        @else
          <h1 class="rise"><span class="line"><span>පුවත්, උපදෙස් සහ <span class="mark">යාවත්කාලීන කිරීම්.</span></span></span></h1>
          <p class="fade-in">නිෂ්පාදන පුවත්, ප්‍රායෝගික මාර්ගෝපදේශ සහ Zeebroo මත ක්‍රියාත්මක වන ව්‍යාපාරවල කතා.</p>
        @endif
      </div>
      <form class="blog-search" method="get" action="{{ url()->current() }}" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="{{ $search }}" placeholder="ලිපි සොයන්න" aria-label="ලිපි සොයන්න">
      </form>
    </div>

    <div class="blog-cats-wrap" data-cats>
      <button type="button" class="blog-cats-btn prev" data-cats-step="-1" aria-label="කාණ්ඩ වමට අනුචලනය කරන්න" tabindex="-1"><i class="fa-solid fa-chevron-left"></i></button>
      <nav class="blog-cats" aria-label="බ්ලොග් කාණ්ඩ">
        <a href="{{ route('blog.index') }}" @class(['on' => ! $category && ! $tag])>සියල්ල</a>
        @foreach ($categories as $c)
          <a href="{{ route('blog.category', $c->slug) }}" @class(['on' => $category?->is($c)])>{{ $c->name }} <em>{{ $c->blogs_count }}</em></a>
        @endforeach
        @if ($tag)
          <a href="{{ route('blog.tag', $tag->slug) }}" class="on">#{{ $tag->name }}</a>
        @endif
      </nav>
      <button type="button" class="blog-cats-btn next" data-cats-step="1" aria-label="කාණ්ඩ දකුණට අනුචලනය කරන්න" tabindex="-1"><i class="fa-solid fa-chevron-right"></i></button>
    </div>

    @if ($search !== '' && $blogs->isNotEmpty())
      <p class="blog-result">
        <b>"{{ $search }}"</b> ට ගැළපෙන ලිපි {{ $blogs->total() }}
        <a href="{{ url()->current() }}">සෙවුම ඉවත් කරන්න <i class="fa-solid fa-xmark"></i></a>
      </p>
    @endif

    @if ($blogs->isEmpty())
      <div class="blog-empty">
        <span class="fi"><i class="fa-solid fa-newspaper"></i></span>
        <b>{{ $search !== '' ? '"' . $search . '" ට ගැළපෙන ලිපි නැත' : 'තවම මෙහි ලිපි නැත' }}</b>
        <p>ඉක්මනින් නැවත බලන්න, නැතහොත් <a href="{{ route('blog.index') }}">සියලුම ලිපි</a> බලන්න.</p>
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
          <div class="feat-sec-h blog-more-h"><span>තවත් ලිපි</span><em>{{ $blogs->total() - 3 }}</em></div>
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
