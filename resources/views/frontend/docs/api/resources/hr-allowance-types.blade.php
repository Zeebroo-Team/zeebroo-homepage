@verbatim
  <div class="endpoint" id="ep-hr-allowance-types-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/allowance-types</code>
      <span class="endpoint-name">List allowance types</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists allowance types for the business, ordered by sort_order, each with a count of employees currently assigned that allowance. Returns an empty list if the hr_allowance_types table is not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 1, "name": "Transport Allowance", "sort_order": 0, "employees_count": 6 },
    { "id": 2, "name": "Meal Allowance", "sort_order": 1, "employees_count": 4 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-hr-allowance-types-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/allowance-types</code>
      <span class="endpoint-name">Create an allowance type</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new allowance type for the business via AllowanceTypeService. The name must be unique within the business. Fails with a 422 if the HR tables are not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Allowance type name, max 255 chars, unique per business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 3, "name": "Fuel Allowance", "sort_order": 2, "employees_count": 0 }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name has already been taken.",
  "errors": { "name": ["The name has already been taken."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-hr-allowance-types-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/hr/allowance-types/{allowanceType}</code>
      <span class="endpoint-name">Delete an allowance type</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes an allowance type. Returns 404 if it does not belong to the current business, and 422 if it is still assigned to one or more employees.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Allowance type deleted." }</code></pre>
      </div>
@endverbatim
