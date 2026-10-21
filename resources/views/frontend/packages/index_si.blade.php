@extends('layouts.frontend')

@section('title', 'මිල ගණන් | Zeebroo: ඔබේ ව්‍යාපාරයේ සෑම අදියරකටම ගැළපෙන පැකේජ')
@section('description', 'Zeebroo පැකේජ සසඳා බලන්න: POS, තොග, ගිණුම්, බිල්පත්, CRM, මානව සම්පත් සහ තවත් මොඩියුල ඇතුළත් මාසික පැකේජ. ඔබට අවශ්‍ය පැකේජය තෝරා, ව්‍යාපාරය වර්ධනය වන විට උසස් කරගන්න.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- PACKAGES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">මිල ගණන්</span>
      <h1 class="rise"><span class="line"><span>ඔබට ගැළපෙන පැකේජය <span class="mark">තෝරාගන්න.</span></span></span></h1>
      <p class="fade-in">සෑම පැකේජයක්ම තත්‍ය කාලීන දත්ත සමඟ වෙබ් සහ ඩෙස්ක්ටොප් යන දෙකෙහිම ක්‍රියා කරයි. අද ඔබට අවශ්‍ය පැකේජයෙන් ආරම්භ කර, ව්‍යාපාරය වර්ධනය වන විට ඉහළ පැකේජයකට මාරු වන්න.</p>
    </div>

    @if ($packages)
      <div class="feat-sec-h"><span>පැකේජ</span><em>{{ count($packages) }}</em></div>
      <div class="pkgs">
        @foreach ($packages as $p)
          @include('frontend.packages.partials.card', ['p' => $p])
        @endforeach
      </div>
      <p class="pkg-note">මිල ගණන් එක් ව්‍යාපාරයක් සඳහා වන අතර මාසිකව අය කෙරේ. ඕනෑම අවස්ථාවක ඔබේ පැකේජය වෙනස් කිරීමට හෝ අවලංගු කිරීමට හැක.</p>

      <div class="feat-sec-h pkg-compare-h"><span>පැකේජ සසඳා බලන්න</span><em>මොඩියුල {{ count($features) }}</em></div>
      @include('frontend.packages.partials.compare')
    @else
      <div class="pkg-empty reveal">
        <span><i class="fa-solid fa-box-open"></i></span>
        <h3>මිල ගණන් මේ මොහොතේ ලබාගත නොහැක</h3>
        <p>නවතම පැකේජ තොරතුරු ලබාගැනීමට නොහැකි විය. මිනිත්තුවකින් පිටුව නැවත පූරණය කරන්න, නැතහොත් අප අමතන්න. අපි ඔබට විස්තර එවන්නෙමු.</p>
        <a class="btn btn-ink" href="{{ route('contact') }}">අපගේ කණ්ඩායම අමතන්න <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    @endif
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
