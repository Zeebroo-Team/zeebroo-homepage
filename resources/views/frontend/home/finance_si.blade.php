<!-- FINANCE MAP -->
<section class="section dark">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">මුදල් කළමනාකරණය</span>
      <h2>හැම රුපියලක්ම එන්නේ කොහෙන්ද, යන්නේ කොහෙටද කියලා බලන්න.</h2>
      <p>බිල්, ණය, ලීසිං සහ ආදායම එකම සජීවී සිතියමක. ගෙවීම් පමාද වන දේ ප්‍රශ්නයක් වෙන්න කලින්ම ඔබට පෙන්වනවා.</p>
    </div>
    <div class="flow-box reveal">
      <svg class="flow" id="flow" viewBox="0 0 1240 560" role="img" aria-label="රූප සටහන: ආදායම් මාර්ග හතරකින් ව්‍යාපාරයට මුදල් ලැබෙන අතර, ව්‍යාපාරය බිල් සහ ණය ගෙවයි"></svg>
    </div>
    <div class="flow-foot"><span>බිලක් හෝ ආදායම් මාර්ගයක් ගැන බලන්න, එය මතට මවුසය ගෙන යන්න.</span><span>උදාහරණ දත්ත</span></div>
  </div>
</section>

<!-- PLATFORMS -->
<section class="section" id="download">
  <div class="wrap">
    <div class="head reveal">
      <h2>කවුන්ටරයෙන්, අන්තර්ජාලයෙන් හෝ පරිගණකයෙන් ඕනෑම තැනක සිට විකුණන්න.</h2>
      <p>කිසිවක් ස්ථාපනය නොකර බ්‍රවුසරයෙන්ම POS භාවිත කරන්න, නැතිනම් සෑම මුදල් කවුන්ටරයකම ඩෙස්ක්ටොප් ඇප් එක ස්ථාපනය කරන්න. ඔබ කොතැනක සිට විකුණුවත්, භාණ්ඩ, ගෙවීම් සහ රිසිට්පත් සියල්ල එකම ආකාරයට ක්‍රියා කරයි.</p>
    </div>
    <div class="plat-photo reveal"><img src="assets/pos-monitor.webp" alt="සුපිරි වෙළඳසැලක කවුන්ටරයේ, බාර්කෝඩ් ස්කෑනරයක් අසල ටච් ස්ක්‍රීන් එකක Zeebroo POS" width="1600" height="1000" loading="lazy"></div>
    @php
      // Latest desktop build per OS, published from the platform's Admin → Releases
      $posDownloads = $posRelease['downloads'] ?? [];
      $posPlatforms = \App\Services\PosReleaseService::PLATFORMS;
      $posFallback = 'https://platform.zeebroo.com/register';
    @endphp
    <div class="plat-row reveal">
      <div class="os" id="posOsRow">
        @if($posDownloads)
          @foreach($posPlatforms as $key => $p)
            @isset($posDownloads[$key])
              <a href="{{ $posDownloads[$key] }}" rel="noopener" data-pos-os="{{ $key }}" data-pos-label="{{ $p['label'] }}"
                 @class(['is-active' => $key === $posDetectedOs])><i class="{{ $p['icon'] }}"></i>{{ $p['label'] }}</a>
            @endisset
          @endforeach
        @else
          <span><i class="fa-brands fa-windows"></i>Windows</span>
          <span><i class="fa-brands fa-apple"></i>macOS</span>
          <span><i class="fa-brands fa-linux"></i>Linux</span>
        @endif
        <a href="https://platform.zeebroo.com/login" rel="noopener"><i class="fa-solid fa-globe"></i>වෙබ් POS</a>
        <span><i class="fa-solid fa-print"></i>තර්මල් රිසිට්</span>
      </div>
      {{-- Points at the visitor's OS build; phones, tablets and OSes without a build get the web POS sign-up --}}
      <a class="btn btn-ink" id="posDownloadBtn" rel="noopener"
         href="{{ $posDetectedOs ? $posDownloads[$posDetectedOs] : $posFallback }}"
         data-fallback-href="{{ $posFallback }}"
         @if(!empty($posRelease['version'])) title="Zeebroo POS v{{ $posRelease['version'] }}" @endif>
        <i class="fa-solid fa-download"></i>
        <span id="posDownloadLabel">{{ $posDetectedOs ? $posPlatforms[$posDetectedOs]['label'] . ' සඳහා ඩවුන්ලෝඩ් කරන්න' : 'POS ඩවුන්ලෝඩ් කරන්න' }}</span>
      </a>
    </div>
  </div>
</section>
<script>
  (function () {
    var btn = document.getElementById('posDownloadBtn');
    var row = document.getElementById('posOsRow');
    var label = document.getElementById('posDownloadLabel');
    if (!btn || !row) return;

    function pick(os) {
      var link = os && row.querySelector('[data-pos-os="' + os + '"]');
      if (!link) return false;
      btn.href = link.href;
      label.textContent = link.getAttribute('data-pos-label') + ' සඳහා ඩවුන්ලෝඩ් කරන්න';
      row.querySelectorAll('[data-pos-os]').forEach(function (a) { a.classList.toggle('is-active', a === link); });
      return true;
    }

    var ua = navigator.userAgent;
    if (!/Macintosh|Mac OS X/.test(ua)) return;

    // iPadOS Safari reports itself as a Mac — touch support gives it away; no desktop build there
    if (navigator.maxTouchPoints > 1) {
      btn.href = btn.getAttribute('data-fallback-href');
      label.textContent = 'POS ඩවුන්ලෝඩ් කරන්න';
      row.querySelectorAll('.is-active').forEach(function (a) { a.classList.remove('is-active'); });
      return;
    }

    // Every Mac browser says "Intel Mac OS X", so the server picks the Apple chip build; switch on a positive Intel signal only.
    // Chromium exposes the CPU architecture directly.
    if (navigator.userAgentData && navigator.userAgentData.getHighEntropyValues) {
      navigator.userAgentData.getHighEntropyValues(['architecture']).then(function (v) {
        if (v.architecture === 'x86') pick('macos_intel');
      }).catch(function () {});
      return;
    }

    // Others (Firefox): only Intel Macs have Intel / AMD GPUs. Safari masks this as "Apple GPU", so it keeps the default.
    try {
      var gl = document.createElement('canvas').getContext('webgl');
      var ext = gl && gl.getExtension('WEBGL_debug_renderer_info');
      var gpu = ext ? String(gl.getParameter(ext.UNMASKED_RENDERER_WEBGL)) : '';
      if (/Intel|AMD|Radeon/i.test(gpu)) pick('macos_intel');
    } catch (e) {}
  })();
</script>