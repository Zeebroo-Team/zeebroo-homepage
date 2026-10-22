@verbatim
  <div class="endpoint" id="ep-purchase-orders-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders</code>
      <span class="endpoint-name">List purchase orders</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">List purchase orders for the current business, optionally filtered by free-text search or status.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search PO number, supplier name, or reference.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>draft</code>, <code>ordered</code>, <code>received</code>, <code>cancelled</code>. Omit or pass <code>all</code> for every status.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 41,
      "po_number": "PO-0041",
      "status": "ordered",
      "status_label": "Ordered",
      "supplier_id": 6,
      "supplier_name": "Ceylon Wholesale Traders",
      "purchase_date": "2026-07-20",
      "expected_delivery_date": "2026-07-28",
      "subtotal": 145000.00,
      "total": 145000.00,
      "items_count": 5,
      "notes": null
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-orders-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders</code>
      <span class="endpoint-name">Create a purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a purchase order with one or more line items against a supplier. Requires the <code>inv_purchasing</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_purchasing</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>supplier_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Supplier the order is placed with.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text reference, max 100 chars.</td></tr>
            <tr><td>purchase_date</td><td class="param-type">date</td><td>Date the order is raised.</td></tr>
            <tr><td>expected_delivery_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Expected delivery date.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>draft</code> or <code>ordered</code>.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text notes, max 2000 chars.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>At least one line item.</td></tr>
            <tr><td>items[].product_id</td><td class="param-type">integer</td><td>Product being ordered.</td></tr>
            <tr><td>items[].quantity</td><td class="param-type">number</td><td>Quantity ordered, min 0.001.</td></tr>
            <tr><td>items[].unit_cost</td><td class="param-type">number</td><td>Cost per unit.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Purchase order PO-0042 created.",
  "data": {
    "id": 42,
    "po_number": "PO-0042",
    "status": "draft",
    "status_label": "Draft",
    "supplier_id": 6,
    "supplier_name": "Ceylon Wholesale Traders",
    "purchase_date": "2026-07-31",
    "expected_delivery_date": null,
    "subtotal": 24000.00,
    "total": 24000.00,
    "items_count": 2,
    "notes": null,
    "items": [
      {
        "id": 101,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity": 20,
        "unit_cost": 1200.00,
        "line_total": 24000.00
      }
    ]
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

  <div class="endpoint" id="ep-purchase-orders-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders/{purchase}</code>
      <span class="endpoint-name">Get PO detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns full purchase order detail including supplier and line items. 404s if the PO does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 41,
    "po_number": "PO-0041",
    "status": "ordered",
    "status_label": "Ordered",
    "supplier_id": 6,
    "supplier_name": "Ceylon Wholesale Traders",
    "purchase_date": "2026-07-20",
    "expected_delivery_date": "2026-07-28",
    "subtotal": 145000.00,
    "total": 145000.00,
    "items_count": 1,
    "notes": null,
    "items": [
      {
        "id": 88,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity": 120,
        "unit_cost": 1200.00,
        "line_total": 144000.00
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-orders-place">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders/{purchase}/place</code>
      <span class="endpoint-name">Mark PO as ordered</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions a draft purchase order to <code>ordered</code>. Requires the <code>inv_purchasing</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_purchasing</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Purchase order PO-0041 placed.",
  "data": { "id": 41, "po_number": "PO-0041", "status": "ordered", "status_label": "Ordered", "...": "same shape as PO detail" }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Only draft purchase orders can be placed.",
  "errors": { "status": ["Only draft purchase orders can be placed."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-orders-receive">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders/{purchase}/receive</code>
      <span class="endpoint-name">Mark PO as received</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Marks the whole purchase order as received without going through the GRN item-level flow. Requires the <code>inv_purchasing</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_purchasing</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Goods received for PO-0041.",
  "data": { "id": 41, "po_number": "PO-0041", "status": "received", "status_label": "Received", "...": "same shape as PO detail" }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This purchase order cannot be received.",
  "errors": { "status": ["This purchase order cannot be received."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-orders-cancel">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders/{purchase}/cancel</code>
      <span class="endpoint-name">Cancel a purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Cancels a purchase order. Requires the <code>inv_purchasing</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: inv_purchasing</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Purchase order PO-0041 cancelled.",
  "data": {
    "id": 41,
    "po_number": "PO-0041",
    "status": "cancelled",
    "status_label": "Cancelled",
    "supplier_id": 6,
    "supplier_name": "Ceylon Wholesale Traders",
    "purchase_date": "2026-07-20",
    "expected_delivery_date": "2026-07-28",
    "subtotal": 145000.00,
    "total": 145000.00,
    "items_count": 1,
    "notes": null
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "A received purchase order cannot be cancelled.",
  "errors": { "status": ["A received purchase order cannot be cancelled."] }
}</code></pre>
      </div>
@endverbatim
