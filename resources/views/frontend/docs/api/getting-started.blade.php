@verbatim
<div class="doc-sec">
  <h3>Base URL</h3>
  <p>Most of the API lives under <code class="ui">/api/v1/pos</code>. A few modules (Developers, most of Platform Modules) have their own base paths — the full path is always shown on each endpoint card.</p>
</div>

<div class="doc-sec">
  <h3>Authentication</h3>
  <div class="doc-steps">
    <div class="doc-step">
      <div class="step-num">1</div>
      <div class="step-body"><strong>Get a token</strong><p><code class="ui">POST /auth/token</code> with <code class="ui">email</code> + <code class="ui">password</code> → returns an <code class="ui">access_token</code>.</p></div>
    </div>
    <div class="doc-step">
      <div class="step-num">2</div>
      <div class="step-body"><strong>Send it on every protected request</strong><p>Header: <code class="ui">Authorization: Bearer {access_token}</code></p></div>
    </div>
  </div>
</div>

<div class="doc-sec">
  <h3>Business &amp; branch scope</h3>
  <p>Most endpoints are scoped to a business. Send <strong>one</strong> of:</p>
  <ul>
    <li>Header <code class="ui">X-Business-Id: {id}</code> <em>(recommended)</em></li>
    <li>Query param <code class="ui">?business_id={id}</code></li>
  </ul>
  <p>If omitted, the API falls back to the authenticated user's most-recently-selected business. When branch-level POS separation is enabled, additionally send header <code class="ui">X-Branch-Id: {id}</code>.</p>
</div>

<div class="doc-sec">
  <h3>Response envelope</h3>
  <p>Successful responses follow <code class="ui">{ "data": … }</code>. Lists add pagination: <code class="ui">{ "data": […], "meta": { pagination } }</code>. Errors return <code class="ui">{ "message": "…", "errors": { "field": ["…"] } }</code> with an appropriate HTTP status code.</p>
</div>

<div class="callout note">
  <div class="callout-icon"><i class="fa-solid fa-circle-info"></i></div>
  <div class="callout-body"><strong>Source</strong>A large part of the Pos module (auth, catalog, checkout, products, sales, invoicing, purchasing, HR/payroll) has a hand-maintained OpenAPI 3.0 spec at <code class="ui">Modules/Pos/docs/openapi.yaml</code>, served live at <code class="ui">/api/v1/pos/docs/openapi.yaml</code>. This reference was built by combining that spec with a direct read of every controller for endpoints the spec doesn't yet cover.</div>
</div>
@endverbatim
