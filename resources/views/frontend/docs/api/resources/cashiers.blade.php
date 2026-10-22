@verbatim
  <div class="endpoint" id="ep-cashiers-login">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/cashier/login</code>
      <span class="endpoint-name">Cashier login</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Authenticates a cashier by business slug, username, and password. On success, revokes any previously issued tokens for that cashier and issues a fresh bearer token scoped to the cashier and business. This route sits outside the <code>auth:sanctum</code> middleware group, so no existing bearer token is needed to call it.</p>
      <div class="endpoint-meta">
        <span class="meta-pill">No bearer token required</span>
        <span class="meta-pill">Business resolved from slug</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>slug</td><td class="param-type">string</td><td>Business slug (matches <code>Str::slug(business.name)</code>), case-insensitive.</td></tr>
            <tr><td>username</td><td class="param-type">string</td><td>Cashier username within that business.</td></tr>
            <tr><td>password</td><td class="param-type">string</td><td>Cashier password.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ",
    "cashier_id": 4,
    "cashier_name": "Jane Doe",
    "cashier_username": "jane",
    "business_id": 12,
    "business_name": "Acme Store",
    "business_slug": "acme-store"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">401</span></h4>
        <pre class="code-block"><code>{
  "message": "Invalid username or password."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-cashiers-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/cashiers</code>
      <span class="endpoint-name">List cashiers</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists POS cashier accounts for the current business, ordered by name.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 4,
      "name": "Jane Doe",
      "username": "jane",
      "is_active": true,
      "created_at": "2026-07-01T09:00:00.000000Z"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-cashiers-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/cashiers</code>
      <span class="endpoint-name">Create cashier</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new cashier login for the current business. The username must be unique within the business; the password is hashed automatically on save.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>username</td><td class="param-type">string</td><td>Max 80 characters, unique within the business.</td></tr>
            <tr><td>password</td><td class="param-type">string</td><td>Min 4, max 255 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Cashier created.",
  "data": {
    "id": 5,
    "name": "John Smith",
    "username": "john",
    "is_active": true,
    "created_at": "2026-07-31T10:00:00.000000Z"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The username has already been taken.",
  "errors": { "username": ["The username has already been taken."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-cashiers-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/cashiers/{cashier}</code>
      <span class="endpoint-name">Update cashier</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a cashier's name, username, password, or active status. Only supplied fields are changed; an omitted or empty password leaves the existing one intact. Returns 403 if the cashier belongs to a different business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>cashier</td><td class="param-type">integer</td><td>Cashier ID (route-model bound).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>username<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 80 characters, unique within the business (ignoring this cashier).</td></tr>
            <tr><td>password<span class="param-required">opt</span></td><td class="param-type">string</td><td>Min 4, max 255 characters. Leave blank to keep the current password.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Enable or disable the login.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Cashier updated.",
  "data": {
    "id": 5,
    "name": "John Smith",
    "username": "johnsmith",
    "is_active": false,
    "created_at": "2026-07-31T10:00:00.000000Z"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The username has already been taken.",
  "errors": { "username": ["The username has already been taken."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-cashiers-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/cashiers/{cashier}</code>
      <span class="endpoint-name">Delete cashier</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a cashier login. Returns 403 if the cashier belongs to a different business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Cashier deleted."
}</code></pre>
      </div>
@endverbatim
