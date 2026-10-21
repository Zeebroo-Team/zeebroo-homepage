<!-- ABOUT: WHAT WE BUILD / WHO WE SERVE -->
@if ($features->isNotEmpty() || $industries->isNotEmpty())
<section class="section abt-platform">
  <div class="wrap">
    @if ($features->isNotEmpty())
      <div class="abt-split abt-split-h reveal">
        <div>
          <span class="label">අපගේ විසඳුම්</span>
          <h2>ව්‍යාපාරයක් පවත්වාගෙන යාමට අවශ්‍ය සියල්ල.</h2>
        </div>
        <p>මොඩියුල {{ $features->count() }}ක්, එකම ගිණුමක්, එකම දත්ත. අද ඔබට අවශ්‍ය මොඩියුල පමණක් සක්‍රිය කර, ව්‍යාපාරය වර්ධනය වන විට අනෙක්වා එකතු කරගන්න.</p>
      </div>
      <div class="abt-chips">
        @foreach ($features as $feature)
          <a class="abt-chip reveal" href="{{ route('features.show', $feature->slug) }}">
            <span class="mi"><i class="fa-solid {{ $feature->icon }}"></i></span>
            <div><b>{{ $feature->title }}</b><small>{{ $feature->menu }}</small></div>
            <i class="fa-solid fa-arrow-right abt-go"></i>
          </a>
        @endforeach
      </div>
    @endif

    @if ($industries->isNotEmpty())
      <div class="abt-split abt-split-h abt-ind-h reveal">
        <div>
          <span class="label">අප සේවය කරන ක්ෂේත්‍ර</span>
          <h2>ඔබේ ව්‍යාපාරයේ ස්වභාවයට ගැළපෙන ලෙස.</h2>
        </div>
        <p>ව්‍යාපාර ක්ෂේත්‍ර {{ $industries->count() }}ක් සඳහා සූදානම් සැකසුම් ඇති බැවින්, පළමු දිනයේ සිටම ඔබට අවශ්‍ය මොඩියුල සමඟ ආරම්භ කළ හැක.</p>
      </div>
      <div class="abt-inds">
        @foreach ($industries as $industry)
          <a class="abt-ind reveal" href="{{ route('industries.show', $industry->slug) }}">
            <i class="fa-solid {{ $industry->icon }}"></i>{{ $industry->title }}
          </a>
        @endforeach
        <a class="abt-ind is-more reveal" href="{{ route('contact') }}"><i class="fa-solid fa-plus"></i>ඔබේ ක්ෂේත්‍රය මෙහි නැද්ද? අප අමතන්න</a>
      </div>
    @endif
  </div>
</section>
@endif
