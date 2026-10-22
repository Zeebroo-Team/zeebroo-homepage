@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-crm-projects-list"><span class="method-badge method-get">GET</span> /crm/projects</a>
    <a href="#ep-crm-projects-store"><span class="method-badge method-post">POST</span> /crm/projects</a>
    <a href="#ep-crm-pipeline"><span class="method-badge method-get">GET</span> /crm/projects/{project}/pipeline</a>
    <a href="#ep-crm-leads-store"><span class="method-badge method-post">POST</span> /crm/projects/{project}/leads</a>
    <a href="#ep-crm-leads-update"><span class="method-badge method-put">PUT</span> /crm/leads/{lead}</a>
    <a href="#ep-crm-leads-move-stage"><span class="method-badge method-post">POST</span> /crm/leads/{lead}/move-stage</a>
    <a href="#ep-crm-leads-destroy"><span class="method-badge method-delete">DELETE</span> /crm/leads/{lead}</a>
    <a href="#ep-crm-stages-list"><span class="method-badge method-get">GET</span> /crm/projects/{project}/stages</a>
    <a href="#ep-crm-stages-store"><span class="method-badge method-post">POST</span> /crm/projects/{project}/stages</a>
    <a href="#ep-crm-stages-reorder"><span class="method-badge method-post">POST</span> /crm/projects/{project}/stages/reorder</a>
    <a href="#ep-crm-stages-update"><span class="method-badge method-put">PUT</span> /crm/projects/{project}/stages/{stage}</a>
    <a href="#ep-crm-stages-destroy"><span class="method-badge method-delete">DELETE</span> /crm/projects/{project}/stages/{stage}</a>
    <a href="#ep-crm-contacts-list"><span class="method-badge method-get">GET</span> /crm/contacts</a>
    <a href="#ep-crm-tasks-list"><span class="method-badge method-get">GET</span> /crm/tasks</a>
    <a href="#ep-crm-tasks-store"><span class="method-badge method-post">POST</span> /crm/tasks</a>
    <a href="#ep-crm-tasks-complete"><span class="method-badge method-post">POST</span> /crm/tasks/{task}/complete</a>
    <a href="#ep-crm-tasks-reopen"><span class="method-badge method-post">POST</span> /crm/tasks/{task}/reopen</a>
    <a href="#ep-crm-tasks-destroy"><span class="method-badge method-delete">DELETE</span> /crm/tasks/{task}</a>
    <a href="#ep-crm-forms-list"><span class="method-badge method-get">GET</span> /crm/projects/{project}/forms</a>
    <a href="#ep-crm-forms-store"><span class="method-badge method-post">POST</span> /crm/projects/{project}/forms</a>
    <a href="#ep-crm-forms-show"><span class="method-badge method-get">GET</span> /crm/projects/{project}/forms/{form}</a>
    <a href="#ep-crm-forms-update"><span class="method-badge method-put">PUT</span> /crm/projects/{project}/forms/{form}</a>
    <a href="#ep-crm-forms-publish"><span class="method-badge method-post">POST</span> /crm/projects/{project}/forms/{form}/publish</a>
    <a href="#ep-crm-forms-unpublish"><span class="method-badge method-post">POST</span> /crm/projects/{project}/forms/{form}/unpublish</a>
    <a href="#ep-crm-forms-destroy"><span class="method-badge method-delete">DELETE</span> /crm/projects/{project}/forms/{form}</a>
    <a href="#ep-crm-form-templates"><span class="method-badge method-get">GET</span> /crm/form-templates</a>
    <a href="#ep-crm-custom-fields-list"><span class="method-badge method-get">GET</span> /crm/projects/{project}/custom-fields</a>
    <a href="#ep-crm-custom-fields-store"><span class="method-badge method-post">POST</span> /crm/projects/{project}/custom-fields</a>
  </div>

  <h3>Projects</h3>

  <div class="endpoint" id="ep-crm-projects-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects</code>
      <span class="endpoint-name">List projects</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists active CRM projects (pipelines) for the business, ordered by name, each with its lead count.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 1,
      "name": "Sales Pipeline",
      "description": "Inbound leads from the website contact form.",
      "status": "active",
      "leads_count": 24
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-projects-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects</code>
      <span class="endpoint-name">Create project</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new CRM project (pipeline) for the business, defaulting its status to active. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Project name, max 255 chars. Must be unique per business.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text description, max 1000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "business_id": 10,
    "name": "Partnership Deals",
    "description": null,
    "status": "active",
    "created_at": "2026-07-31T09:00:00.000000Z",
    "updated_at": "2026-07-31T09:00:00.000000Z"
  }
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

  <h3>Pipeline</h3>

  <div class="endpoint" id="ep-crm-pipeline">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/pipeline</code>
      <span class="endpoint-name">Get pipeline board</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the Kanban-style pipeline for a project: every stage as a column with its leads, plus a per-lead <code>is_customer</code> flag matched by email or phone against the business's POS customers.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "project": { "id": 1, "name": "Sales Pipeline" },
    "columns": [
      {
        "id": 1,
        "name": "New",
        "color": "#64748b",
        "is_won": false,
        "is_lost": false,
        "leads_count": 3,
        "value_total": 4500.00,
        "leads": [
          {
            "id": 12,
            "stage_id": 1,
            "name": "Jane Silva",
            "company": "Acme Cafe",
            "email": "jane@acmecafe.com",
            "phone": "0771234567",
            "estimated_value": "1500.00",
            "expected_close_date": "2026-08-15",
            "notes": null,
            "is_customer": true
          }
        ]
      }
    ],
    "stages": [
      { "id": 1, "name": "New", "color": "#64748b" }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <h3>Leads</h3>

  <div class="endpoint" id="ep-crm-leads-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/leads</code>
      <span class="endpoint-name">Create lead</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a lead in the given project. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Lead name, max 255 chars.</td></tr>
            <tr><td>company<span class="param-required">opt</span></td><td class="param-type">string</td><td>Company name, max 255 chars.</td></tr>
            <tr><td>email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Valid email, max 255 chars.</td></tr>
            <tr><td>phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 chars.</td></tr>
            <tr><td>stage_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Initial pipeline stage. Left unset, the lead has no stage.</td></tr>
            <tr><td>estimated_value<span class="param-required">opt</span></td><td class="param-type">number</td><td>Deal value, min 0.</td></tr>
            <tr><td>expected_close_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Expected close date.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free text, max 2000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 45,
    "business_id": 10,
    "project_id": 1,
    "name": "Jane Silva",
    "company": "Acme Cafe",
    "email": "jane@acmecafe.com",
    "phone": "0771234567",
    "source": null,
    "stage_id": 1,
    "estimated_value": "1500.00",
    "expected_close_date": "2026-08-15",
    "lost_reason": null,
    "notes": null,
    "assigned_to": null,
    "customer_id": null,
    "converted_at": null,
    "stage": { "id": 1, "name": "New", "color": "#64748b", "is_won": false, "is_lost": false }
  }
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

  <div class="endpoint" id="ep-crm-leads-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/crm/leads/{lead}</code>
      <span class="endpoint-name">Update lead</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a lead's details. Does not change the pipeline stage — use the move-stage endpoint for that. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>lead</td><td class="param-type">integer</td><td>Lead ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Lead name, max 255 chars.</td></tr>
            <tr><td>company<span class="param-required">opt</span></td><td class="param-type">string</td><td>Company name, max 255 chars.</td></tr>
            <tr><td>email<span class="param-required">opt</span></td><td class="param-type">string</td><td>Valid email, max 255 chars.</td></tr>
            <tr><td>phone<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 50 chars.</td></tr>
            <tr><td>stage_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Accepted but not validated against the project here; prefer move-stage.</td></tr>
            <tr><td>estimated_value<span class="param-required">opt</span></td><td class="param-type">number</td><td>Deal value, min 0.</td></tr>
            <tr><td>expected_close_date<span class="param-required">opt</span></td><td class="param-type">date</td><td>Expected close date.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free text, max 2000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 45,
    "name": "Jane M. Silva",
    "company": "Acme Cafe",
    "email": "jane@acmecafe.com",
    "phone": "0771234567",
    "estimated_value": "1800.00",
    "expected_close_date": "2026-08-20",
    "notes": "Follow up after site visit.",
    "stage": { "id": 1, "name": "New", "color": "#64748b", "is_won": false, "is_lost": false }
  }
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

  <div class="endpoint" id="ep-crm-leads-move-stage">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/leads/{lead}/move-stage</code>
      <span class="endpoint-name">Move lead to another stage</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Moves a lead to a different pipeline stage (e.g. drag-and-drop on the Kanban board). The target stage must belong to the same project as the lead. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>lead</td><td class="param-type">integer</td><td>Lead ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>stage_id</td><td class="param-type">integer</td><td>Target stage ID. Must exist in <code>crm_lead_stages</code> and belong to the lead's project — a 404 is returned otherwise.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 45,
    "stage_id": 3,
    "name": "Jane Silva",
    "stage": { "id": 3, "name": "Qualified", "color": "#8b5cf6", "is_won": false, "is_lost": false }
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The stage id field is required.",
  "errors": { "stage_id": ["The stage id field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-leads-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/crm/leads/{lead}</code>
      <span class="endpoint-name">Delete lead</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a lead. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>lead</td><td class="param-type">integer</td><td>Lead ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Lead deleted." }</code></pre>
      </div>
    </div>
  </div>

  <h3>Pipeline stages</h3>

  <div class="endpoint" id="ep-crm-stages-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/stages</code>
      <span class="endpoint-name">List stages</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists a project's pipeline stages ordered by <code>sort_order</code>, with each stage's lead count. On first access for a project, seven default stages (New, Contacted, Qualified, Proposal, Negotiation, Won, Lost) are auto-created.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 1, "name": "New", "color": "#64748b", "is_won": false, "is_lost": false, "sort_order": 1, "leads_count": 3 },
    { "id": 6, "name": "Won", "color": "#10b981", "is_won": true, "is_lost": false, "sort_order": 6, "leads_count": 5 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-stages-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/stages</code>
      <span class="endpoint-name">Create stage</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Adds a new pipeline stage to a project, appended after the current highest <code>sort_order</code>. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Stage name, max 60 chars. Unique per project.</td></tr>
            <tr><td>color<span class="param-required">opt</span></td><td class="param-type">string</td><td>Hex color, max 20 chars. Defaults to <code>#64748b</code>.</td></tr>
            <tr><td>is_won<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Marks the stage as a "won" outcome. Default false.</td></tr>
            <tr><td>is_lost<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Marks the stage as a "lost" outcome. Default false.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 8,
    "project_id": 1,
    "name": "Site Visit",
    "color": "#64748b",
    "is_won": false,
    "is_lost": false,
    "sort_order": 8
  }
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

  <div class="endpoint" id="ep-crm-stages-reorder">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/stages/reorder</code>
      <span class="endpoint-name">Reorder stages</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Bulk-updates <code>sort_order</code> for the project's stages to match the order of IDs given (1-indexed). Only IDs belonging to the project are affected. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>ids</td><td class="param-type">array</td><td>Stage IDs in the desired display order.</td></tr>
            <tr><td>ids.*</td><td class="param-type">integer</td><td>Each entry must be an integer stage ID.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Reordered." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The ids field is required.",
  "errors": { "ids": ["The ids field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-stages-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/stages/{stage}</code>
      <span class="endpoint-name">Update stage</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a stage's name, color, or won/lost flags. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>stage</td><td class="param-type">integer</td><td>Stage ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Stage name, max 60 chars.</td></tr>
            <tr><td>color<span class="param-required">opt</span></td><td class="param-type">string</td><td>Hex color, max 20 chars.</td></tr>
            <tr><td>is_won<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Default false when omitted.</td></tr>
            <tr><td>is_lost<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Default false when omitted.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 8,
    "project_id": 1,
    "name": "Site Visit Scheduled",
    "color": "#f59e0b",
    "is_won": false,
    "is_lost": false,
    "sort_order": 8
  }
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

  <div class="endpoint" id="ep-crm-stages-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/stages/{stage}</code>
      <span class="endpoint-name">Delete stage</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a pipeline stage. Blocked with a validation error if any leads are still assigned to it — move or remove those leads first. Requires the <code>crm_pipeline</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_pipeline</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>stage</td><td class="param-type">integer</td><td>Stage ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Stage deleted." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Move or remove leads in this stage before deleting it." }</code></pre>
      </div>
    </div>
  </div>

  <h3>Contacts</h3>

  <div class="endpoint" id="ep-crm-contacts-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/contacts</code>
      <span class="endpoint-name">List contacts</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists the business's POS customers as CRM contacts, each annotated with its open task count and most recent CRM activity timestamp. Search matches name, phone, or email.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Search term matched against name, phone, and email.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 88,
      "name": "Jane Silva",
      "phone": "0771234567",
      "email": "jane@acmecafe.com",
      "open_tasks": 2,
      "last_activity": "2026-07-28T10:15:00.000000Z"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <h3>Tasks</h3>

  <div class="endpoint" id="ep-crm-tasks-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/tasks</code>
      <span class="endpoint-name">List tasks</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists CRM tasks for the business filtered by status. <code>subject_label</code> resolves to the linked customer or lead's name when the task is attached to one.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>filter<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>open</code>, <code>overdue</code>, <code>completed</code>. Defaults to <code>open</code>; invalid values fall back to <code>open</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 21,
      "title": "Call back about quote",
      "description": null,
      "due_at": "2026-08-02T14:00:00+00:00",
      "status": "pending",
      "is_overdue": false,
      "subject_type": "Modules\\Pos\\Models\\Customer",
      "subject_id": 88,
      "subject_label": "Jane Silva"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-tasks-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/tasks</code>
      <span class="endpoint-name">Create task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a standalone task for the business (not attached to a customer or lead through this endpoint). Requires the <code>crm_tasks</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_tasks</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 chars.</td></tr>
            <tr><td>due_at<span class="param-required">opt</span></td><td class="param-type">date</td><td>Due date/time.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 22,
    "business_id": 10,
    "subject_type": null,
    "subject_id": null,
    "title": "Prepare Q3 pipeline review",
    "description": null,
    "due_at": "2026-08-05T09:00:00.000000Z",
    "status": "pending",
    "completed_at": null,
    "assigned_to": null,
    "created_by": 4
  }
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

  <div class="endpoint" id="ep-crm-tasks-complete">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/tasks/{task}/complete</code>
      <span class="endpoint-name">Complete task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Marks a task as completed. Requires the <code>crm_tasks</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_tasks</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>task</td><td class="param-type">integer</td><td>Task ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Task completed." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-tasks-reopen">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/tasks/{task}/reopen</code>
      <span class="endpoint-name">Reopen task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Reverts a completed task back to pending. Requires the <code>crm_tasks</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_tasks</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>task</td><td class="param-type">integer</td><td>Task ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Task reopened." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-tasks-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/crm/tasks/{task}</code>
      <span class="endpoint-name">Delete task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a task. Requires the <code>crm_tasks</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_tasks</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>task</td><td class="param-type">integer</td><td>Task ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Task deleted." }</code></pre>
      </div>
    </div>
  </div>

  <h3>Lead capture forms</h3>

  <div class="endpoint" id="ep-crm-forms-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms</code>
      <span class="endpoint-name">List forms</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists the public lead-capture forms belonging to a project, newest first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 2,
      "name": "Website Contact Form",
      "is_published": true,
      "public_url": "https://app.example.com/f/ab12cd34ef56gh78ij90",
      "submit_button_text": "Submit",
      "success_message": "Thanks for your submission.",
      "blocks_count": 5
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-forms-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms</code>
      <span class="endpoint-name">Create form</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a public lead-capture form from a template (or blank), auto-generating a unique public token/URL. New forms are published by default. Requires the <code>crm_forms</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_forms</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Form name, max 255 chars.</td></tr>
            <tr><td>template<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>blank</code>, <code>contact</code>, <code>quote</code>, <code>newsletter</code>, <code>event</code>. Defaults to <code>blank</code> when omitted.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "name": "Request a Quote",
    "is_published": true,
    "public_url": "https://app.example.com/f/xy98wv76ut54sr32qp10",
    "blocks": [
      { "type": "heading", "text": "Request a quote", "size": "lg" },
      { "type": "field", "field": "name", "label": "Your name", "required": true }
    ],
    "style": { "layout": "card", "accent_color": "#2563eb", "background_color": "#f1f5f9" },
    "submit_button_text": "Request quote",
    "success_message": "Thanks! We'll send your quote within one business day."
  }
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

  <div class="endpoint" id="ep-crm-forms-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms/{form}</code>
      <span class="endpoint-name">Get form (builder detail)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns full form-builder detail: blocks, style settings, the project's custom fields (for binding to blocks), and the list of available templates.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>form</td><td class="param-type">integer</td><td>Form ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "name": "Request a Quote",
    "is_published": true,
    "public_url": "https://app.example.com/f/xy98wv76ut54sr32qp10",
    "blocks": [
      { "type": "field", "field": "name", "label": "Your name", "required": true }
    ],
    "style": { "layout": "card", "accent_color": "#2563eb", "background_color": "#f1f5f9" },
    "submit_button_text": "Request quote",
    "success_message": "Thanks! We'll send your quote within one business day.",
    "custom_fields": [
      { "id": 1, "name": "Budget Range", "type": "select" }
    ],
    "templates": [
      { "key": "blank", "label": "Blank form", "description": "Start from scratch and add your own blocks.", "icon": "fa-file", "blocks": [] }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-forms-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms/{form}</code>
      <span class="endpoint-name">Update form</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Updates a form's name, block layout, and/or style. <code>style</code> is merged onto the existing style settings rather than replacing them wholesale. Requires the <code>crm_forms</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_forms</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>form</td><td class="param-type">integer</td><td>Form ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>blocks<span class="param-required">opt</span></td><td class="param-type">array</td><td>Full block tree for the form builder.</td></tr>
            <tr><td>style<span class="param-required">opt</span></td><td class="param-type">object</td><td>Merged over existing style — <code>layout</code>, <code>accent_color</code>, <code>background_color</code>.</td></tr>
            <tr><td>submit_button_text<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 60 chars.</td></tr>
            <tr><td>success_message<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 500 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "name": "Request a Quote",
    "is_published": true,
    "public_url": "https://app.example.com/f/xy98wv76ut54sr32qp10",
    "blocks": [
      { "type": "field", "field": "name", "label": "Full name", "required": true }
    ],
    "style": { "layout": "split", "accent_color": "#2563eb", "background_color": "#f1f5f9" },
    "submit_button_text": "Request quote",
    "success_message": "Thanks! We'll send your quote within one business day."
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The blocks field must be an array.",
  "errors": { "blocks": ["The blocks field must be an array."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-forms-publish">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms/{form}/publish</code>
      <span class="endpoint-name">Publish form</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Publishes a form so its public URL starts accepting submissions. Requires the <code>crm_forms</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_forms</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>form</td><td class="param-type">integer</td><td>Form ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Form published.", "is_published": true }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-forms-unpublish">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms/{form}/unpublish</code>
      <span class="endpoint-name">Unpublish form</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Unpublishes a form; its public URL stops accepting submissions until republished. Requires the <code>crm_forms</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_forms</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>form</td><td class="param-type">integer</td><td>Form ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Form unpublished.", "is_published": false }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-forms-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/forms/{form}</code>
      <span class="endpoint-name">Delete form</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a form. Requires the <code>crm_forms</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_forms</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
            <tr><td>form</td><td class="param-type">integer</td><td>Form ID. Must belong to the project.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Form deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-form-templates">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/form-templates</code>
      <span class="endpoint-name">List form templates</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the static catalog of form starter templates (blank, contact, quote, newsletter, event) with their preview blocks. Unlike other CRM endpoints, this one does not resolve a business — it is not project- or business-scoped, just authenticated.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "key": "blank",
      "label": "Blank form",
      "description": "Start from scratch and add your own blocks.",
      "icon": "fa-file",
      "blocks": []
    },
    {
      "key": "contact",
      "label": "Contact us",
      "description": "Name, email, and phone — a general-purpose inquiry form.",
      "icon": "fa-comment-dots",
      "blocks": [
        { "type": "heading", "text": "Get in touch", "size": "lg" },
        { "type": "field", "field": "name", "label": "Your name", "required": true }
      ]
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <h3>Custom fields</h3>

  <div class="endpoint" id="ep-crm-custom-fields-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/custom-fields</code>
      <span class="endpoint-name">List custom fields</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists a project's custom lead fields, ordered by <code>sort_order</code>. These fields can be attached to lead-capture form blocks and store per-lead values.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 1, "name": "Budget Range", "type": "select", "sort_order": 1 }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-crm-custom-fields-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/crm/projects/{project}/custom-fields</code>
      <span class="endpoint-name">Create custom field</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Adds a custom lead field to a project, appended after the current highest <code>sort_order</code>. Requires the <code>crm_forms</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: crm_forms</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>project</td><td class="param-type">integer</td><td>Project ID. Must belong to the current business.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Field label, max 80 chars.</td></tr>
            <tr><td>type</td><td class="param-type">string</td><td>One of <code>text</code>, <code>textarea</code>, <code>number</code>, <code>date</code>, <code>select</code>, <code>checkbox</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 2,
    "name": "Preferred Contact Time",
    "type": "text"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The name field is required.",
  "errors": { "name": ["The name field is required."] }
}</code></pre>
      </div>
@endverbatim
