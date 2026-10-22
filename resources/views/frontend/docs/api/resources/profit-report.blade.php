@verbatim
  <div class="endpoint" id="ep-profit-report-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/profit-report</code>
      <span class="endpoint-name">Get profit report</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Computes revenue, COGS, gross/net profit, and returns totals for the selected period, a bucketed trend for charting, and the top 10 products by gross profit. COGS is derived from completed sale items' <code>unit_cost × quantity</code>; expenses are ledger transactions against bills and rentals in the window.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>period<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Number of trailing days: <code>7</code>, <code>30</code> (default), <code>90</code>, or <code>365</code>. Any other value falls back to 30. 7-day periods bucket by day, 30/90-day by week, 365-day by month.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "period": 30,
    "summary": {
      "revenue": 1250000.00,
      "cogs": 780000.00,
      "gross_profit": 470000.00,
      "gross_margin": 37.6,
      "net_profit": 355000.00,
      "returns": 12500.00,
      "expenses": 115000.00
    },
    "trend": {
      "labels": ["Jul 1", "Jul 8", "Jul 15", "Jul 22", "Jul 29"],
      "revenue": [280000.00, 310000.00, 295000.00, 200000.00, 165000.00],
      "gross_profit": [105000.00, 118000.00, 112000.00, 76000.00, 59000.00],
      "expenses": [23000.00, 23000.00, 23000.00, 23000.00, 23000.00]
    },
    "top_products": [
      {
        "name": "Blue T-Shirt",
        "revenue": 216000.00,
        "cogs": 144000.00,
        "gp": 72000.00,
        "margin": 33.3,
        "qty": 120
      }
    ]
  }
}</code></pre>
      </div>
@endverbatim
