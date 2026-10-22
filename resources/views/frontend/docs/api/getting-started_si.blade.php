@verbatim
<div class="doc-sec">
  <h3>මූලික URL (Base URL)</h3>
  <p>API හි වැඩි කොටසක් ඇත්තේ <code class="ui">/api/v1/pos</code> යටතේය. මොඩියුල කිහිපයකට (Developers, සහ Platform Modules හි බොහොමයක්) තමන්ගේම මූලික මාර්ග ඇත: සම්පූර්ණ මාර්ගය සෑම endpoint කාඩ්පතකම සැමවිටම පෙන්වා ඇත.</p>
</div>

<div class="doc-sec">
  <h3>පිවිසුම (Authentication)</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body"><strong>token එකක් ලබාගන්න</strong><p><code class="ui">email</code> + <code class="ui">password</code> සමඟ <code class="ui">POST /auth/token</code> යවන්න → <code class="ui">access_token</code> එකක් ලැබේ.</p></div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body"><strong>ආරක්ෂිත සෑම ඉල්ලීමකම එය යවන්න</strong><p>Header: <code class="ui">Authorization: Bearer {access_token}</code></p></div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3>ව්‍යාපාරය සහ ශාඛාව</h3>
  <p>බොහෝ endpoint ව්‍යාපාරයකට සීමා වේ. පහත ඒවායින් <strong>එකක්</strong> යවන්න:</p>
  <ul>
    <li>Header <code class="ui">X-Business-Id: {id}</code> <em>(නිර්දේශිතයි)</em></li>
    <li>Query param <code class="ui">?business_id={id}</code></li>
  </ul>
  <p>කිසිවක් නොයැවුවහොත්, API පිවිසී ඇති පරිශීලකයා අවසන් වරට තේරූ ව්‍යාපාරය භාවිත කරයි. ශාඛා මට්ටමේ POS වෙන් කිරීම සක්‍රිය නම්, අමතරව <code class="ui">X-Branch-Id: {id}</code> header එකද යවන්න.</p>
</div>

<div class="doc-sec">
  <h3>ප්‍රතිචාර ආකෘතිය</h3>
  <p>සාර්ථක ප්‍රතිචාර <code class="ui">{ "data": … }</code> ආකෘතිය අනුගමනය කරයි. ලැයිස්තුවලට පිටු තොරතුරු එක් වේ: <code class="ui">{ "data": […], "meta": { pagination } }</code>. දෝෂ අදාළ HTTP තත්ත්ව කේතය සමඟ <code class="ui">{ "message": "…", "errors": { "field": ["…"] } }</code> ලෙස ලැබේ.</p>
</div>

<div class="callout note">
  <div class="callout-icon"><i class="fa-solid fa-circle-info"></i></div>
  <div class="callout-body"><strong>මූලාශ්‍රය</strong>Pos මොඩියුලයේ විශාල කොටසකට (auth, catalog, checkout, products, sales, invoicing, purchasing, HR/payroll) <code class="ui">Modules/Pos/docs/openapi.yaml</code> හි අතින් නඩත්තු කරන OpenAPI 3.0 පිරිවිතරයක් ඇති අතර, එය <code class="ui">/api/v1/pos/docs/openapi.yaml</code> හි සජීවීව ලබාගත හැක. මෙම යොමුව සකස් කළේ එම පිරිවිතරය සහ එයට තවම ඇතුළත් නොවූ endpoint සඳහා සෑම controller එකක්ම සෘජුව කියවීමෙන් ලබාගත් තොරතුරු ඒකාබද්ධ කිරීමෙනි.</div>
</div>
@endverbatim
