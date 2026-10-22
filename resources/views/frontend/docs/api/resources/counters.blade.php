@verbatim
  <div class="endpoint" id="ep-counters-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/counters</code>
      <span class="endpoint-name">List counters</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists counters for the business, ordered by sort order then name. Pass <code>branch_id</code> to include only counters that are unscoped (no branch) or that match that branch.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter to counters unscoped or matching this branch.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1,
      "business_id": 12,
      "branch_id": null,
      "name": "Counter 1",
      "sort_order": 0,
      "is_active": true
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-counters-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/counters</code>
      <span class="endpoint-name">Create counter</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new counter for the business, optionally scoped to a branch.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 100 characters.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Min 1. Omit/null for an unscoped counter.</td></tr>
            <tr><td>sort_order<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Min 0. Defaults to 0.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Counter created.",
  "data": {
    "id": 2,
    "business_id": 12,
    "branch_id": 3,
    "name": "Counter 2",
    "sort_order": 1,
    "is_active": true
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

  <div class="endpoint" id="ep-counters-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/counters/{counter}</code>
      <span class="endpoint-name">Update counter</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a counter's name, branch assignment, sort order, or active status. Only supplied fields are changed. Returns 403 if the counter belongs to a different business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>counter</td><td class="param-type">integer</td><td>Counter ID (route-model bound).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 100 characters.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Min 1, nullable to unscope the counter.</td></tr>
            <tr><td>sort_order<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Min 0.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Enable or disable the counter.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Counter updated.",
  "data": {
    "id": 2,
    "business_id": 12,
    "branch_id": null,
    "name": "Front Register",
    "sort_order": 1,
    "is_active": false
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The sort order must be at least 0.",
  "errors": { "sort_order": ["The sort order must be at least 0."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-counters-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/counters/{counter}</code>
      <span class="endpoint-name">Delete counter</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a counter. Returns 403 if it belongs to a different business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Counter deleted."
}</code></pre>
      </div>
@endverbatim
