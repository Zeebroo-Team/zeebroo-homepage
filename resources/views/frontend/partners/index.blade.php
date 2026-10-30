@extends('layouts.frontend')

@section('title', ($category ? $category->name.' | ' : '').'Partners & clients | Zeebroo')
@section('description', $category?->description ?: 'Meet the technology, payment and reseller partners who work with Zeebroo, and the businesses that run on it every day.')
@include('frontend.components.social-meta')

@push('head')
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PARTNERS & CLIENTS -->
<section class="feat-index ptn-index">
  <div class="wrap">
    <div class="head">
      <span class="label">Partners &amp; clients</span>
      <h1 class="rise"><span class="line"><span>Growing together with <span class="mark">great companies.</span></span></span></h1>
      <p class="fade-in">From payment providers and hardware makers to the shops, restaurants and teams that run on Zeebroo every day.</p>
    </div>

    @if ($partnerCount === 0)
      <div class="ptn-empty">
        <span class="ii"><i class="fa-solid fa-handshake"></i></span>
        <b>Our partner list is on its way</b>
        <p>Want to work with us? <a href="{{ route('contact') }}">Get in touch</a>.</p>
      </div>
    @else
      <div class="ptn-stats reveal">
        <div><b>{{ $partnerCount }}</b><span>Partners &amp; clients</span></div>
        <div><b>{{ $categories->count() }}</b><span>{{ Str::plural('Category', $categories->count()) }}</span></div>
        @if ($locationCount)
          <div><b>{{ $locationCount }}</b><span>{{ Str::plural('Location', $locationCount) }}</span></div>
        @endif
      </div>

      @if ($categories->count() > 1 || $category)
        <nav class="ptn-cats" aria-label="Partner categories">
          <a href="{{ route('partners.index') }}" @class(['on' => ! $category])>All <em>{{ $partnerCount }}</em></a>
          @foreach ($categories as $c)
            <a href="{{ route('partners.index', ['category' => $c->slug]) }}" @class(['on' => $category?->is($c)])><i class="fa-solid {{ $c->icon }}"></i>{{ $c->name }} <em>{{ $c->partners->count() }}</em></a>
          @endforeach
        </nav>
      @endif

      @foreach ($category ? collect([$category]) : $categories as $c)
        <div class="ptn-group reveal" id="{{ $c->slug }}">
          <div class="feat-sec-h"><span><i class="fa-solid {{ $c->icon }}"></i> {{ $c->name }}</span><em>{{ $c->partners->count() }}</em></div>
          @if ($c->description)<p class="ptn-group-p">{{ $c->description }}</p>@endif
          <div class="ptn-grid">
            @foreach ($c->partners as $partner)
              @include('frontend.partners.partials.card', ['partner' => $partner])
            @endforeach
          </div>
        </div>
      @endforeach

      @if (! $category && $uncategorised->isNotEmpty())
        <div class="ptn-group reveal">
          <div class="feat-sec-h"><span>{{ $categories->isEmpty() ? 'Partners & clients' : 'More partners' }}</span><em>{{ $uncategorised->count() }}</em></div>
          <div class="ptn-grid">
            @foreach ($uncategorised as $partner)
              @include('frontend.partners.partials.card', ['partner' => $partner])
            @endforeach
          </div>
        </div>
      @endif
    @endif

    <div class="ptn-join reveal">
      <div>
        <h2>Become a Zeebroo partner</h2>
        <p>Resell, integrate or refer. We'll help you grow with the businesses you already serve.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
