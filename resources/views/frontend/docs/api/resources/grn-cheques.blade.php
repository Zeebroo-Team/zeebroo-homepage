@verbatim
  <div class="endpoint" id="ep-grn-cheques-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/cheques</code>
      <span class="endpoint-name">List cheque payments</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists cheque payments for the current business with a status summary. Cheque status is computed as <code>cleared</code>, <code>pending</code>, <code>due</code>, or <code>overdue</code> based on the due date.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>filter<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>all</code> (default), <code>pending</code>, or <code>cleared</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 9,
      "cheque_number": "CHQ-000452",
      "due_date": "2026-08-10",
      "amount": 50000.00,
      "status": "due",
      "status_label": "Due",
      "cleared_at": null,
      "paid_at": null,
      "grn_id": 30,
      "grn_number": "GRN-0030",
      "purchase_id": 41,
      "po_number": "PO-0041",
      "supplier_name": "Ceylon Wholesale Traders",
      "account": null
    }
  ],
  "summary": {
    "pending": 3,
    "overdue": 1,
    "cleared": 12,
    "pending_amount": 210000.00
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-grn-cheques-clear">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/cheques/{cheque}/clear</code>
      <span class="endpoint-name">Clear a cheque</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Marks a cheque as cleared and, if <code>deduct_account_id</code> is provided, debits that account. Fails with 422 if the cheque is already cleared.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Account to debit when clearing.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Cheque cleared.",
  "data": {
    "id": 9,
    "cheque_number": "CHQ-000452",
    "due_date": "2026-08-10",
    "amount": 50000.00,
    "status": "cleared",
    "status_label": "Cleared",
    "cleared_at": "2026-07-31",
    "paid_at": "2026-07-31",
    "grn_id": 30,
    "grn_number": "GRN-0030",
    "purchase_id": 41,
    "po_number": "PO-0041",
    "supplier_name": "Ceylon Wholesale Traders",
    "account": "Main Account · BOC"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This cheque is already cleared."
}</code></pre>
      </div>
@endverbatim
