@extends('layouts.frontend')

@section('title', 'භාවිත උපදෙස් | Zeebroo POS පරිශීලක මාර්ගෝපදේශය')
@section('description', 'Zeebroo POS ඩෙස්ක්ටොප් ඇප් එක සඳහා සිංහලෙන් පියවරෙන් පියවර උපදෙස්: සැකසීම, විකිණීම, ආපසු භාරදීම්, තොග, මූල්‍ය, මානව සම්පත්, ඩිසයින් ස්ටූඩියෝ, අවන්හල් සහ සැකසුම්.')

@push('head')
<link rel="stylesheet" href="{{ asset('assets/css/docs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/features.js') }}"></script>
<script src="{{ asset('assets/js/docs.js') }}"></script>
@endpush

@section('content')
<!-- DOCS INDEX -->
<section class="docs-index">
  <div class="wrap">
    <div class="docs-top">
      <div class="head">
        <span class="label">භාවිත උපදෙස් · {{ config('docs.version') }}</span>
        <h1 class="rise"><span class="line"><span>Zeebroo පියවරෙන් පියවර <span class="mark">ඉගෙන ගන්න.</span></span></span></h1>
        <p class="fade-in">ඔබේ පළමු පිවිසුමේ සිට දිනපතා විකුණුම්, අවන්හල් ඇණවුම් සහ වැටුප් ගෙවීම් දක්වා, Zeebroo POS ඩෙස්ක්ටොප් ඇප් එකෙන් ඔබේ ව්‍යාපාරය පවත්වාගෙන යාමට අවශ්‍ය සියල්ල සරල සිංහලෙන්.</p>
      </div>
      <form class="docs-search fade-in" role="search" onsubmit="return false">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" placeholder="උපදෙස් සොයන්න, උදා: ආපසු හෝ බාර්කෝඩ්" aria-label="භාවිත උපදෙස් තුළ සොයන්න" data-search-input>
        <kbd class="docs-search-key" aria-hidden="true">/</kbd>
      </form>
    </div>

    <ul class="docs-facts fade-in">
      <li><i class="fa-solid fa-book-open"></i>මාර්ගෝපදේශ <b>{{ $pageCount }}</b></li>
      <li><i class="fa-solid fa-desktop"></i>Windows සහ macOS ඩෙස්ක්ටොප් ඇප් එක</li>
      <li><i class="fa-solid fa-image"></i>සැබෑ තිර රූප</li>
      <li><i class="fa-solid fa-keyboard"></i>යතුරුපුවරු කෙටිමං සමඟ</li>
    </ul>

    <div class="docs-start reveal" data-search-intro>
      <div class="docs-start-h">
        <span class="label">Zeebroo ඔබට අලුත්ද?</span>
        <b>පියවර තුනකින් වැඩ අරඹන්න</b>
        <p>මේ පියවර පිළිවෙළින් අනුගමනය කරන්න. අද දිනයේම ඔබේ පළමු පාරිභෝගිකයාට සේවය කිරීමට ඔබ සූදානම් වේවි.</p>
      </div>
      <ol class="docs-start-steps">
        <li>
          <a href="{{ route('download') }}">
            <span class="docs-start-num">1</span>
            <span><b>ඇප් එක ස්ථාපනය කරන්න</b><small>Windows හෝ macOS සඳහා Zeebroo POS බාගන්න.</small></span>
          </a>
        </li>
        <li>
          <a href="{{ route('docs.show', 'getting-started') }}#creating-your-account">
            <span class="docs-start-num">2</span>
            <span><b>ඔබේ ගිණුම සාදන්න</b><small>ලියාපදිංචි වී, ව්‍යාපාර ක්ෂේත්‍රය තෝරා, අවශ්‍ය විශේෂාංග සක්‍රිය කරන්න.</small></span>
          </a>
        </li>
        <li>
          <a href="{{ route('docs.show', 'point-of-sale') }}#starting-a-sale">
            <span class="docs-start-num">3</span>
            <span><b>පළමු විකිණීම කරන්න</b><small>අයිතම කරත්තයට එක් කර, ගෙවීම ලබාගෙන, රිසිට්පත මුද්‍රණය කරන්න.</small></span>
          </a>
        </li>
      </ol>
      <a class="docs-start-pdf" href="{{ asset(config('docs.guide_pdf')) }}" download><i class="fa-solid fa-file-arrow-down"></i> මුද්‍රිත පිටපතක් කැමතිද? සම්පූර්ණ මාර්ගෝපදේශය PDF ලෙස බාගන්න (ඉංග්‍රීසි)</a>
    </div>

    <div data-search-block>
      <div class="feat-sec-h"><span>නිතර කරන කාර්යයන්</span><em>{{ $tasks->count() }}</em></div>
      <div class="docs-tasks">
        @foreach ($tasks as $task)
          <a class="docs-task reveal" href="{{ route('docs.show', $task['page']) }}#{{ $task['anchor'] }}" data-search-item data-search="{{ Str::lower($task['title'] . ' ' . $task['pageTitle']) }}">
            <span class="fi"><i class="fa-solid {{ $task['icon'] }}"></i></span>
            <span><b>{{ $task['title'] }}</b><small>{{ $task['pageTitle'] }}</small></span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        @endforeach
      </div>
    </div>

    <p class="docs-empty" data-search-empty hidden>ඔබ සෙවූ දෙයට ගැළපෙන කිසිවක් හමු නොවීය. <b>තොග</b> හෝ <b>රිසිට්පත</b> වැනි සරල වචනයක් උත්සාහ කරන්න, නැතහොත් <a href="{{ route('contact') }}">අපේ කණ්ඩායමෙන් අසන්න</a>.</p>

    @foreach ($groups as $groupLabel => $pages)
      <div data-search-block>
        <div class="feat-sec-h"><span>{{ $groupLabel }}</span><em>{{ $pages->count() }}</em></div>
        <div class="docs-grid">
          @foreach ($pages as $slug => $page)
            <a class="docs-card reveal" href="{{ route('docs.show', $slug) }}" data-search-item data-search="{{ Str::lower($page['title'] . ' ' . $page['description'] . ' ' . implode(' ', $page['sections'])) }}">
              <span class="docs-card-top">
                <span class="fi"><i class="fa-solid {{ $page['icon'] }}"></i></span>
                <em>{{ $page['number'] }}</em>
              </span>
              <b>{{ $page['title'] }}</b>
              <p>{{ $page['description'] }}</p>
              <span class="docs-card-foot">
                <small>මාතෘකා {{ count($page['sections']) }}</small>
                <span class="feat-more">කියවන්න <i class="fa-solid fa-arrow-right"></i></span>
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endforeach

    <a class="docs-api-band reveal" href="{{ route('docs.api.index') }}">
      <span class="fi"><i class="fa-solid fa-code"></i></span>
      <div>
        <span class="label">සංවර්ධකයින් සඳහා</span>
        <b>API යොමුව</b>
        <p>කාණ්ඩ {{ count(config('api-docs.groups')) }}ක් යටතේ REST endpoint {{ config('api-docs.endpoint_count') }}ක්, පරාමිති සහ නියැදි ප්‍රතිචාර සමඟ.</p>
      </div>
      <span class="feat-more">API බලන්න <i class="fa-solid fa-arrow-right"></i></span>
    </a>

    <div class="docs-help reveal">
      <span class="fi"><i class="fa-solid fa-headset"></i></span>
      <div>
        <b>ඔබට අවශ්‍ය දේ සොයාගත නොහැකිද?</b>
        <p>අපේ කණ්ඩායම ඔබට පියවරෙන් පියවර උදව් කරයි. පණිවිඩයක් එවන්න, අපි ඉක්මනින් ඔබව සම්බන්ධ කරගන්නම්.</p>
      </div>
      <a class="btn btn-ink" href="{{ route('contact') }}">අප අමතන්න <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
@endsection
