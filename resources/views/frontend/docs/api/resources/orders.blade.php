@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-orders-index"><span class="method-badge method-get">GET</span> /orders</a>
    <a href="#ep-orders-store"><span class="method-badge method-post">POST</span> /orders</a>
    <a href="#ep-orders-bootstrap"><span class="method-badge method-get">GET</span> /orders/bootstrap</a>
    <a href="#ep-orders-item-statuses"><span class="method-badge method-get">GET</span> /orders/item-statuses</a>
    <a href="#ep-orders-show"><span class="method-badge method-get">GET</span> /orders/{order}</a>
    <a href="#ep-orders-transition"><span class="method-badge method-patch">PATCH</span> /orders/{order}/status</a>
    <a href="#ep-orders-add-items"><span class="method-badge method-post">POST</span> /orders/{order}/items</a>
    <a href="#ep-orders-item-status"><span class="method-badge method-patch">PATCH</span> /orders/{order}/items/{item}/status</a>
    <a href="#ep-orders-delete-item"><span class="method-badge method-delete">DELETE</span> /orders/{order}/items/{item}</a>
    <a href="#ep-orders-complete"><span class="method-badge method-post">POST</span> /orders/{order}/complete</a>
    <a href="#ep-orders-clear"><span class="method-badge method-delete">DELETE</span> /orders/{order}</a>
  </div>

  <div class="endpoint" id="ep-orders-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders</code>
      <span class="endpoint-name">List orders</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated list of restaurant orders for the current business, with per-status counts. "open" excludes served, paid, and cancelled orders.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>all</code> (default), <code>open</code>, or an exact status (<code>pending</code>, <code>preparing</code>, <code>ready</code>, <code>served</code>, <code>paid</code>, <code>cancelled</code>).</td></tr>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by order number or customer name.</td></tr>
            <tr><td>table_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter by table.</td></tr>
            <tr><td>page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Page number, default 1.</td></tr>
            <tr><td>per_page<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Page size, default 25, max 100.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 12,
      "order_number": "ORD-260731-003",
      "order_type": "dine_in",
      "type_label": "Dine In",
      "status": "preparing",
      "status_color": "#3b82f6",
      "table": { "id": 4, "name": "Table 4" },
      "customer_name": null,
      "customer_phone": null,
      "notes": null,
      "subtotal": 2450.00,
      "discount_amount": 0,
      "total": 2450.00,
      "items": [
        {
          "id": 55,
          "name": "Chicken Kottu",
          "quantity": 2,
          "unit_price": 1225.00,
          "line_total": 2450.00,
          "notes": null,
          "status": "preparing"
        }
      ],
      "created_at": "2026-07-31T10:12:00+00:00"
    }
  ],
  "meta": { "current_page": 1, "last_page": 2, "total": 34 },
  "status_counts": { "pending": 3, "preparing": 5, "ready": 2, "served": 1, "paid": 20, "cancelled": 3 },
  "currency": "LKR"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders</code>
      <span class="endpoint-name">Create order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new order with its line items, sets status to <code>pending</code>, computes subtotal/total, and marks the assigned table (if any) as <code>occupied</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>order_type</td><td class="param-type">string</td><td>One of <code>dine_in</code>, <code>takeaway</code>, <code>delivery</code>.</td></tr>
            <tr><td>table_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must exist in <code>restaurant_tables</code>.</td></tr>
            <tr><td>customer_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>customer_phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 30 chars.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 chars.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>At least one line item.</td></tr>
            <tr><td>items[].menu_item_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Linked menu item id.</td></tr>
            <tr><td>items[].product_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>If set, the line consumes stock via FIFO and is created with status <code>served</code> instead of <code>pending</code>.</td></tr>
            <tr><td>items[].name</td><td class="param-type">string</td><td>Line item display name, max 255.</td></tr>
            <tr><td>items[].quantity</td><td class="param-type">integer</td><td>Min 1.</td></tr>
            <tr><td>items[].unit_price</td><td class="param-type">number</td><td>Min 0.</td></tr>
            <tr><td>items[].notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 41,
    "order_number": "ORD-260731-004",
    "order_type": "dine_in",
    "type_label": "Dine In",
    "status": "pending",
    "status_color": "#f59e0b",
    "table": { "id": 4, "name": "Table 4" },
    "customer_name": null,
    "customer_phone": null,
    "notes": null,
    "subtotal": 1225.00,
    "discount_amount": 0,
    "total": 1225.00,
    "items": [
      { "id": 88, "name": "Chicken Kottu", "quantity": 1, "unit_price": 1225.00, "line_total": 1225.00, "notes": null, "status": "pending" }
    ],
    "created_at": "2026-07-31T11:00:00+00:00"
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The order type field is required.",
  "errors": {
    "order_type": ["The order type field is required."],
    "items": ["The items field is required."]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-bootstrap">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/bootstrap</code>
      <span class="endpoint-name">Order screen bootstrap data</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns everything the "new order" screen needs in one call: active (non-inactive) tables, menu categories with their available menu items, and the business currency.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "tables": [
      { "id": 4, "name": "Table 4", "capacity": 4, "status": "available" }
    ],
    "categories": [
      {
        "id": 2,
        "name": "Rice &amp; Curry",
        "items": [
          { "id": 9, "name": "Chicken Kottu", "price": 1225.00, "image_url": null }
        ]
      }
    ],
    "currency": "LKR"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-item-statuses">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/item-statuses</code>
      <span class="endpoint-name">Poll order item statuses</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lightweight polling endpoint for the kitchen display — returns current status for a set of order item ids, scoped to orders in the current business. Used to refresh statuses without re-fetching whole orders.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>ids[]<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Order item ids to check. Returns <code>{}</code> if empty or omitted.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "55": "preparing",
  "56": "ready"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}</code>
      <span class="endpoint-name">Get order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single order with its table and line items. 404s if the order does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "order_number": "ORD-260731-003",
    "order_type": "dine_in",
    "type_label": "Dine In",
    "status": "preparing",
    "status_color": "#3b82f6",
    "table": { "id": 4, "name": "Table 4" },
    "customer_name": null,
    "customer_phone": null,
    "notes": null,
    "subtotal": 2450.00,
    "discount_amount": 0,
    "total": 2450.00,
    "items": [
      { "id": 55, "name": "Chicken Kottu", "quantity": 2, "unit_price": 1225.00, "line_total": 2450.00, "notes": null, "status": "preparing" }
    ],
    "created_at": "2026-07-31T10:12:00+00:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-transition">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}/status</code>
      <span class="endpoint-name">Transition order status</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Moves the order to a new status following the fixed flow <code>pending → preparing → ready → served → paid</code> (any state can go to <code>cancelled</code>). Frees the table when the new status is <code>served</code>, <code>paid</code>, or <code>cancelled</code>; transitioning to <code>served</code> also deducts recipe ingredients from stock.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status</td><td class="param-type">string</td><td>Target status. Must be a legal transition from the order's current status.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "status": "ready",
    "status_color": "#8b5cf6",
    "...": "same shape as GET /orders/{order}"
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "error": "Cannot transition from pending to served"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-add-items">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}/items</code>
      <span class="endpoint-name">Add items to order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Appends one or more line items to an existing order and recalculates its subtotal/total.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>items</td><td class="param-type">array</td><td>At least one line item.</td></tr>
            <tr><td>items[].menu_item_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Linked menu item id.</td></tr>
            <tr><td>items[].name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>items[].quantity</td><td class="param-type">integer</td><td>Min 1.</td></tr>
            <tr><td>items[].unit_price</td><td class="param-type">number</td><td>Min 0.</td></tr>
            <tr><td>items[].notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "items": [
      { "id": 90, "name": "Iced Tea", "quantity": 1, "unit_price": 350.00, "notes": null, "status": "pending" }
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

  <div class="endpoint" id="ep-orders-item-status">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}/items/{item}/status</code>
      <span class="endpoint-name">Update order item status</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sets the kitchen status of a single line item, used by the kitchen display. 404s if the item does not belong to the given order.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status</td><td class="param-type">string</td><td>One of <code>pending</code>, <code>preparing</code>, <code>ready</code>, <code>served</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true, "status": "ready" }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-delete-item">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}/items/{item}</code>
      <span class="endpoint-name">Remove order item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a single line item from an order. If it was the last remaining item, the whole order is deleted as well.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-complete">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}/complete</code>
      <span class="endpoint-name">Complete and pay order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Settles the order: creates a completed <code>Sale</code> (with a generated <code>POS-####</code> sale number) and matching sale items from the order's lines, marks the order <code>paid</code> and links its <code>sale_id</code>, frees the table, and runs payment settlement. <code>transfer</code> is stored as a card payment on the sale.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>payment_method</td><td class="param-type">string</td><td>One of <code>cash</code>, <code>card</code>, <code>transfer</code>.</td></tr>
            <tr><td>amount_tendered<span class="param-required">opt</span></td><td class="param-type">number</td><td>Defaults to the order total; change is computed from the difference.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The payment method field is required.",
  "errors": { "payment_method": ["The payment method field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-orders-clear">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/orders/{order}</code>
      <span class="endpoint-name">Clear (void) order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes an order and all its line items without settling a sale, and frees the assigned table if any. Used to void an order started in error.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
@endverbatim
