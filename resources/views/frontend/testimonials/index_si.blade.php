@extends('layouts.frontend')

@section('title', 'ප්‍රතිචාර | Zeebroo')
@section('description', 'Zeebroo මත තම ව්‍යාපාරය පවත්වාගෙන යාම ගැන සාප්පු හිමියන්, ආපනශාලා සහ කණ්ඩායම් පවසන දේ කියවන්න.')

@push('head')
<link rel="canonical" href="{{ route('testimonials.index') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endpush

@section('content')
<!-- TESTIMONIALS -->
<section class="feat-index tst-index">
  <div class="wrap">
    <div class="head">
      <span class="label">ප්‍රතිචාර</span>
      <h1 class="rise"><span class="line"><span>අපේ ගනුදෙනුකරුවන් <span class="mark">අප ගැන පවසන දේ.</span></span></span></h1>
      <p class="fade-in">සෑම දිනකම තම විකුණුම්, තොගය සහ කාර්ය මණ්ඩලය Zeebroo මත කළමනාකරණය කරන ව්‍යාපාරවල සැබෑ වචන.</p>
    </div>

    @if ($testimonials->isEmpty())
      <div class="ptn-empty">
        <span class="ii"><i class="fa-solid fa-comment-dots"></i></span>
        <b>ගනුදෙනුකරුවන්ගේ කතා ළඟදීම</b>
        <p>Zeebroo භාවිත කරනවාද? <a href="{{ route('contact') }}">එය කොහොමදැයි අපට කියන්න</a>.</p>
      </div>
    @else
      <div class="ptn-stats tst-stats reveal">
        <div><b>{{ $testimonials->count() }}</b><span>සමාලෝචන</span></div>
        <div><b>{{ number_format($averageRating, 1) }}<i class="fa-solid fa-star"></i></b><span>සාමාන්‍ය ශ්‍රේණිගත කිරීම</span></div>
      </div>

      <div class="tst-grid">
        @foreach ($testimonials as $testimonial)
          @include('frontend.testimonials.partials.card', ['testimonial' => $testimonial])
        @endforeach
      </div>
    @endif

    <div class="ptn-join reveal">
      <div>
        <h2>ඔබේම කතාව ලිවීමට සූදානම්ද?</h2>
        <p>Zeebroo සමඟ පවත්වාගෙන යන, නිරීක්ෂණය කරන සහ වර්ධනය වන ව්‍යාපාරවලට එක්වන්න.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('packages.index') }}">මිල ගණන් බලන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
