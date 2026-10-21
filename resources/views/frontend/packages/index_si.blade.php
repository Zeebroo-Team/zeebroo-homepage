@extends('layouts.frontend')

@section('title', 'මිල ගණන් | Zeebroo: ඔබේ ව්‍යාපාරයේ සෑම අදියරකටම පැකේජ')
@section('description', 'Zeebroo පැකේජ සසඳන්න: POS, තොගය, ගිණුම්, බිල්පත්, CRM, මානව සම්පත් සහ තවත් දේ ඇතුළත් මාසික සැලසුම්. ඔබට අවශ්‍ය දේ තෝරා වර්ධනය වන විට උසස් කරන්න.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PACKAGES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">මිල ගණන්</span>
      <h1 class="rise"><span class="line"><span>ඔබට ගැළපෙන පැකේජය <span class="mark">තෝරන්න.</span></span></span></h1>
      <p class="fade-in">සෑම පැකේජයක්ම බෙදාගත්, සජීවී දත්ත සමඟ වෙබ් සහ ඩෙස්ක්ටොප් මත ක්‍රියා කරයි. අද ඔබට අවශ්‍ය දෙයින් ආරම්භ කර ව්‍යාපාරය වර්ධනය වන විට ඉහළට යන්න.</p>
    </div>

    @if ($packages)
      <div class="feat-sec-h"><span>පැකේජ</span><em>{{ count($packages) }}</em></div>
      <div class="pkgs">
        @foreach ($packages as $p)
          @include('frontend.packages.partials.card', ['p' => $p])
        @endforeach
      </div>
      <p class="pkg-note">මිල ගණන් එක් ව්‍යාපාරයකට වන අතර මාසිකව අය කෙරේ. ඕනෑම වේලාවක පැකේජය අවලංගු කරන්න හෝ වෙනස් කරන්න.</p>

      <div class="feat-sec-h pkg-compare-h"><span>පැකේජ සසඳන්න</span><em>මොඩියුල {{ count($features) }}</em></div>
      @include('frontend.packages.partials.compare')
    @else
      <div class="pkg-empty reveal">
        <span><i class="fa-solid fa-box-open"></i></span>
        <h3>මිල ගණන් මේ මොහොතේ සෙමින් පූරණය වේ</h3>
        <p>නවතම පැකේජ ලබාගැනීමට නොහැකි විය. මිනිත්තුවකින් නැවත පූරණය කරන්න, නැතහොත් අපෙන් විමසන්න, අපි ඒවා එවන්නම්.</p>
        <a class="btn btn-ink" href="{{ route('contact') }}">අපේ කණ්ඩායම හා කතා කරන්න <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    @endif
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
