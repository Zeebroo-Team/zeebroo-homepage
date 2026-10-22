@verbatim
  <div class="endpoint" id="ep-expense-rental-list-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/rentals</code>
      <span class="endpoint-name">List rentals for bill assignment</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a minimal id/name/amount list of the business's rental agreements, sorted by property type. Returns an empty list if the <code>rentals</code> table doesn't exist yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 1, "name": "Shop space · Retail unit", "amount": 85000.00 }
  ]
}</code></pre>
      </div>
@endverbatim
