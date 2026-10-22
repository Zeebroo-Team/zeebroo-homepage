<figure class="screenshot-figure">
  <img src="{{ asset('assets/docs/04-inventory.png') }}" alt="තොග සහ නිෂ්පාදන ටැබය" loading="lazy">
  <figcaption class="screenshot-caption">Inventory ටැබය: තොග මට්ටම්, කාණ්ඩ සහ කළමනාකරණ මෙවලම් සහිත නිෂ්පාදන නාමාවලිය.</figcaption>
</figure>

<div class="doc-sec">
  <h3 id="adding-a-product">නිෂ්පාදනයක් එක් කිරීම</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Inventory විවෘත කරන්න</strong>
        <p><span class="tab-label">INVENTORY</span> ටැබය ක්ලික් කර, Catalog රිබන් කණ්ඩායමේ <span class="ui">New Product</span> ක්ලික් කරන්න.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Overview ටැබය පුරවන්න</strong>
        <p><span class="field-label">Product name</span>, <span class="field-label">Category</span>, <span class="field-label">Brand</span>, <span class="field-label">SKU</span> සහ <span class="field-label">Barcode</span> ඇතුළත් කරන්න. POS තිරයේ පෙන්වීමට නිෂ්පාදනය active (සක්‍රිය) ලෙස සලකුණු කරන්න.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>මිල සකසන්න</strong>
        <p><strong>Pricing</strong> ටැබයට ගොස් <span class="field-label">Cost price</span> (පිරිවැය මිල) සහ <span class="field-label">Selling price</span> (විකුණුම් මිල) ඇතුළත් කරන්න. අවශ්‍ය නම් විවිධ විකුණුම් ඒකක එක් කළ හැක (උදා: තනි ඒකකයක් ලෙසත්, දුසිම ලෙසත් වෙනස් මිලට විකිණීම).</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">4</div>
      <div class="step-body">
        <strong>ආරම්භක තොගය සකසන්න</strong>
        <p><strong>Stock</strong> ටැබයට ගොස් <span class="field-label">Opening stock quantity</span> සහ <span class="field-label">Low stock alert level</span> ඇතුළත් කරන්න. තොගය මෙම මට්ටමට වඩා අඩු වූ විට ඇප් එක ඔබට අනතුරු අඟවයි.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">5</div>
      <div class="step-body">
        <strong>රූප එක් කරන්න</strong>
        <p><strong>Images</strong> ටැබයට ගොස් <span class="ui">Choose Image</span> ක්ලික් කරන්න. පරිගණකයෙන් උඩුගත කිරීමට, File Manager වෙතින් තෝරාගැනීමට හෝ AI මගින් රූපයක් සෑදීමට හැක.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">6</div>
      <div class="step-body">
        <strong>ප්‍රභේද එක් කරන්න (අවශ්‍ය නම්)</strong>
        <p>එකම නිෂ්පාදනයේ ප්‍රමාණ/වර්ණ/මෝස්තර අනුව ප්‍රභේද සෑදීමට <strong>Variants</strong> ටැබයට යන්න. සෑම ප්‍රභේදයකටම තමන්ගේම SKU සහ මිල ඇත.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">7</div>
      <div class="step-body">
        <strong>සුරකින්න</strong>
        <p><span class="ui">Save Product</span> ක්ලික් කරන්න. නිෂ්පාදනය වහාම POS ජාලයේ දිස්වේ.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="categories-brands">කාණ්ඩ සහ වෙළඳ නාම</h3>
  <p>කාණ්ඩ සහ වෙළඳ නාම මගින් ඔබේ නාමාවලිය පිළිවෙළට තබාගන්න. Inventory රිබනයේ <strong>Catalog</strong> කණ්ඩායමේ:</p>
  <ul>
    <li>නිෂ්පාදන කාණ්ඩ එක් කිරීමට, නම වෙනස් කිරීමට හෝ පිළිවෙළ වෙනස් කිරීමට <span class="ui">Categories</span> ක්ලික් කරන්න</li>
    <li>වෙළඳ නාම කළමනාකරණයට <span class="ui">Brands</span> ක්ලික් කරන්න. POS සහ තොග දසුන් දෙකෙහිම පෙරීමට මෙය ප්‍රයෝජනවත්ය</li>
    <li>ගෙවීමේදී යෙදිය හැකි, නැවත නැවත භාවිත කළ හැකි වට්ටම් නීති සෑදීමට <span class="ui">Discounts</span> ක්ලික් කරන්න</li>
  </ul>
</div>

<div class="doc-sec">
  <h3 id="stock-management">තොග කළමනාකරණය</h3>
  <p><strong>Stock</strong> රිබන් කණ්ඩායමෙන් තොග මට්ටම් නිරීක්ෂණය කර වෙනස් කිරීම් කරන්න.</p>
  <table class="data-table">
    <tr><th>ක්‍රියාව</th><th>භාවිත කළ යුත්තේ කවදාද</th></tr>
    <tr><td>Stock Audit</td><td>භෞතික තොගය ගණන් කර වෙනස්කම් නිවැරදි කිරීමට. ස්ථිර විගණන වාර්තාවක් සාදයි.</td></tr>
    <tr><td>Stock Adjustment</td><td>අපතේ යාම, නැතිවීම හෝ නිවැරදි කිරීම් සඳහා තොගය අතින් එක් කිරීමට හෝ අඩු කිරීමට.</td></tr>
    <tr><td>Stock Transfer</td><td>එකම ව්‍යාපාරයේ ශාඛා අතර තොග මාරු කිරීමට.</td></tr>
  </table>
  <div class="callout tip">
    <div class="callout-icon"><i class="fa-solid fa-lightbulb"></i></div>
    <div class="callout-body">
      <strong>ඉඟිය</strong>
      සෑම විකිණීමකින්ම තොගය ස්වයංක්‍රීයව අඩු වේ. මිලදී ගැනීමේ ඇණවුමක භාණ්ඩ ලැබුණු විට තොගය ස්වයංක්‍රීයව වැඩි වේ. අතින් කරන වෙනස් කිරීම් වේලාව සහ පරිශීලකයා සමඟ විගණන වාර්තාවක සටහන් වේ.
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="suppliers">සැපයුම්කරුවන්</h3>
  <p><strong>Suppliers</strong> රිබන් කණ්ඩායමේ සැපයුම්කරු නාමාවලියක් පවත්වාගන්න. සෑම සැපයුම්කරුවෙකුටම නම, සම්බන්ධතා තොරතුරු, ලිපිනය සහ සාමාන්‍ය ගෙවීම් කොන්දේසි සුරකින්න. ඉන්පසු සැපයුම්කරුවන් මිලදී ගැනීමේ ඇණවුම්වලට සම්බන්ධ කළ හැක.</p>
</div>

<div class="doc-sec">
  <h3 id="purchase-orders">මිලදී ගැනීමේ ඇණවුම්</h3>
  <p>ඔබේ මිලදී ගැනීම් <span class="ui">Inventory → Purchasing → Purchase Orders</span> වෙතින් කළමනාකරණය කරන්න.</p>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>කෙටුම්පත් ඇණවුමක් (Draft PO) සාදන්න</strong>
        <p><span class="ui">New PO</span> ක්ලික් කරන්න. සැපයුම්කරු තෝරා, ඇණවුම් දිනය සහ බලාපොරොත්තු වන භාරදීමේ දිනය සකසා, නිෂ්පාදනය, ප්‍රමාණය සහ ඒකක පිරිවැය සමඟ අයිතම එක් කරන්න.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>ඇණවුම යවන්න</strong>
        <p>PO සූදානම් වූ පසු <span class="ui">Place Order</span> ක්ලික් කරන්න. තත්ත්වය <strong>Ordered</strong> ලෙස වෙනස් වන අතර, ඉන්පසු PO සංස්කරණය කළ නොහැක.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>භාණ්ඩ ලබාගන්න (GRN)</strong>
        <p>භාණ්ඩ ලැබුණු විට PO විවෘත කර <span class="ui">Receive Goods</span> ක්ලික් කරන්න. සැබවින්ම ලැබුණු ප්‍රමාණ ඇතුළත් කරන්න. භාණ්ඩ ලැබීමේ සටහනක් (GRN) සැකසෙන අතර තොග මට්ටම් වහාම යාවත්කාලීන වේ.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="barcode-printing">බාර්කෝඩ් මුද්‍රණය</h3>
  <p>තොග ලැයිස්තුවෙන් නිෂ්පාදන එකක් හෝ කිහිපයක් තෝරා, <strong>Print</strong> රිබන් කණ්ඩායමේ <span class="ui">Print Barcodes</span> ක්ලික් කරන්න. ලේබල් පත්‍රයේ ප්‍රමාණය තෝරා, නිෂ්පාදනයකට ලේබල් ගණන සකසා, සම්බන්ධ කළ ඕනෑම ලේබල් මුද්‍රණ යන්ත්‍රයකට කෙලින්ම මුද්‍රණය කරන්න.</p>
</div>
