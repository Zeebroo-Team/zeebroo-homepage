@verbatim
  <div class="endpoint" id="ep-online-bootstrap-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/bootstrap</code>
      <span class="endpoint-name">Full POS bootstrap payload</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns business info, currency, POS settings, categories, a paginated page of product cards, active brands, product units, POS payment accounts, today's sales summary, and branch info in one response. Product filtering/sorting/pagination params match <code>/online/products</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Branch-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search term over product name/SKU.</td></tr>
            <tr><td>category<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter products by category id.</td></tr>
            <tr><td>page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Page number, default 1.</td></tr>
            <tr><td>per_page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Page size, default 40, max 100.</td></tr>
            <tr><td>branch<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Branch id (also accepted via <code>X-Branch-Id</code> header). Only applied when branch-level POS separation is enabled for the business.</td></tr>
            <tr><td>stock_status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>in_stock</code>, <code>low_stock</code>, <code>out_of_stock</code>.</td></tr>
            <tr><td>brand_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter products by brand id.</td></tr>
            <tr><td>sort<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>name_asc</code>, <code>name_desc</code>, <code>price_asc</code>, <code>price_desc</code>, <code>stock_asc</code>, <code>stock_desc</code>, <code>recent_sales</code>. Default <code>name_asc</code>.</td></tr>
            <tr><td>recent_sales<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>When true, biases product ordering toward recently-sold items.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "business": { "id": 1, "name": "Acme Retail" },
    "currency": "USD",
    "channel": "online",
    "categories": [
      { "id": 3, "name": "Beverages", "parent_id": null, "product_count": 12, "image_url": null }
    ],
    "products": [
      { "id": 10, "name": "Blue T-Shirt", "sku": "TS-BLU-001", "unit_price": 1200.00, "total_stock": 42, "is_active": true }
    ],
    "products_meta": { "current_page": 1, "per_page": 40, "total": 118 },
    "accounts": [
      { "id": 1, "account_name": "Main Till", "bank_name": null, "current_balance": 54000.00 }
    ],
    "today": { "sales_count": 12, "total": 154000.00 },
    "settings": { "payment_settlement_mode": "immediate" },
    "product_units": [
      { "id": 1, "name": "Piece", "abbreviation": "pc" }
    ],
    "branch_pos_separate": false,
    "branch_product_separate": false,
    "branches": [
      { "id": 1, "name": "Main Branch" }
    ],
    "selected_branch_id": null,
    "brands": [
      { "id": 2, "name": "Acme Apparel" }
    ]
  }
}</code></pre>
      </div>
@endverbatim
