@verbatim
  <div class="endpoint" id="ep-user-management-me">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/me</code>
      <span class="endpoint-name">Current session permissions</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the effective role and permission set for the current authenticated session. Handles three cases: a POS cashier token (fixed <code>pos_session</code>/<code>pos_checkout</code> permissions), the business owner (always full access, <code>permissions: null</code>), or a business member (permissions resolved from their personal override, falling back to their role's defaults).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "role": "manager",
    "permissions": ["pos_session", "pos_checkout", "pos_returns"],
    "is_owner": false
  },
  "permissions": [
    {
      "key": "home",
      "label": "Home",
      "icon": "fa-house",
      "color": "#3b82f6",
      "items": [
        { "key": "home_btn_pos", "label": "Open POS", "desc": "Ribbon Quick Actions: Open POS register button" }
      ]
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-user-management-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/users</code>
      <span class="endpoint-name">List business users</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists everyone with access to the current business: the owner first (always full access), followed by invited business members with their role, permission overrides, and status. Also returns the full grouped permission catalog used to build permission-editing UI.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 0,
      "user_id": 1,
      "name": "Business Owner",
      "email": "owner@example.com",
      "role": "owner",
      "permissions": [],
      "status": "active",
      "is_owner": true,
      "joined_at": "2026-01-05T08:00:00+00:00"
    },
    {
      "id": 3,
      "user_id": 9,
      "name": "Jane Doe",
      "email": "jane@example.com",
      "role": "manager",
      "permissions": ["pos_session", "pos_checkout"],
      "status": "active",
      "is_owner": false,
      "joined_at": "2026-03-10T12:00:00+00:00"
    }
  ],
  "permissions": [ "...grouped permission catalog, see /me..." ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-user-management-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/users</code>
      <span class="endpoint-name">Add business user</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Adds an existing platform user (identified by email — they must already have an account) as a member of the current business with a role and optional permission overrides. If <code>permissions</code> is omitted, it's inherited from the role's default permission set. Fails with 404 if no account exists for that email, or 422 if it's the owner's own email or the user is already a member.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>email</td><td class="param-type">string</td><td>Must be a valid email of an existing platform user.</td></tr>
            <tr><td>role</td><td class="param-type">string</td><td>Must be one of this business's role slugs (system or custom).</td></tr>
            <tr><td>permissions<span class="param-required">opt</span></td><td class="param-type">array</td><td>List of permission keys. Omit to inherit the role's defaults.</td></tr>
            <tr><td>permissions.*<span class="param-required">opt</span></td><td class="param-type">string</td><td>Each item must be a valid permission key.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "user_id": 9,
    "name": "Jane Doe",
    "email": "jane@example.com",
    "role": "manager",
    "permissions": ["pos_session", "pos_checkout"],
    "status": "active",
    "is_owner": false,
    "joined_at": "2026-07-31T10:00:00+00:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This user is already a member of your business."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-user-management-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/users/{member}</code>
      <span class="endpoint-name">Update business user</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a business member's role and permissions. <code>{member}</code> is the BusinessMember record's own <code>id</code> (the <code>id</code> field from the list response) — not the platform <code>user_id</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>member</td><td class="param-type">integer</td><td>BusinessMember record ID.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>role</td><td class="param-type">string</td><td>Must be one of this business's role slugs.</td></tr>
            <tr><td>permissions<span class="param-required">opt</span></td><td class="param-type">array</td><td>List of permission keys; replaces any existing override (defaults to <code>[]</code> if omitted).</td></tr>
            <tr><td>permissions.*<span class="param-required">opt</span></td><td class="param-type">string</td><td>Each item must be a valid permission key.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "user_id": 9,
    "name": "Jane Doe",
    "email": "jane@example.com",
    "role": "staff",
    "permissions": ["pos_session", "pos_checkout"],
    "status": "active",
    "is_owner": false,
    "joined_at": "2026-03-10T12:00:00+00:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected role is invalid.",
  "errors": { "role": ["The selected role is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-user-management-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/users/{member}</code>
      <span class="endpoint-name">Remove business user</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Removes a member's access to the current business. <code>{member}</code> is the BusinessMember record ID. Does not delete the underlying platform user account.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "User removed from this business."
}</code></pre>
      </div>
@endverbatim
