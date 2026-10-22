@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-automation-editor-index"><span class="method-badge method-get">GET</span> /automations</a>
    <a href="#ep-automation-editor-store"><span class="method-badge method-post">POST</span> /automations</a>
    <a href="#ep-automation-editor-show"><span class="method-badge method-get">GET</span> /automations/{id}</a>
    <a href="#ep-automation-editor-update"><span class="method-badge method-patch">PATCH</span> /automations/{id}</a>
    <a href="#ep-automation-editor-destroy"><span class="method-badge method-delete">DELETE</span> /automations/{id}</a>
    <a href="#ep-automation-editor-runs"><span class="method-badge method-get">GET</span> /automations/{id}/runs</a>
    <a href="#ep-automation-editor-trigger"><span class="method-badge method-post">POST</span> /automations/{id}/trigger</a>
    <a href="#ep-automation-editor-notifications"><span class="method-badge method-get">GET</span> /automation-notifications</a>
    <a href="#ep-automation-editor-notifications-read-all"><span class="method-badge method-post">POST</span> /automation-notifications/read-all</a>
  </div>

  <div class="endpoint" id="ep-automation-editor-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/automations</code>
      <span class="endpoint-name">List automation flows</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every automation flow belonging to the resolved business, newest-updated first, along with the static catalog of triggers an admin can pick from when building a flow.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped (X-Business-Id header, business_id query param, or session-selected business)</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 12,
      "name": "Low stock alert",
      "description": "Notify me when a product drops below reorder level",
      "trigger_type": "stock.updated",
      "is_active": true,
      "run_count": 34,
      "last_run_at": "2026-07-30 09:12:41",
      "updated_at": "2026-07-30 09:12:41",
      "created_at": "2026-06-02 14:03:10"
    }
  ],
  "triggers": {
    "sale.created": "Sale Created",
    "sale.voided": "Sale Voided",
    "stock.updated": "Stock Updated",
    "grn.created": "GRN Created",
    "customer.created": "Customer Created",
    "manual": "Manual / Button Trigger"
  }
}</code></pre>
        <p class="endpoint-desc">The <code>triggers</code> map lists all ~24 available trigger keys (sales/invoices, products/stock, purchasing, customers, cash/EOD, bills, loans, property/rental, plus <code>manual</code>) as defined in <code>AutomationFlow::availableTriggers()</code> — abbreviated above.</p>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/automations</code>
      <span class="endpoint-name">Create automation flow</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new flow for the resolved business. If <code>flow_data</code> is omitted, it defaults to an empty canvas (<code>{"nodes": [], "edges": []}</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
            <tr><td>trigger_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 60 chars, e.g. <code>sale.created</code>.</td></tr>
            <tr><td>flow_data<span class="param-required">opt</span></td><td class="param-type">array</td><td>Drawflow canvas JSON (nodes/edges).</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to false.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 41,
    "name": "New flow",
    "description": null,
    "trigger_type": null,
    "is_active": false,
    "run_count": 0,
    "last_run_at": null,
    "updated_at": "2026-07-31 10:00:00",
    "created_at": "2026-07-31 10:00:00"
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

  <div class="endpoint" id="ep-automation-editor-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/automations/{id}</code>
      <span class="endpoint-name">Get automation flow</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single flow scoped to the resolved business, including the full <code>flow_data</code> canvas (omitted from the list endpoint).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "name": "Low stock alert",
    "description": "Notify me when a product drops below reorder level",
    "trigger_type": "stock.updated",
    "is_active": true,
    "run_count": 34,
    "last_run_at": "2026-07-30 09:12:41",
    "updated_at": "2026-07-30 09:12:41",
    "created_at": "2026-06-02 14:03:10",
    "flow_data": { "nodes": [], "edges": [] }
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/automations/{id}</code>
      <span class="endpoint-name">Update automation flow</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates a flow. When <code>flow_data</code> is sent, the controller scans the canvas for a node of type <code>trigger</code> and, if found, overwrites <code>trigger_type</code> with that node's configured trigger — keeping the stored trigger in sync with what the canvas actually shows.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
            <tr><td>trigger_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>Overridden automatically if a trigger node is present in <code>flow_data</code>.</td></tr>
            <tr><td>flow_data<span class="param-required">opt</span></td><td class="param-type">array</td><td>Full replacement canvas JSON.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Toggle whether the flow runs on its trigger.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "name": "Low stock alert",
    "description": "Notify me when a product drops below reorder level",
    "trigger_type": "stock.updated",
    "is_active": true,
    "run_count": 34,
    "last_run_at": "2026-07-30 09:12:41",
    "updated_at": "2026-07-31 10:05:00",
    "created_at": "2026-06-02 14:03:10",
    "flow_data": { "nodes": [], "edges": [] }
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/automations/{id}</code>
      <span class="endpoint-name">Delete automation flow</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes the flow if it belongs to the resolved business. Returns a success message regardless of whether a matching row existed (the delete query silently affects zero rows).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Automation deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-runs">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/automations/{id}/runs</code>
      <span class="endpoint-name">List flow run history</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns up to the 50 most recent execution runs for a flow, newest first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 501,
      "status": "success",
      "error": null,
      "result": { "notified": 1 },
      "trigger_payload": { "event": "stock.updated" },
      "created_at": "2026-07-30 09:12:41"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-trigger">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/automations/{id}/trigger</code>
      <span class="endpoint-name">Manually trigger a flow</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Dispatches the flow immediately via <code>AutomationRunnerService</code>. Only works for flows whose <code>trigger_type</code> is already <code>manual</code> (set by placing a manual trigger node in the canvas) — otherwise it returns a 422 without dispatching.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>payload<span class="param-required">opt</span></td><td class="param-type">array</td><td>Arbitrary data forwarded into the run's trigger context; defaults to <code>[]</code>.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Flow triggered." }</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "This flow does not use a manual trigger." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-notifications">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/automation-notifications</code>
      <span class="endpoint-name">List automation notifications</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns up to the 100 most recent in-app notifications raised by automation flows for the resolved business, plus a running unread count.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 88,
      "flow_id": 12,
      "title": "Low stock alert",
      "message": "Blue T-Shirt dropped below reorder level (3 left).",
      "read": false,
      "created_at": "2026-07-30 09:12:41"
    }
  ],
  "unread": 4
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-automation-editor-notifications-read-all">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/automation-notifications/read-all</code>
      <span class="endpoint-name">Mark all notifications read</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sets <code>read_at</code> to now on every unread notification for the resolved business. No request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Notifications marked as read." }</code></pre>
      </div>
@endverbatim
