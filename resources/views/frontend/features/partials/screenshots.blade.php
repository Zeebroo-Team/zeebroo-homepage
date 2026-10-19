@if ($feature->screenshots->isNotEmpty())
<!-- FEATURE SCREENSHOTS -->
<section class="section">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">See it in action</span>
      <h2>{{ $feature->title }} inside Zeebroo</h2>
    </div>
    <div @class(['feat-shots', 'feat-shots-1' => $feature->screenshots->count() === 1])>
      @foreach ($feature->screenshots as $shot)
        <figure class="feat-shot reveal">
          <button type="button" class="feat-shot-img" data-shot="{{ $shot->url }}" data-caption="{{ $shot->caption }}" aria-label="View larger{{ $shot->caption ? ': ' . $shot->caption : '' }}">
            <span class="feat-shot-bar" aria-hidden="true"><i></i><i></i><i></i></span>
            <img src="{{ $shot->url }}" alt="{{ $shot->caption ?: $feature->title . ' screenshot ' . $loop->iteration }}" loading="lazy">
          </button>
          @if ($shot->caption)<figcaption>{{ $shot->caption }}</figcaption>@endif
        </figure>
      @endforeach
    </div>
  </div>
</section>

<dialog class="feat-lightbox" id="shotBox" aria-label="Screenshot">
  <button type="button" class="feat-lb-x" data-lb-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
  @if ($feature->screenshots->count() > 1)
    <button type="button" class="feat-lb-nav prev" data-lb-step="-1" aria-label="Previous screenshot"><i class="fa-solid fa-arrow-left"></i></button>
    <button type="button" class="feat-lb-nav next" data-lb-step="1" aria-label="Next screenshot"><i class="fa-solid fa-arrow-right"></i></button>
  @endif
  <figure><img src="" alt=""><figcaption></figcaption></figure>
</dialog>
@endif
