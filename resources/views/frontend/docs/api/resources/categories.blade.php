@verbatim
  <div class="endpoint" id="ep-categories-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/categories</code>
      <span class="endpoint-name">List product categories</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated list of product categories for the current business, with parent name, product count, and child count.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by category name.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>active</code> or <code>inactive</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 3,
      "name": "Apparel",
      "description": null,
      "parent_id": null,
      "parent_name": null,
      "is_active": true,
      "sort_order": 1,
      "products_count": 24,
      "children_count": 2
    }
  ],
  "meta": { "current_page": 1, "per_page": 50, "total": 9 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-categories-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/categories</code>
      <span class="endpoint-name">Create a category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a product category, optionally nested under a parent category.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Category name.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>&nbsp;</td></tr>
            <tr><td>parent_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Nullable; parent category id.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 11, "name": "Footwear", "parent_id": null, "is_active": true }
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

  <div class="endpoint" id="ep-categories-parent-options">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/categories/parent-options</code>
      <span class="endpoint-name">Options list for parent category selector</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a flattened, depth-indexed list of categories for building a "select parent category" dropdown, excluding the category currently being edited (and its descendants).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>exclude<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Exclude this category id (when editing).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 3, "name": "Apparel", "label": "Apparel", "depth": 0 },
    { "id": 7, "name": "Footwear", "label": "— Footwear", "depth": 1 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-categories-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/categories/{category}</code>
      <span class="endpoint-name">Update a category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a category's name, description, parent, or active status. <code>{category}</code> is route-model-bound and scoped to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>&nbsp;</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>&nbsp;</td></tr>
            <tr><td>parent_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Nullable.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 7, "name": "Footwear & Accessories" }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "A category cannot be its own parent.",
  "errors": { "parent_id": ["A category cannot be its own parent."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-categories-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/categories/{category}</code>
      <span class="endpoint-name">Delete a category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a category owned by the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Category deleted."
}</code></pre>
      </div>
@endverbatim
