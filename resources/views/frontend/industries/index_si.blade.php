@extends('layouts.frontend')

@section('title', 'ව්‍යාපාර ක්ෂේත්‍ර | Zeebroo: ඔබේ ක්ෂේත්‍රයට ගැළපෙන ලෙස නිර්මාණය කර ඇත')
@section('description', 'ආපනශාලා, සිල්ලර වෙළඳසැල්, ඊ-වාණිජ්‍යය, නිෂ්පාදනය, අමතර කොටස්, තොග වෙළඳාම, ලාභ නොලබන ආයතන, ඖෂධශාලා සහ හෝටල් සඳහා Zeebroo ගැළපෙන ආකාරය දැනගන්න.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- INDUSTRIES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">ව්‍යාපාර ක්ෂේත්‍ර</span>
      <h1 class="rise"><span class="line"><span>ඔබේ ක්ෂේත්‍රයට <span class="mark">ගැළපෙන ලෙසම.</span></span></span></h1>
      <p class="fade-in">ඔබ Zeebroo වලට අනුගත විය යුතු නැත. Zeebroo ඔබේ ව්‍යාපාරයට අනුගත වේ. ඔබේ ක්ෂේත්‍රයට ගැළපෙන මොඩියුල සහ ක්‍රියාවලි දැකගැනීමට එය තෝරන්න.</p>
    </div>

    <div class="feat-sec-h"><span>සියලුම ක්ෂේත්‍ර</span><em>{{ $industries->count() }}</em></div>
    @include('frontend.industries.partials.grid')
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
