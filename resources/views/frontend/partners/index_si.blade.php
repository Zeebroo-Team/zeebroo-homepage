@extends('layouts.frontend')

@section('title', ($category ? $category->name.' | ' : '').'හවුල්කරුවන් සහ ගනුදෙනුකරුවන් | Zeebroo')
@section('description', $category?->description ?: 'Zeebroo සමඟ වැඩ කරන තාක්ෂණ, ගෙවීම් සහ නැවත විකුණුම් හවුල්කරුවන් සහ සෑම දිනකම එය මත ක්‍රියාත්මක වන ව්‍යාපාර හමුවන්න.')

@push('head')
<link rel="canonical" href="{{ $category ? route('partners.index', ['category' => $category->slug]) : route('partners.index') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PARTNERS & CLIENTS -->
<section class="feat-index ptn-index">
  <div class="wrap">
    <div class="head">
      <span class="label">හවුල්කරුවන් සහ ගනුදෙනුකරුවන්</span>
      <h1 class="rise"><span class="line"><span>විශිෂ්ට සමාගම් සමඟ <span class="mark">එකට වර්ධනය වෙමු.</span></span></span></h1>
      <p class="fade-in">ගෙවීම් සපයන්නන් සහ දෘඪාංග නිෂ්පාදකයින්ගේ සිට සෑම දිනකම Zeebroo මත ක්‍රියාත්මක වන සාප්පු, ආපනශාලා සහ කණ්ඩායම් දක්වා.</p>
    </div>

    @if ($partnerCount === 0)
      <div class="ptn-empty">
        <span class="ii"><i class="fa-solid fa-handshake"></i></span>
        <b>අපේ හවුල්කරු ලැයිස්තුව ළඟදීම</b>
        <p>අප සමඟ වැඩ කිරීමට කැමතිද? <a href="{{ route('contact') }}">අප අමතන්න</a>.</p>
      </div>
    @else
      <div class="ptn-stats reveal">
        <div><b>{{ $partnerCount }}</b><span>හවුල්කරුවන් සහ ගනුදෙනුකරුවන්</span></div>
        <div><b>{{ $categories->count() }}</b><span>කාණ්ඩ</span></div>
        @if ($locationCount)
          <div><b>{{ $locationCount }}</b><span>ස්ථාන</span></div>
        @endif
      </div>

      @if ($categories->count() > 1 || $category)
        <nav class="ptn-cats" aria-label="හවුල්කරු කාණ්ඩ">
          <a href="{{ route('partners.index') }}" @class(['on' => ! $category])>සියල්ල <em>{{ $partnerCount }}</em></a>
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
          <div class="feat-sec-h"><span>{{ $categories->isEmpty() ? 'හවුල්කරුවන් සහ ගනුදෙනුකරුවන්' : 'තවත් හවුල්කරුවන්' }}</span><em>{{ $uncategorised->count() }}</em></div>
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
        <h2>Zeebroo හවුල්කරුවෙකු වන්න</h2>
        <p>නැවත විකුණන්න, ඒකාබද්ධ කරන්න හෝ යොමු කරන්න. ඔබ දැනටමත් සේවය කරන ව්‍යාපාර සමඟ වර්ධනය වීමට අපි උදව් කරමු.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">අප හා කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
