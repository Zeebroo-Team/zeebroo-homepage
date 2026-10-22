@verbatim
  <div class="endpoint" id="ep-discounts-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/discounts</code>
      <span class="endpoint-name">List product discounts</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns configured product discounts with computed pricing (original price, discount amount, final price) and whether each is currently active based on its date window.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by discount or product name.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>active</code> or <code>inactive</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 4,
      "name": "Summer Sale",
      "product_id": 10,
      "product_name": "Blue T-Shirt",
      "discount_type": "percentage",
      "discount_value": 15,
      "starts_at": "2026-07-01T00:00:00+00:00",
      "ends_at": "2026-08-31T23:59:59+00:00",
      "is_active": true,
      "is_currently_active": true,
      "original_price": 1200.00,
      "discount_amount": 180.00,
      "final_price": 1020.00
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-discounts-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/discounts</code>
      <span class="endpoint-name">Create a discount</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a discount attached to a single product (optionally scoped to one of its selling units).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>&nbsp;</td></tr>
            <tr><td>product_id</td><td class="param-type">integer</td><td>&nbsp;</td></tr>
            <tr><td>discount_type</td><td class="param-type">string</td><td><code>flat</code> or <code>percentage</code>.</td></tr>
            <tr><td>discount_value</td><td class="param-type">number</td><td>&nbsp;</td></tr>
            <tr><td>product_selling_unit_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Restrict the discount to one selling unit.</td></tr>
            <tr><td>starts_at<span class="param-required">opt</span></td><td class="param-type">string (date-time)</td><td>&nbsp;</td></tr>
            <tr><td>ends_at<span class="param-required">opt</span></td><td class="param-type">string (date-time)</td><td>&nbsp;</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 5, "name": "Clearance", "product_id": 10, "discount_type": "flat", "discount_value": 100.00 }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The discount value field is required.",
  "errors": { "discount_value": ["The discount value field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-discounts-product-options">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/discounts/product-options</code>
      <span class="endpoint-name">Search products for discount form</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Typeahead search returning products (with their selling units) for the "attach discount to product" selector.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search term over product name.</td></tr>
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
      "selling_price": 1200.00,
      "selling_units": [
        { "id": 1, "label": "Box of 12", "sell_price": 13000.00 }
      ]
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-discounts-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/discounts/{discount}</code>
      <span class="endpoint-name">Update a discount</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a discount's name, type, value, date window, or active status. The attached product cannot be changed after creation.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>&nbsp;</td></tr>
            <tr><td>discount_type<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>flat</code> or <code>percentage</code>.</td></tr>
            <tr><td>discount_value<span class="param-required">opt</span></td><td class="param-type">number</td><td>&nbsp;</td></tr>
            <tr><td>starts_at<span class="param-required">opt</span></td><td class="param-type">string (date-time)</td><td>&nbsp;</td></tr>
            <tr><td>ends_at<span class="param-required">opt</span></td><td class="param-type">string (date-time)</td><td>&nbsp;</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 4, "name": "Summer Sale (Extended)" }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The ends at must be a date after starts at.",
  "errors": { "ends_at": ["The ends at must be a date after starts at."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-discounts-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/discounts/{discount}</code>
      <span class="endpoint-name">Delete a discount</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a discount owned by the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Discount deleted."
}</code></pre>
      </div>
@endverbatim
