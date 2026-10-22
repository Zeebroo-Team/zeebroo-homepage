@verbatim
  <div class="endpoint" id="ep-sales-chart-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/products/{id}/sales-chart</code>
      <span class="endpoint-name">Product sales chart data</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sums <code>quantity</code> from completed sales for the product, bucketed by day/week/month depending on <code>period</code>. Buckets are database-driver-aware (MySQL vs SQLite date functions) and always cover a fixed trailing window: 30 buckets for daily, 12 for weekly, 12 for monthly.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>period<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>daily</code>, <code>weekly</code>, <code>monthly</code>. Defaults to <code>weekly</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "period": "weekly",
    "subtitle": "Last 12 weeks",
    "total": 214,
    "labels": ["May 4 – May 10", "May 11 – May 17"],
    "series": [18, 26]
  }
}</code></pre>
      </div>
@endverbatim
