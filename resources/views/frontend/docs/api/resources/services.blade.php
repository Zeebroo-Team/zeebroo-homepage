@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-services-catalog-index"><span class="method-badge method-get">GET</span> /service/catalog</a>
    <a href="#ep-services-catalog-store"><span class="method-badge method-post">POST</span> /service/catalog</a>
    <a href="#ep-services-catalog-show"><span class="method-badge method-get">GET</span> /service/catalog/{serviceItem}</a>
    <a href="#ep-services-catalog-update"><span class="method-badge method-patch">PATCH</span> /service/catalog/{serviceItem}</a>
    <a href="#ep-services-catalog-destroy"><span class="method-badge method-delete">DELETE</span> /service/catalog/{serviceItem}</a>
    <a href="#ep-services-catalog-employees-sync"><span class="method-badge method-put">PUT</span> /service/catalog/{serviceItem}/employees</a>
    <a href="#ep-services-catalog-products-sync"><span class="method-badge method-put">PUT</span> /service/catalog/{serviceItem}/products</a>
    <a href="#ep-services-categories-index"><span class="method-badge method-get">GET</span> /service/categories</a>
    <a href="#ep-services-categories-store"><span class="method-badge method-post">POST</span> /service/categories</a>
    <a href="#ep-services-categories-destroy"><span class="method-badge method-delete">DELETE</span> /service/categories/{serviceCategory}</a>
    <a href="#ep-services-requests-index"><span class="method-badge method-get">GET</span> /service/requests</a>
    <a href="#ep-services-requests-store"><span class="method-badge method-post">POST</span> /service/requests</a>
    <a href="#ep-services-requests-status"><span class="method-badge method-patch">PATCH</span> /service/requests/{serviceRequest}/status</a>
  </div>

  <div class="endpoint" id="ep-services-catalog-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog</code>
      <span class="endpoint-name">List service catalog</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists service items for the current business, ordered by name, with each item's assigned categories. Supports a free-text search across name and description.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search term matched against service name or description.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 5,
      "name": "Haircut &amp; Styling",
      "description": "Wash, cut, and blow-dry",
      "price": 2500.00,
      "duration_label": "45m",
      "is_active": true,
      "has_warranty": false,
      "categories": ["Hair", "Grooming"]
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-catalog-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog</code>
      <span class="endpoint-name">Create service item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new service item, optionally attaching service categories, employees who can perform it, and product lines consumed per booking (via <code>PosServiceApiController@store</code> → <code>ServiceItemService::create()</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>price</td><td class="param-type">numeric</td><td>Minimum 0.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>duration_minutes<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Expected service duration.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
            <tr><td>is_featured<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to false.</td></tr>
            <tr><td>has_warranty<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to false.</td></tr>
            <tr><td>service_category_ids<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Category IDs to attach.</td></tr>
            <tr><td>employee_ids<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Employees who can perform this service.</td></tr>
            <tr><td>product_lines<span class="param-required">opt</span></td><td class="param-type">array</td><td>Array of <code>{product_id, qty}</code> — products consumed per booking.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "name": "Deep Tissue Massage",
    "description": "60-minute full body massage",
    "price": 6000.00,
    "duration_label": "1h",
    "is_active": true,
    "is_featured": false,
    "has_warranty": true,
    "categories": ["Spa"]
  },
  "message": "Service created."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name field is required.",
  "errors": { "name": ["The name field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-catalog-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog/{serviceItem}</code>
      <span class="endpoint-name">Get service item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns full detail for a single service item, including its assigned categories, employees, and consumed product lines. 404s if the item does not belong to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "name": "Deep Tissue Massage",
    "description": "60-minute full body massage",
    "price": 6000.00,
    "duration_minutes": 60,
    "duration_label": "1h",
    "is_active": true,
    "is_featured": false,
    "has_warranty": true,
    "categories": [{ "id": 3, "name": "Spa" }],
    "employees": [{ "id": 8, "name": "Nadia Perera", "job_title": "Therapist" }],
    "products": [{ "id": 44, "name": "Massage Oil", "qty": 0.05, "unit": "L" }]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-catalog-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog/{serviceItem}</code>
      <span class="endpoint-name">Update service item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a service item's core fields and re-syncs its categories, employees, and product lines. Note: despite the PATCH verb, <code>name</code> and <code>price</code> are still validated as required (full replace of scalar fields).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>price</td><td class="param-type">numeric</td><td>Minimum 0.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>duration_minutes<span class="param-required">opt</span></td><td class="param-type">integer</td><td>—</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Falls back to existing value if omitted.</td></tr>
            <tr><td>is_featured<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Falls back to existing value if omitted.</td></tr>
            <tr><td>has_warranty<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Falls back to existing value if omitted.</td></tr>
            <tr><td>service_category_ids<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Replaces the full category set.</td></tr>
            <tr><td>employee_ids<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Replaces the full employee set.</td></tr>
            <tr><td>product_lines<span class="param-required">opt</span></td><td class="param-type">array</td><td>Replaces the full product-line set with <code>{product_id, qty}</code> entries.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 12,
    "name": "Deep Tissue Massage",
    "description": "75-minute full body massage",
    "price": 7000.00,
    "duration_label": "1h 15m",
    "is_active": true,
    "is_featured": true,
    "has_warranty": true,
    "categories": ["Spa"]
  },
  "message": "Service updated."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The price must be at least 0.",
  "errors": { "price": ["The price must be at least 0."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-catalog-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog/{serviceItem}</code>
      <span class="endpoint-name">Delete service item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a service item. 404s if it does not belong to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Service deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-catalog-employees-sync">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog/{serviceItem}/employees</code>
      <span class="endpoint-name">Sync assigned employees</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the full set of employees able to perform this service item (pivot table sync — sending an empty array clears all assignments).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>employee_ids</td><td class="param-type">integer[]</td><td>Must be present (may be empty). Full replacement list of employee IDs.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 8, "name": "Nadia Perera", "job_title": "Therapist" }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-catalog-products-sync">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/service/catalog/{serviceItem}/products</code>
      <span class="endpoint-name">Sync consumed products</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the full set of products/quantities consumed each time this service is performed (pivot table sync with a <code>qty</code> column).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>product_lines</td><td class="param-type">array</td><td>Must be present (may be empty). Each entry: <code>product_id</code> (integer, required), <code>qty</code> (numeric, min 0.001, required).</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 44, "name": "Massage Oil", "qty": 0.05, "unit": "L" }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-categories-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/service/categories</code>
      <span class="endpoint-name">List service categories</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists service categories for the business, ordered by sort order then name, each annotated with its service item count.</p>
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
      "name": "Spa",
      "description": "Relaxation and wellness treatments",
      "is_active": true,
      "sort_order": 1,
      "service_items_count": 6
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-categories-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/service/categories</code>
      <span class="endpoint-name">Create service category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new service category for the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 characters.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
            <tr><td>sort_order<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Defaults to 0.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "name": "Hair",
    "description": null,
    "is_active": true,
    "sort_order": 0,
    "service_items_count": 0
  },
  "message": "Category created."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name field is required.",
  "errors": { "name": ["The name field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-categories-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/service/categories/{serviceCategory}</code>
      <span class="endpoint-name">Delete service category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a service category. 404s if it does not belong to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_catalog</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Category deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-requests-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/service/requests</code>
      <span class="endpoint-name">List service requests</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists customer service requests for the business (bookings/work orders against the service catalog), with optional keyword and status filters. Each request eager-loads its linked project management project.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text search term.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filter by status (e.g. <code>pending</code>, <code>in_progress</code>, <code>completed</code>, <code>cancelled</code>).</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 21,
      "request_number": "SR-0021",
      "title": "AC repair — Unit 4",
      "status": "pending",
      "status_label": "Pending",
      "status_color": "#f59e0b",
      "total_price": 4500.00,
      "scheduled_at": "2026-08-02T09:00:00+00:00",
      "notes": "Customer reports no cooling",
      "customer": { "id": 7, "name": "Kasun Silva" },
      "service_item": { "id": 12, "name": "AC Repair" },
      "project": null,
      "project_id": null,
      "created_at": "2026-07-30T06:12:00+00:00"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-requests-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/service/requests</code>
      <span class="endpoint-name">Create service request</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new service request for the business. If a <code>project_id</code> is supplied it must resolve to a Project Management project belonging to the same business, or the request fails with a 422.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_requests</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
            <tr><td>service_item_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Related service catalog item.</td></tr>
            <tr><td>customer_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Related customer.</td></tr>
            <tr><td>project_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must belong to the current business if supplied.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>scheduled_at<span class="param-required">opt</span></td><td class="param-type">date</td><td>—</td></tr>
            <tr><td>total_price<span class="param-required">opt</span></td><td class="param-type">numeric</td><td>Minimum 0.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 22,
    "request_number": "SR-0022",
    "title": "Sofa upholstery cleaning",
    "status": "pending",
    "status_label": "Pending",
    "status_color": "#f59e0b",
    "total_price": null,
    "scheduled_at": null,
    "notes": null,
    "customer": null,
    "service_item": null,
    "project": null,
    "project_id": null,
    "created_at": "2026-07-31T08:00:00+00:00"
  },
  "message": "Request created."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Project not found." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-services-requests-status">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/service/requests/{serviceRequest}/status</code>
      <span class="endpoint-name">Update request status</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a service request's status and, optionally, its linked project. When the status is set to <code>in_progress</code> and the request has a linked project, a Project Management task is auto-created unless <code>create_task</code> is explicitly false (defaults to true).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: svc_requests</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status</td><td class="param-type">string</td><td>One of <code>pending</code>, <code>in_progress</code>, <code>completed</code>, <code>cancelled</code>.</td></tr>
            <tr><td>project_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Reassigns the linked project (must belong to this business).</td></tr>
            <tr><td>create_task<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true. Set false to skip auto-creating a PM task when moving to <code>in_progress</code>.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 21,
    "request_number": "SR-0021",
    "title": "AC repair — Unit 4",
    "status": "in_progress",
    "status_label": "In Progress",
    "status_color": "#3b82f6",
    "total_price": 4500.00,
    "scheduled_at": "2026-08-02T09:00:00+00:00",
    "notes": "Customer reports no cooling",
    "customer": { "id": 7, "name": "Kasun Silva" },
    "service_item": { "id": 12, "name": "AC Repair" },
    "project": { "id": 3, "name": "Facilities" },
    "project_id": 3,
    "created_at": "2026-07-30T06:12:00+00:00"
  },
  "pm_task": { "id": 88, "title": "AC repair — Unit 4 — AC Repair" },
  "message": "Status updated."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected status is invalid.",
  "errors": { "status": ["The selected status is invalid."] }
}</code></pre>
      </div>
@endverbatim
