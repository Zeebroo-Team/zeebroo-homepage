@verbatim
  <div class="endpoint" id="ep-properties-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/properties</code>
      <span class="endpoint-name">List business properties</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists properties for the business with expiring-soon (within 60 days) and expired flags computed against today's date, plus totals.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 5,
      "property_name": "Colombo Warehouse",
      "property_type": "Warehouse",
      "cost": 8500000.00,
      "cost_fmt": "8,500,000.00",
      "has_expiry": false,
      "expire_date": null,
      "expire_date_fmt": null,
      "expiring_soon": false,
      "expired": false,
      "description": null
    }
  ],
  "total_count": 1,
  "expiring_count": 0,
  "total_cost_fmt": "8,500,000.00"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-properties-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/properties</code>
      <span class="endpoint-name">Create a property</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a property record. Requires the <code>fin_assets</code> permission. If <code>property_type</code> is <code>other</code>, <code>property_type_other</code> must be supplied and is stored as the actual type.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_assets</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>property_name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>property_type</td><td class="param-type">string</td><td>One of the platform's type options, or <code>other</code>.</td></tr>
            <tr><td>property_type_other<span class="param-required">opt</span></td><td class="param-type">string</td><td>Required when <code>property_type</code> is <code>other</code>.</td></tr>
            <tr><td>cost</td><td class="param-type">number</td><td>Acquisition cost.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>has_expiry<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Whether this property/asset has an expiry (e.g. lease or license).</td></tr>
            <tr><td>expire_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Used when <code>has_expiry</code> is true.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Property saved.",
  "data": {
    "id": 6,
    "property_name": "Delivery Van",
    "property_type": "Vehicle",
    "cost": 4200000.00,
    "cost_fmt": "4,200,000.00",
    "has_expiry": true,
    "expire_date": "2027-01-15",
    "expire_date_fmt": "Jan 15, 2027",
    "expiring_soon": false,
    "expired": false,
    "description": null
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Provide the custom property type.",
  "errors": { "property_type_other": ["Required when type is Other."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-properties-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/properties/{property}</code>
      <span class="endpoint-name">Delete a property</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a property record. Requires the <code>fin_assets</code> permission; 404s if it does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_assets</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Property deleted."
}</code></pre>
      </div>
@endverbatim
