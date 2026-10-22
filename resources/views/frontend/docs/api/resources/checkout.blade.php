@verbatim
  <div class="endpoint" id="ep-checkout-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/online/checkout</code>
      <span class="endpoint-name">Create a sale from cart items</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Validates and checks out a cart via <code>SaleService::checkout()</code>, consuming stock layers, applying any per-line discount and an overall <code>discount_percent</code>, and recording the payment method. When <code>payment_settlement_mode</code> is <code>end_of_day</code> and the payment method is cash/card, settlement is deferred to the end-of-day flow. If the authenticated principal is a PosCashier token rather than a full user, the sale is recorded under the business owner's user id.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires <code>pos_checkout</code> permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>items</td><td class="param-type">array</td><td>At least one cart line.</td></tr>
            <tr><td>items[].item_type<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>product</code> or <code>service</code>.</td></tr>
            <tr><td>items[].product_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required for product lines.</td></tr>
            <tr><td>items[].service_item_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required for service lines.</td></tr>
            <tr><td>items[].quantity</td><td class="param-type">number</td><td>Minimum 0.001.</td></tr>
            <tr><td>items[].product_stock_layer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Pin the sale to a specific stock layer (e.g. FIFO override).</td></tr>
            <tr><td>items[].product_selling_unit_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Sell using a configured selling unit (e.g. "Box of 12") instead of the base unit.</td></tr>
            <tr><td>items[].warranty_type<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>lifetime</code> or <code>date</code>, for products with warranty tracking.</td></tr>
            <tr><td>items[].warranty_date<span class="param-required">opt</span></td><td class="param-type">string</td><td>Format <code>Y-m-d</code>; required when <code>warranty_type</code> is <code>date</code>.</td></tr>
            <tr><td>payment_method</td><td class="param-type">string</td><td>One of <code>cash</code>, <code>card</code>, <code>credit</code>.</td></tr>
            <tr><td>channel<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>retail</code> or <code>online</code>. Defaults to <code>online</code> for this endpoint.</td></tr>
            <tr><td>credit_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Account to charge when <code>payment_method</code> is <code>credit</code>.</td></tr>
            <tr><td>pos_customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Attach the sale to a customer.</td></tr>
            <tr><td>amount_paid<span class="param-required">opt</span></td><td class="param-type">number</td><td>Amount actually paid.</td></tr>
            <tr><td>amount_tendered<span class="param-required">opt</span></td><td class="param-type">number</td><td>Cash tendered, used to compute change.</td></tr>
            <tr><td>discount_percent<span class="param-required">opt</span></td><td class="param-type">number</td><td>0–100, applied to the whole sale.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>scheduled_at<span class="param-required">opt</span></td><td class="param-type">string (date)</td><td>Schedule the sale for a future time instead of completing immediately.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Branch the sale is recorded against.</td></tr>
            <tr><td>pos_counter_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>POS counter/register the sale is recorded against.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Sale SALE-0142 completed.",
  "data": {
    "id": 142,
    "sale_number": "SALE-0142",
    "status": "completed",
    "payment_method": "cash",
    "payment_method_label": "Cash",
    "channel": "online",
    "channel_label": "Online",
    "branch": { "id": 1, "name": "Main Branch" },
    "subtotal": 1200.00,
    "discount_percent": 0,
    "discount_amount": 0,
    "total": 1200.00,
    "amount_paid": 1200.00,
    "amount_tendered": 1500.00,
    "change_amount": 300.00,
    "notes": null,
    "customer_name": null,
    "sold_at": "2026-07-31T10:15:00+00:00",
    "credit_account": null,
    "cashier": { "id": 1, "name": "Jane Doe" },
    "items": [
      {
        "id": 300,
        "product_id": 10,
        "product_stock_layer_id": 44,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity": 1,
        "unit_cost": 800.00,
        "discount_amount": 0,
        "unit_sell_price": 1200.00,
        "line_total": 1200.00,
        "returned_quantity": 0,
        "warranty_type": null,
        "warranty_days": null,
        "warranty_expires_at": null
      }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Insufficient stock for Blue T-Shirt.",
  "errors": { "items.0.quantity": ["Insufficient stock for Blue T-Shirt."] }
}</code></pre>
      </div>
@endverbatim
