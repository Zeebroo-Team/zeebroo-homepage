<figure class="screenshot-figure">
  <img src="{{ asset('assets/docs/09-rst-pos.png') }}" alt="අවන්හල් POS ටැබය" loading="lazy">
  <figcaption class="screenshot-caption">අවන්හල් POS: වම් පසින් මෙනු ජාලය, දකුණු පසින් සක්‍රිය ඇණවුමේ කරත්තය. ඇණවුමට එක් කිරීමට අයිතම තෝරා, අවසානයේ ගෙවීම ලබාගන්න.</figcaption>
</figure>

<div class="doc-sec">
  <h3 id="the-restaurant-pos-interface">අවන්හල් POS තිරය</h3>
  <p>ඇණවුම් ගන්නා තිරය විවෘත කිරීමට <span class="tab-label">RESTAURANT POS</span> ටැබය ක්ලික් කරන්න. රිබනයෙන් මාරු කළ හැකි මාදිලි දෙකක් ඇත:</p>
  <ul>
    <li><strong>Takeaway මාදිලිය</strong>: මේසයක් නොමැති ඇණවුම්. පාරිභෝගිකයාගේ නම සහ දුරකථන අංකය ඇතුළත් කරන්න.</li>
    <li><strong>Table මාදිලිය</strong>: ඇණවුම මේසයකට සම්බන්ධ කිරීමට ආසන සැලැස්මෙන් මේසයක් තෝරන්න.</li>
  </ul>
  <p>වම් පස <strong>මෙනු ජාලය</strong> (කාණ්ඩ අනුව අයිතම) ද, දකුණු පස <strong>කරත්තය / වත්මන් ඇණවුම</strong> ද පෙන්වයි. ඉහළින් ඇති ටැබ් මගින් එකවර සක්‍රිය ඇණවුම් කිහිපයක් කළමනාකරණය කළ හැක.</p>
</div>

<div class="doc-sec">
  <h3 id="taking-a-table-order">මේස ඇණවුමක් ගැනීම</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>මේසයක් තෝරන්න</strong>
        <p>අවන්හල් POS රිබනයේ <span class="ui">Tables</span> ක්ලික් කරන්න. ආසන සැලැස්ම විවෘත වේ: හිස් මේසයක් (කොළ පැහැයෙන් පෙන්වන) ක්ලික් කරන්න. එම මේසය සඳහා නව ටැබයක් විවෘත වේ.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>මෙනු ජාලයෙන් අයිතම එක් කරන්න</strong>
        <p>ඇණවුමට එක් කිරීමට මෙනු අයිතම කාඩ්පත් ක්ලික් කරන්න. ප්‍රමාණය වැඩි කිරීමට කාඩ්පත කිහිප වතාවක් ක්ලික් කරන්න. සෑම අයිතමයකම මුළුතැන්ගෙයි තත්ත්වය සටහන් වේ.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>මුළුතැන්ගෙයට යවන්න</strong>
        <p><span class="ui">Send Order</span> ක්ලික් කරන්න. ඇණවුම පද්ධතියේ සැකසෙන අතර මුළුතැන්ගෙයි KDS තිරයේ වහාම දිස්වේ. මේසයේ තත්ත්වය <strong>Occupied</strong> ලෙස වෙනස් වේ.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">4</div>
      <div class="step-body">
        <strong>මුළුතැන්ගෙයි තත්ත්වය බලන්න</strong>
        <p>කරත්තයේ සෑම අයිතමයකම මුළුතැන්ගෙයි තත්ත්වය පෙන්වයි: <strong>Pending → Preparing → Ready → Served</strong>. කාර්ය මණ්ඩලය KDS හි අයිතම සලකුණු කරන විට තත්ත්වය සජීවීව යාවත්කාලීන වේ. ඉහළ තීරුවේ සජීවී දර්ශකය දැල්වෙන්නේ යාවත්කාලීන කිරීම ක්‍රියාත්මක බව පෙන්වීමටයි.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">5</div>
      <div class="step-body">
        <strong>සේවය අතරතුර තවත් අයිතම එක් කරන්න</strong>
        <p>ඇණවුම තවමත් <strong>Pending</strong> නම්, නව අයිතම එම මුළුතැන්ගෙයි ටිකට්පතටම එක් වේ. මුළුතැන්ගෙය දැනටමත් <strong>Preparing</strong> නම්, නව අයිතම ස්වයංක්‍රීයව <em>වෙනම නව කාඩ්පතක්</em> ලෙස යවයි. ඒ නිසා කිසිවක් මඟ හැරෙන්නේ නැත.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">6</div>
      <div class="step-body">
        <strong>ඇණවුම අවසන් කර ගෙවීම ලබාගන්න</strong>
        <p><span class="ui">Complete Order</span> බොත්තම සක්‍රිය වන්නේ ඇණවුම් කළ <em>සියලු</em> අයිතම KDS හි <strong>Served</strong> ලෙස සලකුණු කළ පසු පමණි. ගෙවීම් තිරය විවෘත කිරීමට එය ක්ලික් කරන්න.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">7</div>
      <div class="step-body">
        <strong>ගෙවීම් ක්‍රමය තෝරා තහවුරු කරන්න</strong>
        <p><strong>Cash</strong>, <strong>Card</strong> හෝ <strong>Bank Transfer</strong> තෝරන්න. මුදල් ගෙවීමකදී ලැබුණු මුදල ඇතුළත් කරන්න. <span class="ui">Confirm Payment</span> ක්ලික් කරන්න. රිසිට්පතක් මුද්‍රණය වන අතර, ඇණවුම Paid ලෙස සලකුණු වී මේසය නැවත Available (හිස්) වේ.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="taking-a-takeaway-order">රැගෙන යන ඇණවුමක් ගැනීම</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>රිබනයේ Takeaway ක්ලික් කරන්න</strong>
        <p>පාරිභෝගිකයාගේ නම/දුරකථන ක්ෂේත්‍ර සහිත නව ටැබයක් විවෘත වේ.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>පාරිභෝගික තොරතුරු ඇතුළත් කර අයිතම එක් කරන්න</strong>
        <p>පාරිභෝගිකයාගේ නම සහ දුරකථන අංකය පුරවන්න (අනිවාර්ය නොවේ, නමුත් ඇණවුම සූදානම් බව දැනුම් දීමට ප්‍රයෝජනවත්ය). ජාලයෙන් මෙනු අයිතම එක් කරන්න.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>මුළුතැන්ගෙයට යවා අවසන් කරන්න</strong>
        <p>මේස ඇණවුමක් හා සමාන ක්‍රියාවලියයි: යවන්න, KDS හි තත්ත්වය බලන්න, සියලු අයිතම සූදානම් වූ විට අවසන් කරන්න.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="multiple-active-orders">එකවර ඇණවුම් කිහිපයක්</h3>
  <p>අවන්හල් POS හි ඉහළින් ඇති සෑම ටැබයක්ම සක්‍රිය ඇණවුමක් (මේසයක් හෝ රැගෙන යන ඇණවුමක්) නියෝජනය කරයි. ඔබට අවශ්‍ය තරම් ටැබ් විවෘත කළ හැක. ටැබ් අතර මාරු වීමෙන් දත්ත කිසිවක් නැති නොවේ: සෑම ටැබයකම කරත්තය, ඇණවුම් අංකය සහ මුළුතැන්ගෙයි තත්ත්වය වෙන වෙනම සටහන් වේ.</p>
  <div class="callout warn">
    <div class="callout-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="callout-body">
      <strong>වැදගත්</strong>
      මුළුතැන්ගෙය ඇණවුමක් පිසීම ආරම්භ කළ පසු (තත්ත්වය: Preparing), පවතින අයිතමවල ප්‍රමාණය වැඩි කළ නොහැක. අමතර ප්‍රමාණ වෙනම අයිතම ලෙස එක් කරන්න: ඒවා නව KDS කාඩ්පතක දිස්වේ.
    </div>
  </div>
</div>
