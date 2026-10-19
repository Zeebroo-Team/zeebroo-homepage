<!-- HERO -->
<section class="hero">
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-copy">
        <h1><span class="line"><span>Grow your business</span></span><span class="line"><span>with <span class="mark">clarity</span> &amp; control</span></span></h1>
        <p class="hero-sub">Sales, stock, money, people and marketing in one workspace. Less app-switching, more time with customers.</p>
        <div class="hero-ctas">
          <a class="btn btn-ink" href="https://www.zeebroo.com/signup">Get started <i class="fa-solid fa-arrow-right"></i></a>
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

<!-- BENEFITS -->
<section class="section" id="benefits">
  <div class="wrap">
    <div class="head reveal">
      <h2>Less chaos.<br>More growth.</h2>
      <p>What sold today? What's low in stock? Who owes what? Zeebroo keeps the answers in one place your whole team can trust.</p>
    </div>
    <div class="bento">
      <article class="tile t-a reveal">
        <div>
          <h3>Focus on growth</h3>
          <p>See sales, costs and activity together. Spot what works, cut waste, and invest where it pays off.</p>
          <div class="big-num">Rs 412k<small><i class="fa-solid fa-arrow-up"></i> 18%</small></div>
          <span class="note">Example: one shop's weekly revenue</span>
        </div>
        <div>
          <div class="bars"><div style="--h:42%"></div><div style="--h:55%"></div><div style="--h:38%"></div><div style="--h:64%"></div><div style="--h:71%"></div><div class="hi" style="--h:96%"></div><div style="--h:60%"></div></div>
          <div class="days"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></div>
        </div>
      </article>
      <article class="tile t-b reveal">
        <h3>Save time every day</h3>
        <p>No more copying numbers between spreadsheets, tills and HR sheets.</p>
        <div class="merge" aria-hidden="true">
          <span class="src" style="left:4%;top:4%"><i class="fa-solid fa-table"></i></span>
          <span class="src" style="left:74%;top:0%"><i class="fa-solid fa-calculator"></i></span>
          <span class="src" style="left:0%;top:64%"><i class="fa-regular fa-file-lines"></i></span>
          <span class="src" style="left:78%;top:62%"><i class="fa-solid fa-cash-register"></i></span>
          <span class="src" style="left:40%;top:74%"><i class="fa-regular fa-envelope"></i></span>
          <span class="dst"><img src="assets/mark.png" alt="" width="44" height="55"></span>
        </div>
      </article>
      <article class="tile t-c reveal">
        <h3>The whole picture, live</h3>
        <p>Cash flow, stock levels, bills and staff, without digging through folders.</p>
        <div class="kpis">
          <div class="kpi"><small>Cash in today</small><b class="g" data-count="128450" data-pre="Rs ">Rs 0</b></div>
          <div class="kpi"><small>Products</small><b data-count="1007">0</b></div>
          <div class="kpi"><small>Bills due</small><b class="r" data-count="6">0</b></div>
          <div class="kpi"><small>Staff on shift</small><b data-count="14">0</b></div>
        </div>
      </article>
      <article class="tile t-d reveal">
        <h3>Reports you can act on</h3>
        <p>Know what to reorder, discount or chase, without exporting a single spreadsheet.</p>
        <div class="alerts">
          <div class="alert"><i style="background:#FDECEC;color:var(--red)" class="fa-solid fa-box-open"></i>Fresh Milk 1L, 3 left<span>reorder</span></div>
          <div class="alert"><i style="background:#FFF4D1;color:#9A6B00" class="fa-solid fa-file-invoice"></i>Electricity bill<span>overdue</span></div>
          <div class="alert"><i style="background:#E7F6EE;color:var(--green)" class="fa-solid fa-arrow-trend-up"></i>Bakery up 18%<span>this week</span></div>
        </div>
      </article>
      <article class="tile t-e reveal">
        <div>
          <h3>The right access for every role.</h3>
          <p>Give cashiers, managers and accountants their own permissions per branch. Everyone works in one system without seeing what they shouldn't. Flip a switch to try it.</p>
        </div>
        <div class="roles" id="roles"></div>
      </article>
    </div>
  </div>
</section>

<!-- MODULES -->
<section class="section" id="modules">
  <div class="wrap">
    <div class="head reveal">
      <h2>Turn on what you need. Add the rest as you grow.</h2>
      <p>Every module shares the same data, so the register and the ledger always agree.</p>
    </div>
    <div class="mods reveal">
      <div class="mod-list" id="modList" role="listbox" aria-label="Modules"></div>
      <div class="mod-view" id="modView" aria-live="polite">
        <span class="mod-status" id="modStatus">Installed</span>
        <div class="art"><img id="modImg" src="assets/features/point-of-sale.webp" alt="" width="344" height="347"></div>
        <h3 id="modTitle"></h3>
        <p id="modDesc"></p>
      </div>
    </div>
    <div class="suite reveal">
      <span>All included, plus:</span>
      <a href="https://www.zeebroo.com/#erp"><i class="fa-solid fa-diagram-project"></i>ERP</a>
      <a href="https://www.zeebroo.com/#accounting"><i class="fa-solid fa-scale-balanced"></i>Accounting</a>
      <a href="https://www.zeebroo.com/#multibranch"><i class="fa-solid fa-code-branch"></i>Multibranch</a>
      <a href="https://www.zeebroo.com/#crm"><i class="fa-solid fa-address-book"></i>CRM</a>
      <a href="https://www.zeebroo.com/#design"><i class="fa-solid fa-pen-ruler"></i>Design Studio</a>
      <a href="https://www.zeebroo.com/#automation"><i class="fa-solid fa-wand-magic-sparkles"></i>Automation</a>
      <a href="https://www.zeebroo.com/#ai-agent"><i class="fa-solid fa-robot"></i>AI Agent <span class="new">New</span></a>
    </div>
  </div>
</section>

<!-- FINANCE MAP -->
<section class="section dark">
  <div class="wrap">
    <div class="head reveal">
      <span class="label">Finance</span>
      <h2>See where every rupee comes from, and where it goes.</h2>
      <p>Bills, loans, rentals and income in one live map. Overdue items stand out before they become a problem.</p>
    </div>
    <div class="flow-box reveal">
      <svg class="flow" id="flow" viewBox="0 0 1240 560" role="img" aria-label="Diagram: four income streams flow into the business, which pays out to bills and loans"></svg>
    </div>
    <div class="flow-foot"><span>Hover a bill or income stream to trace it.</span><span>Example business data</span></div>
  </div>
</section>

<!-- PLATFORMS -->
<section class="section" id="download">
  <div class="wrap">
    <div class="head reveal">
      <h2>Sell at the counter, on the web or on desktop.</h2>
      <p>Run POS in the browser, or install the desktop app on each till. Same checkout everywhere: products, payments and receipts.</p>
    </div>
    <div class="plat-photo reveal"><img src="assets/pos-monitor.webp" alt="Zeebroo POS on a touchscreen at a supermarket checkout, next to a barcode scanner" width="1600" height="1000" loading="lazy"></div>
    <div class="plat-row reveal">
      <div class="os">
        <span><i class="fa-brands fa-windows"></i>Windows</span>
        <span><i class="fa-brands fa-apple"></i>macOS</span>
        <span><i class="fa-brands fa-linux"></i>Linux</span>
        <span><i class="fa-solid fa-globe"></i>Web POS</span>
        <span><i class="fa-solid fa-print"></i>Thermal receipts</span>
      </div>
      <a class="btn btn-ink" href="https://www.zeebroo.com/download"><i class="fa-solid fa-download"></i> Download POS</a>
    </div>
  </div>
</section>

<!-- INDUSTRIES -->
<section class="section" id="industries">
  <div class="wrap">
    <div class="head reveal">
      <h2>Built for the way your industry works.</h2>
      <p>Zeebroo adapts to your business, not the other way round.</p>
    </div>
    <div class="inds reveal" id="inds"></div>
  </div>
</section>

<!-- STEPS -->
<section class="section">
  <div class="wrap steps">
    <div class="steps-l reveal">
      <h2>From first login to first sale.</h2>
      <p>Quick setup, no long contracts, and our team helps you get going.</p>
      <img src="assets/desktop-monitor.webp" alt="Zeebroo analytics dashboard on a desktop monitor" width="1306" height="816" loading="lazy">
    </div>
    <div class="steps-r">
      <div class="prog"></div>
      <div class="step"><h3>Tell us about your business</h3><p>We help you set up your company, branches and team so everyone starts on the right foot.</p><ul><li>Company</li><li>Branches</li><li>Staff and roles</li></ul></div>
      <div class="step"><h3>Turn on what you need</h3><p>Stock, POS, bills, HR, campaigns. Enable what matters now and add more as you expand.</p><ul><li>Import products</li><li>Print barcodes</li><li>Design receipts</li></ul></div>
      <div class="step"><h3>Grow with confidence</h3><p>Train staff once, sell everywhere, and keep your numbers aligned from the shop floor to your reports.</p><ul><li>Live dashboard</li><li>Profit analytics</li><li>Sales reports</li></ul></div>
    </div>
  </div>
</section>

<!-- MANIFESTO -->
<section class="section">
  <div class="wrap">
    <p class="manifesto" id="manifesto">Your business. Your data. Your pace.</p>
  </div>
</section>

<!-- FAQ -->
<section class="section">
  <div class="wrap faq">
    <div class="faq-l reveal">
      <span class="label">FAQ</span>
      <h2>Good to know.</h2>
      <p>Something else? Write to <a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a>.</p>
    </div>
    <div class="reveal">
      <details open><summary>Do I need special hardware? <span class="pm"><i class="fa-solid fa-plus"></i></span></summary><p>No. Run POS in any modern browser, or install the desktop app on Windows, macOS or Linux. Add a barcode scanner and a thermal receipt printer when you're ready.</p></details>
      <details><summary>Do I pay extra for each module? <span class="pm"><i class="fa-solid fa-plus"></i></span></summary><p>No. All modules are included with no extra licenses. Turn on stock, bills, HR or campaigns whenever your business needs them.</p></details>
      <details><summary>Can I run more than one branch? <span class="pm"><i class="fa-solid fa-plus"></i></span></summary><p>Yes. Multibranch management runs every location from one dashboard, with permissions set per branch for cashiers, managers and accountants.</p></details>
      <details><summary>Can I customise receipts and barcodes? <span class="pm"><i class="fa-solid fa-plus"></i></span></summary><p>Yes. The receipt editor lets you brand your thermal receipts, and you can print barcode labels straight from your product catalogue.</p></details>
      <details><summary>How do I get started? <span class="pm"><i class="fa-solid fa-plus"></i></span></summary><p>Create an account and tell us about your business. We'll help you set up your company, branches and team so you can make your first sale quickly.</p></details>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="wrap">
  <div class="cta reveal">
    <div>
      <h2>Ready to run it all from one place?</h2>
      <p>Tell us about your shop or company and we'll show you how Zeebroo fits the way you already work.</p>
      <div class="cta-btns">
        <a class="btn btn-ink" href="https://www.zeebroo.com/signup">Get started <i class="fa-solid fa-arrow-right"></i></a>
        <a class="btn btn-line" href="mailto:hello@zeebroo.com"><i class="fa-regular fa-envelope"></i> Talk to our team</a>
      </div>
    </div>
    <div class="cta-ufo"><img src="assets/ufo.webp" alt="" width="179" height="187" loading="lazy"></div>
  </div>
</section>