@verbatim
  <div class="endpoint" id="ep-pos-settings-features">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/features</code>
      <span class="endpoint-name">Get enabled features</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the list of module/feature keys enabled for the business (from the <code>business.features</code> setting), filtered against a fixed known-feature list. <code>account_management</code> is always included even if not explicitly stored.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": ["account_management", "point_of_sale", "product_management", "stock_management", "human_resources"]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-settings-features-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/online/features</code>
      <span class="endpoint-name">Update enabled features</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the business's full feature-toggle map. Keys are validated only as booleans; unknown keys are ignored and every key from the fixed known-feature list is written (defaulting to false when absent). <code>account_management</code> is always forced on.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>features</td><td class="param-type">object</td><td>Map of feature key → boolean, e.g. <code>{"restaurant": true, "crm": false}</code>. Recognized keys: <code>account_management</code>, <code>automation_editor</code>, <code>bill_management</code>, <code>crm</code>, <code>developers</code>, <code>human_resources</code>, <code>mail</code>, <code>point_of_sale</code>, <code>product_management</code>, <code>project_management</code>, <code>restaurant</code>, <code>service_management</code>, <code>social_media_campaign</code>, <code>stock_management</code>.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": ["account_management", "point_of_sale", "restaurant"]
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The features field is required.",
  "errors": { "features": ["The features field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-settings-settings-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/settings</code>
      <span class="endpoint-name">Get POS settings</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the business's flattened POS settings (profile, checkout, receipt, tax, branch, and invoice numbering settings) via <code>PosSettingsService::forBusiness()</code>. Passing <code>include=assignment_targets</code> additionally returns pickers for branches, HR departments, properties, employees, modifications, and rentals — used by settings screens that assign POS behavior per branch/department/etc.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>include<span class="param-required">opt</span></td><td class="param-type">string</td><td>Set to <code>assignment_targets</code> to also return branch/department/property/employee/modification/rental picker lists.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "business_name": "Acme Retail",
    "slug": "acme-retail",
    "currency": "LKR",
    "timezone": "Asia/Colombo",
    "default_deposit_account_id": 3,
    "discount_field_enabled": true,
    "checkout_modal_enabled": false,
    "display_theme": "inherit",
    "receipt_header": "",
    "receipt_footer": "Thank you for your purchase!",
    "show_business_name": true,
    "show_business_address": false,
    "receipt_address_line": "",
    "receipt_language": "en",
    "show_account_info": true,
    "payment_settlement_mode": "immediate",
    "featured_products_limit": 0,
    "featured_categories_limit": 0,
    "show_service_bound_products": true,
    "dont_settle_to_account": false,
    "stock_selection_mode": "fifo",
    "choose_price": false,
    "multi_warehouse_branch": false,
    "branch_product_separate": false,
    "branch_stock_separate": false,
    "branch_pos_separate": false,
    "tax_enabled": false,
    "tax_rate": 0,
    "invoice_prefix": "INV",
    "invoice_next_number": 1
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-settings-settings-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/online/settings</code>
      <span class="endpoint-name">Update POS settings (full replace)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Saves the business's POS settings via <code>PosSettingsService::saveForBusiness()</code> and returns the resulting settings object. All fields are optional/nullable — omitted booleans are treated as false/defaults by the service layer.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>business_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>currency<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 10 characters.</td></tr>
            <tr><td>timezone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 80 characters.</td></tr>
            <tr><td>default_deposit_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must resolve to an Account belonging to this business or it is silently ignored.</td></tr>
            <tr><td>discount_field_enabled<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Show the discount field at checkout.</td></tr>
            <tr><td>checkout_modal_enabled<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>display_theme<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>light</code>, <code>dark</code>, <code>inherit</code>.</td></tr>
            <tr><td>receipt_header<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 200 characters.</td></tr>
            <tr><td>receipt_footer<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 200 characters.</td></tr>
            <tr><td>show_business_name<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>show_business_address<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>receipt_address_line<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 300 characters.</td></tr>
            <tr><td>receipt_language<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>en</code>, <code>si</code>, <code>ta</code>.</td></tr>
            <tr><td>show_account_info<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>payment_settlement_mode<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>immediate</code>, <code>end_of_day</code>.</td></tr>
            <tr><td>featured_products_limit<span class="param-required">opt</span></td><td class="param-type">integer</td><td>0–200.</td></tr>
            <tr><td>featured_categories_limit<span class="param-required">opt</span></td><td class="param-type">integer</td><td>0–200.</td></tr>
            <tr><td>show_service_bound_products<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>dont_settle_to_account<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>stock_selection_mode<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>fifo</code>, <code>choose</code>, <code>last_price</code>.</td></tr>
            <tr><td>choose_price<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>multi_warehouse_branch<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>branch_product_separate<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>branch_stock_separate<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>branch_pos_separate<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>tax_enabled<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>—</td></tr>
            <tr><td>tax_rate<span class="param-required">opt</span></td><td class="param-type">numeric</td><td>0–100.</td></tr>
            <tr><td>invoice_prefix<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 20 characters.</td></tr>
            <tr><td>invoice_next_number<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Minimum 1.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "POS settings saved.",
  "data": {
    "business_name": "Acme Retail",
    "currency": "LKR",
    "display_theme": "dark",
    "tax_enabled": true,
    "tax_rate": 8,
    "invoice_prefix": "INV",
    "invoice_next_number": 105
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected display theme is invalid.",
  "errors": { "display_theme": ["The selected display theme is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-settings-settings-patch">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/online/settings</code>
      <span class="endpoint-name">Update POS settings (partial)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Routed to the exact same <code>PosSettingsApiController@update</code> action as the PUT variant above (same validation rules, same response shape) — registered as an unnamed route purely so PATCH-based clients can hit the same handler. There is no behavioral difference between PUT and PATCH here.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <p class="endpoint-desc">Identical to <a href="#ep-pos-settings-settings-update">PUT /online/settings</a> — all fields optional.</p>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "POS settings saved.",
  "data": {
    "business_name": "Acme Retail",
    "discount_field_enabled": true,
    "payment_settlement_mode": "end_of_day"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-settings-sync-status">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/sync-status</code>
      <span class="endpoint-name">Get sync status</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the latest <code>updated_at</code> timestamp per data domain (products, categories, stock, restaurant tables, menu items, restaurant orders) for the business. Used by the desktop client to cheaply detect whether its local cache is stale without pulling full datasets.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "products": "2026-07-31T07:45:12.000000Z",
    "categories": "2026-07-20T09:00:00.000000Z",
    "stock": "2026-07-31T06:10:00.000000Z",
    "tables": null,
    "menu_items": null,
    "rst_orders": null
  }
}</code></pre>
      </div>
@endverbatim
