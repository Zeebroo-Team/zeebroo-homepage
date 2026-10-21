<!-- FEATURE HERO -->
<section class="feat-hero">
  <div class="wrap feat-hero-grid">
    <div class="feat-copy">
      <nav class="crumbs" aria-label="පිටු මාර්ගය">
        <a href="{{ route('home') }}">මුල් පිටුව</a><i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('features.index') }}">විශේෂාංග</a><i class="fa-solid fa-chevron-right"></i>
        <span aria-current="page">{{ $feature->title }}</span>
      </nav>
      <span class="feat-tag"><i class="fa-solid {{ $feature->icon }}"></i>{{ $feature->title }}@if ($feature->badge) <em>{{ $feature->badge }}</em>@endif</span>
      <h1 class="rise">@include('frontend.components.rise-title', ['text' => $feature->headline ?: $feature->title])</h1>
      @if ($feature->lead)
        <p class="feat-lead fade-in">{{ $feature->lead }}</p>
      @endif
      <div class="feat-ctas fade-in" style="--d:.42s">
        <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-envelope"></i> ආදර්ශනයක් වෙන් කරන්න</a>
      </div>
      <ul class="feat-meta fade-in" style="--d:.54s">
        <li><i class="fa-solid fa-check"></i>{{ $feature->group === 'core' ? 'ප්‍රධාන මොඩියුලයක්' : 'Zeebroo හි ඇතුළත්' }}</li>
        <li><i class="fa-solid fa-check"></i>වෙබ් සහ ඩෙස්ක්ටොප්</li>
        <li><i class="fa-solid fa-check"></i>බෙදාගත්, සජීවී දත්ත</li>
      </ul>
    </div>

    <div class="feat-art fade-in" style="--d:.2s" aria-hidden="true">
      @if ($feature->spot_url)
        <img src="{{ $feature->spot_url }}" alt="" width="344" height="347" fetchpriority="high">
      @else
        {{-- no preview image: the module icon with its first three highlights orbiting it --}}
        <div class="feat-orbit">
          <span class="feat-orbit-ic"><i class="fa-solid {{ $feature->icon }}"></i></span>
          @foreach (array_slice($feature->highlights ?? [], 0, 3) as $h)
            <span class="feat-chip feat-chip-{{ $loop->iteration }}"><i class="fa-solid {{ $h['icon'] }}"></i>{{ $h['title'] }}</span>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
