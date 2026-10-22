@verbatim
  <div class="endpoint" id="ep-stock-audits-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/stock-audits</code>
      <span class="endpoint-name">List stock audits</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated list of stock audits for the business, newest first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 12,
      "business_id": 1,
      "branch_id": null,
      "audit_number": "SA-0012",
      "audit_date": "2026-07-28",
      "status": "open",
      "notes": null,
      "finalized_at": null,
      "finalized_by": null,
      "created_by": 1,
      "created_at": "2026-07-28T09:00:00.000000Z",
      "updated_at": "2026-07-28T09:00:00.000000Z"
    }
  ],
  "meta": { "current_page": 1, "last_page": 1, "total": 12 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-stock-audits-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/stock-audits</code>
      <span class="endpoint-name">Create a stock audit</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Opens a new stock audit for the given date. The service snapshots each product's expected quantity onto audit lines at creation time. Requires the <code>inv_audit</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_audit</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>audit_date</td><td class="param-type">date</td><td>Date the physical count is taken.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 13,
    "business_id": 1,
    "audit_number": "SA-0013",
    "audit_date": "2026-07-31",
    "status": "open",
    "notes": null,
    "finalized_at": null,
    "created_by": 1,
    "lines": [
      {
        "id": 201,
        "stock_audit_id": 13,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "unit": "pcs",
        "expected_qty": "42.000",
        "counted_qty": null,
        "notes": null,
        "sort_order": 0
      }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The audit date field is required.",
  "errors": { "audit_date": ["The audit date field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-stock-audits-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/stock-audits/{stockAudit}</code>
      <span class="endpoint-name">Get stock audit detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a stock audit with its lines, each showing the expected quantity and, once counted, the counted quantity.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "audit_number": "SA-0012",
    "audit_date": "2026-07-28",
    "status": "open",
    "lines": [
      {
        "id": 190,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "unit": "pcs",
        "expected_qty": "42.000",
        "counted_qty": "40.000",
        "notes": null,
        "sort_order": 0
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-stock-audits-save-lines">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/stock-audits/{stockAudit}/lines</code>
      <span class="endpoint-name">Save counted quantities</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Bulk-saves counted quantities and per-line notes while an audit is still open. Requires the <code>inv_audit</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_audit</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>lines</td><td class="param-type">array</td><td>Array of counted lines, matched by array position to the audit's existing lines.</td></tr>
            <tr><td>lines[].counted_qty<span class="param-required">opt</span></td><td class="param-type">number</td><td>Physically counted quantity.</td></tr>
            <tr><td>lines[].notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "audit_number": "SA-0012",
    "status": "open",
    "lines": [
      { "id": 190, "product_name": "Blue T-Shirt", "expected_qty": "42.000", "counted_qty": "40.000", "notes": "2 damaged" }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The lines field is required.",
  "errors": { "lines": ["The lines field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-stock-audits-finalize">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/stock-audits/{stockAudit}/finalize</code>
      <span class="endpoint-name">Finalize audit and apply adjustments</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Locks the audit (<code>status</code> becomes <code>finalized</code>) and applies stock adjustments to bring each product's on-hand quantity in line with its counted quantity. Requires the <code>inv_audit</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_audit</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "audit_number": "SA-0012",
    "status": "finalized",
    "finalized_at": "2026-07-31T12:00:00.000000Z",
    "finalized_by": 1
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-stock-audits-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/stock-audits/{stockAudit}</code>
      <span class="endpoint-name">Delete a stock audit</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a stock audit and its lines. Requires the <code>inv_audit</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_audit</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Deleted."
}</code></pre>
      </div>
@endverbatim
