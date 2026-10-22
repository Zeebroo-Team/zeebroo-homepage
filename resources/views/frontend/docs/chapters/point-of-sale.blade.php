<figure class="screenshot-figure">
  <img src="{{ asset('assets/docs/03-pos.png') }}" alt="Zeebroo POS Point of Sale screen" loading="lazy">
  <figcaption class="screenshot-caption">Point of Sale — product grid with category filters, search, and cart panel ready for checkout.</figcaption>
</figure>

<div class="doc-sec">
  <h3 id="the-pos-layout">The POS Layout</h3>
  <p>The POS screen has three zones:</p>
  <ul>
    <li><strong>Left — Product grid:</strong> All your products displayed as cards, filterable by category</li>
    <li><strong>Right — Cart:</strong> Items added to the current sale, with totals and payment controls</li>
    <li><strong>Top — Search &amp; category bar:</strong> Filter products by name, SKU, or barcode, and jump between categories</li>
  </ul>
</div>

<div class="doc-sec">
  <h3 id="starting-a-sale">Starting a Sale</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Open the POS tab</strong>
        <p>Click the <span class="tab-label">POS</span> ribbon tab, or press <kbd>F2</kbd> from anywhere in the app.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Find a product</strong>
        <p>Click a product card directly, or type in the search bar to filter by name, SKU, or scan a barcode with <kbd>F3</kbd>. Click the <strong>Recent</strong> chip to show your most frequently sold items first.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>Add to cart</strong>
        <p>Click any product card to add one unit. Click it again to increase quantity, or edit the quantity number directly in the cart. Remove a line by clicking the ✕ icon.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">4</div>
      <div class="step-body">
        <strong>Apply a discount (optional)</strong>
        <p>If the Discount field is enabled in Settings, a discount box appears in the cart footer. Enter a percentage or fixed amount. This applies to the whole sale.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">5</div>
      <div class="step-body">
        <strong>Process payment</strong>
        <p>Click <span class="ui">Checkout</span>. Select the payment method — <strong>Cash</strong>, <strong>Card</strong>, or <strong>Bank Transfer</strong>. For cash, enter the amount tendered and the change is calculated automatically. Click <span class="ui">Confirm Sale</span>.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">6</div>
      <div class="step-body">
        <strong>Print or share receipt</strong>
        <p>After confirming, the receipt preview opens. Print directly or close to return to the POS.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="multiple-pos-sessions-tabs">Multiple POS Sessions (Tabs)</h3>
  <p>You can run several parallel sales at once — useful for holding an order while serving another customer. Each session is called a <strong>tab</strong>.</p>
  <ul>
    <li>Click <span class="ui">+ New Tab</span> in the POS session bar to open an additional register</li>
    <li>Click any tab to switch between active sessions</li>
    <li>Each tab holds an independent cart — switching tabs does not affect the other session's items</li>
  </ul>
</div>

<div class="doc-sec">
  <h3 id="parking-an-order">Parking an Order</h3>
  <p>If a customer needs to come back, click <span class="ui">Park Order</span> (in the POS ribbon group) to save the current cart without completing the sale. The parked order count badge appears in the ribbon. Click <span class="ui">Parked Orders</span> to retrieve and continue any parked sale.</p>
</div>

<div class="doc-sec">
  <h3 id="customers">Customers</h3>
  <p>Attach a customer to a sale for purchase history tracking and account management.</p>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Search or create a customer</strong>
        <p>Click <span class="ui">Customer</span> in the cart header. Type a name or phone number to search existing customers, or click <span class="ui">New Customer</span> to add one on the spot.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Link to the sale</strong>
        <p>Select the customer from the dropdown. Their name appears in the cart and the sale is recorded in their purchase history.</p>
      </div>
    </div>
  </div>
  <p>Access the full customer list from the ribbon's <strong>Customers</strong> group to view purchase history, outstanding credits, and account balances.</p>
</div>

<div class="doc-sec">
  <h3 id="quotations">Quotations</h3>
  <p>Create a quotation (price estimate) without completing a sale:</p>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Build the cart as normal</strong>
        <p>Add the products and quantities the customer is interested in.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Click Quotation in the ribbon</strong>
        <p>Under the <strong>Quotations</strong> ribbon group, click <span class="ui">New Quotation</span>. The current cart items are saved as a quotation with a quote number.</p>
      </div>
    </div>
    <div class="doc-step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>Print or convert</strong>
        <p>Open the quotation from the Sales tab to print it or convert it to a completed sale.</p>
      </div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3 id="pos-keyboard-shortcuts">POS Keyboard Shortcuts</h3>
  <p>Master these shortcuts to speed up every transaction. On macOS, replace <kbd>Ctrl</kbd> with <kbd>⌘ Cmd</kbd>.</p>

  <div class="shortcut-table">
    <div class="shortcut-group-header">Opening &amp; Navigation</div>
    <div class="shortcut-row"><span class="shortcut-label">Open POS / focus product search</span><div class="shortcut-keys"><kbd>F2</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Toggle full screen mode</span><div class="shortcut-keys"><kbd>F11</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Close modal / cancel action</span><div class="shortcut-keys"><kbd>Esc</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Move between input fields</span><div class="shortcut-keys"><kbd>Tab</kbd></div></div>

    <div class="shortcut-group-header">Finding Products</div>
    <div class="shortcut-row"><span class="shortcut-label">Focus the product search bar</span><div class="shortcut-keys"><kbd>F2</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Start typing anywhere to search</span><div class="shortcut-keys"><kbd>Any key</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Activate barcode scan mode</span><div class="shortcut-keys"><kbd>F3</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Add top search result to cart</span><div class="shortcut-keys"><kbd>Enter</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Navigate search results</span><div class="shortcut-keys"><kbd>↑</kbd><kbd>↓</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Refresh product grid</span><div class="shortcut-keys"><kbd>F5</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Add new product (quick form)</span><div class="shortcut-keys"><kbd>F4</kbd></div></div>

    <div class="shortcut-group-header">Managing the Cart</div>
    <div class="shortcut-row"><span class="shortcut-label">Add 1 unit of selected product</span><div class="shortcut-keys"><kbd>Enter</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Increase selected item quantity</span><div class="shortcut-keys"><kbd>+</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Decrease selected item quantity</span><div class="shortcut-keys"><kbd>−</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Remove selected line from cart</span><div class="shortcut-keys"><kbd>Del</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Clear entire cart</span><div class="shortcut-keys"><kbd>Ctrl</kbd><kbd>Del</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Undo last cart change</span><div class="shortcut-keys"><kbd>Ctrl</kbd><kbd>Z</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Apply / edit sale discount</span><div class="shortcut-keys"><kbd>F8</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Search &amp; attach customer</span><div class="shortcut-keys"><kbd>F9</kbd></div></div>

    <div class="shortcut-group-header">Sessions &amp; Tabs</div>
    <div class="shortcut-row"><span class="shortcut-label">Open a new POS session tab</span><div class="shortcut-keys"><kbd>F7</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Switch to next session tab</span><div class="shortcut-keys"><kbd>Ctrl</kbd><kbd>Tab</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Switch to previous session tab</span><div class="shortcut-keys"><kbd>Ctrl</kbd><kbd>Shift</kbd><kbd>Tab</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Park the current order</span><div class="shortcut-keys"><kbd>Ctrl</kbd><kbd>K</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Open parked orders list</span><div class="shortcut-keys"><kbd>F6</kbd></div></div>

    <div class="shortcut-group-header">Checkout &amp; Payment</div>
    <div class="shortcut-row"><span class="shortcut-label">Open checkout / payment screen</span><div class="shortcut-keys"><kbd>F10</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Select Cash payment method</span><div class="shortcut-keys"><kbd>F10</kbd> then <kbd>1</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Select Card payment method</span><div class="shortcut-keys"><kbd>F10</kbd> then <kbd>2</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Select Bank Transfer method</span><div class="shortcut-keys"><kbd>F10</kbd> then <kbd>3</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Confirm / complete the sale</span><div class="shortcut-keys"><kbd>Enter</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Print receipt after sale</span><div class="shortcut-keys"><kbd>Ctrl</kbd><kbd>P</kbd></div></div>
    <div class="shortcut-row"><span class="shortcut-label">Reprint last receipt</span><div class="shortcut-keys"><kbd>F12</kbd></div></div>
  </div>

  <div class="callout tip">
    <div class="callout-icon"><i class="fa-solid fa-lightbulb"></i></div>
    <div class="callout-body">
      <strong>Cashier tip</strong>
      The fastest checkout flow is: scan items with a barcode scanner (<kbd>F3</kbd>), check the cart total, press <kbd>F10</kbd> to open payment, type the cash amount tendered, press <kbd>Enter</kbd> to confirm, then <kbd>Ctrl+P</kbd> to print — never touching the mouse.
    </div>
  </div>
</div>

<div class="callout warn">
  <div class="callout-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
  <div class="callout-body">
    <strong>Important</strong>
    The POS and Restaurant POS features are mutually exclusive. If your business uses the Restaurant module, use the <span class="tab-label">RESTAURANT POS</span> tab instead — see <a href="{{ route('docs.show', 'restaurant-pos') }}">Chapter 10</a>.
  </div>
</div>
