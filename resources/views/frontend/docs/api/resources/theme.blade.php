@verbatim
  <div class="endpoint" id="ep-theme-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/themes</code>
      <span class="endpoint-name">List themes</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Renders the <code>theme::index</code> Blade view (the only view file that actually exists in the module). No data is queried or passed to the view — there's no Theme model.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not backed by a model</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>Content-Type: text/html
(renders the `theme::index` Blade view — not JSON, no data)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-theme-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/themes</code>
      <span class="endpoint-name">Create theme</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc"><code>store(Request $request) {}</code> — an empty method body. The request is accepted and validated against nothing, and nothing is persisted or returned.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">No-op</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>(empty response body — the method has no implementation)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-theme-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/themes/{theme}</code>
      <span class="endpoint-name">Get theme</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Attempts to render <code>theme::show</code>, which does not exist under <code>Modules/Theme/resources/views/</code> — this currently throws a view-not-found error.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not implemented</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">500</span></h4>
        <pre class="code-block"><code>InvalidArgumentException: View [theme::show] not found.</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-theme-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span><span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/themes/{theme}</code>
      <span class="endpoint-name">Update theme</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc"><code>update(Request $request, $id) {}</code> — an empty method body. No-op, nothing persisted.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">No-op</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>(empty response body — the method has no implementation)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-theme-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/themes/{theme}</code>
      <span class="endpoint-name">Delete theme</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc"><code>destroy($id) {}</code> — an empty method body. No-op, nothing deleted.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">No-op</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>(empty response body — the method has no implementation)</code></pre>
      </div>
@endverbatim
