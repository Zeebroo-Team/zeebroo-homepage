<!-- HERO -->
<section class="hero">
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-copy">
        <h1><span class="line"><span>ඔබේ ව්‍යාපාරය වර්ධනය කරන්න</span></span><span class="line"><span><span class="mark">පැහැදිලිව</span> සහ පාලනයෙන්</span></span></h1>
        <p class="hero-sub">විකුණුම්, තොගය, මුදල්, කාර්ය මණ්ඩලය සහ අලෙවිකරණය එකම තැනක. යෙදුම් අතර මාරු වීම අඩුයි, ගනුදෙනුකරුවන් සමඟ වැඩි කාලයක්.</p>
        <div class="hero-ctas">
          <a class="btn btn-ink" href="https://platform.zeebroo.com/register">ආරම්භ කරන්න <i class="fa-solid fa-arrow-right"></i></a>
          <a class="btn btn-line" href="#download"><i class="fa-solid fa-download"></i> POS බාගන්න</a>
        </div>
      </div>
      <div class="hero-art">
        <img id="mascot" src="assets/mascot.webp" alt="Zeebroo චරිතය: සූට් එකක් ඇඳ බෑගයක් අතැති සීබ්‍රාවෙක්" width="481" height="731">
        <div class="bubble" id="bubble" role="status">අත්හදා බලන්න. භාණ්ඩයක් තට්ටු කර, පසුව <b>අය කරන්න</b> ඔබන්න.</div>
      </div>
    </div>

    <div class="demo" id="product">
      <div class="app" id="app">
        <div class="app-bar">
          <div class="lights"><i></i><i></i><i></i></div>
          <div class="app-brand"><span>Z</span>Zeebroo POS</div>
          <div class="app-stats"><span class="chip b"><i class="fa-solid fa-cart-shopping"></i><span id="stSales">235</span> අද විකුණුම්</span><span class="chip g">Rs <span id="stRev">753,292</span></span></div>
        </div>
        <div class="app-tabs"><span>මුල් පිටුව</span><span class="on">POS</span><span>විකුණුම්</span><span>තොගය</span><span>මුදල්</span></div>
        <div class="app-body">
          <div class="catalog">
            <label class="search"><i class="fa-solid fa-magnifying-glass"></i><input id="q" type="search" placeholder="භාණ්ඩ සොයන්න" aria-label="භාණ්ඩ සොයන්න"><kbd>F2</kbd></label>
            <div class="cats" id="cats" role="tablist" aria-label="භාණ්ඩ කාණ්ඩ"></div>
            <div class="grid-p" id="grid"></div>
          </div>
          <div class="cart" id="cart">
            <div class="cart-h"><span><i class="fa-solid fa-receipt" style="color:var(--blue);margin-right:8px"></i>වත්මන් විකුණුම</span><span class="count" id="count">0</span></div>
            <div class="lines" id="lines" aria-live="polite"></div>
            <div class="totals">
              <div><span>උප එකතුව</span><span id="sub">Rs 0</span></div>
              <div><span>වට්ටම</span><span id="disc">Rs 0</span></div>
              <div class="grand"><span>මුළු එකතුව</span><span id="tot">Rs 0</span></div>
            </div>
            <div class="pay" id="pay"><button class="on" data-m="Cash"><i class="fa-solid fa-money-bill-wave"></i> මුදල්</button><button data-m="Card"><i class="fa-regular fa-credit-card"></i> කාඩ්පත</button><button data-m="QR"><i class="fa-solid fa-qrcode"></i> QR</button></div>
            <button class="charge" id="charge">අය කරන්න <span id="chargeAmt">Rs 0</span></button>
            <div class="receipt-wrap" id="rwrap">
              <div class="printer"></div>
              <div class="receipt" id="receipt"></div>
              <button class="btn btn-ink" id="newSale"><i class="fa-solid fa-plus"></i> නව විකුණුමක්</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
