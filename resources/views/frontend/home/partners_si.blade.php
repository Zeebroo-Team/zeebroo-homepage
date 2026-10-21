@if ($featuredPartners->isNotEmpty())
<!-- PARTNERS -->
<section class="section" id="partners">
  <div class="wrap">
    <div class="head reveal">
      <h2>ව්‍යාපාර සහ හවුල්කරුවන් විශ්වාස කරයි.</h2>
      <p>අප සමඟ එක්ව ගොඩනගන සමාගම් සහ සෑම දිනකම Zeebroo මත ක්‍රියාත්මක වන ව්‍යාපාර.</p>
    </div>
    <div class="ptn-strip reveal">
      <div class="ptn-track">
        @foreach ([false, true] as $copy)
          <ul class="ptn-row" @if ($copy) aria-hidden="true" @endif>
            @foreach ($featuredPartners as $partner)
              <li title="{{ $partner->name }}">
                @include('frontend.partners.partials.logo', ['partner' => $partner])
                <span>{{ $partner->name }}</span>
              </li>
            @endforeach
          </ul>
        @endforeach
      </div>
    </div>
    <a class="btn btn-line ptn-more" href="{{ route('partners.index') }}">සියලුම හවුල්කරුවන් සහ ගනුදෙනුකරුවන් බලන්න <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>
@endif
