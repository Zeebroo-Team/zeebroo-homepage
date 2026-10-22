@verbatim
  <div class="endpoint" id="ep-payroll-overview-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/payroll-overview</code>
      <span class="endpoint-name">Get payroll overview dashboard data</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns aggregated HR/payroll dashboard data for the business: employee counts by employment type, department count and salary breakdown, payroll cycle status counts, the latest 8 cycles, KPIs and top 8 earners from the last finalized cycle, and a 12-month gross/net trend built from finalized cycles. All figures default to zero/empty if the underlying HR or payroll tables are not yet migrated.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "summary": {
      "emp_total": 18,
      "emp_full_time": 14,
      "emp_part_time": 3,
      "emp_contract": 1,
      "dept_count": 4,
      "pending_cycles": 1,
      "last_cycle_label": "July 2026",
      "last_cycle_gross": 1800000.0,
      "last_cycle_net": 1450000.0,
      "last_cycle_deductions": 350000.0,
      "last_cycle_emp_count": 12
    },
    "trend": {
      "labels": ["Aug '25", "Sep '25", "Oct '25", "Jul '26"],
      "gross": [1700000.0, 1720000.0, 1750000.0, 1800000.0],
      "net": [1380000.0, 1390000.0, 1410000.0, 1450000.0]
    },
    "recent_cycles": [
      { "id": 7, "name": "July 2026", "status": "finalized", "gross": 1800000.0, "net": 1450000.0, "emp_count": 12, "period_start": "2026-07-01", "period_end": "2026-07-31", "finalized_at": "2026-07-29 09:00:00" }
    ],
    "top_earners": [
      { "name": "Nimal Perera", "gross": 250000.0, "deductions": 45000.0, "net": 205000.0 }
    ],
    "dept_breakdown": [
      { "name": "Operations", "emp_count": 8, "total_salary": 960000.0 }
    ]
  }
}</code></pre>
      </div>
@endverbatim
