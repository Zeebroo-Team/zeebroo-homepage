@verbatim
  <div class="endpoint" id="ep-account-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/accounts</code>
      <span class="endpoint-name">List accounts</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every account owned by the authenticated user (across all their businesses), newest first, with bank type, business, bank, and warehouse/branch relations eager-loaded. Only returns JSON when the request expects it (<code>Accept: application/json</code>); otherwise renders the <code>account::index</code> Blade view.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Owned-by-user scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 4,
      "user_id": 1,
      "business_id": 2,
      "branch_id": null,
      "account_name": "Main operating account",
      "bank_type_id": 1,
      "category": "operating",
      "bank_id": 3,
      "bank_account_number": "0012345678",
      "branch": "Colombo Fort",
      "current_balance": "150000.00",
      "bank_officer_contact": null,
      "notes": null,
      "bank_type": { "id": 1, "name": "Current Account", "slug": "current-account" },
      "business": { "id": 2, "name": "Acme Retail" },
      "bank": { "id": 3, "name": "Commercial Bank" },
      "warehouse": null
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-account-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/accounts</code>
      <span class="endpoint-name">Create account</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new account for a business the authenticated user owns. <code>branch_id</code> is silently forced to <code>null</code> unless the target business has multi-warehouse/branch mode enabled.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Owned-by-user scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>business_id</td><td class="param-type">integer</td><td>Must be a business owned by the authenticated user.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Warehouse/branch, only used when the business has multi-warehouse mode on.</td></tr>
            <tr><td>account_name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>bank_type_id</td><td class="param-type">integer</td><td>Must exist in <code>bank_types</code>.</td></tr>
            <tr><td>category<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>operating</code>, <code>savings</code>, <code>petty_cash</code>, <code>credit_card</code>, <code>payroll</code>, <code>investment</code>, <code>loan</code>.</td></tr>
            <tr><td>bank_id</td><td class="param-type">integer</td><td>Must exist in <code>banks</code>.</td></tr>
            <tr><td>bank_account_number</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>branch</td><td class="param-type">string</td><td>Bank branch name (free text — distinct from <code>branch_id</code>, the business warehouse).</td></tr>
            <tr><td>current_balance</td><td class="param-type">numeric</td><td>Min 0.</td></tr>
            <tr><td>bank_officer_contact<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Account created.",
  "data": {
    "id": 9,
    "account_name": "Payroll account",
    "current_balance": "0.00",
    "bank_type": { "id": 1, "name": "Current Account" },
    "business": { "id": 2, "name": "Acme Retail" },
    "bank": { "id": 3, "name": "Commercial Bank" }
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The account name field is required.",
  "errors": { "account_name": ["The account name field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-account-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/accounts/{account}</code>
      <span class="endpoint-name">Get account</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single account owned by the authenticated user, 404 if it belongs to someone else. Relations (<code>bankType</code>, <code>business</code>, <code>bank</code>, <code>warehouse</code>) are eager-loaded.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Owned-by-user scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 4,
    "account_name": "Main operating account",
    "current_balance": "150000.00",
    "bank_type": { "id": 1, "name": "Current Account" },
    "business": { "id": 2, "name": "Acme Retail" },
    "bank": { "id": 3, "name": "Commercial Bank" },
    "warehouse": null
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-account-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span><span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/accounts/{account}</code>
      <span class="endpoint-name">Update account</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates an account owned by the authenticated user. Note that unlike <code>store</code>, this validation set does not accept a <code>category</code> field — the account's category cannot be changed via this endpoint.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Owned-by-user scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>business_id</td><td class="param-type">integer</td><td>Must be a business owned by the authenticated user.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Only used when the business has multi-warehouse mode on.</td></tr>
            <tr><td>account_name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>bank_type_id</td><td class="param-type">integer</td><td>Must exist in <code>bank_types</code>.</td></tr>
            <tr><td>bank_id</td><td class="param-type">integer</td><td>Must exist in <code>banks</code>.</td></tr>
            <tr><td>bank_account_number</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>branch</td><td class="param-type">string</td><td>Bank branch name.</td></tr>
            <tr><td>current_balance</td><td class="param-type">numeric</td><td>Min 0.</td></tr>
            <tr><td>bank_officer_contact<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Account updated.",
  "data": {
    "id": 4,
    "account_name": "Main operating account (renamed)",
    "bank_type": { "id": 1, "name": "Current Account" },
    "business": { "id": 2, "name": "Acme Retail" },
    "bank": { "id": 3, "name": "Commercial Bank" }
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The bank account number field is required.",
  "errors": { "bank_account_number": ["The bank account number field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-account-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/accounts/{account}</code>
      <span class="endpoint-name">Delete account</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes an account owned by the authenticated user (hard delete — the model has no soft-delete trait).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Owned-by-user scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Account deleted." }</code></pre>
      </div>
@endverbatim
