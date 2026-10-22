@verbatim
  <div class="endpoint" id="ep-sales-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/sales</code>
      <span class="endpoint-name">List recent sales</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Unpaginated list of sales for the current business, ordered by most recent, optionally filtered by search term or channel and capped at a limit.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by sale number or notes.</td></tr>
            <tr><td>channel<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filter by channel: <code>retail</code> or <code>online</code>.</td></tr>
            <tr><td>limit<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Cap the number of rows returned. No limit if omitted.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1042,
      "sale_number": "SL-1042",
      "status": "completed",
      "payment_method": "cash",
      "channel": "retail",
      "total": 4500.00,
      "items_count": 3,
      "sold_at": "2026-07-30T14:22:00+00:00",
      "customer_name": "Nimal Perera"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-sales-history">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/sales/history</code>
      <span class="endpoint-name">Paginated sales history with summary and chart</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated sales list (25 per page) plus aggregate summary counts/totals and a daily sales chart for the same filter set — used to power the sales history screen.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by sale number or notes.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filter by sale status. Defaults to <code>all</code>.</td></tr>
            <tr><td>channel<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filter by channel: <code>retail</code> or <code>online</code>. Defaults to <code>all</code>.</td></tr>
            <tr><td>date_from<span class="param-required">opt</span></td><td class="param-type">date</td><td>Restrict to sales sold on/after this date.</td></tr>
            <tr><td>date_to<span class="param-required">opt</span></td><td class="param-type">date</td><td>Restrict to sales sold on/before this date.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1042,
      "sale_number": "SL-1042",
      "status": "completed",
      "payment_method": "cash",
      "channel": "retail",
      "total": 4500.00,
      "items_count": 3,
      "sold_at": "2026-07-30T14:22:00+00:00",
      "customer_name": "Nimal Perera"
    }
  ],
  "meta": { "current_page": 1, "last_page": 4, "total": 87, "per_page": 25 },
  "summary": {
    "count": 87,
    "completed_count": 80,
    "completed_total": 452300.00,
    "void_count": 3
  },
  "chart": [
    { "date": "2026-07-29", "count": 12, "total": 54000.00 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-sales-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/sales/{sale}</code>
      <span class="endpoint-name">Get sale detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Full detail for a single sale, including line items with any returned quantities netted against each item, cashier, branch, credit account, and warranty info per item. 404s if the sale does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 1042,
    "sale_number": "SL-1042",
    "status": "completed",
    "payment_method": "cash",
    "payment_method_label": "Cash",
    "channel": "retail",
    "channel_label": "Retail",
    "branch": { "id": 2, "name": "Colombo Branch" },
    "subtotal": 4800.00,
    "discount_percent": 5.00,
    "discount_amount": 300.00,
    "total": 4500.00,
    "amount_paid": 4500.00,
    "amount_tendered": 5000.00,
    "change_amount": 500.00,
    "notes": null,
    "customer_name": "Nimal Perera",
    "sold_at": "2026-07-30T14:22:00+00:00",
    "credit_account": null,
    "cashier": { "id": 7, "name": "Ishara Silva" },
    "items": [
      {
        "id": 3301,
        "product_id": 88,
        "product_stock_layer_id": 512,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity": 2,
        "unit_cost": 800.00,
        "discount_amount": 0,
        "unit_sell_price": 2400.00,
        "line_total": 4800.00,
        "returned_quantity": 0,
        "warranty_type": null,
        "warranty_days": null,
        "warranty_expires_at": null
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-sales-void">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/sales/{sale}/void</code>
      <span class="endpoint-name">Void a sale</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Voids a completed sale: restores stock for each product line (including composed service-item products), reverses any credit-account balance impact, and flips the sale to <code>void</code> status. Fails if the sale is already void.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Sale SL-1042 has been voided.",
  "data": {
    "id": 1042,
    "sale_number": "SL-1042",
    "status": "void",
    "total": 4500.00
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This sale is already void.",
  "errors": { "sale": ["This sale is already void."] }
}</code></pre>
      </div>
@endverbatim
