@verbatim
  <div class="endpoint" id="ep-expenses-overview-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/overview</code>
      <span class="endpoint-name">Get expenses overview</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a summary of monthly bill/rental outflow, overdue counts, a category cost breakdown, a 12-month bills-vs-rentals trend, and the 15 most recent ledger payments across bills and rentals. Any tables that don't exist yet (bills, rentals, modifications, ledger_transactions) degrade to empty/zeroed sections rather than erroring.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "summary": {
      "bills_monthly": 32000.00,
      "bills_count": 4,
      "overdue_count": 1,
      "rentals_monthly": 85000.00,
      "mods_total": 340000.00,
      "total_monthly": 117000.00
    },
    "category_breakdown": [
      { "category": "electricity", "total": 18000.00 },
      { "category": "water", "total": 14000.00 }
    ],
    "monthly_trend": {
      "months": ["Aug 25", "Sep 25", "..."],
      "bills": [32000.00, 30500.00],
      "rentals": [85000.00, 85000.00]
    },
    "bills": [
      {
        "id": 77,
        "name": "Main branch electricity",
        "amount": 18000.00,
        "category": "electricity",
        "category_label": "Electricity",
        "payment_mode": "recurring",
        "recurring_type": "per_month",
        "due_date_fmt": "Aug 5, 2026",
        "overdue": false,
        "fully_paid": false,
        "amount_varies": false,
        "paid_total": 0.00,
        "notes": ""
      }
    ],
    "rentals": [
      { "id": 1, "name": "Shop space · Retail unit", "amount": 85000.00 }
    ],
    "modifications": [
      { "id": 2, "name": "Store front repaint", "amount": 250000.00 }
    ],
    "recent_payments": [
      {
        "id": 501,
        "amount": 18000.00,
        "date_fmt": "Jul 5, 2026",
        "source_label": "Bill",
        "source_title": "Main branch electricity"
      }
    ]
  }
}</code></pre>
      </div>
@endverbatim
