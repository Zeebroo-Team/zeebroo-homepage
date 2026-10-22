@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-design-studio-designs-index"><span class="method-badge method-get">GET</span> /design-studio/designs</a>
    <a href="#ep-design-studio-designs-store"><span class="method-badge method-post">POST</span> /design-studio/designs</a>
    <a href="#ep-design-studio-designs-show"><span class="method-badge method-get">GET</span> /design-studio/designs/{design}</a>
    <a href="#ep-design-studio-designs-update"><span class="method-badge method-patch">PATCH</span> /design-studio/designs/{design}</a>
    <a href="#ep-design-studio-designs-destroy"><span class="method-badge method-delete">DELETE</span> /design-studio/designs/{design}</a>
    <a href="#ep-design-studio-proposals-index"><span class="method-badge method-get">GET</span> /design-studio/proposals</a>
    <a href="#ep-design-studio-proposals-store"><span class="method-badge method-post">POST</span> /design-studio/proposals</a>
    <a href="#ep-design-studio-proposals-ai-content"><span class="method-badge method-post">POST</span> /design-studio/proposals/ai-content</a>
    <a href="#ep-design-studio-proposals-destroy"><span class="method-badge method-delete">DELETE</span> /design-studio/proposals/{group}</a>
    <a href="#ep-design-studio-proposals-ai-fill"><span class="method-badge method-post">POST</span> /design-studio/proposals/{group}/ai-fill</a>
    <a href="#ep-design-studio-proposals-link-invoice"><span class="method-badge method-post">POST</span> /design-studio/proposals/{group}/link-invoice</a>
    <a href="#ep-design-studio-proposals-add-page"><span class="method-badge method-post">POST</span> /design-studio/proposals/{group}/pages</a>
    <a href="#ep-design-studio-proposals-pages"><span class="method-badge method-get">GET</span> /design-studio/proposals/{group}/pages</a>
  </div>

  <div class="endpoint" id="ep-design-studio-designs-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/designs</code>
      <span class="endpoint-name">List designs</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists standalone design canvases for the business (excludes proposal pages), newest-updated first, optionally filtered by type. Also returns a per-type count breakdown. Returns an empty list gracefully if the Design Studio module's table doesn't exist yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>type<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filter by design type, e.g. <code>letterhead</code>, <code>company-profile</code>, <code>business-card</code>.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 4,
      "title": "Company Letterhead",
      "type": "letterhead",
      "width": 794,
      "height": 1123,
      "has_canvas": true,
      "proposal_group": null,
      "proposal_sort": null,
      "invoice_id": null,
      "quotation_id": null,
      "created_at": "2026-07-01",
      "updated_at": "2026-07-20 09:14"
    }
  ],
  "total_count": 1,
  "by_type": { "letterhead": 1 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-designs-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/designs</code>
      <span class="endpoint-name">Create design canvas</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new blank design canvas. Types <code>letterhead</code> and <code>company-profile</code> are treated as singletons per business — creating a second one of either type fails with a 422 and returns the existing design instead.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>width</td><td class="param-type">integer</td><td>100–8000 px.</td></tr>
            <tr><td>height</td><td class="param-type">integer</td><td>100–8000 px.</td></tr>
            <tr><td>type<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 characters, e.g. <code>letterhead</code>.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "title": "Summer Sale Poster",
    "type": "poster",
    "width": 794,
    "height": 1123,
    "has_canvas": false,
    "proposal_group": null,
    "proposal_sort": null,
    "invoice_id": null,
    "quotation_id": null,
    "created_at": "2026-07-31",
    "updated_at": "2026-07-31 08:00"
  },
  "message": "Design created."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Letterhead already exists for this business.",
  "data": { "id": 4, "title": "Company Letterhead", "type": "letterhead" }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-designs-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/designs/{design}</code>
      <span class="endpoint-name">Get design</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single design including its full <code>canvas_json</code> (serialized Fabric.js document). 404s if the design does not belong to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 4,
    "title": "Company Letterhead",
    "type": "letterhead",
    "width": 794,
    "height": 1123,
    "canvas_json": "{\"version\":\"5.3.0\",\"objects\":[...]}",
    "has_canvas": true,
    "proposal_group": null,
    "proposal_sort": null,
    "invoice_id": null,
    "quotation_id": null,
    "created_at": "2026-07-01",
    "updated_at": "2026-07-20 09:14"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-designs-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/designs/{design}</code>
      <span class="endpoint-name">Update design (save canvas)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Saves canvas edits — typically called by the design editor's autosave with the serialized Fabric.js <code>canvas_json</code> string. Only fields present and non-null are applied.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>canvas_json<span class="param-required">opt</span></td><td class="param-type">string</td><td>Serialized Fabric.js canvas document.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 4,
    "title": "Company Letterhead",
    "type": "letterhead",
    "width": 794,
    "height": 1123,
    "canvas_json": "{\"version\":\"5.3.0\",\"objects\":[...]}",
    "has_canvas": true,
    "proposal_group": null,
    "proposal_sort": null,
    "invoice_id": null,
    "quotation_id": null,
    "created_at": "2026-07-01",
    "updated_at": "2026-07-31 08:05"
  },
  "message": "Saved."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The title must not be greater than 120 characters.",
  "errors": { "title": ["The title must not be greater than 120 characters."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-designs-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/designs/{design}</code>
      <span class="endpoint-name">Delete design</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a design canvas. 404s if it does not belong to the resolved business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Design deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals</code>
      <span class="endpoint-name">List project proposals</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists project proposals — groups of designs sharing a <code>proposal_group</code> UUID — with the project title and client parsed out of each page's stored title, sorted by most recently updated. Each proposal's pages are nested.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "group": "9c3e1e2a-0e2a-4c9a-9e1a-2f7a6b8e1234",
      "title": "Website Redesign",
      "client": "Acme Retail",
      "page_count": 6,
      "has_canvas": true,
      "updated_at": "2026-07-30 11:20:00",
      "pages": [
        { "id": 30, "title": "Website Redesign — Acme Retail — Cover Page", "type": "project-proposal", "width": 794, "height": 1123, "has_canvas": true, "proposal_group": "9c3e1e2a-...", "proposal_sort": 1, "invoice_id": null, "quotation_id": null, "created_at": "2026-07-30", "updated_at": "2026-07-30 11:20" }
      ]
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals</code>
      <span class="endpoint-name">Create project proposal</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new project proposal: a group of 6 blank 794×1123 design pages (Cover Page, Executive Summary, Our Services, Project Timeline, Investment &amp; Pricing, Contact &amp; Next Steps) sharing a new UUID <code>proposal_group</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 100 characters. The proposal/project title.</td></tr>
            <tr><td>client<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 100 characters. Client name, appended to every page title.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "group": "9c3e1e2a-0e2a-4c9a-9e1a-2f7a6b8e1234",
    "title": "Website Redesign — Acme Retail",
    "pages": [
      { "id": 30, "title": "Website Redesign — Acme Retail — Cover Page", "type": "project-proposal", "proposal_sort": 1, "has_canvas": false }
    ]
  },
  "message": "Project proposal created."
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The title field is required.",
  "errors": { "title": ["The title field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-ai-content">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals/ai-content</code>
      <span class="endpoint-name">Generate proposal content (AI, preview)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Generates proposal copy (tagline, summary, key outcomes, services, timeline, pricing, contact steps) via the Gemini API without saving anything — used to preview AI content before committing it to a proposal's pages. Tries <code>gemini-2.5-flash</code> first, falling back through <code>gemini-2.0-flash</code> and <code>gemini-1.5-flash</code> on rate limits or failures.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 120 characters. Project title fed to the AI prompt.</td></tr>
            <tr><td>description</td><td class="param-type">string</td><td>Max 1500 characters. Project brief fed to the AI prompt.</td></tr>
            <tr><td>client<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 100 characters.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "content": {
    "tagline": "Modern design, measurable growth",
    "summary": "We will redesign the storefront to boost conversion...",
    "summary_points": ["Faster checkout", "Mobile-first UI", "SEO uplift"],
    "services": [{ "name": "UX Audit", "desc": "Full funnel review" }],
    "timeline": [{ "phase": "Phase 1", "title": "Discovery", "duration": "Week 1-2", "desc": "Research & wireframes" }],
    "pricing": { "subtitle": "Investment Overview", "items": [{ "name": "Design", "amount": "$4,000" }], "total": "$12,000", "note": "50% upfront" },
    "contact": { "intro": "Ready to begin?", "steps": ["Sign proposal", "Kickoff call", "Discovery sprint"] }
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "AI generation failed. Please try again." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals/{group}</code>
      <span class="endpoint-name">Delete proposal</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes every design page belonging to the given <code>proposal_group</code> UUID for the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Proposal deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-ai-fill">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals/{group}/ai-fill</code>
      <span class="endpoint-name">Fill proposal with AI content</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Generates proposal content via Gemini (same prompt/model fallback chain as the preview endpoint) and, unlike the preview endpoint, immediately renders and saves a <code>canvas_json</code> layout into all 6 pages of the proposal group — building the cover, summary, services, timeline, pricing, and contact page designs server-side.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>description</td><td class="param-type">string</td><td>Max 1500 characters.</td></tr>
            <tr><td>client<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 100 characters.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Proposal filled with AI content.",
  "data": {
    "group": "9c3e1e2a-0e2a-4c9a-9e1a-2f7a6b8e1234",
    "pages": [
      { "id": 30, "title": "Website Redesign — Acme Retail — Cover Page", "proposal_sort": 1, "has_canvas": true }
    ]
  }
}</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "AI generation failed. Please try again." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-link-invoice">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals/{group}/link-invoice</code>
      <span class="endpoint-name">Link proposal to invoice</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Attaches (or clears) an invoice reference on every page in the proposal group. If <code>invoice_id</code> is supplied it must belong to a <code>Sales\Invoice</code> in the current business, otherwise the request is rejected.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>invoice_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Nullable. Must belong to the current business; pass null to unlink.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Proposal linked to invoice." }</code></pre>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Invoice not found." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-add-page">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals/{group}/pages</code>
      <span class="endpoint-name">Add proposal page</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Appends a new blank page to an existing proposal group, one sort position after the current last page, inheriting the group's canvas dimensions and title prefix. 404s if the group has no existing pages for this business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: design_all</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>invoice_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Optional invoice link for the new page.</td></tr>
            <tr><td>quotation_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Optional quotation link for the new page.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 37,
    "title": "Website Redesign — Acme Retail — Page 7",
    "type": "project-proposal",
    "width": 794,
    "height": 1123,
    "has_canvas": false,
    "proposal_group": "9c3e1e2a-0e2a-4c9a-9e1a-2f7a6b8e1234",
    "proposal_sort": 7,
    "invoice_id": null,
    "quotation_id": null,
    "created_at": "2026-07-31",
    "updated_at": "2026-07-31 08:10"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-design-studio-proposals-pages">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/proposals/{group}/pages</code>
      <span class="endpoint-name">Get proposal pages</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every page in a proposal group in sort order, including each page's full <code>canvas_json</code> — used to open a proposal in the design editor. 404s if the group has no pages for this business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "group": "9c3e1e2a-0e2a-4c9a-9e1a-2f7a6b8e1234",
    "title": "Website Redesign",
    "client": "Acme Retail",
    "pages": [
      {
        "id": 30,
        "title": "Website Redesign — Acme Retail — Cover Page",
        "type": "project-proposal",
        "width": 794,
        "height": 1123,
        "canvas_json": "{\"version\":\"5.3.0\",\"objects\":[...]}",
        "has_canvas": true,
        "proposal_group": "9c3e1e2a-0e2a-4c9a-9e1a-2f7a6b8e1234",
        "proposal_sort": 1,
        "invoice_id": null,
        "quotation_id": null,
        "created_at": "2026-07-30",
        "updated_at": "2026-07-30 11:20"
      }
    ]
  }
}</code></pre>
      </div>
@endverbatim
