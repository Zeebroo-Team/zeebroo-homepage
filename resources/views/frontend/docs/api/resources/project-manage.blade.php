@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-project-manage-projects-index"><span class="method-badge method-get">GET</span> /api/v1/pos/pm/projects</a>
    <a href="#ep-project-manage-projects-store"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/projects</a>
    <a href="#ep-project-manage-projects-update"><span class="method-badge method-patch">PATCH</span> /api/v1/pos/pm/projects/{id}</a>
    <a href="#ep-project-manage-projects-destroy"><span class="method-badge method-delete">DELETE</span> /api/v1/pos/pm/projects/{id}</a>
    <a href="#ep-project-manage-board"><span class="method-badge method-get">GET</span> /api/v1/pos/pm/projects/{id}/board</a>
    <a href="#ep-project-manage-milestones-index"><span class="method-badge method-get">GET</span> /api/v1/pos/pm/projects/{id}/milestones</a>
    <a href="#ep-project-manage-milestones-store"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/projects/{id}/milestones</a>
    <a href="#ep-project-manage-milestones-complete"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/milestones/{id}/complete</a>
    <a href="#ep-project-manage-milestones-destroy"><span class="method-badge method-delete">DELETE</span> /api/v1/pos/pm/milestones/{id}</a>
    <a href="#ep-project-manage-tasks-index"><span class="method-badge method-get">GET</span> /api/v1/pos/pm/projects/{id}/tasks</a>
    <a href="#ep-project-manage-tasks-store"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/projects/{id}/tasks</a>
    <a href="#ep-project-manage-tasks-status"><span class="method-badge method-patch">PATCH</span> /api/v1/pos/pm/tasks/{id}/status</a>
    <a href="#ep-project-manage-tasks-complete"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/tasks/{id}/complete</a>
    <a href="#ep-project-manage-tasks-reopen"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/tasks/{id}/reopen</a>
    <a href="#ep-project-manage-tasks-destroy"><span class="method-badge method-delete">DELETE</span> /api/v1/pos/pm/tasks/{id}</a>
    <a href="#ep-project-manage-tasks-comment"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/tasks/{id}/comments</a>
    <a href="#ep-project-manage-tasks-time"><span class="method-badge method-post">POST</span> /api/v1/pos/pm/tasks/{id}/time</a>
    <a href="#ep-project-manage-my-tasks"><span class="method-badge method-get">GET</span> /api/v1/pos/pm/my-tasks</a>
  </div>

  <div class="endpoint" id="ep-project-manage-projects-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects</code>
      <span class="endpoint-name">List projects</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Projects — lists every project for the current business, ordered by status then name, with each project's <code>task_stats</code> breakdown and total <code>tasks_count</code> computed per row.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>filter<span class="param-required">opt</span></td><td class="param-type">string</td><td>Read from the query string (default "all") but not currently applied by <code>ProjectService::listForBusiness()</code> — every project for the business is returned regardless of its value.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 3,
      "name": "POS Terminal Refresh",
      "description": "Rollout of the new POS UI to all branches.",
      "client_name": null,
      "status": "active",
      "priority": "high",
      "color": "#4f46e5",
      "start_date": "2026-07-01",
      "due_date": "2026-09-30",
      "budget": 15000.00,
      "task_stats": { "todo": 4, "in_progress": 2, "review": 1, "done": 6, "total": 13 },
      "tasks_count": 13,
      "created_at": "2026-06-28 09:00:00"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-projects-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects</code>
      <span class="endpoint-name">Create project</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Projects — creates a new project for the current business. <code>status</code> defaults to <code>active</code> and <code>priority</code> defaults to <code>normal</code> when omitted; <code>created_by</code> is set to the authenticated user's id.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 150 characters.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>client_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>priority<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>low</code>, <code>normal</code>, <code>high</code>. Defaults to <code>normal</code>.</td></tr>
            <tr><td>color<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 20 characters, e.g. a hex code used by the board UI.</td></tr>
            <tr><td>start_date<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
            <tr><td>budget<span class="param-required">opt</span></td><td class="param-type">numeric</td><td>Minimum 0.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 9,
    "name": "Loyalty Program Launch",
    "description": null,
    "client_name": null,
    "status": "active",
    "priority": "normal",
    "color": null,
    "start_date": null,
    "due_date": null,
    "budget": null,
    "task_stats": { "todo": 0, "in_progress": 0, "review": 0, "done": 0, "total": 0 },
    "tasks_count": 0,
    "created_at": "2026-07-30 10:20:00"
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

  <div class="endpoint" id="ep-project-manage-projects-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}</code>
      <span class="endpoint-name">Update project</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Projects — updates a project belonging to the current business (404 if it belongs to another business). Unlike create, <code>status</code> can also be changed here (<code>active</code>, <code>on_hold</code>, <code>completed</code>, <code>archived</code>). Note: although <code>name</code> is validated as <code>sometimes</code>, <code>ProjectService::update()</code> unconditionally re-writes it from the payload — omitting <code>name</code> on a PATCH can clear it, so send it on every update.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 150 characters. See note above.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>client_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 120 characters.</td></tr>
            <tr><td>priority<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>low</code>, <code>normal</code>, <code>high</code>.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>active</code>, <code>on_hold</code>, <code>completed</code>, <code>archived</code>.</td></tr>
            <tr><td>color<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 20 characters.</td></tr>
            <tr><td>start_date<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
            <tr><td>budget<span class="param-required">opt</span></td><td class="param-type">numeric</td><td>Minimum 0.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "name": "POS Terminal Refresh",
    "description": "Rollout of the new POS UI to all branches.",
    "client_name": null,
    "status": "on_hold",
    "priority": "high",
    "color": "#4f46e5",
    "start_date": "2026-07-01",
    "due_date": "2026-09-30",
    "budget": 15000.00,
    "task_stats": { "todo": 4, "in_progress": 2, "review": 1, "done": 6, "total": 13 },
    "tasks_count": 13,
    "created_at": "2026-06-28 09:00:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected status is invalid.",
  "errors": { "status": ["The selected status is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-projects-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}</code>
      <span class="endpoint-name">Delete project</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Projects — deletes a project belonging to the current business. <code>ProjectService::delete()</code> refuses to delete a project that still has any tasks attached, returning a 422 instead — move or remove its tasks first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Project deleted."
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Move or remove tasks in this project before deleting it."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-board">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}/board</code>
      <span class="endpoint-name">Get kanban board</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Board — returns the project's tasks grouped into four fixed columns (<code>todo</code>, <code>in_progress</code>, <code>review</code>, <code>done</code>) ordered by <code>sort_order</code> then id, alongside the project summary itself. Used to render the drag-and-drop task board.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "project": {
    "id": 3,
    "name": "POS Terminal Refresh",
    "description": "Rollout of the new POS UI to all branches.",
    "client_name": null,
    "status": "active",
    "priority": "high",
    "color": "#4f46e5",
    "start_date": "2026-07-01",
    "due_date": "2026-09-30",
    "budget": 15000.00,
    "task_stats": { "todo": 4, "in_progress": 2, "review": 1, "done": 6, "total": 13 },
    "tasks_count": 13,
    "created_at": "2026-06-28 09:00:00"
  },
  "columns": [
    {
      "status": "todo",
      "label": "To Do",
      "tasks": [
        {
          "id": 41,
          "project_id": 3,
          "project_name": "POS Terminal Refresh",
          "milestone_id": 5,
          "milestone_name": "Beta rollout",
          "title": "Wire up receipt preview",
          "description": null,
          "status": "todo",
          "priority": "normal",
          "assigned_to": 12,
          "assigned_name": "Nadeesha Perera",
          "due_date": "2026-08-05",
          "estimated_hours": 4.0,
          "logged_minutes": 0,
          "is_overdue": false,
          "completed_at": null,
          "created_at": "2026-07-20 09:00:00"
        }
      ]
    },
    { "status": "in_progress", "label": "In Progress", "tasks": [] },
    { "status": "review", "label": "Review", "tasks": [] },
    { "status": "done", "label": "Done", "tasks": [] }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-milestones-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}/milestones</code>
      <span class="endpoint-name">List milestones</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Milestones — lists every milestone belonging to the given project, milestones without a due date sorted last, otherwise by ascending <code>due_date</code>. Includes each milestone's <code>tasks_count</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 5,
      "project_id": 3,
      "name": "Beta rollout",
      "description": "Ship to the two pilot branches.",
      "due_date": "2026-08-15",
      "status": "pending",
      "completed_at": null,
      "tasks_count": 6
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-milestones-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}/milestones</code>
      <span class="endpoint-name">Create milestone</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Milestones — creates a new milestone under the given project, always starting in <code>pending</code> status.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 150 characters.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 2000 characters.</td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 6,
    "project_id": 3,
    "name": "GA release",
    "description": null,
    "due_date": "2026-09-30",
    "status": "pending",
    "completed_at": null,
    "tasks_count": 0
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

  <div class="endpoint" id="ep-project-manage-milestones-complete">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/milestones/{id}/complete</code>
      <span class="endpoint-name">Complete milestone</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Milestones — marks the milestone <code>completed</code> and stamps <code>completed_at</code> with the current time. The milestone's project is resolved first and checked against the caller's business (404 otherwise). Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 5,
    "project_id": 3,
    "name": "Beta rollout",
    "description": "Ship to the two pilot branches.",
    "due_date": "2026-08-15",
    "status": "completed",
    "completed_at": "2026-07-30 10:30:00",
    "tasks_count": 6
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-milestones-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/pm/milestones/{id}</code>
      <span class="endpoint-name">Delete milestone</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Milestones — deletes the milestone. Tasks pointing at it are not deleted; their <code>milestone_id</code> foreign key is set null by the database (<code>nullOnDelete</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Milestone deleted."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}/tasks</code>
      <span class="endpoint-name">List tasks in project</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (project-scoped) — lists tasks for the given project, ordered by <code>sort_order</code> then descending id, with optional filters applied directly as equality <code>WHERE</code> clauses.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>todo</code>, <code>in_progress</code>, <code>review</code>, <code>done</code>.</td></tr>
            <tr><td>milestone_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter to tasks on a specific milestone.</td></tr>
            <tr><td>assigned_to<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Filter to tasks assigned to a specific user id.</td></tr>
            <tr><td>priority<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>low</code>, <code>normal</code>, <code>high</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 41,
      "project_id": 3,
      "project_name": "POS Terminal Refresh",
      "milestone_id": 5,
      "milestone_name": "Beta rollout",
      "title": "Wire up receipt preview",
      "description": null,
      "status": "todo",
      "priority": "normal",
      "assigned_to": 12,
      "assigned_name": "Nadeesha Perera",
      "due_date": "2026-08-05",
      "estimated_hours": 4.0,
      "logged_minutes": 0,
      "is_overdue": false,
      "completed_at": null,
      "created_at": "2026-07-20 09:00:00"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/projects/{id}/tasks</code>
      <span class="endpoint-name">Create task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (project-scoped) — creates a new task under the given project. <code>status</code> defaults to <code>todo</code> and <code>priority</code> defaults to <code>normal</code> when omitted.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>title</td><td class="param-type">string</td><td>Max 200 characters.</td></tr>
            <tr><td>description<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 5000 characters.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>todo</code>, <code>in_progress</code>, <code>review</code>, <code>done</code>. Defaults to <code>todo</code>.</td></tr>
            <tr><td>priority<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>low</code>, <code>normal</code>, <code>high</code>. Defaults to <code>normal</code>.</td></tr>
            <tr><td>milestone_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Attaches the task to an existing milestone.</td></tr>
            <tr><td>assigned_to<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Must reference an existing row in <code>users</code>.</td></tr>
            <tr><td>due_date<span class="param-required">opt</span></td><td class="param-type">date</td><td></td></tr>
            <tr><td>estimated_hours<span class="param-required">opt</span></td><td class="param-type">numeric</td><td>Minimum 0.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 42,
    "project_id": 3,
    "project_name": "POS Terminal Refresh",
    "milestone_id": null,
    "milestone_name": null,
    "title": "Add dark mode toggle",
    "description": null,
    "status": "todo",
    "priority": "normal",
    "assigned_to": null,
    "assigned_name": null,
    "due_date": null,
    "estimated_hours": null,
    "logged_minutes": 0,
    "is_overdue": false,
    "completed_at": null,
    "created_at": "2026-07-30 10:35:00"
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

  <div class="endpoint" id="ep-project-manage-tasks-status">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/pm/tasks/{id}/status</code>
      <span class="endpoint-name">Move task to a status column</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (task-scoped) — moves a task to a new board column. Used by the drag-and-drop board. Setting status to <code>done</code> stamps <code>completed_at</code> if not already set; moving away from <code>done</code> clears <code>completed_at</code> back to null.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>status</td><td class="param-type">string</td><td>One of <code>todo</code>, <code>in_progress</code>, <code>review</code>, <code>done</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 41,
    "project_id": 3,
    "project_name": "POS Terminal Refresh",
    "milestone_id": 5,
    "milestone_name": "Beta rollout",
    "title": "Wire up receipt preview",
    "description": null,
    "status": "in_progress",
    "priority": "normal",
    "assigned_to": 12,
    "assigned_name": "Nadeesha Perera",
    "due_date": "2026-08-05",
    "estimated_hours": 4.0,
    "logged_minutes": 0,
    "is_overdue": false,
    "completed_at": null,
    "created_at": "2026-07-20 09:00:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected status is invalid.",
  "errors": { "status": ["The selected status is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-complete">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/tasks/{id}/complete</code>
      <span class="endpoint-name">Complete task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (task-scoped) — shortcut that sets <code>status</code> to <code>done</code> and stamps <code>completed_at</code> with the current time, regardless of the task's current status. Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 41,
    "project_id": 3,
    "project_name": "POS Terminal Refresh",
    "milestone_id": 5,
    "milestone_name": "Beta rollout",
    "title": "Wire up receipt preview",
    "description": null,
    "status": "done",
    "priority": "normal",
    "assigned_to": 12,
    "assigned_name": "Nadeesha Perera",
    "due_date": "2026-08-05",
    "estimated_hours": 4.0,
    "logged_minutes": 90,
    "is_overdue": false,
    "completed_at": "2026-07-30 10:40:00",
    "created_at": "2026-07-20 09:00:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-reopen">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/tasks/{id}/reopen</code>
      <span class="endpoint-name">Reopen task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (task-scoped) — resets a completed task back to <code>status: todo</code> and clears <code>completed_at</code>. Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 41,
    "project_id": 3,
    "project_name": "POS Terminal Refresh",
    "milestone_id": 5,
    "milestone_name": "Beta rollout",
    "title": "Wire up receipt preview",
    "description": null,
    "status": "todo",
    "priority": "normal",
    "assigned_to": 12,
    "assigned_name": "Nadeesha Perera",
    "due_date": "2026-08-05",
    "estimated_hours": 4.0,
    "logged_minutes": 90,
    "is_overdue": true,
    "completed_at": null,
    "created_at": "2026-07-20 09:00:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/pm/tasks/{id}</code>
      <span class="endpoint-name">Delete task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (task-scoped) — permanently deletes the task, cascading to its comments and time logs at the database level (<code>cascadeOnDelete</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Task deleted."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-comment">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/tasks/{id}/comments</code>
      <span class="endpoint-name">Add task comment</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (task-scoped) — appends a comment to the task's discussion thread, attributed to the authenticated user (falls back to user id 0 / displayed as "System" if unauthenticated).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>body</td><td class="param-type">string</td><td>Max 5000 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 18,
    "user": "Nadeesha Perera",
    "body": "Blocked on the icon set from design.",
    "created_at": "2026-07-30 10:45:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The body field is required.",
  "errors": { "body": ["The body field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-tasks-time">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/pm/tasks/{id}/time</code>
      <span class="endpoint-name">Log time against task</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Tasks (task-scoped) — records a time entry against the task, attributed to the authenticated user. The task's <code>logged_minutes</code> (seen on the task resource) is the sum of all its time log entries.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>minutes</td><td class="param-type">integer</td><td>Between 1 and 9999.</td></tr>
            <tr><td>logged_at<span class="param-required">opt</span></td><td class="param-type">date</td><td>Defaults to null if omitted (stored as-is; the DB column is a plain date, not nullable at the schema level).</td></tr>
            <tr><td>note<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 characters.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 27,
    "minutes": 90,
    "logged_at": "2026-07-30",
    "note": "Implemented preview rendering."
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The minutes field is required.",
  "errors": { "minutes": ["The minutes field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-project-manage-my-tasks">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/pm/my-tasks</code>
      <span class="endpoint-name">List my tasks</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">My Tasks — a cross-project view of tasks for the current business, sorted with tasks that have no due date last, then by ascending due date. <code>filter</code> controls which subset is returned via <code>TaskService::listForBusiness()</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>filter<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>open</code> (default; excludes <code>done</code>), <code>overdue</code> (not done, past due date), <code>mine</code> (assigned to the caller, not done), <code>done</code>. Any other value returns all tasks unfiltered.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 41,
      "project_id": 3,
      "project_name": "POS Terminal Refresh",
      "milestone_id": 5,
      "milestone_name": "Beta rollout",
      "title": "Wire up receipt preview",
      "description": null,
      "status": "todo",
      "priority": "normal",
      "assigned_to": 12,
      "assigned_name": "Nadeesha Perera",
      "due_date": "2026-08-05",
      "estimated_hours": 4.0,
      "logged_minutes": 90,
      "is_overdue": false,
      "completed_at": null,
      "created_at": "2026-07-20 09:00:00"
    }
  ]
}</code></pre>
      </div>
@endverbatim
