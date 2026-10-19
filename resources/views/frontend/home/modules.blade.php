<!-- MODULES -->
<section class="section" id="modules">
  <div class="wrap">
    <div class="head reveal">
      <h2>Turn on what you need. Add the rest as you grow.</h2>
      <p>Every module shares the same data, so the register and the ledger always agree.</p>
    </div>
    <div class="mods reveal">
      <div class="mod-list" id="modList" role="listbox" aria-label="Modules"></div>
      <div class="mod-view" id="modView" aria-live="polite">
        <span class="mod-status" id="modStatus">Installed</span>
        <div class="art"><img id="modImg" src="assets/features/point-of-sale.webp" alt="" width="344" height="347"></div>
        <h3 id="modTitle"></h3>
        <p id="modDesc"></p>
        <a class="mod-more" id="modMore" href="{{ route('features.show', 'point-of-sale') }}">Learn more <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>
    <div class="suite reveal">
      <span>All included, plus:</span>
      @foreach (collect(config('features'))->where('group', 'suite') as $slug => $f)
        <a href="{{ route('features.show', $slug) }}"><i class="fa-solid {{ $f['icon'] }}"></i>{{ $f['title'] }}@if ($f['badge']) <span class="new">{{ $f['badge'] }}</span>@endif</a>
      @endforeach
    </div>
  </div>
</section>