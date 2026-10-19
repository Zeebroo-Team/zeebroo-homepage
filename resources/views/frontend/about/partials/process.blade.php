<!-- ABOUT: HOW WE WORK WITH YOU -->
@php($steps = [
    ['icon' => 'fa-comments', 'title' => 'Tell us how you work', 'text' => 'Share how your shop, kitchen or company runs today. We listen first, then show you exactly how Zeebroo fits.'],
    ['icon' => 'fa-screwdriver-wrench', 'title' => 'We set it up together', 'text' => 'Your company, branches, products and team, configured with you so nothing is left to guesswork.'],
    ['icon' => 'fa-cash-register', 'title' => 'Make your first sale', 'text' => 'Go live in the browser or on the desktop app. Add a barcode scanner and receipt printer whenever you\'re ready.'],
    ['icon' => 'fa-chart-line', 'title' => 'Grow with confidence', 'text' => 'Add modules, open new branches or move up a package. Your data and history come with you every step.'],
])
<section class="section abt-process">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Working with us</span>
      <h2>From first call to first sale.</h2>
      <p>Switching systems sounds hard. With us it's four clear steps, and you're never doing them alone.</p>
    </div>
    <ol class="abt-steps">
      @foreach ($steps as $step)
        <li class="abt-step reveal">
          <div class="abt-step-t"><span>Step {{ $loop->iteration }}</span><i class="fa-solid {{ $step['icon'] }}"></i></div>
          <h3>{{ $step['title'] }}</h3>
          <p>{{ $step['text'] }}</p>
        </li>
      @endforeach
    </ol>
  </div>
</section>
