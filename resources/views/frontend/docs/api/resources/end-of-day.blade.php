@verbatim
  <div class="endpoint" id="ep-end-of-day-status">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/eod</code>
      <span class="endpoint-name">EOD status</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns completed cash/card sales that have not yet been settled to a bank account, a totals-by-method summary, and the last 7 days of settlement history.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "currency": "LKR",
  "unsettled": [
    {
      "id": 901,
      "sale_number": "SL-000901",
      "payment_method": "cash",
      "total": 12500.00,
      "sold_at": "2026-07-31T10:20:00+05:30",
      "account_label": null
    }
  ],
  "summary": {
    "total_count": 1,
    "total_amount": 12500.00,
    "by_method": {
      "cash": { "count": 1, "total": 12500.00 },
      "card": { "count": 0, "total": 0.0 }
    }
  },
  "history": [
    { "date": "2026-07-30", "sale_count": 14, "total": 182500.00 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-end-of-day-settle">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/eod/settle</code>
      <span class="endpoint-name">Settle all unsettled sales</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Settles every unsettled cash/card sale that has a credit account assigned, crediting each sale's account and marking it settled. Sales without a <code>credit_account_id</code> are skipped. Fires an <code>eod.settled</code> automation event when at least one sale settles. Requires the <code>pos_eod</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: pos_eod</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "6 sales settled to bank.",
  "settled": 6,
  "errors": []
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Settlement failed.",
  "settled": 0,
  "errors": ["Sale SL-000902: The deduct account could not be found."]
}</code></pre>
      </div>
@endverbatim
