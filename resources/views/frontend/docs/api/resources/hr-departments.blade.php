@verbatim
  <div class="endpoint" id="ep-hr-departments-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/departments</code>
      <span class="endpoint-name">List departments</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists HR departments for the business, alphabetically, each with its employee count and configured salary range. Returns an empty list if the HR module's tables are not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 2,
      "name": "Operations",
      "employees_count": 8,
      "salary_range_min": "60,000.00",
      "salary_range_max": "150,000.00"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-hr-departments-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/departments</code>
      <span class="endpoint-name">Create a department</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new HR department for the business via DepartmentService. The name must be unique within the business. Fails with a 422 if the HR tables are not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Department name, max 255 chars, unique per business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "name": "Marketing",
    "employees_count": 0,
    "salary_range_min": null,
    "salary_range_max": null
  }
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

  <div class="endpoint" id="ep-hr-departments-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/hr/departments/{department}</code>
      <span class="endpoint-name">Delete a department</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a department. Returns 404 if it does not belong to the current business, and 422 if it still has employees assigned to it.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Department deleted." }</code></pre>
      </div>
@endverbatim
