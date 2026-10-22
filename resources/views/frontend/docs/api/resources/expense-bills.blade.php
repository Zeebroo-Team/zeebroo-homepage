@verbatim
  <div class="endpoint" id="ep-expense-bills-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/expenses/bills</code>
      <span class="endpoint-name">Create an expense bill</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a recurring or one-time expense bill, optionally assigned to a branch, department, property, employee, modification, or rental. Requires the <code>fin_bills</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_bills</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Bill name, max 255 chars.</td></tr>
            <tr><td>payment_mode</td><td class="param-type">string</td><td><code>recurring</code> or <code>one_time</code>.</td></tr>
            <tr><td>bill_category</td><td class="param-type">string</td><td>One of <code>water</code>, <code>electricity</code>, <code>telephone</code>, <code>internet</code>, <code>gas</code>, <code>waste</code>, <code>other</code>.</td></tr>
            <tr><td>bill_category_other<span class="param-required">opt</span></td><td class="param-type">string</td><td>Required when <code>bill_category</code> is <code>other</code>.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
            <tr><td>assignment_type<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>none</code>, <code>branch</code>, <code>department</code>, <code>property</code>, <code>employee</code>, <code>modification</code>, or <code>rental</code>.</td></tr>
            <tr><td>branch_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>assignment_type</code> is <code>branch</code>.</td></tr>
            <tr><td>department_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>assignment_type</code> is <code>department</code>.</td></tr>
            <tr><td>property_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>assignment_type</code> is <code>property</code>.</td></tr>
            <tr><td>employee_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>assignment_type</code> is <code>employee</code>.</td></tr>
            <tr><td>modification_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>assignment_type</code> is <code>modification</code>.</td></tr>
            <tr><td>rental_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>assignment_type</code> is <code>rental</code>.</td></tr>
            <tr><td>deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Default account to debit on payment.</td></tr>
            <tr><td>amount_varies_by_usage<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>When true, each period's charge is declared at payment time instead of a fixed amount.</td></tr>
            <tr><td>recurring_cost<span class="param-required">opt</span></td><td class="param-type">number</td><td>Required unless <code>amount_varies_by_usage</code> is true.</td></tr>
            <tr><td>recurring_type<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>per_day</code>, <code>per_month</code>, or <code>per_year</code>. Required when <code>payment_mode</code> is <code>recurring</code>.</td></tr>
            <tr><td>agreement_valid_until_year<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when recurring; auto-derived from the due date for one-time bills.</td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Required for one-time bills unless <code>first_installment_due_date</code> is set.</td></tr>
            <tr><td>first_installment_due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>First billing date for recurring schedules.</td></tr>
            <tr><td>remind_before_days<span class="param-required">opt</span></td><td class="param-type">integer</td><td>0–366.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "message": "Bill created successfully.",
  "data": {
    "id": 77,
    "name": "Main branch electricity",
    "bill_category": "electricity",
    "bill_category_other": null,
    "payment_mode": "recurring",
    "recurring_cost": 18000.00,
    "recurring_type": "per_month",
    "agreement_valid_until_year": 2027,
    "first_installment_due_date": "2026-08-05",
    "due_date": null,
    "remind_before_days": 3,
    "amount_varies_by_usage": false,
    "allow_split_payment": true,
    "assignment_type": "branch",
    "branch_id": 2,
    "department_id": null,
    "property_id": null,
    "employee_id": null,
    "modification_id": null,
    "rental_property_related": false,
    "rental_id": null,
    "deduct_account_id": 4,
    "description": null,
    "notes": null
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Describe this bill when you choose Other.",
  "errors": { "bill_category_other": ["Describe this bill when you choose Other."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-expense-bills-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/bills/{bill}</code>
      <span class="endpoint-name">Get bill detail</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns bill detail with its billing schedule (including per-period paid status) and ledger transaction history. 404s if the bill does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 77,
    "name": "Main branch electricity",
    "bill_category": "electricity",
    "payment_mode": "recurring",
    "recurring_cost": 18000.00,
    "recurring_type": "per_month",
    "agreement_valid_until_year": 2027,
    "first_installment_due_date": "2026-08-05",
    "due_date": null,
    "amount_varies_by_usage": false,
    "allow_split_payment": true,
    "assignment_type": "branch",
    "is_overdue": false,
    "is_fully_paid": false,
    "account": { "id": 4, "account_name": "Main Account", "bank_name": "BOC" },
    "assignment_name": null,
    "schedule": [
      {
        "period": "Aug 2026",
        "due_ymd": "2026-08-05",
        "amount_formatted": "18,000.00",
        "amount_varies": false,
        "paid": false,
        "partially_paid": false,
        "paid_total": 0.00,
        "paid_total_formatted": "0.00",
        "outstanding_formatted": "18,000.00",
        "needs_period_charge_declaration": false,
        "past_due_unpaid": false,
        "status_label": "Upcoming",
        "period_charge_declared": null
      }
    ],
    "ledger": []
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-expense-bills-pay">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/expenses/bills/{bill}/pay</code>
      <span class="endpoint-name">Record a bill payment</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Records a payment against a specific billing period — in full, partially, or split across several debit accounts. Requires the <code>fin_bills</code> permission.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_bills</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>occurrence_date</td><td class="param-type">date</td><td>The billing period being paid.</td></tr>
            <tr><td>payment_option</td><td class="param-type">string</td><td><code>full</code>, <code>partial</code>, or <code>split</code>.</td></tr>
            <tr><td>deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Required when <code>payment_option</code> is <code>full</code> or <code>partial</code>.</td></tr>
            <tr><td>partial_amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Required when <code>payment_option</code> is <code>partial</code>.</td></tr>
            <tr><td>split_rows<span class="param-required">opt</span></td><td class="param-type">array</td><td>Required when <code>payment_option</code> is <code>split</code>; needs at least two lines with distinct accounts.</td></tr>
            <tr><td>split_rows[].deduct_account_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Account for this split line.</td></tr>
            <tr><td>split_rows[].amount<span class="param-required">opt</span></td><td class="param-type">number</td><td>Amount for this split line.</td></tr>
            <tr><td>period_charge_total<span class="param-required">opt</span></td><td class="param-type">number</td><td>Required for the period when the bill has <code>amount_varies_by_usage</code> and no total has been declared yet.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Bill payment recorded and account balance updated."
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Validation failed.",
  "errors": { "occurrence_date": ["This billing date is already fully paid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-expense-bills-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/expenses/bills/{bill}</code>
      <span class="endpoint-name">Delete a bill</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes an expense bill for the current business. Requires the <code>fin_bills</code> permission; returns 403 if the underlying service refuses the delete (e.g. payments already recorded, depending on business rules).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires permission: fin_bills</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Bill deleted successfully."
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Unable to delete this bill."
}</code></pre>
      </div>
@endverbatim
