@verbatim
  <div class="endpoint" id="ep-payroll-items-recompute">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/cycles/{cycle}/items/{item}/recompute</code>
      <span class="endpoint-name">Recompute a single employee payroll item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Recomputes one employee's payroll item using the given overrides (overtime, attendance, leave-without-pay days, salary advance, stamp duty) merged with the cycle's rule set. Returns 404 if the item does not belong to the cycle, and 422 if the cycle is already finalized.</p>
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
            <tr><td>overtime_hours<span class="param-required">opt</span></td><td class="param-type">number</td><td>0 to 1000.</td></tr>
            <tr><td>overtime_rate<span class="param-required">opt</span></td><td class="param-type">number</td><td>Rate per overtime hour, 0 to 999999.99.</td></tr>
            <tr><td>attendance_days<span class="param-required">opt</span></td><td class="param-type">number</td><td>0 to 31.</td></tr>
            <tr><td>working_days<span class="param-required">opt</span></td><td class="param-type">number</td><td>0 to 31.</td></tr>
            <tr><td>leave_without_pay_days<span class="param-required">opt</span></td><td class="param-type">number</td><td>0 to 31.</td></tr>
            <tr><td>salary_advance<span class="param-required">opt</span></td><td class="param-type">number</td><td>Deducted from net pay, 0 to 99999999999.99.</td></tr>
            <tr><td>stamp_duty<span class="param-required">opt</span></td><td class="param-type">number</td><td>0 to 999999.99.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 101,
    "employee_id": 5,
    "employee_name": "Nimal Perera",
    "employee_code": "EMP-005",
    "status": "computed",
    "basic_salary": 120000.0,
    "basic_salary_fmt": "120,000.00",
    "overtime_amount": 4500.0,
    "overtime_amount_fmt": "4,500.00",
    "gross_earnings": 154500.0,
    "gross_earnings_fmt": "154,500.00",
    "total_deductions": 29000.0,
    "total_deductions_fmt": "29,000.00",
    "net_pay": 125500.0,
    "net_pay_fmt": "125,500.00",
    "inputs_json": { "overtime_hours": 6, "overtime_rate": 750 },
    "has_errors": false,
    "errors": []
  },
  "errors": []
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The overtime hours field must be between 0 and 1000.",
  "errors": { "overtime_hours": ["The overtime hours field must be between 0 and 1000."] }
}</code></pre>
      </div>
@endverbatim
