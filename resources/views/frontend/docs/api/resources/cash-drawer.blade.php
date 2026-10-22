@verbatim
  <div class="endpoint" id="ep-cash-drawer-status">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/cash-drawer</code>
      <span class="endpoint-name">Today's drawer status</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns today's cash drawer status: whether it has been opened, the opening float, total completed cash sales for the day, total withdrawals, and the computed running balance (opening float + cash sales − withdrawals). <code>balance</code> is <code>null</code> until the drawer is opened.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "date": "2026-07-31",
    "is_opened": true,
    "opening_float": 5000.00,
    "cash_sales": 12500.50,
    "total_withdrawals": 2000.00,
    "balance": 15500.50,
    "withdrawals": [
      {
        "id": 7,
        "amount": 2000.00,
        "note": "Bank deposit run",
        "time": "2026-07-31T11:15:00+00:00"
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-cash-drawer-open">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/cash-drawer/open</code>
      <span class="endpoint-name">Set opening float</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Records today's opening cash float for the business, or overwrites it if already set for today. Requires the <code>pos_session</code> permission for non-owner business members; the business owner always passes.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires <code>pos_session</code> permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>opening_float</td><td class="param-type">number</td><td>Min 0, max 9,999,999.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Opening cash recorded.",
  "data": {
    "date": "2026-07-31",
    "is_opened": true,
    "opening_float": 5000.00,
    "cash_sales": 0,
    "total_withdrawals": 0,
    "balance": 5000.00,
    "withdrawals": []
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The opening float field is required.",
  "errors": { "opening_float": ["The opening float field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-cash-drawer-withdraw">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/cash-drawer/withdraw</code>
      <span class="endpoint-name">Log withdrawal</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Logs a cash withdrawal from the drawer (e.g. a bank deposit run) against today's register date, and fires an <code>eod.withdraw</code> automation event afterward (dispatch failures are silently swallowed). Requires the <code>pos_session</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires <code>pos_session</code> permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>amount</td><td class="param-type">number</td><td>Min 0.01, max 9,999,999.</td></tr>
            <tr><td>note<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Withdrawal recorded.",
  "data": {
    "date": "2026-07-31",
    "is_opened": true,
    "opening_float": 5000.00,
    "cash_sales": 12500.50,
    "total_withdrawals": 2000.00,
    "balance": 15500.50,
    "withdrawals": [
      {
        "id": 7,
        "amount": 2000.00,
        "note": "Bank deposit run",
        "time": "2026-07-31T11:15:00+00:00"
      }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The amount field is required.",
  "errors": { "amount": ["The amount field is required."] }
}</code></pre>
      </div>
@endverbatim
