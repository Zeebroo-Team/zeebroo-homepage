<!-- ABOUT: HOW WE WORK WITH YOU -->
@php($steps = [
    ['icon' => 'fa-comments', 'title' => 'ඔබ වැඩ කරන ආකාරය අපට කියන්න', 'text' => 'ඔබේ සාප්පුව, කුස්සිය හෝ සමාගම අද ක්‍රියාත්මක වන ආකාරය බෙදාගන්න. අපි මුලින්ම සවන් දී, පසුව Zeebroo ගැළපෙන ආකාරය නිවැරදිවම පෙන්වමු.'],
    ['icon' => 'fa-screwdriver-wrench', 'title' => 'අපි එකට එය සකසමු', 'text' => 'ඔබේ සමාගම, ශාඛා, භාණ්ඩ සහ කණ්ඩායම ඔබ සමඟම සකසන නිසා, කිසිවක් අනුමානයට ඉතිරි නොවේ.'],
    ['icon' => 'fa-cash-register', 'title' => 'ඔබේ පළමු විකුණුම කරන්න', 'text' => 'බ්‍රව්සරයේ හෝ ඩෙස්ක්ටොප් යෙදුමේ සජීවීව ආරම්භ කරන්න. ඔබ සූදානම් ඕනෑම වේලාවක බාර්කෝඩ් ස්කෑනරයක් සහ රිසිට් මුද්‍රකයක් එක් කරන්න.'],
    ['icon' => 'fa-chart-line', 'title' => 'විශ්වාසයෙන් වර්ධනය වන්න', 'text' => 'මොඩියුල එක් කරන්න, නව ශාඛා විවෘත කරන්න හෝ ඉහළ පැකේජයකට යන්න. සෑම පියවරකදීම ඔබේ දත්ත සහ ඉතිහාසය ඔබ සමඟම පැමිණේ.'],
])
<section class="section abt-process">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">අප සමඟ වැඩ කිරීම</span>
      <h2>පළමු ඇමතුමේ සිට පළමු විකුණුම දක්වා.</h2>
      <p>පද්ධති මාරු කිරීම අපහසු බව පෙනේ. අප සමඟ එය පැහැදිලි පියවර හතරක් පමණක් වන අතර, ඔබ කිසිදා ඒවා තනිව කරන්නේ නැහැ.</p>
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
