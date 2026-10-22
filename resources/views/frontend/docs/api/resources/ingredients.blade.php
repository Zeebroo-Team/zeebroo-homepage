@verbatim
  <div class="endpoint" id="ep-ingredients-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/ingredients</code>
      <span class="endpoint-name">List ingredients</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns all ingredients for the current business, ordered by name, with a computed low-stock flag. No filters or pagination.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 3,
      "name": "Chicken breast",
      "unit": "kg",
      "quantity": 12.5,
      "low_stock_threshold": 5,
      "cost_per_unit": 950.0000,
      "is_low_stock": false
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredients-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/ingredients</code>
      <span class="endpoint-name">Create ingredient</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates an ingredient with an initial on-hand quantity. Note: this returns the raw Eloquent model, not the formatted shape used by the list endpoint.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>unit</td><td class="param-type">string</td><td>One of <code>g</code>, <code>kg</code>, <code>ml</code>, <code>l</code>, <code>pcs</code>, <code>tbsp</code>, <code>tsp</code>, <code>cup</code>.</td></tr>
            <tr><td>quantity</td><td class="param-type">number</td><td>Initial stock quantity, min 0.</td></tr>
            <tr><td>low_stock_threshold<span class="param-required">opt</span></td><td class="param-type">number</td><td>Min 0. When set, drives <code>is_low_stock</code>.</td></tr>
            <tr><td>cost_per_unit<span class="param-required">opt</span></td><td class="param-type">number</td><td>Min 0.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 11,
    "business_id": 4,
    "name": "Basmati rice",
    "unit": "kg",
    "quantity": "25.000",
    "low_stock_threshold": "10.000",
    "cost_per_unit": "320.0000",
    "created_at": "2026-07-31T09:00:00.000000Z",
    "updated_at": "2026-07-31T09:00:00.000000Z"
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The unit field is required.",
  "errors": { "unit": ["The unit field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredients-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/ingredients/{ingredient}</code>
      <span class="endpoint-name">Update ingredient</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates name, unit, low-stock threshold, and cost per unit. Quantity is not editable here — use stock-in (or a GRN) to change on-hand stock so the transaction ledger stays accurate.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>unit</td><td class="param-type">string</td><td>One of <code>g</code>, <code>kg</code>, <code>ml</code>, <code>l</code>, <code>pcs</code>, <code>tbsp</code>, <code>tsp</code>, <code>cup</code>.</td></tr>
            <tr><td>low_stock_threshold<span class="param-required">opt</span></td><td class="param-type">number</td><td>Min 0.</td></tr>
            <tr><td>cost_per_unit<span class="param-required">opt</span></td><td class="param-type">number</td><td>Min 0.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "business_id": 4,
    "name": "Chicken breast",
    "unit": "kg",
    "quantity": "12.500",
    "low_stock_threshold": "6.000",
    "cost_per_unit": "975.0000",
    "created_at": "2026-06-27T10:00:00.000000Z",
    "updated_at": "2026-07-31T09:05:00.000000Z"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredients-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/ingredients/{ingredient}</code>
      <span class="endpoint-name">Delete ingredient</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes an ingredient. Note this endpoint returns <code>{"message": "Deleted"}</code> rather than the usual <code>{"success": true}</code> shape.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Deleted" }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredients-stock-in">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/ingredients/{ingredient}/stock-in</code>
      <span class="endpoint-name">Manual stock-in</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Increments the ingredient's quantity and records a <code>purchase</code>-type stock transaction with the resulting balance.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>quantity</td><td class="param-type">number</td><td>Min 0.001.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars. Defaults to "Stock added".</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "data": { "quantity": 20.5 } }</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The quantity field is required.",
  "errors": { "quantity": ["The quantity field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-ingredients-transactions">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/ingredients/{ingredient}/transactions</code>
      <span class="endpoint-name">List stock transactions</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated (30/page) stock movement ledger for one ingredient, newest first — covers <code>purchase</code>, <code>deduction</code> (order serve), <code>adjustment</code>, and <code>waste</code> entries. Returns the raw Laravel paginator, not the <code>{data, meta}</code> envelope used elsewhere.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "current_page": 1,
  "data": [
    {
      "id": 41,
      "ingredient_id": 3,
      "business_id": 4,
      "type": "deduction",
      "quantity_change": "-0.500",
      "quantity_after": "12.500",
      "notes": "Order #ORD-260731-003",
      "reference_type": "Modules\\Restaurant\\Models\\Order",
      "reference_id": 12,
      "created_at": "2026-07-31T10:20:00.000000Z",
      "updated_at": "2026-07-31T10:20:00.000000Z"
    }
  ],
  "per_page": 30,
  "last_page": 3,
  "total": 62
}</code></pre>
      </div>
@endverbatim
