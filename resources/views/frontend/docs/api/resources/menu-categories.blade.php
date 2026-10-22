@verbatim
  <div class="endpoint" id="ep-menu-categories-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-categories</code>
      <span class="endpoint-name">List menu categories</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns all menu categories for the current business, ordered by sort order then name, with a name/description substring filter applied client-side after loading.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Case-insensitive match against name or description.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 2, "name": "Rice &amp; Curry", "description": null, "sort_order": 1, "is_active": true, "item_count": 6 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-categories-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-categories</code>
      <span class="endpoint-name">Create menu category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a menu category, appending it to the end of the business's sort order.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 chars.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 6, "name": "Desserts", "description": null, "sort_order": 5, "is_active": true, "item_count": 0 }
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

  <div class="endpoint" id="ep-menu-categories-reorder">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-categories/reorder</code>
      <span class="endpoint-name">Reorder menu categories</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Bulk-sets <code>sort_order</code> from the position of each id in the submitted list (1-based). Ids not belonging to the current business are silently ignored.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>ids</td><td class="param-type">integer[]</td><td>Category ids in their new display order.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-categories-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-categories/{menuCategory}</code>
      <span class="endpoint-name">Update menu category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a menu category's name, description, and active flag.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 1000 chars.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 2, "name": "Rice &amp; Curry", "description": "Main course rice dishes", "sort_order": 1, "is_active": true, "item_count": 6 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-categories-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-categories/{menuCategory}</code>
      <span class="endpoint-name">Delete menu category</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes the category. Menu items previously assigned to it via the legacy single-category field have <code>menu_category_id</code> set to null rather than being deleted.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
@endverbatim
