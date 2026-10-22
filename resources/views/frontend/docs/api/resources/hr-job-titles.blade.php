@verbatim
  <div class="endpoint" id="ep-hr-job-titles-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/job-titles</code>
      <span class="endpoint-name">List job titles</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists job titles for the business, alphabetically, returning only id and name. Returns an empty list if the hr_job_titles table is not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 3, "name": "Floor Supervisor" },
    { "id": 9, "name": "Marketing Executive" }
  ]
}</code></pre>
      </div>
@endverbatim
