@verbatim
  <div class="endpoint" id="ep-app-connection-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/releases</code>
      <span class="endpoint-name">Publish a release</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Publishes (or updates, keyed by <code>version</code>) a desktop release entry, intended to be called from CI. If <code>is_latest</code> is true, every other release on the same <code>channel</code> is flipped to <code>is_latest = false</code> first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">X-Api-Key header required (matches <code>services.zeebroo.api_key</code> config) — not a Sanctum bearer token</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>version</td><td class="param-type">string</td><td>Max 32 chars. Unique key used for upsert.</td></tr>
            <tr><td>release_date</td><td class="param-type">date</td><td></td></tr>
            <tr><td>channel</td><td class="param-type">string</td><td>One of <code>stable</code>, <code>beta</code>, <code>alpha</code>, <code>rc</code>.</td></tr>
            <tr><td>is_latest<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>When true, unmarks other releases on the same channel.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">array of strings</td><td>Changelog bullet points.</td></tr>
            <tr><td>windows_url<span class="param-required">opt</span></td><td class="param-type">string (url)</td><td>Windows installer download link.</td></tr>
            <tr><td>macos_url<span class="param-required">opt</span></td><td class="param-type">string (url)</td><td>macOS Apple Silicon (arm64) download link.</td></tr>
            <tr><td>macos_intel_url<span class="param-required">opt</span></td><td class="param-type">string (url)</td><td>macOS Intel (x64) download link.</td></tr>
            <tr><td>linux_url<span class="param-required">opt</span></td><td class="param-type">string (url)</td><td>Linux installer download link.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 7,
    "version": "4.3.0",
    "release_date": "2026-07-31",
    "channel": "stable",
    "is_latest": true,
    "notes": ["Cashier management added", "Bug fixes"],
    "windows_url": "https://.../Zeebroo-Setup-4.3.0.exe",
    "macos_url": "https://.../Zeebroo-4.3.0-arm64.zip",
    "macos_intel_url": "https://.../Zeebroo-4.3.0-x64.zip",
    "linux_url": null,
    "created_at": "2026-07-31T10:00:00.000000Z",
    "updated_at": "2026-07-31T10:00:00.000000Z"
  }
}</code></pre>
        <p class="endpoint-desc">Returns <code>200</code> instead of <code>201</code> when an existing release with the same <code>version</code> was updated rather than created.</p>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">401</span></h4>
        <pre class="code-block"><code>{ "message": "Unauthorized" }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-app-connection-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/releases</code>
      <span class="endpoint-name">List releases</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every published release, ordered newest release date (then id) first. No pagination.</p>
      <div class="endpoint-meta">
        <span class="meta-pill">No authentication required</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 7,
      "version": "4.3.0",
      "release_date": "2026-07-31",
      "channel": "stable",
      "is_latest": true,
      "notes": ["Cashier management added"],
      "windows_url": "https://.../Zeebroo-Setup-4.3.0.exe",
      "macos_url": "https://.../Zeebroo-4.3.0-arm64.zip",
      "macos_intel_url": "https://.../Zeebroo-4.3.0-x64.zip",
      "linux_url": null
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-app-connection-latest">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/releases/latest</code>
      <span class="endpoint-name">Get latest stable release</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Used by the desktop app's auto-update check. Prefers the <code>stable</code> release flagged <code>is_latest</code>; falls back to the highest-id <code>stable</code> release if none is flagged. Returns <code>"data": null</code> if no stable release exists yet (or on a query error, which is swallowed).</p>
      <div class="endpoint-meta">
        <span class="meta-pill">No authentication required</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 7,
    "version": "4.3.0",
    "release_date": "2026-07-31",
    "channel": "stable",
    "is_latest": true,
    "windows_url": "https://.../Zeebroo-Setup-4.3.0.exe",
    "macos_url": "https://.../Zeebroo-4.3.0-arm64.zip",
    "macos_intel_url": "https://.../Zeebroo-4.3.0-x64.zip",
    "linux_url": null
  }
}</code></pre>
      </div>
@endverbatim
