@verbatim
  <div class="endpoint" id="ep-today-summary-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/today-summary</code>
      <span class="endpoint-name">Get today's summary</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns today's completed sales (count, revenue, gross profit, hourly breakdown, by-payment-method breakdown), top 5 products and top 5 services by revenue, the 15 most recent sales, and a snapshot of pending/in-progress/today-completed service requests.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "sales": {
      "count": 24,
      "revenue": 186500.00,
      "gross_profit": 71200.00,
      "items_sold": 58,
      "by_method": {
        "cash": { "count": 15, "total": 102500.00 },
        "card": { "count": 9, "total": 84000.00 }
      },
      "hourly": [
        { "count": 0, "revenue": 0.0 },
        { "count": 3, "revenue": 18500.00 }
      ]
    },
    "service_requests": {
      "pending": 2,
      "in_progress": 1,
      "completed": 4,
      "list": [
        {
          "id": 340,
          "request_number": "SR-000340",
          "title": "Laptop screen repair",
          "status": "in_progress",
          "status_label": "In progress",
          "customer_name": "Nimal Silva",
          "scheduled_at": "2026-07-31T14:00:00+05:30",
          "total_price": 8500.00
        }
      ]
    },
    "top_products": [
      { "name": "Blue T-Shirt", "qty": 12, "revenue": 21600.00 }
    ],
    "top_services": [
      { "name": "Screen replacement", "qty": 3, "revenue": 25500.00 }
    ],
    "recent_sales": [
      {
        "id": 901,
        "sale_number": "SL-000901",
        "total": 12500.00,
        "payment_method": "cash",
        "sold_at": "2026-07-31T10:20:00+05:30",
        "items_count": 3
      }
    ]
  }
}</code></pre>
      </div>
@endverbatim
