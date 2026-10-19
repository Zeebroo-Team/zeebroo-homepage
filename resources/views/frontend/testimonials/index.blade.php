@extends('layouts.frontend')

@section('title', 'Testimonials | Zeebroo')
@section('description', 'Read what shop owners, restaurants and teams say about running their business on Zeebroo.')

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
      <span class="label">Testimonials</span>
      <h1 class="rise"><span class="line"><span>What our customers <span class="mark">say about us.</span></span></span></h1>
      <p class="fade-in">Real words from the businesses that run their sales, stock and people on Zeebroo every day.</p>
    </div>

    @if ($testimonials->isEmpty())
      <div class="ptn-empty">
        <span class="ii"><i class="fa-solid fa-comment-dots"></i></span>
        <b>Customer stories are on their way</b>
        <p>Using Zeebroo? <a href="{{ route('contact') }}">Tell us how it's going</a>.</p>
      </div>
    @else
      <div class="ptn-stats tst-stats reveal">
        <div><b>{{ $testimonials->count() }}</b><span>{{ Str::plural('Review', $testimonials->count()) }}</span></div>
        <div><b>{{ number_format($averageRating, 1) }}<i class="fa-solid fa-star"></i></b><span>Average rating</span></div>
      </div>

      <div class="tst-grid tst-masonry">
        @foreach ($testimonials as $testimonial)
          @include('frontend.testimonials.partials.card', ['testimonial' => $testimonial])
        @endforeach
      </div>
    @endif

    <div class="ptn-join reveal">
      <div>
        <h2>Ready to write your own story?</h2>
        <p>Join the businesses that run, track and grow with Zeebroo.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('packages.index') }}">See pricing <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
