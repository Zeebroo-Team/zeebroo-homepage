@verbatim
  <div class="endpoint" id="ep-grns-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/grns</code>
      <span class="endpoint-name">List goods receive notes</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">List GRNs for the current business, optionally filtered by search term, payment status, or capped to a max number of rows.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search GRN number, PO number, or supplier name.</td></tr>
            <tr><td>payment<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>all</code> (default), <code>paid</code>, or <code>unpaid</code>.</td></tr>
            <tr><td>limit<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Caps the number of rows returned.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 30,
      "grn_number": "GRN-0030",
      "purchase_id": 41,
      "po_number": "PO-0041",
      "supplier_name": "Ceylon Wholesale Traders",
      "received_date": "2026-07-25",
      "total": 144000.00,
      "payment_method": "credit",
      "payment_status": "pending",
      "payment_status_label": "Payment pending",
      "amount_paid": 0.00,
      "amount_outstanding": 144000.00
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-grns-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/grns/{grn}</code>
      <span class="endpoint-name">Get GRN detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns GRN detail with received line items and the payment/ledger history recorded against it. 404s if the GRN does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 30,
    "grn_number": "GRN-0030",
    "purchase_id": 41,
    "po_number": "PO-0041",
    "supplier_name": "Ceylon Wholesale Traders",
    "received_date": "2026-07-25",
    "total": 144000.00,
    "payment_method": "credit",
    "payment_status": "pending",
    "payment_status_label": "Payment pending",
    "amount_paid": 0.00,
    "amount_outstanding": 144000.00,
    "reference": null,
    "notes": null,
    "subtotal": 144000.00,
    "items": [
      {
        "id": 55,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity_received": 120.000,
        "unit_cost": 1200.00,
        "selling_unit_price": 1800.00,
        "line_total": 144000.00
      }
    ],
    "payments": []
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-grns-create-form">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders/{purchase}/grn-form</code>
      <span class="endpoint-name">Get GRN creation form data</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the purchase order's line items with quantities already received/remaining, ready to prefill a new GRN. 422s if the purchase order cannot currently receive goods (e.g. draft or already fully received).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "purchase": {
      "id": 41,
      "po_number": "PO-0041",
      "supplier_name": "Ceylon Wholesale Traders",
      "status": "ordered"
    },
    "items": [
      {
        "id": 88,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity_ordered": 120.000,
        "quantity_received": 0.000,
        "quantity_remaining": 120.000,
        "unit_cost": 1200.00,
        "selling_unit_price": null
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-grns-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/purchase-orders/{purchase}/grns</code>
      <span class="endpoint-name">Create a GRN against a purchase order</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Records receipt of goods for one or more of the purchase order's line items and optionally settles a cash/credit/cheque payment at the same time. Requires the <code>inv_purchasing</code> permission.</p>
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
            <tr><td>received_date</td><td class="param-type">date</td><td>Date goods were received.</td></tr>
            <tr><td>reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>payment_method</td><td class="param-type">string</td><td><code>cash</code>, <code>credit</code>, or <code>cheque</code>.</td></tr>
            <tr><td>payment_reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>cheque_due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Required in practice when <code>payment_method</code> is <code>cheque</code>.</td></tr>
            <tr><td>payment_option<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>full</code> or <code>partial</code>.</td></tr>
            <tr><td>pay_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Amount paid now when <code>payment_option</code> is <code>partial</code>.</td></tr>
            <tr><td>deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Account debited for the payment.</td></tr>
            <tr><td>items</td><td class="param-type">array</td><td>At least one received line.</td></tr>
            <tr><td>items[].purchase_item_id</td><td class="param-type">integer</td><td>The purchase order line item being received.</td></tr>
            <tr><td>items[].quantity_received<span class="param-required">opt</span></td><td class="param-type">number</td><td>Quantity received on this line.</td></tr>
            <tr><td>items[].selling_unit_price<span class="param-required">opt</span></td><td class="param-type">number</td><td>Selling price to set on the product for this receipt.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Goods receive note GRN-0031 recorded.",
  "data": {
    "id": 31,
    "grn_number": "GRN-0031",
    "purchase_id": 41,
    "po_number": "PO-0041",
    "supplier_name": "Ceylon Wholesale Traders",
    "received_date": "2026-07-31",
    "total": 144000.00,
    "payment_method": "cash",
    "payment_status": "paid_full",
    "payment_status_label": "Paid in full",
    "amount_paid": 144000.00,
    "amount_outstanding": 0.00,
    "reference": null,
    "notes": null,
    "subtotal": 144000.00,
    "items": [
      {
        "id": 56,
        "product_id": 18,
        "product_name": "Blue T-Shirt",
        "sku": "TS-BLU-001",
        "quantity_received": 120.000,
        "unit_cost": 1200.00,
        "selling_unit_price": 1800.00,
        "line_total": 144000.00
      }
    ],
    "payments": []
  }
}</code></pre>
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

  <div class="endpoint" id="ep-grns-pay">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/grns/{grn}/pay</code>
      <span class="endpoint-name">Record additional payment on a GRN</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Settles some or all of the outstanding balance on an existing GRN from a debit account, by cash, credit, or cheque. Fails with 422 if the GRN is already fully paid. Requires the <code>inv_purchasing</code> permission.</p>
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
            <tr><td>payment_method</td><td class="param-type">string</td><td><code>cash</code>, <code>credit</code>, or <code>cheque</code>.</td></tr>
            <tr><td>deduct_account_id</td><td class="param-type">integer</td><td>Account to debit.</td></tr>
            <tr><td>payment_option</td><td class="param-type">string</td><td><code>full</code> or <code>partial</code>.</td></tr>
            <tr><td>pay_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Required when <code>payment_option</code> is <code>partial</code>.</td></tr>
            <tr><td>payment_reference<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 chars.</td></tr>
            <tr><td>cheque_due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Used when paying by cheque.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Payment recorded.",
  "data": {
    "id": 30,
    "grn_number": "GRN-0030",
    "purchase_id": 41,
    "po_number": "PO-0041",
    "supplier_name": "Ceylon Wholesale Traders",
    "received_date": "2026-07-25",
    "total": 144000.00,
    "payment_method": "credit",
    "payment_status": "paid_full",
    "payment_status_label": "Paid in full",
    "amount_paid": 144000.00,
    "amount_outstanding": 0.00,
    "reference": null,
    "notes": null,
    "subtotal": 144000.00,
    "items": [],
    "payments": [
      { "id": 12, "amount": 144000.00, "account": "Main Account · BOC", "date": "2026-07-31" }
    ]
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This GRN is already fully paid."
}</code></pre>
      </div>
@endverbatim
