@verbatim
  <div class="endpoint" id="ep-auth-token">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/auth/token</code>
      <span class="endpoint-name">Create access token</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Verifies email + password against <code>users</code> and issues a Sanctum personal access token. Send the returned <code>access_token</code> as <code>Authorization: Bearer {token}</code> on all protected routes.</p>
      <div class="endpoint-meta">
        <span class="meta-pill">Public — no auth required</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>email</td><td class="param-type">string</td><td>Account email.</td></tr>
            <tr><td>password</td><td class="param-type">string</td><td>Account password.</td></tr>
            <tr><td>device_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Label for the issued token. Defaults to <code>pos-api-client</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "token_type": "Bearer",
  "access_token": "1|abcdef123456...",
  "user": {
    "id": 1,
    "name": "Jane Doe",
    "email": "jane@example.com"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The provided credentials are incorrect.",
  "errors": {
    "email": ["The provided credentials are incorrect."]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-auth-register">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/auth/register</code>
      <span class="endpoint-name">Register user and create first business</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new user, creates their first <code>Business</code> under the given category, stores enabled feature flags on <code>business.features</code>, and returns a bearer token in the same shape as <code>/auth/token</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill">Public — no auth required</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>User's full name.</td></tr>
            <tr><td>business_name</td><td class="param-type">string</td><td>Name for the first business.</td></tr>
            <tr><td>business_category</td><td class="param-type">string</td><td>Category slug (from <code>/auth/business-categories</code>).</td></tr>
            <tr><td>features<span class="param-required">opt</span></td><td class="param-type">array&lt;string&gt;</td><td>Enabled feature keys, e.g. <code>point_of_sale</code>, <code>stock_management</code>. <code>account_management</code> is always forced on; <code>point_of_sale</code> is forced off unless both <code>stock_management</code> and <code>product_management</code> are enabled.</td></tr>
            <tr><td>email</td><td class="param-type">string</td><td>Must be unique in <code>users</code>.</td></tr>
            <tr><td>password</td><td class="param-type">string</td><td>Min 8 characters, must be confirmed.</td></tr>
            <tr><td>password_confirmation</td><td class="param-type">string</td><td>Must match <code>password</code>.</td></tr>
            <tr><td>device_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Label for the issued token. Defaults to <code>pos-api-client</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "token_type": "Bearer",
  "access_token": "2|xyz987654...",
  "user": {
    "id": 42,
    "name": "Jane Doe",
    "email": "jane@example.com"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The email has already been taken.",
  "errors": {
    "email": ["The email has already been taken."]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-auth-business-categories">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/auth/business-categories</code>
      <span class="endpoint-name">List business category options</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the fixed list of business category options (value/label pairs) used to populate the category selector on registration and business-creation forms.</p>
      <div class="endpoint-meta">
        <span class="meta-pill">Public — no auth required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "value": "retail", "label": "Retail" },
    { "value": "restaurant", "label": "Restaurant" }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-auth-me">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/auth/me</code>
      <span class="endpoint-name">Get authenticated user profile</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the id, name, and email of the currently authenticated token holder.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 1,
    "name": "Jane Doe",
    "email": "jane@example.com"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-auth-revoke">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/auth/revoke</code>
      <span class="endpoint-name">Revoke current token</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes the Sanctum token used to authenticate the current request (logout). The token cannot be used again after this call.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Token revoked."
}</code></pre>
      </div>
@endverbatim
