@verbatim
  <div class="endpoint" id="ep-settings-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/settings</code>
      <span class="endpoint-name">Render user settings page</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Aliases straight to the <code>user()</code> action: renders the <code>settings::index</code> Blade view scoped to the authenticated user's own settings (tabs built from the enabled/non-disabled field definitions, current values merged in). HR-portal-only accounts are redirected away.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">User-scoped</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>Content-Type: text/html
(renders the `settings::index` Blade view — not JSON)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-settings-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/settings</code>
      <span class="endpoint-name">Set a single setting value</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Looks up <code>key</code> in the definitions for the given <code>scope</code>, rejects it if the field is unknown/disabled or (when marked required) the submitted value is empty, normalizes the value by field <code>type</code> (checkbox/number/select/file), then persists it via <code>SettingsService::set</code>. Redirects back to the settings page on success or failure.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">User- or business-scoped (per <code>scope</code>)</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>scope</td><td class="param-type">string</td><td><code>user</code> or <code>business</code>.</td></tr>
            <tr><td>key</td><td class="param-type">string</td><td>Max 100 chars. Must match a known, enabled field definition for the scope.</td></tr>
            <tr><td>value<span class="param-required">opt</span></td><td class="param-type">mixed</td><td>Normalized according to the field definition's <code>type</code> (checkbox → boolean, number → clamped int, select → validated against options, file → existing stored path).</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">302</span></h4>
        <pre class="code-block"><code>HTTP/1.1 302 Found
Location: /settings/user (or /settings/business)
(redirect with flashed "status" message — not JSON)</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-settings-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/settings</code>
      <span class="endpoint-name">Unset a setting value</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Removes a stored setting value via <code>SettingsService::forget</code>, after the same "known, enabled field" check as <code>store</code>. Note the key/scope are sent as a request body on a DELETE request, not as query params or a route segment.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer/session auth required</span>
        <span class="meta-pill">User- or business-scoped (per <code>scope</code>)</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>scope</td><td class="param-type">string</td><td><code>user</code> or <code>business</code>.</td></tr>
            <tr><td>key</td><td class="param-type">string</td><td>Max 100 chars. Must match a known, enabled field definition for the scope.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">302</span></h4>
        <pre class="code-block"><code>HTTP/1.1 302 Found
Location: /settings/user (or /settings/business)
(redirect with flashed "status" message — not JSON)</code></pre>
      </div>
@endverbatim
