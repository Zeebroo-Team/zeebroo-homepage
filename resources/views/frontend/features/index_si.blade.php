@extends('layouts.frontend')

@section('title', 'විශේෂාංග | Zeebroo: සියලුම මොඩියුල එකම වේදිකාවක')
@section('description', 'Zeebroo හි සියලුම මොඩියුල ගවේෂණය කරන්න: POS, තොගය, ගිණුම්, බිල්පත්, මානව සම්පත්, ප්‍රචාරණ, CRM, ගිණුම්කරණය, ස්වයංක්‍රීයකරණය සහ තවත් බොහෝ දේ, සියල්ල එකම සජීවී දත්ත බෙදාගනිමින්.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- FEATURES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">විශේෂාංග</span>
      <h1 class="rise"><span class="line"><span>එකම වේදිකාවක්, සියලුම <span class="mark">මොඩියුල.</span></span></span></h1>
      <p class="fade-in">සෑම මොඩියුලයක්ම එකම දත්ත බෙදාගන්නා නිසා, මුදල් ලාච්චුව සහ ලෙජරය සැමවිටම එකඟ වේ. ඔබට අවශ්‍ය දේ සක්‍රිය කර, වර්ධනය වන විට ඉතිරිය එක් කරන්න.</p>
    </div>

    @foreach ([['ප්‍රධාන මොඩියුල', $core], ['සියල්ල ඇතුළත්, ඊට අමතරව', $suite]] as [$sectionLabel, $features])
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
              <span class="feat-more">තවත් දැනගන්න <i class="fa-solid fa-arrow-right"></i></span>
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
