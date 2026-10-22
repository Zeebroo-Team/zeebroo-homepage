@verbatim
  <div class="endpoint" id="ep-sale-returns-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/sales/{sale}/return</code>
      <span class="endpoint-name">Process a sale return / refund</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a sale-return record for the given sale covering one or more sale items and quantities, and applies the refund via the chosen method. Requires the <code>pos_returns</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_returns permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>items</td><td class="param-type">array</td><td>At least one item to return.</td></tr>
            <tr><td>items[].sale_item_id</td><td class="param-type">integer</td><td>The sale line item being returned.</td></tr>
            <tr><td>items[].quantity</td><td class="param-type">number</td><td>Quantity to return, minimum 0.001.</td></tr>
            <tr><td>refund_method</td><td class="param-type">string</td><td>One of <code>cash</code>, <code>card</code>, <code>credit</code>.</td></tr>
            <tr><td>credit_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Customer credit account to refund into, when <code>refund_method</code> is <code>credit</code>.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Internal note, max 1000 characters.</td></tr>
            <tr><td>refund_reason<span class="param-required">opt</span></td><td class="param-type">string</td><td>Reason key/label for the return, max 500 characters. See the Return Reasons endpoint for valid keys.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Return processed successfully.",
  "data": {
    "return_number": "RT-0007",
    "total": 900.00,
    "sale": {
      "id": 1042,
      "sale_number": "SL-1042",
      "status": "completed",
      "total": 4500.00
    }
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Could not process return.",
  "errors": { "items.0.quantity": ["The quantity exceeds the remaining returnable amount."] }
}</code></pre>
      </div>
@endverbatim
