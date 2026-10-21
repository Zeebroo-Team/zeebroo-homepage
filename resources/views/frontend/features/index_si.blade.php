@extends('layouts.frontend')

@section('title', 'විශේෂාංග | Zeebroo: සියලුම මොඩියුල එකම පද්ධතියක')
@section('description', 'Zeebroo හි සියලුම මොඩියුල පිළිබඳ දැනගන්න: POS, තොග, ගිණුම්, බිල්පත්, මානව සම්පත්, ප්‍රචාරණ, CRM, ස්වයංක්‍රීයකරණය සහ තවත් බොහෝ දේ. සියල්ල එකම දත්ත මත, තත්‍ය කාලීනව ක්‍රියා කරයි.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- FEATURES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">විශේෂාංග</span>
      <h1 class="rise"><span class="line"><span>එකම පද්ධතියක්, සියලුම <span class="mark">මොඩියුල.</span></span></span></h1>
      <p class="fade-in">සියලුම මොඩියුල එකම දත්ත භාවිත කරන බැවින්, ඔබේ විකුණුම් සහ ගිණුම් සැමවිටම එකිනෙකට ගැළපේ. අද ඔබට අවශ්‍ය මොඩියුල සක්‍රිය කර, ව්‍යාපාරය වර්ධනය වන විට අනෙක්වා එකතු කරගන්න.</p>
    </div>

    @foreach ([['ප්‍රධාන මොඩියුල', $core], ['ඇතුළත් අමතර මොඩියුල', $suite]] as [$sectionLabel, $features])
      @if ($features->isNotEmpty())
        <div class="feat-sec-h"><span>{{ $sectionLabel }}</span><em>{{ $features->count() }}</em></div>
        <div class="feat-core">
          @foreach ($features as $f)
            <a class="feat-tile reveal" href="{{ route('features.show', $f->slug) }}">
              <div class="feat-tile-art">
                @if ($f->spot_url)
                  <img src="{{ $f->spot_url }}" alt="" width="344" height="347" loading="lazy">
                @else
                  <span class="fi"><i class="fa-solid {{ $f->icon }}"></i></span>
                @endif
              </div>
              <b>{{ $f->title }}@if ($f->badge) <span class="badge">{{ $f->badge }}</span>@endif</b>
              <p>{{ $f->lead ?: $f->menu }}</p>
              <span class="feat-more">වැඩි විස්තර <i class="fa-solid fa-arrow-right"></i></span>
            </a>
          @endforeach
        </div>
      @endif
    @endforeach
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
