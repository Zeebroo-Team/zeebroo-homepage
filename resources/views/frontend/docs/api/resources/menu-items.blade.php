@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-menu-items-index"><span class="method-badge method-get">GET</span> /menu-items</a>
    <a href="#ep-menu-items-store"><span class="method-badge method-post">POST</span> /menu-items</a>
    <a href="#ep-menu-items-show"><span class="method-badge method-get">GET</span> /menu-items/{menuItem}</a>
    <a href="#ep-menu-items-update"><span class="method-badge method-put">PUT</span> /menu-items/{menuItem}</a>
    <a href="#ep-menu-items-destroy"><span class="method-badge method-delete">DELETE</span> /menu-items/{menuItem}</a>
    <a href="#ep-menu-items-toggle"><span class="method-badge method-patch">PATCH</span> /menu-items/{menuItem}/toggle</a>
    <a href="#ep-menu-items-ingredients-list"><span class="method-badge method-get">GET</span> /menu-items/{menuItem}/ingredients</a>
    <a href="#ep-menu-items-ingredients-sync"><span class="method-badge method-put">PUT</span> /menu-items/{menuItem}/ingredients</a>
  </div>

  <div class="endpoint" id="ep-menu-items-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items</code>
      <span class="endpoint-name">List menu items</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Paginated (25/page) list of menu items for the current business, ordered by sort order then name.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filter by item name.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>all</code> (default), <code>available</code>, <code>unavailable</code>.</td></tr>
            <tr><td>category<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter to items assigned to this menu category id.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 9,
      "name": "Chicken Kottu",
      "description": "Chopped roti stir-fried with chicken and vegetables.",
      "price": 1225.00,
      "is_available": true,
      "prep_time_minutes": 15,
      "prep_label": "15m",
      "dietary_tags": ["spicy"],
      "sort_order": 1,
      "file_manager_file_id": null,
      "image_url": null,
      "categories": [{ "id": 2, "name": "Rice &amp; Curry" }]
    }
  ],
  "meta": { "current_page": 1, "last_page": 1, "total": 18, "per_page": 25 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items</code>
      <span class="endpoint-name">Create menu item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a menu item, appending it to the end of the business's sort order, and syncs its menu categories.</p>
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
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 3000 chars.</td></tr>
            <tr><td>price</td><td class="param-type">number</td><td>Min 0.</td></tr>
            <tr><td>is_available<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>prep_time_minutes<span class="param-required">opt</span></td><td class="param-type">integer</td><td>1–9999.</td></tr>
            <tr><td>dietary_tags<span class="param-required">opt</span></td><td class="param-type">string[]</td><td>Each value one of <code>vegetarian</code>, <code>vegan</code>, <code>gluten_free</code>, <code>halal</code>, <code>spicy</code>, <code>nut_free</code>, <code>dairy_free</code>.</td></tr>
            <tr><td>menu_category_ids<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Categories to attach.</td></tr>
            <tr><td>file_manager_file_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must exist in <code>file_manager_files</code>; used as the item's image.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 22,
    "name": "Fish Curry",
    "description": null,
    "price": 1450.00,
    "is_available": true,
    "prep_time_minutes": null,
    "prep_label": "—",
    "dietary_tags": [],
    "sort_order": 19,
    "file_manager_file_id": null,
    "image_url": null,
    "categories": [{ "id": 2, "name": "Rice &amp; Curry" }]
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name field is required.",
  "errors": {
    "name": ["The name field is required."],
    "price": ["The price field is required."]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items/{menuItem}</code>
      <span class="endpoint-name">Get menu item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single menu item with its categories and image file loaded. 404s if the item does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "name": "Chicken Kottu",
    "description": "Chopped roti stir-fried with chicken and vegetables.",
    "price": 1225.00,
    "is_available": true,
    "prep_time_minutes": 15,
    "prep_label": "15m",
    "dietary_tags": ["spicy"],
    "sort_order": 1,
    "file_manager_file_id": null,
    "image_url": null,
    "categories": [{ "id": 2, "name": "Rice &amp; Curry" }]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items/{menuItem}</code>
      <span class="endpoint-name">Update menu item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a menu item's fields and re-syncs its menu categories. Uses the same validation rules as create.</p>
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
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 3000 chars.</td></tr>
            <tr><td>price</td><td class="param-type">number</td><td>Min 0.</td></tr>
            <tr><td>is_available<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
            <tr><td>prep_time_minutes<span class="param-required">opt</span></td><td class="param-type">integer</td><td>1–9999.</td></tr>
            <tr><td>dietary_tags<span class="param-required">opt</span></td><td class="param-type">string[]</td><td>Same enum as create.</td></tr>
            <tr><td>menu_category_ids<span class="param-required">opt</span></td><td class="param-type">integer[]</td><td>Replaces the item's category attachments.</td></tr>
            <tr><td>file_manager_file_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must exist in <code>file_manager_files</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "name": "Chicken Kottu",
    "price": 1300.00,
    "is_available": true,
    "prep_time_minutes": 15,
    "prep_label": "15m",
    "dietary_tags": ["spicy"],
    "sort_order": 1,
    "file_manager_file_id": null,
    "image_url": null,
    "categories": [{ "id": 2, "name": "Rice &amp; Curry" }]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items/{menuItem}</code>
      <span class="endpoint-name">Delete menu item</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a menu item.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-toggle">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items/{menuItem}/toggle</code>
      <span class="endpoint-name">Toggle availability</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Flips <code>is_available</code> to its opposite value. No request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "data": { "is_available": false } }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-ingredients-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items/{menuItem}/ingredients</code>
      <span class="endpoint-name">Get menu item recipe</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the recipe (ingredient list with quantities) attached to a menu item, used for automatic stock deduction when an order is served.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 3, "name": "Chicken breast", "unit": "kg", "quantity_required": 0.25 },
    { "id": 7, "name": "Kottu roti", "unit": "pcs", "quantity_required": 2 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-menu-items-ingredients-sync">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/restaurant/menu-items/{menuItem}/ingredients</code>
      <span class="endpoint-name">Set menu item recipe</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Replaces the full recipe for a menu item. Any <code>ingredient_id</code> that does not belong to the current business is silently dropped rather than erroring.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>ingredients</td><td class="param-type">array</td><td>Present but may be empty to clear the recipe.</td></tr>
            <tr><td>ingredients[].ingredient_id</td><td class="param-type">integer</td><td>&nbsp;</td></tr>
            <tr><td>ingredients[].quantity_required</td><td class="param-type">number</td><td>Min 0.001.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "success": true }</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The ingredients.0.quantity_required field is required.",
  "errors": { "ingredients.0.quantity_required": ["The ingredients.0.quantity_required field is required."] }
}</code></pre>
      </div>
@endverbatim
