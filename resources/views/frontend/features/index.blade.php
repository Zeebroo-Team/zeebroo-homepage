@extends('layouts.frontend')

@section('title', 'Features | Zeebroo: every module in one platform')
@section('description', 'Explore every Zeebroo module: POS, stock, accounts, bills, HR, campaigns, CRM, accounting, automation and more, all sharing the same live data.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- FEATURES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">Features</span>
      <h1 class="rise"><span class="line"><span>One platform, every <span class="mark">module.</span></span></span></h1>
      <p class="fade-in">Every module shares the same data, so the register and the ledger always agree. Turn on what you need and add the rest as you grow.</p>
    </div>

    @if ($core->isNotEmpty())
      <div class="feat-sec-h"><span>Core modules</span><em>{{ $core->count() }}</em></div>
      <div class="feat-core">
        @foreach ($core as $f)
          <a class="feat-tile reveal" href="{{ route('features.show', $f->slug) }}">
            <div class="feat-tile-art">
              @if ($f->spot_url)
                <img src="{{ $f->spot_url }}" alt="" width="344" height="347" loading="lazy">
              @else
                <span class="fi"><i class="fa-solid {{ $f->icon }}"></i></span>
              @endif
            </div>
            <b>{{ $f->title }}@if ($f->badge) <span class="badge">{{ $f->badge }}</span>@endif</b>
            <p>{{ $f->lead }}</p>
            <span class="feat-more">Learn more <i class="fa-solid fa-arrow-right"></i></span>
          </a>
        @endforeach
      </div>
    @endif

    @if ($suite->isNotEmpty())
      <div class="feat-sec-h"><span>All included, plus</span><em>{{ $suite->count() }}</em></div>
      <div class="feat-grid">
        @foreach ($suite as $f)
          @include('frontend.features.partials.card', ['f' => $f])
        @endforeach
      </div>
    @endif
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
