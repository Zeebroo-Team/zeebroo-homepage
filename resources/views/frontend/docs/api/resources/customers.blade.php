@verbatim
  <div class="endpoint" id="ep-customers-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/customers</code>
      <span class="endpoint-name">List customers</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated (50 per page) list of customers for the current business, ordered by name, optionally filtered by search term against name/phone/email. Includes each customer's sales count.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by name, phone, or email.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 4,
      "name": "Nimal Perera",
      "phone": "0771234567",
      "email": "nimal@example.com",
      "address": "12 Galle Road, Colombo",
      "notes": null,
      "customer_type": "retail",
      "sales_count": 9
    }
  ],
  "meta": { "total": 128, "current_page": 1, "last_page": 3 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-customers-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/customers</code>
      <span class="endpoint-name">Create a customer</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a customer on the current business and dispatches a <code>customer.created</code> automation event. Requires the <code>pos_customers</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_customers permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 characters.</td></tr>
            <tr><td>email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Valid email, max 255 characters.</td></tr>
            <tr><td>address<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 characters.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 characters.</td></tr>
            <tr><td>customer_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>retail</code>, <code>wholesale</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 129,
    "name": "Kamal Fernando",
    "phone": "0719876543",
    "email": "kamal@example.com",
    "address": null,
    "notes": null,
    "customer_type": "retail",
    "sales_count": 0
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

  <div class="endpoint" id="ep-customers-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/customers/{customer}</code>
      <span class="endpoint-name">Get customer detail with recent sales</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Customer detail plus the 5 most recent sales, sorted by <code>sold_at</code> descending. Returns 403 if the customer belongs to a different business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 4,
    "name": "Nimal Perera",
    "phone": "0771234567",
    "email": "nimal@example.com",
    "address": "12 Galle Road, Colombo",
    "notes": null,
    "customer_type": "retail",
    "sales_count": 9,
    "recent_sales": [
      {
        "id": 1042,
        "sale_number": "SL-1042",
        "total": 4500.00,
        "payment_method": "cash",
        "sold_at": "2026-07-30 14:22:00"
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-customers-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/customers/{customer}</code>
      <span class="endpoint-name">Update a customer</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates a customer's contact details. Requires the <code>pos_customers</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_customers permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 characters.</td></tr>
            <tr><td>email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Valid email, max 255 characters.</td></tr>
            <tr><td>address<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 characters.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 characters.</td></tr>
            <tr><td>customer_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>retail</code>, <code>wholesale</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 4,
    "name": "Nimal Perera",
    "phone": "0771234567",
    "email": "nimal.p@example.com",
    "address": "12 Galle Road, Colombo",
    "notes": "Prefers SMS updates",
    "customer_type": "wholesale",
    "sales_count": 9
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

  <div class="endpoint" id="ep-customers-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/customers/{customer}</code>
      <span class="endpoint-name">Delete a customer</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a customer record. Requires the <code>pos_customers</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_customers permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Customer deleted."
}</code></pre>
      </div>
@endverbatim
