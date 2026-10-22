@verbatim
  <div class="endpoint" id="ep-suppliers-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/suppliers</code>
      <span class="endpoint-name">List suppliers</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated (50 per page) list of suppliers for the current business, ordered by name, optionally filtered by active status or search term against name/contact/email/phone. Includes each supplier's purchase count.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by name, contact name, email, or phone.</td></tr>
            <tr><td>active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Filter by active status. Omit to include both active and inactive suppliers.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 9,
      "name": "Ceylon Textiles Ltd",
      "contact_name": "Ruwan Jayasuriya",
      "email": "ruwan@ceylontextiles.lk",
      "phone": "0112345678",
      "address": "44 Industrial Zone, Ratmalana",
      "notes": null,
      "is_active": true,
      "purchases_count": 14
    }
  ],
  "meta": { "total": 22, "current_page": 1, "last_page": 1 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-suppliers-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/suppliers</code>
      <span class="endpoint-name">Create a supplier</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a supplier on the current business, active by default. Requires the <code>inv_suppliers</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires inv_suppliers permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>contact_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Valid email, max 255 characters.</td></tr>
            <tr><td>phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 characters.</td></tr>
            <tr><td>address<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 characters.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 23,
    "name": "Lanka Hardware Supplies",
    "contact_name": "Priya Wickramasinghe",
    "email": "priya@lankahardware.lk",
    "phone": "0117654321",
    "address": null,
    "notes": null,
    "is_active": true,
    "purchases_count": 0
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name field is required.",
  "errors": { "name": ["The name field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-suppliers-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/suppliers/{supplier}</code>
      <span class="endpoint-name">Get supplier detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Supplier detail including purchase count. Returns 403 if the supplier belongs to a different business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "name": "Ceylon Textiles Ltd",
    "contact_name": "Ruwan Jayasuriya",
    "email": "ruwan@ceylontextiles.lk",
    "phone": "0112345678",
    "address": "44 Industrial Zone, Ratmalana",
    "notes": null,
    "is_active": true,
    "purchases_count": 14
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-suppliers-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/suppliers/{supplier}</code>
      <span class="endpoint-name">Update a supplier</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates a supplier's details, including the ability to toggle <code>is_active</code> directly. Requires the <code>inv_suppliers</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires inv_suppliers permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>contact_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Valid email, max 255 characters.</td></tr>
            <tr><td>phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 characters.</td></tr>
            <tr><td>address<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 characters.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 characters.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Toggle supplier active status.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "name": "Ceylon Textiles Ltd",
    "contact_name": "Ruwan Jayasuriya",
    "email": "ruwan@ceylontextiles.lk",
    "phone": "0112345678",
    "address": "44 Industrial Zone, Ratmalana",
    "notes": "Net 30 terms",
    "is_active": true,
    "purchases_count": 14
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The email field must be a valid email address.",
  "errors": { "email": ["The email field must be a valid email address."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-suppliers-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/suppliers/{supplier}</code>
      <span class="endpoint-name">Deactivate supplier</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sets <code>is_active</code> to <code>false</code> rather than deleting the row, preserving purchase-order history. Requires the <code>inv_suppliers</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires inv_suppliers permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Supplier deactivated."
}</code></pre>
      </div>
@endverbatim
