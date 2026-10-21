@extends('layouts.frontend')

@section('title', 'ව්‍යාපාර ක්ෂේත්‍ර | Zeebroo: ඔබේ ක්ෂේත්‍රය වැඩ කරන ආකාරයටම නිර්මාණය කළා')
@section('description', 'ආපනශාලා, සිල්ලර වෙළඳසැල්, ඊ-වාණිජ්‍යය, නිෂ්පාදනය, අමතර කොටස්, තොග වෙළඳාම, ලාභ නොලබන ආයතන, ඖෂධශාලා සහ හෝටල් සඳහා Zeebroo ගැළපෙන අයුරු බලන්න.')

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- INDUSTRIES INDEX -->
<section class="feat-index">
  <div class="wrap">
    <div class="head">
      <span class="label">ව්‍යාපාර ක්ෂේත්‍ර</span>
      <h1 class="rise"><span class="line"><span>ඔබේ ක්ෂේත්‍රය වැඩ කරන <span class="mark">ආකාරයටම.</span></span></span></h1>
      <p class="fade-in">Zeebroo ඔබේ ව්‍යාපාරයට ගැලපේ, ඔබ Zeebroo ට ගැලපිය යුතු නැහැ. ඔබේ ක්ෂේත්‍රයට ගැළපෙන මොඩියුල සහ ක්‍රියාවලි බැලීමට එය තෝරන්න.</p>
    </div>

    <div class="feat-sec-h"><span>සියලුම ක්ෂේත්‍ර</span><em>{{ $industries->count() }}</em></div>
    @include('frontend.industries.partials.grid')
  </div>
</section>

<div class="feat-index-cta">
  @include('frontend.features.partials.cta')
</div>
@endsection
