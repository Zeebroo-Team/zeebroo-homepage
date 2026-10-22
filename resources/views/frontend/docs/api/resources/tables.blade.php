@verbatim
  <div class="endpoint" id="ep-tables-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/tables</code>
      <span class="endpoint-name">List tables</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns all tables for the current business, ordered by name. No filters or pagination.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 4, "name": "Table 4", "capacity": 4, "status": "available", "notes": null, "pos_x": 120, "pos_y": 60 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-tables-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/tables</code>
      <span class="endpoint-name">Create table</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a table with status forced to <code>available</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 100 chars.</td></tr>
            <tr><td>capacity</td><td class="param-type">integer</td><td>1–100.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 9, "name": "Table 9", "capacity": 6, "status": "available", "notes": null, "pos_x": null, "pos_y": null }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The capacity field is required.",
  "errors": { "capacity": ["The capacity field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-tables-positions">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/tables/positions</code>
      <span class="endpoint-name">Save table floor-plan positions</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Bulk-updates <code>pos_x</code>/<code>pos_y</code> for a set of tables, scoped to the current business — used by the drag-and-drop floor plan editor to persist layout changes in one call.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>positions</td><td class="param-type">array</td><td>One entry per table to reposition.</td></tr>
            <tr><td>positions[].id</td><td class="param-type">integer</td><td>Table id.</td></tr>
            <tr><td>positions[].x</td><td class="param-type">integer</td><td>0–9000.</td></tr>
            <tr><td>positions[].y</td><td class="param-type">integer</td><td>0–9000.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-tables-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/tables/{restaurantTable}</code>
      <span class="endpoint-name">Update table</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a table's name, capacity, status, and notes. Note this is also how status is set directly (independent of order-driven status changes).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 100 chars.</td></tr>
            <tr><td>capacity</td><td class="param-type">integer</td><td>1–100.</td></tr>
            <tr><td>status</td><td class="param-type">string</td><td>One of <code>available</code>, <code>occupied</code>, <code>reserved</code>, <code>inactive</code>.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 4, "name": "Table 4", "capacity": 4, "status": "reserved", "notes": null, "pos_x": 120, "pos_y": 60 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-tables-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/tables/{restaurantTable}</code>
      <span class="endpoint-name">Delete table</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a table.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
@endverbatim
