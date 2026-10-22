@verbatim
  <div class="endpoint" id="ep-bank-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/banks</code>
      <span class="endpoint-name">List all banks</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the platform-wide list of banks (not business-scoped data — banks are a shared lookup table), sorted alphabetically. A business must still be resolvable for the request to succeed.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 2, "name": "Bank of Ceylon", "code": "BOC" },
    { "id": 5, "name": "Commercial Bank", "code": "COMB" }
  ]
}</code></pre>
      </div>
@endverbatim
