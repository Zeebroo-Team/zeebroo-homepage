@verbatim
  <div class="endpoint" id="ep-loans-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/loans</code>
      <span class="endpoint-name">List loans</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists loans for the business with each one's computed approximate monthly payment, plus aggregate totals across currently-active loans (those with no end date or an end date in the future).</p>
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
      "name": "Equipment loan",
      "description": null,
      "bank_id": 2,
      "bank_name": "Bank of Ceylon",
      "borrowed_amount": 1500000.00,
      "borrowed_amount_fmt": "1,500,000.00",
      "interest_rate_type": "percentage",
      "interest_rate_type_label": "Percentage",
      "interest_rate": 12.5,
      "recurring_type": "per_month",
      "first_installment_due_date": "2026-02-01",
      "first_installment_due_fmt": "Feb 1, 2026",
      "loan_ending_date": "2029-02-01",
      "loan_ending_date_fmt": "Feb 1, 2029",
      "remind_before_days": 5,
      "deduct_account_id": 4,
      "account_name": "Main Account",
      "account_number": "0041000123",
      "account_bank_name": "Bank of Ceylon",
      "account_type_name": "Current",
      "account_balance": "520,000.00",
      "payment_formatted": "45,000.00",
      "approx_monthly_formatted": "45,000.00",
      "period_count": 36,
      "period_source": "loan_ending_date",
      "cadence_label": "Per month"
    }
  ],
  "active_count": 1,
  "total_principal": 1500000.00,
  "total_principal_fmt": "1,500,000.00",
  "total_monthly_outflow": 45000.00,
  "total_monthly_fmt": "45,000.00"
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-loans-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/loans</code>
      <span class="endpoint-name">Create a loan</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a loan record with an interest rate, repayment cadence, and optional deduction account.</p>
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
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
            <tr><td>bank_id</td><td class="param-type">integer</td><td>Lending bank.</td></tr>
            <tr><td>borrowed_amount</td><td class="param-type">number</td><td>Principal amount.</td></tr>
            <tr><td>interest_rate_type</td><td class="param-type">string</td><td><code>percentage</code> or <code>flat</code>.</td></tr>
            <tr><td>interest_rate</td><td class="param-type">number</td><td>Rate value.</td></tr>
            <tr><td>recurring_type</td><td class="param-type">string</td><td><code>per_day</code>, <code>per_month</code>, or <code>per_year</code>.</td></tr>
            <tr><td>first_installment_due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>First installment date.</td></tr>
            <tr><td>loan_ending_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Final installment date.</td></tr>
            <tr><td>deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Account debited on payment.</td></tr>
            <tr><td>remind_before_days<span class="param-required">opt</span></td><td class="param-type">integer</td><td>0–365.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Loan created successfully.",
  "data": {
    "id": 4,
    "name": "Delivery van loan",
    "bank_id": 2,
    "bank_name": "Bank of Ceylon",
    "borrowed_amount": 3200000.00,
    "borrowed_amount_fmt": "3,200,000.00",
    "interest_rate_type": "percentage",
    "interest_rate": 10.0,
    "recurring_type": "per_month",
    "first_installment_due_date": "2026-09-01",
    "loan_ending_date": "2031-09-01",
    "remind_before_days": null,
    "deduct_account_id": null,
    "payment_formatted": "68,266.67",
    "approx_monthly_formatted": "68,266.67",
    "period_count": 60,
    "period_source": "loan_ending_date",
    "cadence_label": "Per month"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The bank id field is required.",
  "errors": { "bank_id": ["The bank id field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-loans-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/loans/{loan}</code>
      <span class="endpoint-name">Get loan detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns loan detail plus the full installment schedule with each installment's paid/overdue status. 404s if the loan does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "name": "Equipment loan",
    "borrowed_amount": 1500000.00,
    "interest_rate_type": "percentage",
    "interest_rate": 12.5,
    "recurring_type": "per_month",
    "payment_formatted": "45,000.00",
    "approx_monthly_formatted": "45,000.00",
    "schedule": [
      {
        "period": "Aug 2026",
        "due_ymd": "2026-08-01",
        "amount_formatted": "45,000.00",
        "paid": false,
        "paid_via_ledger": false,
        "past_due_unpaid": false,
        "status_label": "Upcoming"
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-loans-pay">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/loans/{loan}/pay</code>
      <span class="endpoint-name">Record a loan installment payment</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Records an installment as paid, either through the ledger (debiting a business account) or as an "external" mark (paid outside the system, no ledger entry).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>due_date</td><td class="param-type">date</td><td>The installment period being paid.</td></tr>
            <tr><td>recording_option</td><td class="param-type">string</td><td><code>ledger</code> or <code>external</code>.</td></tr>
            <tr><td>account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>recording_option</code> is <code>ledger</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Installment recorded successfully."
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "This installment has already been recorded."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-loans-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/loans/{loan}</code>
      <span class="endpoint-name">Delete a loan</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a loan record for the current business. Returns 403 if the underlying service refuses the delete.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Loan deleted successfully."
}</code></pre>
      </div>
@endverbatim
