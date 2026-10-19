@if ($feature['scene'])
<!-- FEATURE SCENE -->
<section class="wrap feat-scene-wrap">
  <figure class="feat-scene reveal">
    <img src="{{ asset('assets/features/' . $feature['scene']) }}" alt="Zeebroo zebra using {{ $feature['title'] }}" width="1280" height="768" loading="lazy">
  </figure>
</section>
@endif
