<!-- ABOUT: VALUES -->
@php($values = [
    ['icon' => 'fa-wand-magic-sparkles', 'title' => 'Simple by default', 'text' => 'If a new cashier can\'t learn it in one shift, it isn\'t finished. We cut steps before we add features.'],
    ['icon' => 'fa-database', 'title' => 'One source of truth', 'text' => 'Every module shares the same live data, so the register, the ledger and the stockroom always agree.'],
    ['icon' => 'fa-user-shield', 'title' => 'Your data, your rules', 'text' => 'Permissions per role and per branch keep sensitive figures with the people who actually need them.'],
    ['icon' => 'fa-seedling', 'title' => 'Grow at your pace', 'text' => 'Start with POS, then switch on stock, bills, HR or campaigns the day your business is ready for them.'],
    ['icon' => 'fa-headset', 'title' => 'Real people, real help', 'text' => 'Talk to a person, not a ticket queue. We help you get set up and stay with you after go-live.'],
    ['icon' => 'fa-arrows-rotate', 'title' => 'Always improving', 'text' => 'Updates reach web and desktop together, shaped by what our customers ask for at the counter.'],
])
<section class="section abt-values">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">What we believe</span>
      <h2>Six promises behind every screen.</h2>
      <p>These shape what we build, what we leave out, and how we treat the businesses that trust us with their day.</p>
    </div>
    <div class="abt-val-grid">
      @foreach ($values as $value)
        <article class="abt-val reveal">
          <span class="abt-val-n">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <span class="abt-val-ic"><i class="fa-solid {{ $value['icon'] }}"></i></span>
          <h3>{{ $value['title'] }}</h3>
          <p>{{ $value['text'] }}</p>
        </article>
      @endforeach
    </div>
  </div>
</section>
