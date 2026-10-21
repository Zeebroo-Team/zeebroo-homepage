<!-- ABOUT: HERO -->
<section class="abt-hero">
  <div class="wrap">
    <div class="abt-hero-in">
      <div class="head">
        <span class="label">Zeebroo ගැන</span>
        <h1 class="rise"><span class="line"><span>කාර්යබහුල ව්‍යාපාර සඳහා</span></span><span class="line"><span><span class="mark">විශ්වසනීය පද්ධතියක්.</span></span></span></h1>
        <p class="fade-in">Zeebroo යනු විකුණුම්, තොග, බිල්පත්, සේවක කළමනාකරණය සහ ව්‍යාපාර වර්ධනය එකම තැනකින් පාලනය කළ හැකි පද්ධතියකි. වාර්තා ගැළපීමට කාලය වැය කරනවා වෙනුවට පාරිභෝගිකයන්ට සේවය කිරීමට අවධානය යොමු කරන වෙළඳසැල්, ආපනශාලා සහ වර්ධනය වන ව්‍යාපාර සඳහා අපි එය නිර්මාණය කර ඇත්තෙමු.</p>
        <div class="abt-hero-ctas fade-in" style="--d:.45s">
          <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Zeebroo සමඟ ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
          <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-calendar"></i> Demo සැසියක් වෙන් කරන්න</a>
        </div>
      </div>
      <div class="abt-hero-art fade-in" style="--d:.5s">
        <img src="{{ asset('assets/mascot.webp') }}" alt="සූට් ඇඳගත් Zeebroo සීබ්‍රා චරිතය" width="481" height="731">
      </div>
    </div>

    <div class="ptn-stats abt-stats reveal">
      <div><b>{{ $features->count() }}</b><span>ඇතුළත් මොඩියුල</span></div>
      <div><b>{{ $industries->count() }}</b><span>සහාය දක්වන ව්‍යාපාර ක්ෂේත්‍ර</span></div>
      @if ($partnerCount > 0)
        <div><b>{{ $partnerCount }}</b><span>හවුල්කරුවන් සහ ගනුදෙනුකරුවන්</span></div>
      @endif
      @if ($averageRating !== null)
        <div><b>{{ number_format($averageRating, 1) }}<i class="fa-solid fa-star"></i></b><span>සාමාන්‍ය ඇගයීම</span></div>
      @else
        <div><b>4</b><span>වෙබ්, Windows, macOS, Linux</span></div>
      @endif
    </div>
  </div>
</section>
