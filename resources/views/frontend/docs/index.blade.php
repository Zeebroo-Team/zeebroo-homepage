@extends('layouts.frontend')

@section('title', 'Docs | Zeebroo POS user guide')
@section('description', 'Step-by-step guides for the Zeebroo POS desktop app: setup, selling, returns, stock, finance, HR, design studio, restaurants and settings.')

@push('head')
<link rel="stylesheet" href="{{ asset('assets/css/docs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
<script src="{{ asset('assets/js/docs.js') }}"></script>
@endpush

@section('content')
<!-- DOCS INDEX -->
<section class="docs-index">
  <div class="wrap">
    <div class="docs-top">
      <div class="head">
        <span class="label">Docs · {{ config('docs.version') }}</span>
        <h1 class="rise"><span class="line"><span>Learn Zeebroo, step by <span class="mark">step.</span></span></span></h1>
        <p class="fade-in">Everything you need to set up, run and grow your business on the Zeebroo POS desktop app, from your first login to daily restaurant orders, payroll and beyond.</p>
      </div>
      <form class="docs-search fade-in" role="search" onsubmit="return false">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" placeholder="Search the guide, e.g. return or barcode" aria-label="Search the user guide" data-search-input>
        <kbd class="docs-search-key" aria-hidden="true">/</kbd>
      </form>
    </div>

    <ul class="docs-facts fade-in">
      <li><i class="fa-solid fa-book-open"></i><b>{{ $pageCount }}</b> guides</li>
      <li><i class="fa-solid fa-desktop"></i>Windows &amp; macOS desktop app</li>
      <li><i class="fa-solid fa-image"></i>Real screenshots</li>
      <li><i class="fa-solid fa-keyboard"></i>Keyboard shortcuts included</li>
    </ul>

    <div class="docs-start reveal" data-search-intro>
      <div class="docs-start-h">
        <span class="label">New to Zeebroo?</span>
        <b>Up and running in three steps</b>
        <p>Follow these in order and you'll be ready to serve your first customer today.</p>
      </div>
      <ol class="docs-start-steps">
        <li>
          <a href="{{ route('download') }}">
            <span class="docs-start-num">1</span>
            <span><b>Install the app</b><small>Download Zeebroo POS for Windows or macOS.</small></span>
          </a>
        </li>
        <li>
          <a href="{{ route('docs.show', 'getting-started') }}#creating-your-account">
            <span class="docs-start-num">2</span>
            <span><b>Create your account</b><small>Register, pick your industry and turn on the features you need.</small></span>
          </a>
        </li>
        <li>
          <a href="{{ route('docs.show', 'point-of-sale') }}#starting-a-sale">
            <span class="docs-start-num">3</span>
            <span><b>Make your first sale</b><small>Add items to the cart, take payment and print the receipt.</small></span>
          </a>
        </li>
      </ol>
      <a class="docs-start-pdf" href="{{ asset(config('docs.guide_pdf')) }}" download><i class="fa-solid fa-file-arrow-down"></i> Prefer paper? Download the full guide as a PDF</a>
    </div>

    <div data-search-block>
      <div class="feat-sec-h"><span>Common tasks</span><em>{{ $tasks->count() }}</em></div>
      <div class="docs-tasks">
        @foreach ($tasks as $task)
          <a class="docs-task reveal" href="{{ route('docs.show', $task['page']) }}#{{ $task['anchor'] }}" data-search-item data-search="{{ Str::lower($task['title'] . ' ' . $task['pageTitle']) }}">
            <span class="fi"><i class="fa-solid {{ $task['icon'] }}"></i></span>
            <span><b>{{ $task['title'] }}</b><small>{{ $task['pageTitle'] }}</small></span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        @endforeach
      </div>
    </div>

    <p class="docs-empty" data-search-empty hidden>Nothing in the guide matches your search. Try a simpler word like <b>stock</b> or <b>receipt</b>, or <a href="{{ route('contact') }}">ask our team</a>.</p>

    @foreach ($groups as $groupLabel => $pages)
      <div data-search-block>
        <div class="feat-sec-h"><span>{{ $groupLabel }}</span><em>{{ $pages->count() }}</em></div>
        <div class="docs-grid">
          @foreach ($pages as $slug => $page)
            <a class="docs-card reveal" href="{{ route('docs.show', $slug) }}" data-search-item data-search="{{ Str::lower($page['title'] . ' ' . $page['description'] . ' ' . implode(' ', $page['sections'])) }}">
              <span class="docs-card-top">
                <span class="fi"><i class="fa-solid {{ $page['icon'] }}"></i></span>
                <em>{{ $page['number'] }}</em>
              </span>
              <b>{{ $page['title'] }}</b>
              <p>{{ $page['description'] }}</p>
              <span class="docs-card-foot">
                <small>{{ count($page['sections']) }} {{ Str::plural('topic', count($page['sections'])) }}</small>
                <span class="feat-more">Read <i class="fa-solid fa-arrow-right"></i></span>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endforeach

    <a class="docs-api-band reveal" href="{{ route('docs.api.index') }}">
      <span class="fi"><i class="fa-solid fa-code"></i></span>
      <div>
        <span class="label">For developers</span>
        <b>API reference</b>
        <p>{{ config('api-docs.endpoint_count') }} REST endpoints across {{ count(config('api-docs.groups')) }} groups, with parameters and sample responses.</p>
      </div>
      <span class="feat-more">Browse the API <i class="fa-solid fa-arrow-right"></i></span>
    </a>

    <div class="docs-help reveal">
      <span class="fi"><i class="fa-solid fa-headset"></i></span>
      <div>
        <b>Can't find what you need?</b>
        <p>Our team will walk you through it. Send us a message and we'll get back to you.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
