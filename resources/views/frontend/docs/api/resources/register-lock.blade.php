@verbatim
  <div class="endpoint" id="ep-register-lock-verify">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/verify-password</code>
      <span class="endpoint-name">Verify password</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Checks the supplied password against the currently authenticated user's stored password hash and returns <code>{ "ok": true }</code> on match. Used to unlock a register that was locked mid-session rather than requiring a fresh login.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>password</td><td class="param-type">string</td><td>The current user's account password.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "ok": true
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Incorrect password."
}</code></pre>
      </div>
@endverbatim
