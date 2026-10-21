<!-- ABOUT: HERO -->
<section class="abt-hero">
  <div class="wrap">
    <div class="abt-hero-in">
      <div class="head">
        <span class="label">Zeebroo ගැන</span>
        <h1 class="rise"><span class="line"><span>කාර්යබහුල කවුන්ටර පිටුපස</span></span><span class="line"><span>ඇති <span class="mark">පද්ධතිය අපි ගොඩනගමු.</span></span></span></h1>
        <p class="fade-in">Zeebroo යනු විකුණුම්, තොගය, බිල්පත්, කාර්ය මණ්ඩලය සහ වර්ධනය සඳහා එකම වේදිකාවකි. පැතුරුම්පත් ගළපනවාට වඩා ගනුදෙනුකරුවන්ට සේවය කිරීමට කැමති සාප්පු හිමියන්, ආපනශාලා සහ වර්ධනය වන සමාගම් සඳහා අපි එය නිර්මාණය කරමු.</p>
        <div class="abt-hero-ctas fade-in" style="--d:.45s">
          <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Zeebroo සමඟ ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
          <a class="btn btn-line" href="{{ route('contact') }}"><i class="fa-regular fa-calendar"></i> ආදර්ශනයක් වෙන් කරන්න</a>
        </div>
      </div>
      <div class="abt-hero-art fade-in" style="--d:.5s">
        <img src="{{ asset('assets/mascot.webp') }}" alt="Zeebroo චරිතය: සූට් එකක් ඇඳ බෑගයක් අතැති සීබ්‍රාවෙක්" width="481" height="731">
      </div>
    </div>

    <div class="ptn-stats abt-stats reveal">
      <div><b>{{ $features->count() }}</b><span>ඇතුළත් මොඩියුල</span></div>
      <div><b>{{ $industries->count() }}</b><span>සේවය කරන ක්ෂේත්‍ර</span></div>
      @if ($partnerCount > 0)
        <div><b>{{ $partnerCount }}</b><span>හවුල්කරුවන් සහ ගනුදෙනුකරුවන්</span></div>
      @endif
      @if ($averageRating !== null)
        <div><b>{{ number_format($averageRating, 1) }}<i class="fa-solid fa-star"></i></b><span>සාමාන්‍ය ශ්‍රේණිගත කිරීම</span></div>
      @else
        <div><b>4</b><span>වේදිකා: වෙබ්, Windows, macOS, Linux</span></div>
      @endif
    </div>
  </div>
</section>
