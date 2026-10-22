@verbatim
  <div class="endpoint" id="ep-business-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/businesses</code>
      <span class="endpoint-name">List businesses</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Route is registered and reaches Sanctum auth, but <code>BusinessController</code> has no <code>index()</code> method. Calling this endpoint currently throws a fatal PHP error at dispatch time — it is non-functional.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not implemented</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">500</span></h4>
        <pre class="code-block"><code>Error: Call to undefined method
Modules\Business\Http\Controllers\BusinessController::index()</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-business-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/businesses</code>
      <span class="endpoint-name">Create business</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same gap as <code>index</code> — no <code>store()</code> method exists on <code>BusinessController</code>. Business creation actually happens via the web-only <code>storeOnboarding</code> action, not this API route.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not implemented</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">500</span></h4>
        <pre class="code-block"><code>Error: Call to undefined method
Modules\Business\Http\Controllers\BusinessController::store()</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-business-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/businesses/{business}</code>
      <span class="endpoint-name">Get business</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">No <code>show()</code> method exists on <code>BusinessController</code>. Non-functional.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not implemented</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">500</span></h4>
        <pre class="code-block"><code>Error: Call to undefined method
Modules\Business\Http\Controllers\BusinessController::show()</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-business-update">
    <div class="endpoint-head">
      <span class="method-badge method-put">PUT</span><span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/businesses/{business}</code>
      <span class="endpoint-name">Update business</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">No <code>update()</code> method exists on <code>BusinessController</code>. Business profile edits go through the web-only <code>updateBrand</code>, <code>updateLogo</code>, and <code>updateFeatures</code> actions instead.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not implemented</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">500</span></h4>
        <pre class="code-block"><code>Error: Call to undefined method
Modules\Business\Http\Controllers\BusinessController::update()</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-business-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/businesses/{business}</code>
      <span class="endpoint-name">Delete business</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">No <code>destroy()</code> method exists on <code>BusinessController</code>. Non-functional.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Not implemented</span>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">500</span></h4>
        <pre class="code-block"><code>Error: Call to undefined method
Modules\Business\Http\Controllers\BusinessController::destroy()</code></pre>
      </div>
@endverbatim
