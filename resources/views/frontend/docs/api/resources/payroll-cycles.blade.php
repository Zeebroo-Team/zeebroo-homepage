@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-payroll-cycles-list"><span class="method-badge method-get">GET</span> /hr/payroll/cycles</a>
    <a href="#ep-payroll-cycles-store"><span class="method-badge method-post">POST</span> /hr/payroll/cycles</a>
    <a href="#ep-payroll-cycles-show"><span class="method-badge method-get">GET</span> /hr/payroll/cycles/{cycle}</a>
    <a href="#ep-payroll-cycles-destroy"><span class="method-badge method-delete">DELETE</span> /hr/payroll/cycles/{cycle}</a>
    <a href="#ep-payroll-cycles-compute"><span class="method-badge method-post">POST</span> /hr/payroll/cycles/{cycle}/compute</a>
    <a href="#ep-payroll-cycles-finalize"><span class="method-badge method-post">POST</span> /hr/payroll/cycles/{cycle}/finalize</a>
    <a href="#ep-payroll-cycles-payment"><span class="method-badge method-post">POST</span> /hr/payroll/cycles/{cycle}/payment</a>
    <a href="#ep-payroll-cycles-salary-sheet"><span class="method-badge method-get">GET</span> /hr/payroll/cycles/{cycle}/salary-sheet</a>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles</code>
      <span class="endpoint-name">List payroll cycles</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists payroll cycles for the business, newest year/month first, each with its rule set name and total net pay. Also returns overall counts by status. Returns zeroed counts if the HR payroll tables have not been migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 7,
      "name": "July 2026",
      "year": 2026,
      "month": 7,
      "month_label": "July",
      "period_start": "2026-07-01",
      "period_end": "2026-07-31",
      "status": "finalized",
      "status_label": "Finalized",
      "rule_set_id": 1,
      "rule_set_name": "Sri Lanka Standard 2026",
      "currency": "LKR",
      "computed_at": "2026-07-28 10:15",
      "finalized_at": "2026-07-29 09:00",
      "items_count": 12,
      "total_net_pay": 1450000.0,
      "total_net_pay_fmt": "1,450,000.00"
    }
  ],
  "total_count": 7,
  "draft_count": 1,
  "computed_count": 1,
  "finalized_count": 5
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles</code>
      <span class="endpoint-name">Create a payroll cycle</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new payroll cycle in draft status for the given rule set, year, and month. Rejects with a 422 if the rule set does not belong to the business or a cycle already exists for that year/month.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>rule_set_id</td><td class="param-type">integer</td><td>Must belong to the current business.</td></tr>
            <tr><td>name</td><td class="param-type">string</td><td>Cycle name, max 140 chars.</td></tr>
            <tr><td>year</td><td class="param-type">integer</td><td>Between 2020 and 2100.</td></tr>
            <tr><td>month</td><td class="param-type">integer</td><td>Between 1 and 12.</td></tr>
            <tr><td>period_start</td><td class="param-type">date</td><td>Cycle period start date.</td></tr>
            <tr><td>period_end</td><td class="param-type">date</td><td>Must be on or after period_start.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 8,
    "name": "August 2026",
    "year": 2026,
    "month": 8,
    "month_label": "August",
    "period_start": "2026-08-01",
    "period_end": "2026-08-31",
    "status": "draft",
    "status_label": "Draft",
    "rule_set_id": 1,
    "rule_set_name": "Sri Lanka Standard 2026",
    "currency": "LKR",
    "computed_at": null,
    "finalized_at": null,
    "items_count": 0,
    "total_net_pay": 0,
    "total_net_pay_fmt": "0.00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "A payroll cycle for August 2026 already exists." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}</code>
      <span class="endpoint-name">Get cycle detail with items and summary</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the cycle with a computed summary (gross earnings, total deductions, net pay, and Sri Lanka statutory totals — EPF employee, ETF employer, APIT), whether a payment has been recorded, and every employee's payroll item for the cycle.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 7,
    "name": "July 2026",
    "year": 2026,
    "month": 7,
    "status": "finalized",
    "status_label": "Finalized",
    "rule_set_id": 1,
    "rule_set_name": "Sri Lanka Standard 2026",
    "currency": "LKR",
    "items_count": 12,
    "total_net_pay": 1450000.0,
    "summary": {
      "gross_earnings": 1800000.0,
      "total_deductions": 350000.0,
      "net_pay": 1450000.0,
      "epf_employee": 144000.0,
      "etf_employer": 54000.0,
      "apit": 60000.0,
      "gross_earnings_fmt": "1,800,000.00",
      "total_deductions_fmt": "350,000.00",
      "net_pay_fmt": "1,450,000.00",
      "epf_employee_fmt": "144,000.00",
      "etf_employer_fmt": "54,000.00",
      "apit_fmt": "60,000.00"
    },
    "is_paid": true,
    "items": [
      {
        "id": 101,
        "employee_id": 5,
        "employee_name": "Nimal Perera",
        "employee_code": "EMP-005",
        "status": "computed",
        "basic_salary": 120000.0,
        "basic_salary_fmt": "120,000.00",
        "overtime_amount": 0,
        "overtime_amount_fmt": "0.00",
        "gross_earnings": 150000.0,
        "gross_earnings_fmt": "150,000.00",
        "total_deductions": 29000.0,
        "total_deductions_fmt": "29,000.00",
        "net_pay": 121000.0,
        "net_pay_fmt": "121,000.00",
        "inputs_json": { "attendance_days": 22, "working_days": 22 },
        "has_errors": false,
        "errors": []
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}</code>
      <span class="endpoint-name">Delete a payroll cycle</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a payroll cycle and its items. Rejected with a 422 if a payment has already been recorded against the cycle (a ledger transaction exists).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Payroll cycle deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-compute">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}/compute</code>
      <span class="endpoint-name">Compute payroll for all employees in cycle</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Runs the cycle's rule set against every eligible employee, creating or refreshing each employee's payroll item and component breakdown. Blocked with a 422 once the cycle is finalized. Per-employee failures are collected into computation_errors rather than aborting the whole run.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Computed 12 employee(s).",
  "computation_errors": [],
  "data": {
    "id": 7,
    "status": "computed",
    "status_label": "Computed",
    "items_count": 12,
    "summary": {
      "gross_earnings": 1800000.0,
      "total_deductions": 350000.0,
      "net_pay": 1450000.0,
      "epf_employee": 144000.0,
      "etf_employer": 54000.0,
      "apit": 60000.0
    },
    "is_paid": false,
    "items": [ { "id": 101, "employee_id": 5, "status": "computed", "net_pay": 121000.0 } ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-finalize">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}/finalize</code>
      <span class="endpoint-name">Finalize a payroll cycle</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Finalizes a computed cycle, locking it against further recomputation. Rejected with a 422 if the cycle is already finalized, has errored items, or has not been computed yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Cycle finalized successfully.", "status": "finalized" }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Cannot finalize payroll cycle with errored items." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-payment">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}/payment</code>
      <span class="endpoint-name">Record payroll payment</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Records payment of the cycle's total net pay by deducting it from the given ledger account, creating a ledger transaction. Delegated to PayrollCyclePaymentService, which validates the account (must belong to the business, be active, and have sufficient balance where applicable).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>deduct_account_id</td><td class="param-type">integer</td><td>Ledger account to deduct the net pay total from.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Payment recorded successfully." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected deduct account id is invalid.",
  "errors": { "deduct_account_id": ["The selected deduct account id is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-cycles-salary-sheet">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}/salary-sheet</code>
      <span class="endpoint-name">Get formatted salary sheet for a cycle</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Builds a presentation-ready salary sheet for the cycle via PayrollSalarySheetPresentationService: a dynamic set of money columns derived from the rule set's active rules (plus variance-vs-previous-cycle columns), and one row per employee with values keyed by column.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "columns": [
      { "key": "basic_salary", "kind": "money", "label": "Basic Salary" },
      { "key": "gross_earnings", "kind": "money", "label": "Gross Earnings" },
      { "key": "net_pay", "kind": "money", "label": "Net Pay", "emphasize": true },
      { "key": "var_net", "kind": "money", "label": "Δ Net", "emphasize": true }
    ],
    "rows": [
      {
        "employee_name": "Nimal Perera",
        "employee_id": "EMP-005",
        "payroll_item_id": 101,
        "status": "Computed",
        "values": { "basic_salary": 120000.0, "gross_earnings": 150000.0, "net_pay": 121000.0, "var_net": 1500.0 },
        "variance": { "gross": 1500.0, "deductions": 0.0, "net": 1500.0 }
      }
    ],
    "variance": { "previous_cycle_label": "June 2026" }
  }
}</code></pre>
      </div>
@endverbatim
