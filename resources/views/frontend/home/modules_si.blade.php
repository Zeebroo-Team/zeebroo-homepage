@php($homeModules = $navFeatures->where('group', 'core')->values())
<!-- MODULES -->
<section class="section" id="modules">
  <div class="wrap">
    <div class="head reveal">
      <h2>දැන් අවශ්‍ය දේ සක්‍රිය කරන්න. ව්‍යාපාරය වැඩෙද්දී අනෙකුත් මොඩියුල එකතු කරන්න.</h2>
      <p>හැම මොඩියුලයක්ම එකම දත්ත භාවිත කරන නිසා, කැෂ් ලාච්චුවේ මුදලයි ගිණුම් පොතයි හැමවිටම ගැළපෙනවා.</p>
    </div>
    @if ($homeModules->isNotEmpty())
      <div class="mods reveal">
        <div class="mod-list" id="modList" role="listbox" aria-label="Modules"></div>
        <div class="mod-view" id="modView" aria-live="polite">
          <span class="mod-status" id="modStatus">සක්‍රියයි</span>
          <div class="art"><img id="modImg" src="{{ $homeModules[0]->spot_url }}" alt="" width="344" height="347" @if (! $homeModules[0]->spot_url) hidden @endif></div>
          <h3 id="modTitle"></h3>
          <p id="modDesc"></p>
          <a class="mod-more" id="modMore" href="{{ route('features.show', $homeModules[0]->slug) }}">තවත් දැනගන්න <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
      {{-- read by script.js to build the module switcher --}}
      <script type="application/json" id="modData">{!! $homeModules->map(fn ($f) => [
        't' => $f->title,
        's' => $f->menu,
        'd' => $f->lead,
        'img' => $f->spot_url,
        'u' => route('features.show', $f->slug),
        'i' => $f->icon,
      ])->toJson(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endif
    <div class="suite reveal">
      <span>ඒ වගේම මේවාත් ඇතුළත්:</span>
      @foreach ($navFeatures->where('group', 'suite') as $f)
        <a href="{{ route('features.show', $f->slug) }}"><i class="fa-solid {{ $f->icon }}"></i>{{ $f->title }}@if ($f->badge) <span class="new">{{ $f->badge }}</span>@endif</a>
      @endforeach
    </div>
  </div>
</section>
