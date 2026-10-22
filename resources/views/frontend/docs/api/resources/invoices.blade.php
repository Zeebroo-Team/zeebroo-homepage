@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-invoices-list"><span class="method-badge method-get">GET</span> /invoices</a>
    <a href="#ep-invoices-store"><span class="method-badge method-post">POST</span> /invoices</a>
    <a href="#ep-invoices-show"><span class="method-badge method-get">GET</span> /invoices/{invoice}</a>
    <a href="#ep-invoices-update"><span class="method-badge method-patch">PATCH</span> /invoices/{invoice}</a>
    <a href="#ep-invoices-destroy"><span class="method-badge method-delete">DELETE</span> /invoices/{invoice}</a>
    <a href="#ep-invoices-mark-sent"><span class="method-badge method-post">POST</span> /invoices/{invoice}/mark-sent</a>
    <a href="#ep-invoices-mark-paid"><span class="method-badge method-post">POST</span> /invoices/{invoice}/mark-paid</a>
    <a href="#ep-invoices-mark-overdue"><span class="method-badge method-post">POST</span> /invoices/{invoice}/mark-overdue</a>
    <a href="#ep-invoices-cancel"><span class="method-badge method-post">POST</span> /invoices/{invoice}/cancel</a>
  </div>

  <div class="endpoint" id="ep-invoices-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/invoices</code>
      <span class="endpoint-name">List invoices</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">List of invoices for the current business, optionally filtered by search term, status, or customer.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search term.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>draft</code>, <code>sent</code>, <code>paid</code>, <code>overdue</code>, <code>cancelled</code>. Defaults to <code>all</code>.</td></tr>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Restrict to a single customer.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 22,
      "invoice_number": "INV-0022",
      "status": "sent",
      "status_label": "Sent",
      "status_color": "blue",
      "customer_name": "Nimal Perera",
      "reference": "PO-8831",
      "issue_date": "2026-07-25",
      "due_date": "2026-08-08",
      "is_overdue": false,
      "total": 18000.00,
      "proposal_count": 0
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/invoices</code>
      <span class="endpoint-name">Create an invoice</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates an invoice with one or more line items, starting in <code>draft</code> status. Requires the <code>pos_checkout</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_checkout permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to a customer on this business.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>issue_date</td><td class="param-type">date</td><td>Invoice issue date.</td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Payment due date.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 characters.</td></tr>
            <tr><td>discount_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Header-level discount.</td></tr>
            <tr><td>tax_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Header-level tax.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>At least one line item.</td></tr>
            <tr><td>items[].item_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>product</code>, <code>service</code>, <code>custom</code>.</td></tr>
            <tr><td>items[].product_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>item_type</code> is <code>product</code>.</td></tr>
            <tr><td>items[].service_item_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>item_type</code> is <code>service</code>.</td></tr>
            <tr><td>items[].description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters; used for <code>custom</code> lines.</td></tr>
            <tr><td>items[].quantity</td><td class="param-type">number</td><td>Minimum 0.001.</td></tr>
            <tr><td>items[].unit_price</td><td class="param-type">number</td><td>Minimum 0.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Invoice INV-0023 created.",
  "data": {
    "id": 23,
    "invoice_number": "INV-0023",
    "status": "draft",
    "status_label": "Draft",
    "status_color": "gray",
    "customer_name": "Nimal Perera",
    "reference": "PO-8831",
    "issue_date": "2026-07-31",
    "due_date": "2026-08-14",
    "is_overdue": false,
    "total": 18000.00,
    "proposal_count": 0,
    "subtotal": 17500.00,
    "discount_amount": 0,
    "tax_amount": 500.00,
    "notes": null,
    "customer_id": 4,
    "is_editable": true,
    "items": [
      {
        "id": 61,
        "product_id": 88,
        "item_type": "product",
        "description": null,
        "quantity": 7,
        "unit_price": 2500.00,
        "line_total": 17500.00
      }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The issue date field is required.",
  "errors": { "issue_date": ["The issue date field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}</code>
      <span class="endpoint-name">Get invoice detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Full invoice detail including all line items. 404s if the invoice does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 22,
    "invoice_number": "INV-0022",
    "status": "sent",
    "status_label": "Sent",
    "status_color": "blue",
    "customer_name": "Nimal Perera",
    "reference": "PO-8831",
    "issue_date": "2026-07-25",
    "due_date": "2026-08-08",
    "is_overdue": false,
    "total": 18000.00,
    "proposal_count": 0,
    "subtotal": 17500.00,
    "discount_amount": 0,
    "tax_amount": 500.00,
    "notes": null,
    "customer_id": 4,
    "is_editable": false,
    "items": [
      {
        "id": 60,
        "product_id": 88,
        "item_type": "product",
        "description": null,
        "quantity": 7,
        "unit_price": 2500.00,
        "line_total": 17500.00
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}</code>
      <span class="endpoint-name">Update an invoice</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the invoice header and line items. Only allowed while the invoice is editable (i.e. still <code>draft</code>). Requires the <code>pos_checkout</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_checkout permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to a customer on this business.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>issue_date</td><td class="param-type">date</td><td>Invoice issue date.</td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Payment due date.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 characters.</td></tr>
            <tr><td>discount_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Header-level discount.</td></tr>
            <tr><td>tax_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Header-level tax.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>Full replacement set of line items, same shape as create.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Invoice updated.",
  "data": {
    "id": 22,
    "invoice_number": "INV-0022",
    "status": "draft",
    "total": 19500.00,
    "is_editable": true
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The items field is required.",
  "errors": { "items": ["The items field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}</code>
      <span class="endpoint-name">Delete an invoice</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes an invoice. Requires the <code>pos_checkout</code> permission for non-owner business members; the underlying service may reject deletion depending on invoice state.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_checkout permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Invoice deleted."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-mark-sent">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}/mark-sent</code>
      <span class="endpoint-name">Mark invoice as sent</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the invoice status to <code>sent</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Marked as sent.",
  "status": "sent"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-mark-paid">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}/mark-paid</code>
      <span class="endpoint-name">Mark invoice as paid</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the invoice status to <code>paid</code>. Can reject the transition (e.g. from an invalid current state) with a validation error.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Marked as paid.",
  "status": "paid"
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This invoice cannot be marked as paid."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-mark-overdue">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}/mark-overdue</code>
      <span class="endpoint-name">Mark invoice as overdue</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the invoice status to <code>overdue</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Marked as overdue.",
  "status": "overdue"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-invoices-cancel">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/invoices/{invoice}/cancel</code>
      <span class="endpoint-name">Cancel an invoice</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the invoice status to <code>cancelled</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Invoice cancelled.",
  "status": "cancelled"
}</code></pre>
      </div>
@endverbatim
