@verbatim
  <div class="endpoint" id="ep-finance-flow-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/finance/flow</code>
      <span class="endpoint-name">Get combined finance flow</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists all bills, loans, and rentals with each one's monthly-equivalent cost (per-day/per-year cadences normalized to a 30-day month) and overdue flag, plus a totals summary across all three.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "business_name": "Zeebroo Retail",
  "bills": [
    {
      "id": 77,
      "name": "Main branch electricity",
      "category_label": "Electricity",
      "is_one_time": false,
      "amount_fmt": "18,000.00",
      "cadence": "Per month",
      "overdue": false,
      "property_id": null
    }
  ],
  "loans": [
    {
      "id": 3,
      "name": "Equipment loan",
      "monthly_fmt": "45,000.00",
      "cadence": "Per month",
      "overdue": false
    }
  ],
  "rentals": [
    {
      "id": 1,
      "name": "Shop space",
      "cost_fmt": "85,000.00",
      "cadence": "Per month",
      "overdue": false
    }
  ],
  "summary": {
    "bills_count": 4,
    "bills_overdue": 0,
    "bills_monthly_fmt": "32,000.00",
    "loans_count": 1,
    "loans_monthly_fmt": "45,000.00",
    "rentals_count": 1,
    "rentals_overdue": 0,
    "rentals_monthly_fmt": "85,000.00",
    "total_monthly_fmt": "162,000.00",
    "total_items": 6
  }
}</code></pre>
      </div>
@endverbatim
