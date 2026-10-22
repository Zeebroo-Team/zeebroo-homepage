@verbatim
  <div class="endpoint" id="ep-role-management-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/roles</code>
      <span class="endpoint-name">List roles</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists all roles for the business — system roles first, then custom roles by sort order and name — each annotated with a live count of members currently on that role. Seeds the built-in admin/manager/staff roles on first access if they don't exist yet.</p>
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
      "name": "Admin",
      "slug": "admin",
      "color": "#0ea5e9",
      "description": "Full access to all modules.",
      "permissions": null,
      "is_system": true,
      "sort_order": 1,
      "member_count": 1
    },
    {
      "id": 4,
      "name": "Cashier Lead",
      "slug": "cashier_lead",
      "color": "#64748b",
      "description": "Custom role for senior cashiers.",
      "permissions": ["pos_session", "pos_checkout"],
      "is_system": false,
      "sort_order": 99,
      "member_count": 2
    }
  ],
  "permissions": [ "...grouped permission catalog, see User Management → /me..." ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-role-management-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/roles</code>
      <span class="endpoint-name">Create role</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a custom role. The slug is auto-generated from the name (underscored) and de-duplicated within the business by appending a numeric suffix if it already exists.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 80 characters.</td></tr>
            <tr><td>color<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 20 characters (hex color). Defaults to <code>#64748b</code>.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>permissions<span class="param-required">opt</span></td><td class="param-type">array</td><td>List of permission keys. Defaults to <code>[]</code> (no access) if omitted.</td></tr>
            <tr><td>permissions.*<span class="param-required">opt</span></td><td class="param-type">string</td><td>Each item must be a valid permission key.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "name": "Cashier Lead",
    "slug": "cashier_lead",
    "color": "#64748b",
    "description": "Custom role for senior cashiers.",
    "permissions": ["pos_session", "pos_checkout"],
    "is_system": false,
    "sort_order": 99,
    "member_count": 0
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

  <div class="endpoint" id="ep-role-management-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/roles/{role}</code>
      <span class="endpoint-name">Update role</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a role's color, description, and permissions. System roles (admin/manager/staff) cannot be renamed — the <code>name</code> field is silently ignored for them — but their color, description, and permissions can still be changed. <code>{role}</code> is the numeric BusinessRole ID.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>role</td><td class="param-type">integer</td><td>BusinessRole ID.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 80 characters. Required for custom roles; rejected/ignored for system roles.</td></tr>
            <tr><td>color<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 20 characters.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>permissions<span class="param-required">opt</span></td><td class="param-type">array</td><td>List of permission keys.</td></tr>
            <tr><td>permissions.*<span class="param-required">opt</span></td><td class="param-type">string</td><td>Each item must be a valid permission key.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "name": "Cashier Lead",
    "slug": "cashier_lead",
    "color": "#f59e0b",
    "description": "Senior cashiers with return approval rights.",
    "permissions": ["pos_session", "pos_checkout", "pos_returns"],
    "is_system": false,
    "sort_order": 99,
    "member_count": 2
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

  <div class="endpoint" id="ep-role-management-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/roles/{role}</code>
      <span class="endpoint-name">Delete role</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a custom role and reassigns any members currently on that role to <code>staff</code>. System roles (admin/manager/staff) cannot be deleted.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Role deleted."
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "System roles cannot be deleted."
}</code></pre>
      </div>
@endverbatim
