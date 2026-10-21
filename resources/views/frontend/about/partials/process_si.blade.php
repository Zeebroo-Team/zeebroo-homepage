<!-- ABOUT: HOW WE WORK WITH YOU -->
@php($steps = [
    ['icon' => 'fa-comments', 'title' => 'ඔබේ අවශ්‍යතා අපට පවසන්න', 'text' => 'ඔබේ වෙළඳසැල, ආපනශාලාව හෝ සමාගම දැනට ක්‍රියාත්මක වන ආකාරය අප සමඟ බෙදාගන්න. ඒ අනුව Zeebroo ඔබට ගැළපෙන ආකාරය අපි පැහැදිලිව පෙන්වා දෙන්නෙමු.'],
    ['icon' => 'fa-screwdriver-wrench', 'title' => 'එක්ව පද්ධතිය සකසමු', 'text' => 'ඔබේ සමාගම, ශාඛා, භාණ්ඩ සහ සේවකයින් ඔබ සමඟම සකසන බැවින්, කිසිවක් අවිනිශ්චිතව ඉතිරි නොවේ.'],
    ['icon' => 'fa-cash-register', 'title' => 'පළමු විකුණුම සිදු කරන්න', 'text' => 'වෙබ් බ්‍රවුසරය හෝ ඩෙස්ක්ටොප් යෙදුම හරහා භාවිතය ආරම්භ කරන්න. ඔබ සූදානම් ඕනෑම අවස්ථාවක බාර්කෝඩ් ස්කෑනරයක් සහ රිසිට් මුද්‍රකයක් සම්බන්ධ කරගත හැක.'],
    ['icon' => 'fa-chart-line', 'title' => 'විශ්වාසයෙන් වර්ධනය වන්න', 'text' => 'නව මොඩියුල එකතු කරන්න, නව ශාඛා විවෘත කරන්න හෝ ඉහළ පැකේජයකට මාරු වන්න. සෑම පියවරකදීම ඔබේ දත්ත සහ පැරණි වාර්තා සුරක්ෂිතව පවතී.'],
])
<section class="section abt-process">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">අප සමඟ කටයුතු කරන ආකාරය</span>
      <h2>පළමු සාකච්ඡාවේ සිට පළමු විකුණුම දක්වා.</h2>
      <p>නව පද්ධතියකට මාරු වීම අපහසු බවක් පෙනුණද, අප සමඟ එය පැහැදිලි පියවර හතරකින් සමන්විතයි. සෑම පියවරකදීම අපගේ කණ්ඩායම ඔබ සමඟ සිටී.</p>
    </div>
    <ol class="abt-steps">
      @foreach ($steps as $step)
        <li class="abt-step reveal">
          <div class="abt-step-t"><span>පියවර {{ $loop->iteration }}</span><i class="fa-solid {{ $step['icon'] }}"></i></div>
          <h3>{{ $step['title'] }}</h3>
          <p>{{ $step['text'] }}</p>
        </li>
      @endforeach
    </ol>
  </div>
</section>
