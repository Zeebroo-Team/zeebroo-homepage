@verbatim
  <div class="endpoint" id="ep-branches-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/branches</code>
      <span class="endpoint-name">List branches available for POS</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Reads the <code>business.branch_pos_separate</code> setting; if disabled, returns an empty <code>branches</code> array (single-branch POS). If enabled, returns every branch on the business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "branch_pos_separate": true,
    "branches": [
      { "id": 1, "name": "Main Branch" },
      { "id": 2, "name": "Mall Kiosk" }
    ]
  }
}</code></pre>
      </div>
@endverbatim
