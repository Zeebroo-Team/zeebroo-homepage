@verbatim
  <div class="endpoint" id="ep-pos-accounts-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/accounts</code>
      <span class="endpoint-name">List deposit accounts</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists deposit accounts for the current business, ordered by account name.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 3,
      "account_name": "Main Operating Account",
      "bank_name": "Commercial Bank",
      "current_balance": 458200.75
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-accounts-bank-types">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/bank-types</code>
      <span class="endpoint-name">List bank types</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists the global bank/account type options (e.g. Bank, Cash, Mobile Wallet) used to populate the <code>bank_type_id</code> field on the account creation form. The catalog itself is global, not business-specific, though a valid business context is still required to call the endpoint.</p>
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
      "name": "Bank",
      "slug": "bank",
      "description": "Standard bank account"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-pos-accounts-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/accounts</code>
      <span class="endpoint-name">Create deposit account</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new deposit account for the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>account_name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>category</td><td class="param-type">string</td><td>One of <code>operating</code>, <code>savings</code>, <code>petty_cash</code>, <code>credit_card</code>, <code>payroll</code>, <code>investment</code>, <code>loan</code>.</td></tr>
            <tr><td>bank_type_id</td><td class="param-type">integer</td><td>Must exist in <code>bank_types</code>.</td></tr>
            <tr><td>bank_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must exist in <code>banks</code> if supplied.</td></tr>
            <tr><td>bank_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>bank_account_number<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>branch<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>current_balance</td><td class="param-type">number</td><td>Min 0.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "account_name": "Petty Cash",
    "current_balance": 5000.00
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected category is invalid.",
  "errors": { "category": ["The selected category is invalid."] }
}</code></pre>
      </div>
@endverbatim
