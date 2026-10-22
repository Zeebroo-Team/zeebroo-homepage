@verbatim
  <div class="endpoint" id="ep-catalog-categories">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/categories</code>
      <span class="endpoint-name">List POS categories</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns categories for the POS category filter, with per-category product counts. When branch-level product separation is enabled, counts are scoped to the given branch.</p>
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
            <tr><td>branch<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Branch id; only applied when branch-level POS separation is enabled.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 3, "name": "Beverages", "parent_id": null, "product_count": 12, "image_url": null }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-catalog-products">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/products</code>
      <span class="endpoint-name">Paginated product catalog for POS screen</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns paginated product cards for the POS grid, with reserved-stock enrichment: each product also gets <code>reserved_qty</code> (quantity tied up in open invoices/quotations) and <code>available_stock</code> (stock minus reserved).</p>
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
            <tr><td>category<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter by category id.</td></tr>
            <tr><td>page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Page number, default 1.</td></tr>
            <tr><td>per_page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Page size, default 40, max 100.</td></tr>
            <tr><td>branch<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Branch id (also accepted via <code>X-Branch-Id</code> header).</td></tr>
            <tr><td>stock_status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>in_stock</code>, <code>low_stock</code>, <code>out_of_stock</code>.</td></tr>
            <tr><td>brand_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter by brand id.</td></tr>
            <tr><td>sort<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>name_asc</code>, <code>name_desc</code>, <code>price_asc</code>, <code>price_desc</code>, <code>stock_asc</code>, <code>stock_desc</code>. Default <code>name_asc</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 10,
      "name": "Blue T-Shirt",
      "sku": "TS-BLU-001",
      "unit_price": 1200.00,
      "total_stock": 42,
      "is_active": true,
      "category": "Apparel",
      "brand": "Acme Apparel",
      "images": ["https://.../ts-blu-001.jpg"],
      "unit_name": "Piece",
      "reserved_qty": 3,
      "available_stock": 39
    }
  ],
  "meta": { "current_page": 1, "per_page": 40, "total": 118 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-catalog-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/products/{id}</code>
      <span class="endpoint-name">Full product detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the full product detail used by the product edit/detail panel: pricing, stock layers, selling units, bundle items, categories, brands, and all images.</p>
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
            <tr><td>branch<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Branch id (also accepted via <code>X-Branch-Id</code> header); used for branch-scoped stock totals.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 10,
    "name": "Blue T-Shirt",
    "sku": "TS-BLU-001",
    "unit_price": 1200.00,
    "cost_price": 800.00,
    "total_stock": 42,
    "is_active": true,
    "is_bundle": false,
    "has_warranty": false,
    "track_expiry": false,
    "courier_delivery": true,
    "loyalty_redeemable": true,
    "description": "100% cotton t-shirt.",
    "category": { "id": 3, "name": "Apparel" },
    "brand": { "id": 2, "name": "Acme Apparel" },
    "category_ids": [3],
    "brand_ids": [2],
    "product_unit_id": 1,
    "file_manager_file_id": 55,
    "bundle_items": [],
    "unit_name": "Piece",
    "images": [{ "id": 12, "url": "https://.../ts-blu-001.jpg" }],
    "selling_units": [
      { "id": 1, "label": "Box of 12", "multiplier": 12, "sell_price": 13000.00, "sku": "TS-BLU-001-BX", "is_active": true }
    ],
    "stock_layers": [
      { "id": 44, "quantity_remaining": 42, "unit_cost": 800.00, "received_at": "2026-07-01" }
    ],
    "created_at": "2026-01-10 09:00:00",
    "updated_at": "2026-07-20 14:22:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-catalog-sku">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/products/sku/{sku}</code>
      <span class="endpoint-name">Look up product by SKU (barcode scan)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Finds a single sellable product by exact SKU match, for barcode-scanner add-to-cart flows on the POS screen.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 10,
    "name": "Blue T-Shirt",
    "sku": "TS-BLU-001",
    "unit_price": 1200.00,
    "total_stock": 42,
    "is_active": true
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">404</span></h4>
        <pre class="code-block"><code>{
  "message": "No product found for SKU: TS-BLU-999"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-catalog-stock-history">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/products/{id}/stock-history</code>
      <span class="endpoint-name">Product stock-layer receiving history</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every stock layer received for the product, newest first, joined back to the GRN and purchase order/supplier that brought it in — used for the product's "stock history" tab.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "received_at": "2026-07-01",
      "quantity_received": 50,
      "quantity_remaining": 42,
      "unit_cost": 800.00,
      "grn_number": "GRN-0012",
      "grn_reference": null,
      "grn_id": 12,
      "po_number": "PO-0009",
      "po_id": 9,
      "supplier_name": "Textile Supplies Co."
    }
  ]
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">404</span></h4>
        <pre class="code-block"><code>{
  "message": "Product not found."
}</code></pre>
      </div>
@endverbatim
