<!-- ABOUT: VALUES -->
@php($values = [
    ['icon' => 'fa-wand-magic-sparkles', 'title' => 'පෙරනිමියෙන්ම සරලයි', 'text' => 'නව මුදල් අයකැමියෙකුට එක් සේවා මුරයකින් එය ඉගෙනගත නොහැකි නම්, එය තවම නිම නැත. විශේෂාංග එක් කිරීමට පෙර අපි පියවර අඩු කරමු.'],
    ['icon' => 'fa-database', 'title' => 'සත්‍යයේ එකම මූලාශ්‍රය', 'text' => 'සෑම මොඩියුලයක්ම එකම සජීවී දත්ත බෙදාගන්නා නිසා, මුදල් ලාච්චුව, ලෙජරය සහ ගබඩාව සැමවිටම එකඟ වේ.'],
    ['icon' => 'fa-user-shield', 'title' => 'ඔබේ දත්ත, ඔබේ නීති', 'text' => 'භූමිකාව සහ ශාඛාව අනුව අවසර නිසා, සංවේදී ඉලක්කම් සැබවින්ම අවශ්‍ය අය වෙත පමණක් සීමා වේ.'],
    ['icon' => 'fa-seedling', 'title' => 'ඔබේ වේගයට වර්ධනය වන්න', 'text' => 'POS සමඟ ආරම්භ කර, ඔබේ ව්‍යාපාරය සූදානම් වූ දිනයේ තොගය, බිල්පත්, මානව සම්පත් හෝ ප්‍රචාරණ සක්‍රිය කරන්න.'],
    ['icon' => 'fa-headset', 'title' => 'සැබෑ මිනිසුන්, සැබෑ උදව්', 'text' => 'ටිකට් පෝලිමකට නොව, මිනිසෙකු හා කතා කරන්න. සැකසීමට අපි උදව් කරන අතර සජීවීව ආරම්භ කළ පසුවද ඔබ සමඟ සිටිමු.'],
    ['icon' => 'fa-arrows-rotate', 'title' => 'නිරන්තරයෙන් දියුණු වෙමින්', 'text' => 'යාවත්කාලීන කිරීම් වෙබ් සහ ඩෙස්ක්ටොප් වෙත එකවර ළඟා වන අතර, ඒවා හැඩගැසෙන්නේ අපේ ගනුදෙනුකරුවන් කවුන්ටරයේදී ඉල්ලන දේ අනුවයි.'],
])
<section class="section abt-values">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">අප විශ්වාස කරන දේ</span>
      <h2>සෑම තිරයක් පිටුපසම ඇති පොරොන්දු හය.</h2>
      <p>අප ගොඩනගන දේ, අතහැර දමන දේ සහ තම දවස අප වෙත භාර දෙන ව්‍යාපාර සමඟ අප කටයුතු කරන ආකාරය මේවායින් හැඩගැසේ.</p>
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
