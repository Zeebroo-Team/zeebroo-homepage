@verbatim
  <div class="endpoint" id="ep-businesses-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/businesses</code>
      <span class="endpoint-name">List accessible businesses</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every business the user owns, plus any business where they are an active HR employee or an active POS team member (<code>business_members</code> with <code>status = active</code>), sorted by name.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 1, "name": "Acme Retail" },
    { "id": 4, "name": "Acme Cafe" }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-businesses-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/businesses</code>
      <span class="endpoint-name">Create a new business</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates an additional business owned by the current user and stores its enabled feature flags on <code>business.features</code> (same forced-flag rules as registration).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Business name.</td></tr>
            <tr><td>category</td><td class="param-type">string</td><td>Category slug (from <code>/auth/business-categories</code>).</td></tr>
            <tr><td>features<span class="param-required">opt</span></td><td class="param-type">array&lt;string&gt;</td><td>Enabled feature keys.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 5, "name": "Acme Warehouse" }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name field is required.",
  "errors": { "name": ["The name field is required."] }
}</code></pre>
      </div>
@endverbatim
