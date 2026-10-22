@verbatim
  <div class="endpoint" id="ep-expense-modifications-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/modifications</code>
      <span class="endpoint-name">List expense modifications</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists modification projects for the business with each one's linked bill count and a resolved property display name where the assignment type is <code>property</code>. Returns an empty list if the <code>modifications</code> table doesn't exist yet.</p>
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
      "name": "Store front repaint",
      "assignment_type": "property",
      "assignment_reference": "5",
      "assignment_display": "Colombo Warehouse · Warehouse",
      "property_work_type": "exterior_painting",
      "work_type_label": "Exterior painting",
      "estimated_cost": 250000.00,
      "estimated_cost_fmt": "250,000.00",
      "duration": "2 weeks",
      "description": null,
      "bills_count": 3,
      "created_at": "2026-06-14"
    }
  ],
  "total_count": 1,
  "total_cost_fmt": "250,000.00"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-expense-modifications-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/expenses/modifications</code>
      <span class="endpoint-name">Create an expense modification</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a renovation/property-modification record that expense bills can later be assigned to. Validation of <code>assignment_reference</code> and <code>property_work_type</code> varies by <code>assignment_type</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>assignment_type</td><td class="param-type">string</td><td><code>renovation</code>, <code>property</code>, or <code>other</code>.</td></tr>
            <tr><td>assignment_reference<span class="param-required">opt</span></td><td class="param-type">integer|string</td><td>Property id when type is <code>property</code>; free text when <code>renovation</code>; optional free text when <code>other</code>.</td></tr>
            <tr><td>property_work_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>Required when type is <code>property</code> — one of the modification module's work-type keys.</td></tr>
            <tr><td>property_work_type_other<span class="param-required">opt</span></td><td class="param-type">string</td><td>Required when <code>property_work_type</code> is <code>other</code>.</td></tr>
            <tr><td>estimated_cost</td><td class="param-type">number</td><td>Estimated total project cost.</td></tr>
            <tr><td>duration<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 chars, e.g. "2 weeks".</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Modification created.",
  "data": {
    "id": 3,
    "name": "Back office rewiring",
    "assignment_type": "renovation",
    "assignment_reference": "Back office",
    "assignment_display": "Back office",
    "property_work_type": null,
    "work_type_label": null,
    "estimated_cost": 90000.00,
    "estimated_cost_fmt": "90,000.00",
    "duration": "1 week",
    "description": null,
    "bills_count": 0,
    "created_at": "2026-07-31"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The estimated cost field is required.",
  "errors": { "estimated_cost": ["The estimated cost field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-expense-modifications-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/modifications/{modification}</code>
      <span class="endpoint-name">Get modification detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns modification detail with the list of expense bills currently linked to it. 404s if the modification does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 2,
    "name": "Store front repaint",
    "assignment_type": "property",
    "assignment_display": "Colombo Warehouse · Warehouse",
    "estimated_cost": 250000.00,
    "estimated_cost_fmt": "250,000.00",
    "duration": "2 weeks",
    "description": null,
    "bills_count": 1,
    "created_at": "2026-06-14",
    "bills": [
      {
        "id": 80,
        "name": "Paint contractor invoice",
        "category_label": "Other (specify)",
        "payment_mode_label": "One-time payment",
        "recurring_cost_fmt": "120,000.00",
        "due_date": "2026-07-01",
        "description": null
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-expense-modifications-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/expenses/modifications/{modification}</code>
      <span class="endpoint-name">Delete a modification</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a modification record. Does not delete bills that were assigned to it.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Modification deleted."
}</code></pre>
      </div>
@endverbatim
