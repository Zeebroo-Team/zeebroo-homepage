@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-quotations-list"><span class="method-badge method-get">GET</span> /quotations</a>
    <a href="#ep-quotations-store"><span class="method-badge method-post">POST</span> /quotations</a>
    <a href="#ep-quotations-show"><span class="method-badge method-get">GET</span> /quotations/{quotation}</a>
    <a href="#ep-quotations-update"><span class="method-badge method-patch">PATCH</span> /quotations/{quotation}</a>
    <a href="#ep-quotations-destroy"><span class="method-badge method-delete">DELETE</span> /quotations/{quotation}</a>
    <a href="#ep-quotations-mark-sent"><span class="method-badge method-post">POST</span> /quotations/{quotation}/mark-sent</a>
    <a href="#ep-quotations-accept"><span class="method-badge method-post">POST</span> /quotations/{quotation}/accept</a>
    <a href="#ep-quotations-reject"><span class="method-badge method-post">POST</span> /quotations/{quotation}/reject</a>
  </div>

  <div class="endpoint" id="ep-quotations-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/quotations</code>
      <span class="endpoint-name">List quotations</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">List of quotations for the current business, optionally filtered by search term or status.</p>
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
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>draft</code>, <code>sent</code>, <code>accepted</code>, <code>rejected</code>. Defaults to <code>all</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 15,
      "quote_number": "QT-0015",
      "status": "sent",
      "status_label": "Sent",
      "status_color": "blue",
      "customer_name": "Nimal Perera",
      "reference": "PROJ-2201",
      "quote_date": "2026-07-28",
      "expiry_date": "2026-08-11",
      "total": 12500.00,
      "proposal_count": 0
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-quotations-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/quotations</code>
      <span class="endpoint-name">Create a quotation</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a quotation with one or more line items, starting in <code>draft</code> status. Requires the <code>pos_quotations</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_quotations permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to a customer on this business.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text reference, max 120 characters.</td></tr>
            <tr><td>quote_date</td><td class="param-type">date</td><td>Quotation date.</td></tr>
            <tr><td>expiry_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Quotation expiry date.</td></tr>
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
  "message": "Quotation QT-0016 created.",
  "data": {
    "id": 16,
    "quote_number": "QT-0016",
    "status": "draft",
    "status_label": "Draft",
    "status_color": "gray",
    "customer_name": "Nimal Perera",
    "reference": "PROJ-2201",
    "quote_date": "2026-07-31",
    "expiry_date": "2026-08-14",
    "total": 12500.00,
    "proposal_count": 0,
    "subtotal": 12000.00,
    "discount_amount": 0,
    "tax_amount": 500.00,
    "notes": null,
    "customer_id": 4,
    "is_editable": true,
    "items": [
      {
        "id": 41,
        "product_id": 88,
        "item_type": "product",
        "description": null,
        "quantity": 5,
        "unit_price": 2400.00,
        "line_total": 12000.00
      }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The quote date field is required.",
  "errors": { "quote_date": ["The quote date field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-quotations-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/quotations/{quotation}</code>
      <span class="endpoint-name">Get quotation detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Full quotation detail including all line items. 404s if the quotation does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 15,
    "quote_number": "QT-0015",
    "status": "sent",
    "status_label": "Sent",
    "status_color": "blue",
    "customer_name": "Nimal Perera",
    "reference": "PROJ-2201",
    "quote_date": "2026-07-28",
    "expiry_date": "2026-08-11",
    "total": 12500.00,
    "proposal_count": 0,
    "subtotal": 12000.00,
    "discount_amount": 0,
    "tax_amount": 500.00,
    "notes": null,
    "customer_id": 4,
    "is_editable": false,
    "items": [
      {
        "id": 40,
        "product_id": 88,
        "item_type": "product",
        "description": null,
        "quantity": 5,
        "unit_price": 2400.00,
        "line_total": 12000.00
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-quotations-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/quotations/{quotation}</code>
      <span class="endpoint-name">Update a quotation</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the quotation header and line items. Only allowed while the quotation is editable (i.e. still <code>draft</code>). Requires the <code>pos_quotations</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_quotations permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to a customer on this business.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>quote_date</td><td class="param-type">date</td><td>Quotation date.</td></tr>
            <tr><td>expiry_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Quotation expiry date.</td></tr>
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
  "message": "Quotation updated.",
  "data": {
    "id": 15,
    "quote_number": "QT-0015",
    "status": "draft",
    "total": 13200.00,
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

  <div class="endpoint" id="ep-quotations-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/quotations/{quotation}</code>
      <span class="endpoint-name">Delete a quotation</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a quotation. Requires the <code>pos_quotations</code> permission for non-owner business members; the underlying service may reject deletion depending on quotation state.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires pos_quotations permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Quotation deleted."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-quotations-mark-sent">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/quotations/{quotation}/mark-sent</code>
      <span class="endpoint-name">Mark quotation as sent</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the quotation status to <code>sent</code>.</p>
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

  <div class="endpoint" id="ep-quotations-accept">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/quotations/{quotation}/accept</code>
      <span class="endpoint-name">Mark quotation as accepted</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the quotation status to <code>accepted</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Marked as accepted.",
  "status": "accepted"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-quotations-reject">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/quotations/{quotation}/reject</code>
      <span class="endpoint-name">Mark quotation as rejected</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions the quotation status to <code>rejected</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Marked as rejected.",
  "status": "rejected"
}</code></pre>
      </div>
@endverbatim
