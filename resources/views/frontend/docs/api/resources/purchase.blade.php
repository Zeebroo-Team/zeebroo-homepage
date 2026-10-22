@verbatim
  <div class="endpoint" id="ep-purchase-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/purchases</code>
      <span class="endpoint-name">List purchases</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Resolves the current business via the session-selected business (<code>Business::currentForNavbar</code> — not the <code>X-Business-Id</code> header) and renders the <code>purchase::purchases.index</code> Blade view listing purchase orders. Supports filtering.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">Business-scoped (session-selected business only)</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text search.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>all</code> (default), <code>draft</code>, <code>ordered</code>, <code>partially_received</code>, <code>received</code>, <code>cancelled</code>.</td></tr>
            <tr><td>supplier_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter to a single supplier.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>Content-Type: text/html
(renders the `purchase::purchases.index` Blade view — not JSON)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/purchases</code>
      <span class="endpoint-name">Create purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a purchase order (and its line items) via <code>PurchaseService::create</code>, generating a <code>po_number</code>. On success it redirects to the purchase's show page; on validation failure it redirects back to the index with flashed errors — no JSON body either way.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">Business-scoped (session-selected business only)</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Only accepted when the business has branch-level stock separation enabled.</td></tr>
            <tr><td>supplier_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to the resolved business.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>purchase_date</td><td class="param-type">date</td><td></td></tr>
            <tr><td>expected_delivery_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be on/after <code>purchase_date</code>.</td></tr>
            <tr><td>status</td><td class="param-type">string</td><td><code>draft</code> or <code>ordered</code> only.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>At least one line item.</td></tr>
            <tr><td>items.*.product_id</td><td class="param-type">integer</td><td>Must belong to the resolved business.</td></tr>
            <tr><td>items.*.quantity</td><td class="param-type">numeric</td><td>Min 0.001, max 999999.</td></tr>
            <tr><td>items.*.unit_cost</td><td class="param-type">numeric</td><td>Min 0, max 999999999.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">302</span></h4>
        <pre class="code-block"><code>HTTP/1.1 302 Found
Location: /purchases/{purchase}
(redirect with flashed "status" message — not JSON)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/purchases/{purchase}</code>
      <span class="endpoint-name">Get purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Route-model-binds <code>{purchase}</code> by id, then 404s unless it belongs to the session-selected business. Renders <code>purchase::purchases.show</code> with the purchase, its supplier, items, and goods-receive-notes (with ledger totals) eager-loaded.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">Business-scoped (session-selected business only)</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>Content-Type: text/html
(renders the `purchase::purchases.show` Blade view — not JSON)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span><span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/purchases/{purchase}</code>
      <span class="endpoint-name">Update purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same request body as <code>store</code>. Only editable while the purchase is still <code>draft</code> or <code>ordered</code> (<code>PurchaseService::update</code> is called regardless — editability is enforced on the <code>edit</code> web form, not this route). Redirects to the show page on success.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">Business-scoped (session-selected business only)</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td colspan="3">Identical to <code>POST /api/v1/purchases</code> above (<code>supplier_id</code>, <code>purchase_date</code>, <code>status</code>, <code>items[]</code>, etc.).</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">302</span></h4>
        <pre class="code-block"><code>HTTP/1.1 302 Found
Location: /purchases/{purchase}
(redirect with flashed "status" message — not JSON)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-purchase-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/purchases/{purchase}</code>
      <span class="endpoint-name">Delete purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes via <code>PurchaseService::delete</code>, which throws a <code>ValidationException</code> (caught and redirected-back-with-errors) if the purchase isn't in a deletable state. Redirects to the index on success.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">Business-scoped (session-selected business only)</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">302</span></h4>
        <pre class="code-block"><code>HTTP/1.1 302 Found
Location: /purchases
(redirect with flashed "status" message — not JSON)</code></pre>
      </div>
@endverbatim
