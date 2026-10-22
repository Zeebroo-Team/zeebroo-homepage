@verbatim
  <div class="endpoint" id="ep-expense-bill-list-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/bills</code>
      <span class="endpoint-name">List all expense bills</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every expense bill for the business with overdue/fully-paid flags and its assignment target's display name resolved (property, employee, modification, department, rental, or branch). Not paginated. Returns an empty list if the <code>bills</code> table doesn't exist yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 77,
      "name": "Main branch electricity",
      "amount": 18000.00,
      "overdue": false,
      "is_fully_paid": false,
      "due_date": "2026-08-05",
      "due_date_fmt": "Aug 5, 2026",
      "actual_due_date_fmt": "",
      "first_install_date_fmt": "Aug 5, 2026",
      "payment_mode": "recurring",
      "category": "electricity",
      "category_label": "Electricity",
      "description": "",
      "recurring_type": "per_month",
      "agreement_until": "2027",
      "remind_days": 3,
      "notes": "",
      "amount_varies_by_usage": false,
      "property_name": "",
      "employee_name": "",
      "modification_name": "",
      "department_name": "",
      "rental_type": "",
      "branch_name": "Main Branch"
    }
  ]
}</code></pre>
      </div>
@endverbatim
