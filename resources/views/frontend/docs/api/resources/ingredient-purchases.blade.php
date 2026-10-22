@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-ingredient-purchases-index"><span class="method-badge method-get">GET</span> /purchase-orders</a>
    <a href="#ep-ingredient-purchases-store"><span class="method-badge method-post">POST</span> /purchase-orders</a>
    <a href="#ep-ingredient-purchases-show"><span class="method-badge method-get">GET</span> /purchase-orders/{ingredientPurchaseOrder}</a>
    <a href="#ep-ingredient-purchases-update"><span class="method-badge method-put">PUT</span> /purchase-orders/{ingredientPurchaseOrder}</a>
    <a href="#ep-ingredient-purchases-destroy"><span class="method-badge method-delete">DELETE</span> /purchase-orders/{ingredientPurchaseOrder}</a>
    <a href="#ep-ingredient-purchases-place-order"><span class="method-badge method-post">POST</span> /purchase-orders/{ingredientPurchaseOrder}/place-order</a>
    <a href="#ep-ingredient-purchases-cancel"><span class="method-badge method-post">POST</span> /purchase-orders/{ingredientPurchaseOrder}/cancel</a>
    <a href="#ep-ingredient-purchases-grn"><span class="method-badge method-post">POST</span> /purchase-orders/{ingredientPurchaseOrder}/grn</a>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders</code>
      <span class="endpoint-name">List purchase orders</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated (25/page) list of ingredient purchase orders for the current business, newest purchase date first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>all</code> (default), <code>draft</code>, <code>ordered</code>, <code>partially_received</code>, <code>received</code>, or <code>cancelled</code>.</td></tr>
            <tr><td>page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Default 1.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 5,
      "po_number": "IPO-0005",
      "status": "ordered",
      "status_label": "Ordered",
      "status_color": "#2563eb",
      "purchase_date": "2026-07-28",
      "expected_delivery_date": "2026-08-02",
      "supplier_name": "Green Valley Farms",
      "total": 48500.00,
      "items_count": 4
    }
  ],
  "meta": { "current_page": 1, "last_page": 1, "total": 5 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders</code>
      <span class="endpoint-name">Create purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a purchase order with a generated <code>IPO-####</code> number and its ingredient lines, computing subtotal/total from quantity × unit cost per line.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>supplier_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must exist in <code>suppliers</code> scoped to this business.</td></tr>
            <tr><td>purchase_date</td><td class="param-type">date</td><td>&nbsp;</td></tr>
            <tr><td>expected_delivery_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be on/after <code>purchase_date</code>.</td></tr>
            <tr><td>status</td><td class="param-type">string</td><td>One of <code>draft</code>, <code>ordered</code>.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 3000 chars.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>At least one valid line (rows with a non-existent ingredient, or zero quantity, cause a 422); each row is <code>ingredient_id</code>, <code>quantity</code>, <code>unit_cost</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 6,
    "po_number": "IPO-0006",
    "status": "draft",
    "status_label": "Draft",
    "status_color": "#6b7280",
    "is_editable": true,
    "can_receive": true,
    "purchase_date": "2026-07-31",
    "expected_delivery_date": null,
    "notes": null,
    "subtotal": 12000.00,
    "total": 12000.00,
    "supplier": { "id": 2, "name": "Green Valley Farms" },
    "items": [
      {
        "id": 14,
        "ingredient_id": 3,
        "ingredient_name": "Chicken breast",
        "ingredient_unit": "kg",
        "quantity": 12.000,
        "unit_cost": 1000.0000,
        "line_total": 12000.00,
        "qty_received": 0,
        "qty_remaining": 12
      }
    ],
    "grns": [],
    "created_at": "2026-07-31T09:30:00+00:00"
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "errors": { "items": ["Add at least one ingredient line."] } }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}</code>
      <span class="endpoint-name">Get purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns full purchase order detail including its ingredient lines (with received/remaining quantities) and any GRNs recorded against it.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "po_number": "IPO-0005",
    "status": "partially_received",
    "status_label": "Partially Received",
    "status_color": "#d97706",
    "is_editable": false,
    "can_receive": true,
    "purchase_date": "2026-07-28",
    "expected_delivery_date": "2026-08-02",
    "notes": null,
    "subtotal": 48500.00,
    "total": 48500.00,
    "supplier": { "id": 2, "name": "Green Valley Farms" },
    "items": [
      {
        "id": 12,
        "ingredient_id": 3,
        "ingredient_name": "Chicken breast",
        "ingredient_unit": "kg",
        "quantity": 30.000,
        "unit_cost": 1000.0000,
        "line_total": 30000.00,
        "qty_received": 10,
        "qty_remaining": 20
      }
    ],
    "grns": [
      {
        "id": 3,
        "grn_number": "IGRN-0003",
        "received_date": "2026-07-29",
        "payment_method": "cash",
        "payment_label": "Cash",
        "reference": null,
        "total": 10000.00
      }
    ],
    "created_at": "2026-07-28T08:00:00+00:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}</code>
      <span class="endpoint-name">Update purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the purchase order's header fields and ingredient lines (existing lines are deleted and recreated), then recalculates totals. Only allowed while the PO is editable (<code>draft</code> or <code>ordered</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>supplier_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must exist in <code>suppliers</code> scoped to this business.</td></tr>
            <tr><td>purchase_date</td><td class="param-type">date</td><td>&nbsp;</td></tr>
            <tr><td>expected_delivery_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be on/after <code>purchase_date</code>.</td></tr>
            <tr><td>status</td><td class="param-type">string</td><td>One of <code>draft</code>, <code>ordered</code>.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 3000 chars.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>Full replacement set of ingredient lines, same shape as create.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 6, "po_number": "IPO-0006", "status": "ordered", "...": "same shape as GET /purchase-orders/{id}" }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "errors": { "purchase": ["Only draft or ordered purchase orders can be edited."] } }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}</code>
      <span class="endpoint-name">Delete purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes the purchase order. Blocked with a 422 if the PO has been received/partially received or already has GRNs recorded against it.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "errors": { "purchase": ["Orders with goods receive notes cannot be deleted."] } }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-place-order">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}/place-order</code>
      <span class="endpoint-name">Place order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Transitions a <code>draft</code> purchase order to <code>ordered</code>. No-op (returns unchanged) if the PO is already past draft. No request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 6, "po_number": "IPO-0006", "status": "ordered", "...": "same shape as GET /purchase-orders/{id}" }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "errors": { "status": ["Cancelled orders cannot be placed."] } }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-cancel">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}/cancel</code>
      <span class="endpoint-name">Cancel purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sets the purchase order's status to <code>cancelled</code>. Blocked with a 422 if the PO is already received or partially received. No request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 6, "po_number": "IPO-0006", "status": "cancelled", "...": "same shape as GET /purchase-orders/{id}" }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "errors": { "status": ["Orders with goods receipts cannot be cancelled."] } }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredient-purchases-grn">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/purchase-orders/{ingredientPurchaseOrder}/grn</code>
      <span class="endpoint-name">Record goods received (GRN)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a goods-received note against the purchase order with a generated <code>IGRN-####</code> number, adds each received quantity to the matching ingredient's stock (logging a <code>purchase</code> stock transaction and refreshing its <code>cost_per_unit</code>), and updates the PO's status to <code>partially_received</code> or <code>received</code> based on total quantities received.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>received_date</td><td class="param-type">date</td><td>&nbsp;</td></tr>
            <tr><td>payment_method</td><td class="param-type">string</td><td>One of <code>cash</code>, <code>cheque</code>, <code>credit</code>.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 chars, e.g. supplier invoice #.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 3000 chars.</td></tr>
            <tr><td>lines</td><td class="param-type">array</td><td>At least one line; received quantity per line cannot exceed that line's remaining quantity on the PO.</td></tr>
            <tr><td>lines[].purchase_order_item_id</td><td class="param-type">integer</td><td>Must belong to this purchase order.</td></tr>
            <tr><td>lines[].quantity_received</td><td class="param-type">number</td><td>Min 0.001.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "po_number": "IPO-0005",
    "status": "partially_received",
    "status_label": "Partially Received",
    "status_color": "#d97706",
    "is_editable": false,
    "can_receive": true,
    "...": "full detail shape as GET /purchase-orders/{id}, with the new GRN in grns[]"
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "errors": { "items": ["Received quantity for Chicken breast exceeds remaining amount (20)."] } }</code></pre>
      </div>
@endverbatim
