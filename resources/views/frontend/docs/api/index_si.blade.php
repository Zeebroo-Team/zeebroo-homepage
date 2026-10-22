@extends('layouts.frontend')

@section('title', 'API යොමුව | Zeebroo භාවිත උපදෙස්')
@section('description', 'Zeebroo POS REST API: පිවිසුම, නාමාවලිය, ගෙවීම්, විකුණුම්, මූල්‍ය, මානව සම්පත්, CRM, අවන්හල් සහ තවත් බොහෝ දේ සඳහා endpoint ' . config('api-docs.endpoint_count') . 'ක්, පරාමිති සහ නියැදි ප්‍රතිචාර සමඟ.')

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
        <span class="label">API යොමුව · {{ config('api-docs.version') }}</span>
        <h1 class="rise"><span class="line"><span>Zeebroo API මත <span class="mark">ගොඩනගන්න.</span></span></span></h1>
        <p class="fade-in">POS පිටුපස ඇති සෑම REST endpoint එකක්ම, පිවිසුම් අවශ්‍යතා, පරාමිති සහ නියැදි ප්‍රතිචාර සමඟ. ඔබේ කවුන්ටරය භාවිත කරන එම සජීවී දත්තවලටම ඔබේ වෙබ් අඩවිය, ගිණුම් මෙවලම් හෝ උපාංග සම්බන්ධ කරන්න.</p>
      </div>
      <form class="docs-search fade-in" role="search" onsubmit="return false">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" placeholder="endpoint සොයන්න, උදා: /sales හෝ invoice" aria-label="API endpoint සොයන්න" data-search-input>
        <kbd class="docs-search-key" aria-hidden="true">/</kbd>
      </form>
    </div>

    <ul class="docs-facts fade-in">
      <li><i class="fa-solid fa-plug"></i>endpoint <b>{{ config('api-docs.endpoint_count') }}</b></li>
      <li><i class="fa-solid fa-layer-group"></i>කාණ්ඩ {{ count($apiGroups) }}ක සම්පත් <b>{{ $resourceCount }}</b></li>
      <li><i class="fa-solid fa-shield-halved"></i>Bearer token පිවිසුම</li>
      <li><i class="fa-solid fa-code"></i>JSON ඇතුළට, JSON පිටතට</li>
    </ul>

    <div class="docs-api-start" data-search-intro>
      <div class="docs-api-start-h">
        <span class="fi"><i class="fa-solid fa-flag-checkered"></i></span>
        <div>
          <b>ආරම්භ කිරීම</b>
          <p>මෙය මුලින්ම කියවන්න. මෙම යොමුවේ ඇති සෑම endpoint එකකටම පාහේ මෙය අදාළ වේ.</p>
        </div>
      </div>
      <div class="doc-prose">
        @include('frontend.docs.api.getting-started')
      </div>
    </div>

    <p class="docs-empty" data-search-empty hidden>ඔබේ සෙවීමට ගැළපෙන endpoint කිසිවක් නැත. <b>/products</b> වැනි මාර්ගයක් හෝ <b>refund</b> වැනි වචනයක් උත්සාහ කරන්න.</p>

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
                <small>endpoint {{ count($item['endpoints']) }}</small>
                <span class="feat-more">බලන්න <i class="fa-solid fa-arrow-right"></i></span>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endforeach

    <div class="docs-help reveal">
      <span class="fi"><i class="fa-solid fa-key"></i></span>
      <div>
        <b>ඔබේ ව්‍යාපාරයට API ප්‍රවේශය අවශ්‍යද?</b>
        <p>වේදිකාවෙන් සංවර්ධක API යතුරු සහ webhooks සාදන්න, නැතහොත් ඒකාබද්ධ කිරීමක් ගැන අප සමඟ කතා කරන්න.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">අප අමතන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
