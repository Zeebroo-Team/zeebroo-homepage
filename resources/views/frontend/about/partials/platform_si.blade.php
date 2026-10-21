<!-- ABOUT: WHAT WE BUILD / WHO WE SERVE -->
@if ($features->isNotEmpty() || $industries->isNotEmpty())
<section class="section abt-platform">
  <div class="wrap">
    @if ($features->isNotEmpty())
      <div class="abt-split abt-split-h reveal">
        <div>
          <span class="label">අප ගොඩනගන දේ</span>
          <h2>ව්‍යාපාරයක් පවත්වාගෙන යාමට අවශ්‍ය සියල්ල.</h2>
        </div>
        <p>මොඩියුල {{ $features->count() }}, එකම පිවිසුමක්, එකම ඉලක්කම් කට්ටලයක්. අද ඔබට අවශ්‍ය දේ පමණක් සක්‍රිය කර, වර්ධනය වන විට ඉතිරිය සක්‍රිය කරන්න.</p>
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
          <span class="label">අප සේවය කරන්නේ කාටද</span>
          <h2>ඔබ වැඩ කරන ආකාරයටම නිර්මාණය කළා.</h2>
        </div>
        <p>ක්ෂේත්‍ර {{ $industries->count() }} ක් සඳහා සූදානම් කළ සැකසුම්, එබැවින් පළමු දිනයේ සිටම නිවැරදි මොඩියුල සක්‍රියව ඔබ ආරම්භ කරයි.</p>
      </div>
      <div class="abt-inds">
        @foreach ($industries as $industry)
          <a class="abt-ind reveal" href="{{ route('industries.show', $industry->slug) }}">
            <i class="fa-solid {{ $industry->icon }}"></i>{{ $industry->title }}
          </a>
        @endforeach
        <a class="abt-ind is-more reveal" href="{{ route('contact') }}"><i class="fa-solid fa-plus"></i>ඔබේ ක්ෂේත්‍රය නැද්ද? අප හා කතා කරන්න</a>
      </div>
    @endif
  </div>
</section>
@endif
