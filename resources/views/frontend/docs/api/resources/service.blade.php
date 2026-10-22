@verbatim
  <div class="endpoint" id="ep-service-catalog">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/service/pos/catalog</code>
      <span class="endpoint-name">Get service POS catalog</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns active service items (optionally filtered by name/description search or category) for the resolved business, featured items first, plus the list of active service categories for the filter UI.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped (X-Business-Id header)</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Matches service <code>name</code> or <code>description</code>.</td></tr>
            <tr><td>category<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter to a single service category id.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "services": [
      {
        "id": 5,
        "name": "Laptop screen replacement",
        "description": "Includes parts and labour",
        "price": 8500.00,
        "duration_minutes": 90,
        "duration_label": "1h 30m",
        "is_featured": true,
        "has_warranty": true,
        "categories": [{ "id": 2, "name": "Repairs" }]
      }
    ],
    "categories": [{ "id": 2, "name": "Repairs" }]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-service-checkout">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/service/pos/checkout</code>
      <span class="endpoint-name">Checkout services</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates one <code>ServiceRequest</code> per cart line (skipping any <code>service_item_id</code> that doesn't resolve to an active item in the business), deducts FIFO stock for any products assigned to that service item (logged as a warning, not fatal, if stock consumption fails), and returns a printable receipt payload.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped (X-Business-Id header)</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>items</td><td class="param-type">array</td><td>At least one line.</td></tr>
            <tr><td>items.*.service_item_id</td><td class="param-type">integer</td><td>Min 1.</td></tr>
            <tr><td>items.*.qty</td><td class="param-type">numeric</td><td>Min 1; rounded to the nearest integer.</td></tr>
            <tr><td>items.*.price</td><td class="param-type">numeric</td><td>Min 0. Unit price used for the line (not re-derived from the catalog).</td></tr>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Min 1.</td></tr>
            <tr><td>scheduled_at<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
            <tr><td>payment_method</td><td class="param-type">string</td><td>One of <code>cash</code>, <code>card</code>, <code>credit</code>.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "requests": [
      {
        "id": 210,
        "request_number": "SR-000210",
        "title": "Laptop screen replacement",
        "total_price": 8500.00,
        "status": "pending"
      }
    ],
    "receipt": {
      "sale_number": "SR-000210",
      "sold_at": "2026-07-31T10:15:00+00:00",
      "payment_method": "cash",
      "payment_method_label": "Cash",
      "subtotal": 8500.00,
      "total": 8500.00,
      "amount_paid": 8500.00,
      "items": [
        {
          "product_name": "Laptop screen replacement",
          "quantity": 1,
          "unit_sell_price": 8500.00,
          "line_total": 8500.00
        }
      ]
    }
  },
  "message": "1 service request created."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "No valid service items found." }</code></pre>
      </div>
@endverbatim
