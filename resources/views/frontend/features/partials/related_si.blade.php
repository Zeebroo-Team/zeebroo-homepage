<!-- RELATED FEATURES -->
<section class="section">
  <div class="wrap">
    @if ($related->isNotEmpty())
      <div class="head reveal">
        <span class="label">සම්බන්ධිත මොඩියුල</span>
        <h2>එක්ව භාවිත කිරීමෙන් වැඩි ප්‍රතිඵල</h2>
        <p>{{ $feature->title }} අමතර සැකසුම් කිසිවක් නොමැතිව මෙම මොඩියුල සමඟ ස්වයංක්‍රීයව දත්ත හුවමාරු කරයි.</p>
      </div>
      <div class="feat-grid">
        @foreach ($related as $f)
          @include('frontend.features.partials.card', ['f' => $f])
        @endforeach
      </div>
    @endif

    <nav class="feat-pager" aria-label="තවත් විශේෂාංග">
      <a href="{{ route('features.show', $prev->slug) }}"><small><i class="fa-solid fa-arrow-left"></i> පෙර</small><b>{{ $prev->title }}</b></a>
      <a class="feat-pager-all" href="{{ route('features.index') }}"><i class="fa-solid fa-grip"></i><span>සියලුම විශේෂාංග</span></a>
      <a href="{{ route('features.show', $next->slug) }}"><small>ඊළඟ <i class="fa-solid fa-arrow-right"></i></small><b>{{ $next->title }}</b></a>
    </nav>
  </div>
</section>
