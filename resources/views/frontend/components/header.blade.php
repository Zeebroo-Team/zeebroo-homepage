<header class="nav" id="nav">
  <div class="nav-in">
    <a href="{{ route('home') }}#top" class="logo" aria-label="Zeebroo home"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a>
    <nav class="nav-links" id="navLinks">
      <a href="{{ route('home') }}#product">Product</a>
      <div class="nav-dd" id="modDD">
        <a href="{{ route('home') }}#modules" class="nav-dd-t" aria-haspopup="true">Modules <i class="fa-solid fa-chevron-down"></i></a>
        <div class="mega" role="menu" aria-label="Modules">
          <div class="mega-in">
            <div class="mega-side">
              <span class="mega-ic"><i class="fa-solid fa-layer-group"></i></span>
              <span class="mega-k">Modules</span>
              <h3>One platform, every module</h3>
              <p>Every module shares the same data, so the register and the ledger always agree.</p>
              <ul>
                <li><i class="fa-solid fa-check"></i>Turn modules on or off</li>
                <li><i class="fa-solid fa-check"></i>Shared, live data</li>
                <li><i class="fa-solid fa-check"></i>Works on web and desktop</li>
              </ul>
              <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mega-main">
              <div class="mega-top"><span>Core modules</span><em>6 modules</em></div>
              <div class="mega-grid">
                <a href="{{ route('home') }}#modules" data-mod="0"><span class="mi"><i class="fa-solid fa-cash-register"></i></span><div><b>Point of Sale <span class="badge">Popular</span></b><small>Fast checkout and receipts</small></div></a>
                <a href="{{ route('home') }}#modules" data-mod="1"><span class="mi"><i class="fa-solid fa-boxes-stacked"></i></span><div><b>Stock Management <span class="badge">Popular</span></b><small>Products, batches, reorders</small></div></a>
                <a href="{{ route('home') }}#modules" data-mod="2"><span class="mi"><i class="fa-solid fa-building-columns"></i></span><div><b>Account Management</b><small>Accounts, branches, balances</small></div></a>
                <a href="{{ route('home') }}#modules" data-mod="3"><span class="mi"><i class="fa-solid fa-file-invoice-dollar"></i></span><div><b>Bill Management</b><small>Bills, loans, expenses</small></div></a>
                <a href="{{ route('home') }}#modules" data-mod="4"><span class="mi"><i class="fa-solid fa-people-group"></i></span><div><b>Human Resources</b><small>Staff, payroll, attendance</small></div></a>
                <a href="{{ route('home') }}#modules" data-mod="5"><span class="mi"><i class="fa-solid fa-bullhorn"></i></span><div><b>Social Campaigns</b><small>Promotions tied to stock</small></div></a>
              </div>
              <div class="mega-top mega-top-2"><span>All included, plus</span></div>
              <div class="mega-suite">
                <a href="https://www.zeebroo.com/#erp"><i class="fa-solid fa-diagram-project"></i>ERP</a>
                <a href="https://www.zeebroo.com/#accounting"><i class="fa-solid fa-scale-balanced"></i>Accounting</a>
                <a href="https://www.zeebroo.com/#multibranch"><i class="fa-solid fa-code-branch"></i>Multibranch</a>
                <a href="https://www.zeebroo.com/#crm"><i class="fa-solid fa-address-book"></i>CRM</a>
                <a href="https://www.zeebroo.com/#design"><i class="fa-solid fa-pen-ruler"></i>Design Studio</a>
                <a href="https://www.zeebroo.com/#automation"><i class="fa-solid fa-wand-magic-sparkles"></i>Automation</a>
                <a href="https://www.zeebroo.com/#ai-agent"><i class="fa-solid fa-robot"></i>AI Agent <span class="new">New</span></a>
              </div>
              <div class="mega-foot">Need something custom? <a href="{{ route('contact') }}">Talk to us <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('home') }}#industries">Industries</a>
      <a href="{{ route('home') }}#download">Download</a>
      <a href="https://www.zeebroo.com/tutorial">Docs</a>
      <a href="{{ route('contact') }}">Contact</a>
    </nav>
    <div class="nav-cta">
      <a class="btn btn-line" href="https://platform.zeebroo.com/login">Sign in</a>
      <a class="btn btn-ink" href="https://platform.zeebroo.com/register">Get started</a>
    </div>
    <button class="burger" id="burger" aria-label="Open menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
  </div>
</header>