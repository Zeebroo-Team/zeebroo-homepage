@if ($feature->scene_url)
<!-- FEATURE SCENE -->
<section class="wrap feat-scene-wrap">
  <figure class="feat-scene reveal">
    <img src="{{ $feature->scene_url }}" alt="Zeebroo zebra using {{ $feature->title }}" width="1280" height="768" loading="lazy">
  </figure>
</section>
@endif
