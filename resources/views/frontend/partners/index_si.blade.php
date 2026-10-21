@extends('layouts.frontend')

@section('title', ($category ? $category->name.' | ' : '').'අපගේ හවුල්කරුවන් සහ සේවාදායකයින් | Zeebroo')
@section('description', $category?->description ?: 'Zeebroo සමඟ එක්ව කටයුතු කරන තාක්ෂණ, ගෙවීම් සහ අලෙවි හවුල්කරුවන් මෙන්ම, දිනපතා Zeebroo භාවිතයෙන් සාර්ථකව ක්‍රියාත්මක වන ව්‍යාපාර ගැන දැනගන්න.')

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
      <span class="label">හවුල්කරුවන් සහ සේවාදායකයින්</span>
      <h1 class="rise"><span class="line"><span>විශ්වාසනීය හවුල්කාරිත්වයෙන් <span class="mark">එක්ව ඉදිරියට.</span></span></span></h1>
      <p class="fade-in">ගෙවීම් සේවා සපයන්නන් සහ දෘඪාංග නිෂ්පාදකයින්ගේ සිට, දිනපතා Zeebroo භාවිතයෙන් ව්‍යාපාර කරගෙන යන වෙළඳසැල්, අවන්හල් සහ ආයතන දක්වා — අප සමඟ එක්ව ඉදිරියට යන සියලු දෙනා මෙන්න.</p>
    </div>

    @if ($partnerCount === 0)
      <div class="ptn-empty">
        <span class="ii"><i class="fa-solid fa-handshake"></i></span>
        <b>අපගේ හවුල්කරුවන්ගේ ලැයිස්තුව ඉක්මනින් එක් කෙරේ</b>
        <p>අප සමඟ එක්ව කටයුතු කිරීමට කැමතිද? <a href="{{ route('contact') }}">අප හා සම්බන්ධ වන්න</a>.</p>
      </div>
    @else
      <div class="ptn-stats reveal">
        <div><b>{{ $partnerCount }}</b><span>හවුල්කරුවන් සහ සේවාදායකයින්</span></div>
        <div><b>{{ $categories->count() }}</b><span>ප්‍රවර්ග</span></div>
        @if ($locationCount)
          <div><b>{{ $locationCount }}</b><span>ස්ථාන</span></div>
        @endif
      </div>

      @if ($categories->count() > 1 || $category)
        <nav class="ptn-cats" aria-label="හවුල්කරුවන්ගේ ප්‍රවර්ග">
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
              @include('frontend.partners.partials.card_si', ['partner' => $partner])
            @endforeach
          </div>
        </div>
      @endforeach

      @if (! $category && $uncategorised->isNotEmpty())
        <div class="ptn-group reveal">
          <div class="feat-sec-h"><span>{{ $categories->isEmpty() ? 'හවුල්කරුවන් සහ සේවාදායකයින්' : 'වෙනත් හවුල්කරුවන්' }}</span><em>{{ $uncategorised->count() }}</em></div>
          <div class="ptn-grid">
            @foreach ($uncategorised as $partner)
              @include('frontend.partners.partials.card_si', ['partner' => $partner])
            @endforeach
          </div>
        </div>
      @endif
    @endif

    <div class="ptn-join reveal">
      <div>
        <h2>Zeebroo හවුල්කරුවෙකු ලෙස එක්වන්න</h2>
        <p>Zeebroo අලෙවි කරන්න, ඔබේ පද්ධති සමඟ ඒකාබද්ධ කරන්න, නැතහොත් නව ව්‍යාපාර අප වෙත යොමු කරන්න. ඔබ දැනටමත් සේවා සපයන ව්‍යාපාර සමඟම වර්ධනය වීමට අපි ඔබට සහාය වෙමු.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">අප හා සම්බන්ධ වන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
