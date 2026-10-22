@verbatim
  <div class="endpoint" id="ep-expense-bill-assignment-targets">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/expenses/bill-assignment-targets</code>
      <span class="endpoint-name">Get assignment target options</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns id/name option lists for every assignable target type: branches, departments, properties, employees, modifications, and rentals. Each sub-list degrades to an empty array if its module's table isn't installed, so the endpoint never errors even when HR/Modification modules are absent.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "branches": [ { "id": 2, "name": "Main Branch" } ],
    "departments": [ { "id": 3, "name": "Operations" } ],
    "properties": [ { "id": 5, "name": "Colombo Warehouse · Warehouse" } ],
    "employees": [ { "id": 11, "name": "Nadeesha Perera  #EMP-011" } ],
    "modifications": [ { "id": 2, "name": "Store front repaint" } ],
    "rentals": [ { "id": 1, "name": "Shop space  ·  Retail unit" } ]
  }
}</code></pre>
      </div>
@endverbatim
