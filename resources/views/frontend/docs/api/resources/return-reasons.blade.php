@verbatim
  <div class="endpoint" id="ep-return-reasons-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/return-reasons</code>
      <span class="endpoint-name">List return reason options</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the fixed list of return-reason key/label pairs defined on the <code>SaleReturn</code> model. Not paginated, not business-scoped.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "key": "low_quality", "label": "Low quality products" },
    { "key": "expired", "label": "Date expired" },
    { "key": "requirement_mismatch", "label": "Customer requirement not match" },
    { "key": "wrong_item", "label": "Wrong item delivered" },
    { "key": "damaged", "label": "Damaged / defective" },
    { "key": "changed_mind", "label": "Changed mind" },
    { "key": "overstock", "label": "Overstock / excess quantity" },
    { "key": "other", "label": "Other" }
  ]
}</code></pre>
      </div>
@endverbatim
