@extends('layouts.frontend')

@section('title', 'API reference | Zeebroo Docs')
@section('description', 'The Zeebroo POS REST API: ' . config('api-docs.endpoint_count') . ' endpoints for auth, catalog, checkout, sales, finance, HR, CRM, restaurants and more, with parameters and sample responses.')

@push('head')
<link rel="canonical" href="{{ route('docs.api.index') }}">
<link rel="stylesheet" href="{{ asset('assets/css/docs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
<script src="{{ asset('assets/js/docs.js') }}"></script>
@endpush

@section('content')
<!-- API INDEX -->
<section class="docs-index">
  <div class="wrap">
    <div class="docs-top">
      <div class="head">
        <span class="label">API reference · {{ config('api-docs.version') }}</span>
        <h1 class="rise"><span class="line"><span>Build on the Zeebroo <span class="mark">API.</span></span></span></h1>
        <p class="fade-in">Every REST endpoint behind the POS, with auth requirements, parameters and sample responses. Connect your website, accounting tools or devices to the same live data your counter uses.</p>
      </div>
      <form class="docs-search fade-in" role="search" onsubmit="return false">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" placeholder="Search endpoints, e.g. /sales or invoice" aria-label="Search API endpoints" data-search-input>
      </form>
    </div>

    <ul class="docs-facts fade-in">
      <li><i class="fa-solid fa-plug"></i><b>{{ config('api-docs.endpoint_count') }}</b> endpoints</li>
      <li><i class="fa-solid fa-layer-group"></i><b>{{ $resourceCount }}</b> resources in {{ count($apiGroups) }} groups</li>
      <li><i class="fa-solid fa-shield-halved"></i>Bearer token auth</li>
      <li><i class="fa-solid fa-code"></i>JSON in, JSON out</li>
    </ul>

    <div class="docs-api-start" data-search-intro>
      <div class="docs-api-start-h">
        <span class="fi"><i class="fa-solid fa-flag-checkered"></i></span>
        <div>
          <b>Getting started</b>
          <p>Read this first. It applies to nearly every endpoint in this reference.</p>
        </div>
      </div>
      <div class="doc-prose">
        @include('frontend.docs.api.getting-started')
      </div>
    </div>

    <p class="docs-empty" data-search-empty hidden>No endpoints match your search. Try a path like <b>/products</b> or a word like <b>refund</b>.</p>

    @foreach ($apiGroups as $groupKey => $apiGroup)
      <div class="docs-api-group" data-search-block>
        <div class="feat-sec-h"><span><i class="fa-solid {{ $apiGroup['icon'] }}"></i> {{ $apiGroup['title'] }}</span><em>{{ $apiGroup['label'] }}</em></div>
        <p class="docs-api-group-desc">{{ $apiGroup['description'] }}</p>
        <div class="docs-grid">
          @foreach ($apiGroup['resources'] as $resourceSlug => $item)
            <a class="docs-card docs-api-card" href="{{ route('docs.api.show', $resourceSlug) }}"
               data-search-item data-search="{{ Str::lower($item['title'] . ' ' . collect($item['endpoints'])->map(fn ($ep) => implode(' ', $ep))->implode(' ')) }}">
              <b>{{ $item['title'] }}</b>
              <p>{{ $item['description'] }}</p>
              <span class="docs-api-methods">
                @foreach (collect($item['endpoints'])->countBy(fn ($ep) => Str::before($ep[0], '/')) as $method => $count)
                  <span class="method-badge method-{{ Str::lower($method) }}">{{ $method }} <em>{{ $count }}</em></span>
                @endforeach
              </span>
              <span class="docs-card-foot">
                <small>{{ count($item['endpoints']) }} {{ Str::plural('endpoint', count($item['endpoints'])) }}</small>
                <span class="feat-more">View <i class="fa-solid fa-arrow-right"></i></span>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endforeach

    <div class="docs-help reveal">
      <span class="fi"><i class="fa-solid fa-key"></i></span>
      <div>
        <b>Need API access for your business?</b>
        <p>Create developer API keys and webhooks from the platform, or talk to us about an integration.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
