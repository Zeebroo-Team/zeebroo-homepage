<!-- HERO -->
<section class="hero">
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-copy">
        <h1><span class="line"><span>Grow your business</span></span><span class="line"><span>with <span class="mark">clarity</span> &amp; control</span></span></h1>
        <p class="hero-sub">Sales, stock, money, people and marketing in one workspace. Less app-switching, more time with customers.</p>
        <div class="hero-ctas">
          <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
          <a class="btn btn-line" href="#download"><i class="fa-solid fa-download"></i> Download POS</a>
        </div>
      </div>
      <div class="hero-art">
        <img id="mascot" src="assets/mascot.webp" alt="Zeebroo mascot: a zebra in a suit holding a briefcase" width="481" height="731">
        <div class="bubble" id="bubble" role="status">Try it. Tap a product, then <b>Charge</b>.</div>
      </div>
    </div>

    <div class="demo" id="product">
      <div class="app" id="app">
        <div class="app-bar">
          <div class="lights"><i></i><i></i><i></i></div>
          <div class="app-brand"><span>Z</span>Zeebroo POS</div>
          <div class="app-stats"><span class="chip b"><i class="fa-solid fa-cart-shopping"></i><span id="stSales">235</span> sales today</span><span class="chip g">Rs <span id="stRev">753,292</span></span></div>
        </div>
        <div class="app-tabs"><span>Home</span><span class="on">POS</span><span>Sales</span><span>Inventory</span><span>Finance</span></div>
        <div class="app-body">
          <div class="catalog">
            <label class="search"><i class="fa-solid fa-magnifying-glass"></i><input id="q" type="search" placeholder="Search products" aria-label="Search products"><kbd>F2</kbd></label>
            <div class="cats" id="cats" role="tablist" aria-label="Product categories"></div>
            <div class="grid-p" id="grid"></div>
          </div>
          <div class="cart" id="cart">
            <div class="cart-h"><span><i class="fa-solid fa-receipt" style="color:var(--blue);margin-right:8px"></i>Current sale</span><span class="count" id="count">0</span></div>
            <div class="lines" id="lines" aria-live="polite"></div>
            <div class="totals">
              <div><span>Subtotal</span><span id="sub">Rs 0</span></div>
              <div><span>Discount</span><span id="disc">Rs 0</span></div>
              <div class="grand"><span>Total</span><span id="tot">Rs 0</span></div>
            </div>
            <div class="pay" id="pay"><button class="on" data-m="Cash"><i class="fa-solid fa-money-bill-wave"></i> Cash</button><button data-m="Card"><i class="fa-regular fa-credit-card"></i> Card</button><button data-m="QR"><i class="fa-solid fa-qrcode"></i> QR</button></div>
            <button class="charge" id="charge">Charge <span id="chargeAmt">Rs 0</span></button>
            <div class="receipt-wrap" id="rwrap">
              <div class="printer"></div>
              <div class="receipt" id="receipt"></div>
              <button class="btn btn-ink" id="newSale"><i class="fa-solid fa-plus"></i> New sale</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>