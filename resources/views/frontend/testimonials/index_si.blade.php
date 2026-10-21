@extends('layouts.frontend')

@section('title', 'පාරිභෝගික අදහස් | Zeebroo')
@section('description', 'Zeebroo භාවිතයෙන් තම ව්‍යාපාර කළමනාකරණය කරන වෙළඳසැල් හිමියන්, අවන්හල් සහ ආයතන ඔවුන්ගේ අත්දැකීම් ගැන පවසන දේ කියවන්න.')

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
      <span class="label">පාරිභෝගික අදහස්</span>
      <h1 class="rise"><span class="line"><span>අපේ පාරිභෝගිකයින්ගේ <span class="mark">සැබෑ අත්දැකීම්.</span></span></span></h1>
      <p class="fade-in">විකුණුම්, තොග සහ සේවක කළමනාකරණය දිනපතා Zeebroo හරහා සිදුකරන ව්‍යාපාර හිමියන් තම අත්දැකීම් මෙසේ බෙදා ගනී.</p>
    </div>

    @if ($testimonials->isEmpty())
      <div class="ptn-empty">
        <span class="ii"><i class="fa-solid fa-comment-dots"></i></span>
        <b>පාරිභෝගික අදහස් ළඟදීම බලාපොරොත්තු වන්න</b>
        <p>ඔබ Zeebroo භාවිත කරනවාද? <a href="{{ route('contact') }}">ඔබේ අත්දැකීම අප සමඟ බෙදාගන්න</a>.</p>
      </div>
    @else
      <div class="ptn-stats tst-stats reveal">
        <div><b>{{ $testimonials->count() }}</b><span>පාරිභෝගික සමාලෝචන</span></div>
        <div><b>{{ number_format($averageRating, 1) }}<i class="fa-solid fa-star"></i></b><span>සාමාන්‍ය ඇගයීම</span></div>
      </div>

      <div class="tst-grid">
        @foreach ($testimonials as $testimonial)
          @include('frontend.testimonials.partials.card', ['testimonial' => $testimonial])
        @endforeach
      </div>
    @endif

    <div class="ptn-join reveal">
      <div>
        <h2>ඊළඟ සාර්ථක කතාව ඔබේ විය හැකියි.</h2>
        <p>Zeebroo සමඟ ව්‍යාපාරය පහසුවෙන් කළමනාකරණය කර, වර්ධනය කරගන්නා ව්‍යාපාර අතරට ඔබත් එක්වන්න.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('packages.index') }}">මිල ගණන් බලන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
