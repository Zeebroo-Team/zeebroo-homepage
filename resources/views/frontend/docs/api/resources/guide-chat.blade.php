@verbatim
  <div class="endpoint" id="ep-guide-chat-chat">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/guide/chat</code>
      <span class="endpoint-name">Guide chat</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Two-pass Gemini-backed assistant (models <code>gemini-2.5-flash</code> → <code>gemini-2.0-flash</code> → <code>gemini-1.5-flash</code>). Pass 1 classifies the user's message into a short reply plus either a UI <code>walkthrough</code> id (e.g. <code>add_product</code>, <code>pos_checkout</code>, <code>hr_new_payroll</code> — dozens of predefined in-app tour steps across POS, Inventory, Finance, HR, Restaurant, Services, and Mail) or a <code>dataQuery</code> id. When a <code>dataQuery</code> is returned, pass 2 fetches live business data server-side (<code>low_stock</code>, <code>out_of_stock</code>, <code>today_sales</code>, <code>recent_sales</code>, <code>expenses_summary</code>, <code>overdue_bills</code>, <code>top_products</code>) and asks Gemini to summarize it as a small HTML snippet (falling back to a PHP-formatted summary if Gemini is unavailable); the response then sets <code>isHtml: true</code> and the <code>reply</code> contains that HTML.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>message</td><td class="param-type">string</td><td>Max 500 characters.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "reply": "Sure — let me show you how to add a product!",
  "walkthrough": "add_product",
  "productName": null,
  "fieldName": null
}</code></pre>
        <p class="endpoint-desc">Data-query variant (e.g. asking "what's low on stock?"):</p>
        <pre class="code-block"><code>{
  "reply": "&lt;b&gt;Low Stock Alert — 3 product(s)&lt;/b&gt;&lt;br&gt;• Blue T-Shirt (TS-BLU-001) — &lt;b&gt;2&lt;/b&gt; left",
  "walkthrough": null,
  "isHtml": true
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The message field is required.",
  "errors": { "message": ["The message field is required."] }
}</code></pre>
      </div>
@endverbatim
