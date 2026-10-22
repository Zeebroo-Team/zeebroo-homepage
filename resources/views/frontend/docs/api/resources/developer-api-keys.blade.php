@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-developer-api-keys-index"><span class="method-badge method-get">GET</span> /api/v1/developers/keys</a>
    <a href="#ep-developer-api-keys-store"><span class="method-badge method-post">POST</span> /api/v1/developers/keys</a>
    <a href="#ep-developer-api-keys-toggle"><span class="method-badge method-patch">PATCH</span> /api/v1/developers/keys/{id}/toggle</a>
    <a href="#ep-developer-api-keys-destroy"><span class="method-badge method-delete">DELETE</span> /api/v1/developers/keys/{id}</a>
    <a href="#ep-developer-api-keys-index-pos"><span class="method-badge method-get">GET</span> /api/v1/pos/developers/keys</a>
    <a href="#ep-developer-api-keys-store-pos"><span class="method-badge method-post">POST</span> /api/v1/pos/developers/keys</a>
    <a href="#ep-developer-api-keys-toggle-pos"><span class="method-badge method-patch">PATCH</span> /api/v1/pos/developers/keys/{id}/toggle</a>
    <a href="#ep-developer-api-keys-destroy-pos"><span class="method-badge method-delete">DELETE</span> /api/v1/pos/developers/keys/{id}</a>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/developers/keys</code>
      <span class="endpoint-name">List API keys</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every API key issued for the current business, newest first. The raw token is never included in this response — only the stored <code>token_prefix</code> — since the full value is not persisted anywhere after creation.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1,
      "name": "Inventory Sync",
      "token_prefix": "sk_live_ab12cd34…",
      "permissions": null,
      "is_active": true,
      "expires_at": null,
      "last_used_at": "2026-07-28 09:14:02",
      "created_at": "2026-07-20 11:02:45"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/developers/keys</code>
      <span class="endpoint-name">Create API key</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Generates a new key (prefixed <code>sk_live_</code>) for the current business via <code>ApiKey::generateToken()</code> and stores it active by default. The full token is returned once in the <code>token</code> field of this response only — only its SHA-256 hash is kept afterward, so it cannot be retrieved again.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Label shown in the keys list. Max 100 characters.</td></tr>
            <tr><td>permissions<span class="param-required">opt</span></td><td class="param-type">array</td><td>List of permission keys restricting the key's scope. Omit or send null for unrestricted access.</td></tr>
            <tr><td>expires_at<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be a date after today. Omit for a non-expiring key.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "name": "Inventory Sync",
    "token_prefix": "sk_live_ab12cd34…",
    "permissions": null,
    "is_active": true,
    "expires_at": null,
    "last_used_at": null,
    "created_at": "2026-07-30 10:00:00"
  },
  "token": "sk_live_YOUR_SECRET_KEY_HERE"
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

  <div class="endpoint" id="ep-developer-api-keys-toggle">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/developers/keys/{id}/toggle</code>
      <span class="endpoint-name">Toggle API key active state</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Flips <code>is_active</code> on the given key (active becomes inactive and vice versa) for the current business. The key is looked up with <code>business_id</code> in the query, so a key belonging to another business returns a 404. Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "name": "Inventory Sync",
    "token_prefix": "sk_live_ab12cd34…",
    "permissions": null,
    "is_active": false,
    "expires_at": null,
    "last_used_at": "2026-07-28 09:14:02",
    "created_at": "2026-07-20 11:02:45"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/developers/keys/{id}</code>
      <span class="endpoint-name">Revoke API key</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes the API key, scoped to the current business. Any integration still presenting the old token immediately loses access. Always returns a success message, even if the key was already gone.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "API key deleted."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-index-pos">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/developers/keys</code>
      <span class="endpoint-name">List API keys (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperApiKeyApiController@index</code> handler as <code>/api/v1/developers/keys</code> above, registered a second time under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.keys.index</code>) for clients that only talk to the <code>/api/v1/pos</code> namespace. Identical response shape.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1,
      "name": "Inventory Sync",
      "token_prefix": "sk_live_ab12cd34…",
      "permissions": null,
      "is_active": true,
      "expires_at": null,
      "last_used_at": "2026-07-28 09:14:02",
      "created_at": "2026-07-20 11:02:45"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-store-pos">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/developers/keys</code>
      <span class="endpoint-name">Create API key (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperApiKeyApiController@store</code> handler as <code>/api/v1/developers/keys</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.keys.store</code>). Same validation rules and one-time <code>token</code> response field.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Label shown in the keys list. Max 100 characters.</td></tr>
            <tr><td>permissions<span class="param-required">opt</span></td><td class="param-type">array</td><td>List of permission keys restricting the key's scope. Omit or send null for unrestricted access.</td></tr>
            <tr><td>expires_at<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be a date after today. Omit for a non-expiring key.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 6,
    "name": "Reporting Bot",
    "token_prefix": "sk_live_9f8e7d6c…",
    "permissions": ["reports.read"],
    "is_active": true,
    "expires_at": "2026-12-31",
    "last_used_at": null,
    "created_at": "2026-07-30 10:05:00"
  },
  "token": "sk_live_YOUR_SECRET_KEY_HERE"
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The expires at must be a date after today.",
  "errors": { "expires_at": ["The expires at must be a date after today."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-toggle-pos">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/developers/keys/{id}/toggle</code>
      <span class="endpoint-name">Toggle API key active state (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperApiKeyApiController@toggle</code> handler as <code>/api/v1/developers/keys/{id}/toggle</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.keys.toggle</code>). Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 6,
    "name": "Reporting Bot",
    "token_prefix": "sk_live_9f8e7d6c…",
    "permissions": ["reports.read"],
    "is_active": false,
    "expires_at": "2026-12-31",
    "last_used_at": null,
    "created_at": "2026-07-30 10:05:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-api-keys-destroy-pos">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/developers/keys/{id}</code>
      <span class="endpoint-name">Revoke API key (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperApiKeyApiController@destroy</code> handler as <code>/api/v1/developers/keys/{id}</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.keys.destroy</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "API key deleted."
}</code></pre>
      </div>
@endverbatim
