@verbatim
  <div class="endpoint" id="ep-rentals-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/rentals</code>
      <span class="endpoint-name">List rental agreements</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists rental agreements for the business with overdue-payment status computed per rental, plus active/overdue counts and total monthly-equivalent rent.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1,
      "property_type": "Shop space",
      "purpose": "Retail unit",
      "name": "Shop space · Retail unit",
      "recurring_cost": 85000.00,
      "recurring_cost_fmt": "85,000.00",
      "recurring_type": "per_month",
      "cadence_label": "Per month",
      "key_money": 250000.00,
      "key_money_fmt": "250,000.00",
      "agreement_valid_until_year": 2028,
      "due_date": "2026-08-01",
      "due_date_fmt": "Aug 1, 2026",
      "notes": null,
      "overdue": false,
      "account_name": "Main Account",
      "account_number": "0041000123",
      "account_bank_name": "Bank of Ceylon",
      "account_type_name": "Current",
      "account_balance": "520,000.00"
    }
  ],
  "active_count": 1,
  "overdue_count": 0,
  "total_monthly_fmt": "85,000.00"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-rentals-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/rentals</code>
      <span class="endpoint-name">Create a rental agreement</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a rental agreement and upserts the landlord into the business's address book (matched on email/phone). At least one of <code>owner_email</code> or <code>owner_phone</code> must be provided. Requires the <code>fin_assets</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_assets</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>property_type</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>purpose<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
            <tr><td>key_money<span class="param-required">opt</span></td><td class="param-type">number</td><td>Upfront deposit / key money.</td></tr>
            <tr><td>agreement_valid_until_year</td><td class="param-type">integer</td><td>2000–2100.</td></tr>
            <tr><td>deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Default account for rent payments.</td></tr>
            <tr><td>recurring_cost</td><td class="param-type">number</td><td>Rent amount.</td></tr>
            <tr><td>recurring_type</td><td class="param-type">string</td><td><code>per_day</code>, <code>per_month</code>, or <code>per_year</code>.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>remind_before_days<span class="param-required">opt</span></td><td class="param-type">integer</td><td>0–366.</td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Next/anchor due date.</td></tr>
            <tr><td>first_installment_due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>First rent due date.</td></tr>
            <tr><td>owner_name</td><td class="param-type">string</td><td>Landlord name, max 255 chars.</td></tr>
            <tr><td>owner_email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Landlord email — required unless <code>owner_phone</code> is set.</td></tr>
            <tr><td>owner_phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Landlord phone — required unless <code>owner_email</code> is set.</td></tr>
            <tr><td>owner_address<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
            <tr><td>owner_bank_details<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>owner_notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars, stored on the address book contact.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Rental created successfully.",
  "data": {
    "id": 2,
    "property_type": "Storage unit",
    "purpose": "Overflow stock",
    "name": "Storage unit · Overflow stock",
    "recurring_cost": 22000.00,
    "recurring_cost_fmt": "22,000.00",
    "recurring_type": "per_month",
    "cadence_label": "Per month",
    "key_money": null,
    "agreement_valid_until_year": 2028,
    "due_date": "2026-09-01",
    "due_date_fmt": "Sep 1, 2026",
    "notes": null,
    "overdue": false,
    "account_name": null,
    "account_number": null,
    "account_bank_name": null,
    "account_type_name": null,
    "account_balance": null
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Provide landlord email or phone so we can save them once in your address book.",
  "errors": { "owner_email": ["Provide landlord email or phone."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-rentals-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/rentals/{rental}</code>
      <span class="endpoint-name">Get rental detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns rental detail with billing schedule, linked expense bills, landlord contact info, and the branch/warehouse it's tied to (if any). 404s if the rental does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 1,
    "property_type": "Shop space",
    "purpose": "Retail unit",
    "recurring_cost": 85000.00,
    "recurring_cost_fmt": "85,000.00",
    "overdue": false,
    "schedule": [
      {
        "period": "Aug 2026",
        "due_ymd": "2026-08-01",
        "amount_formatted": "85,000.00",
        "paid": false,
        "past_due_unpaid": false,
        "status_label": "Upcoming"
      }
    ],
    "bills": [],
    "landlord": {
      "name": "W. Fernando",
      "email": "wfernando@example.com",
      "phone": "+94771234567",
      "street_address": "12 Galle Road, Colombo",
      "bank_account_details": null,
      "notes": null
    },
    "warehouse_name": null
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-rentals-pay">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/rentals/{rental}/pay</code>
      <span class="endpoint-name">Record a rent payment</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Records a rent payment for the given due date, debiting the specified account. Requires the <code>fin_assets</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_assets</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>due_date</td><td class="param-type">date</td><td>The rent period being paid.</td></tr>
            <tr><td>account_id</td><td class="param-type">integer</td><td>Account to debit.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Rent payment recorded successfully."
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This rent period is already fully paid."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-rentals-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/rentals/{rental}</code>
      <span class="endpoint-name">Delete a rental</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a rental agreement. Requires the <code>fin_assets</code> permission; returns 403 if the underlying service refuses the delete.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_assets</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Rental deleted successfully."
}</code></pre>
      </div>
@endverbatim
