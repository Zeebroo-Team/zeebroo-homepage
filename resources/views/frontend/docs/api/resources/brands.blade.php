@verbatim
  <div class="endpoint" id="ep-brands-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/brands</code>
      <span class="endpoint-name">List product brands</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns product brands for the current business, with a product count per brand.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search by brand name.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>active</code> or <code>inactive</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 2, "name": "Acme Apparel", "description": null, "website": null, "is_active": true, "products_count": 30 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-brands-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/brands</code>
      <span class="endpoint-name">Create a brand</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a product brand.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Brand name.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>&nbsp;</td></tr>
            <tr><td>website<span class="param-required">opt</span></td><td class="param-type">string (uri)</td><td>&nbsp;</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Defaults to true.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 9, "name": "Nova Footwear", "is_active": true }
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

  <div class="endpoint" id="ep-brands-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/brands/{brand}</code>
      <span class="endpoint-name">Update a brand</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a brand's name, description, website, or active status.</p>
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
            <tr><td>website<span class="param-required">opt</span></td><td class="param-type">string (uri)</td><td>&nbsp;</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>&nbsp;</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 9, "name": "Nova Footwear Co." }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The website must be a valid URL.",
  "errors": { "website": ["The website must be a valid URL."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-brands-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/brands/{brand}</code>
      <span class="endpoint-name">Delete a brand</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a brand owned by the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Brand deleted."
}</code></pre>
      </div>
@endverbatim
