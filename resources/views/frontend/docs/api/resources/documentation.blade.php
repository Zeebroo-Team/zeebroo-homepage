@verbatim
  <div class="endpoint" id="ep-documentation-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/documentation</code>
      <span class="endpoint-name">List documents</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Resolves the business as the authenticated user's first owned business (<code>$request->user()->businesses()->first()</code> — not the <code>X-Business-Id</code> header). If found, lists that business's documents (any status); otherwise lists only globally published documents. 20 per page.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped when the user owns a business, else public</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Matches <code>title</code> or <code>content</code>.</td></tr>
            <tr><td>category<span class="param-required">opt</span></td><td class="param-type">integer</td><td><code>document_category_id</code> filter.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>Only applied in business scope (e.g. <code>draft</code>/<code>published</code>); ignored/absent in the public fallback.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "current_page": 1,
  "data": [
    {
      "id": 3,
      "business_id": 2,
      "created_by": 1,
      "document_category_id": 1,
      "title": "Getting started",
      "slug": "getting-started",
      "content": "...",
      "status": "published",
      "created_at": "2026-06-12T10:00:00.000000Z",
      "updated_at": "2026-06-12T10:00:00.000000Z",
      "author": { "id": 1, "name": "Jane Doe" },
      "category": { "id": 1, "name": "Guides" }
    }
  ],
  "first_page_url": "/api/documentation?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "/api/documentation?page=1",
  "next_page_url": null,
  "path": "/api/documentation",
  "per_page": 20,
  "prev_page_url": null,
  "to": 1,
  "total": 1
}</code></pre>
        <p class="endpoint-desc">This is Laravel's stock <code>LengthAwarePaginator</code> JSON shape — the controller passes the paginator straight to <code>response()->json()</code> with no custom envelope.</p>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-documentation-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/documentation/{document}</code>
      <span class="endpoint-name">Get document</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Route-model-binds <code>{document}</code> by id. Returns 404 if the user has a business and the document belongs to a different one, or if the user has no business and the document isn't published.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped when the user owns a business, else public-published-only</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "business_id": 2,
    "created_by": 1,
    "document_category_id": 1,
    "title": "Getting started",
    "slug": "getting-started",
    "content": "Full article body...",
    "status": "published",
    "created_at": "2026-06-12T10:00:00.000000Z",
    "updated_at": "2026-06-12T10:00:00.000000Z",
    "author": { "id": 1, "name": "Jane Doe" }
  }
}</code></pre>
      </div>
@endverbatim
