@verbatim
  <div class="endpoint" id="ep-products-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/online/products</code>
      <span class="endpoint-name">Create a product</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a product via <code>PosProductQuickCreateService</code> (name, SKU, price, opening stock as a manual stock layer, unit, branch), then applies any extended fields present on the request (description, wholesale price, flags, categories, brands, files, bundle items) as a second update pass.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires <code>inv_products</code> permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>unit_price</td><td class="param-type">number</td><td>Selling price.</td></tr>
            <tr><td>sku<span class="param-required">opt</span></td><td class="param-type">string</td><td>Must be unique within the business.</td></tr>
            <tr><td>stock_quantity<span class="param-required">opt</span></td><td class="param-type">number</td><td>Opening stock; recorded as a manual stock layer at <code>unit_price</code> cost.</td></tr>
            <tr><td>product_unit_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to the business.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to the business; used when branch-level product separation is enabled.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Applied in the extended-fields pass.</td></tr>
            <tr><td>wholesale_price<span class="param-required">opt</span></td><td class="param-type">number</td><td>Applied in the extended-fields pass.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
            <tr><td>is_bundle<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>When true, <code>bundle_items</code> is applied.</td></tr>
            <tr><td>has_warranty<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Applied in the extended-fields pass.</td></tr>
            <tr><td>track_expiry<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Applied in the extended-fields pass.</td></tr>
            <tr><td>courier_delivery<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Applied in the extended-fields pass.</td></tr>
            <tr><td>loyalty_redeemable<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Applied in the extended-fields pass.</td></tr>
            <tr><td>product_category_ids<span class="param-required">opt</span></td><td class="param-type">array&lt;integer&gt;</td><td>Synced onto the product.</td></tr>
            <tr><td>product_brand_ids<span class="param-required">opt</span></td><td class="param-type">array&lt;integer&gt;</td><td>Synced onto the product.</td></tr>
            <tr><td>file_manager_file_ids<span class="param-required">opt</span></td><td class="param-type">array&lt;integer&gt;</td><td>Product image file ids from the file manager.</td></tr>
            <tr><td>bundle_items<span class="param-required">opt</span></td><td class="param-type">array</td><td>Each item: <code>product_id</code>, <code>quantity</code>. Only applied when <code>is_bundle</code> is present.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Product added.",
  "data": {
    "id": 55,
    "name": "Red Hoodie",
    "sku": "HD-RED-001",
    "unit_price": 3500.00,
    "total_stock": 20,
    "is_active": true
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This SKU is already used by another product.",
  "errors": { "sku": ["This SKU is already used by another product."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-products-import">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/online/products/import</code>
      <span class="endpoint-name">Bulk import products</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates up to 500 products in one call. Each row runs through the same quick-create flow as a single product create; category/brand names are resolved (or created) and cached per-request. Rows that fail validation are skipped and reported individually rather than failing the whole batch.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>rows</td><td class="param-type">array</td><td>1–500 rows.</td></tr>
            <tr><td>rows[].name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>rows[].unit_price</td><td class="param-type">number</td><td>Selling price.</td></tr>
            <tr><td>rows[].sku<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>rows[].stock_quantity<span class="param-required">opt</span></td><td class="param-type">number</td><td>Opening stock.</td></tr>
            <tr><td>rows[].wholesale_price<span class="param-required">opt</span></td><td class="param-type">number</td><td>Applied after creation.</td></tr>
            <tr><td>rows[].category<span class="param-required">opt</span></td><td class="param-type">string</td><td>Category name; created if it doesn't already exist on the business.</td></tr>
            <tr><td>rows[].brand<span class="param-required">opt</span></td><td class="param-type">string</td><td>Brand name; created if it doesn't already exist on the business.</td></tr>
            <tr><td>rows[].description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "imported": 48,
  "skipped": 2,
  "errors": [
    { "row": 13, "name": "Green Hoodie", "message": "This SKU is already used by another product." }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-products-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/online/products/{product}</code>
      <span class="endpoint-name">Update a product</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a product's core and extended fields via <code>ProductService::update()</code>. <code>{product}</code> is route-model-bound; the controller separately verifies the product belongs to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires <code>inv_products</code> permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>sku<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 characters.</td></tr>
            <tr><td>unit_price<span class="param-required">opt</span></td><td class="param-type">number</td><td>Selling price.</td></tr>
            <tr><td>wholesale_price<span class="param-required">opt</span></td><td class="param-type">number</td><td>Wholesale price.</td></tr>
            <tr><td>stock_quantity<span class="param-required">opt</span></td><td class="param-type">number</td><td>Not adjusted via stock layers here — passed through to the update.</td></tr>
            <tr><td>product_unit_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Product unit id.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>is_bundle<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>has_warranty<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>track_expiry<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>courier_delivery<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>loyalty_redeemable<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>product_category_ids<span class="param-required">opt</span></td><td class="param-type">array&lt;integer&gt;</td><td>&nbsp;</td></tr>
            <tr><td>product_brand_ids<span class="param-required">opt</span></td><td class="param-type">array&lt;integer&gt;</td><td>&nbsp;</td></tr>
            <tr><td>file_manager_file_ids<span class="param-required">opt</span></td><td class="param-type">array&lt;integer&gt;</td><td>&nbsp;</td></tr>
            <tr><td>bundle_items<span class="param-required">opt</span></td><td class="param-type">array</td><td>Each item: <code>product_id</code> (integer), <code>quantity</code> (number, min 0.001).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Product updated.",
  "data": { "id": 55, "name": "Red Hoodie (V2)" }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The unit price must be at least 0.",
  "errors": { "unit_price": ["The unit price must be at least 0."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-products-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/online/products/{product}</code>
      <span class="endpoint-name">Delete a product</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a product owned by the resolved business via <code>ProductService::delete()</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires <code>inv_products</code> permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Product deleted."
}</code></pre>
      </div>
@endverbatim
