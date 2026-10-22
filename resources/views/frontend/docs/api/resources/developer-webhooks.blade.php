@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-developer-webhooks-index"><span class="method-badge method-get">GET</span> /api/v1/developers/webhooks</a>
    <a href="#ep-developer-webhooks-store"><span class="method-badge method-post">POST</span> /api/v1/developers/webhooks</a>
    <a href="#ep-developer-webhooks-update"><span class="method-badge method-patch">PATCH</span> /api/v1/developers/webhooks/{id}</a>
    <a href="#ep-developer-webhooks-regenerate-secret"><span class="method-badge method-post">POST</span> /api/v1/developers/webhooks/{id}/regenerate-secret</a>
    <a href="#ep-developer-webhooks-destroy"><span class="method-badge method-delete">DELETE</span> /api/v1/developers/webhooks/{id}</a>
    <a href="#ep-developer-webhooks-index-pos"><span class="method-badge method-get">GET</span> /api/v1/pos/developers/webhooks</a>
    <a href="#ep-developer-webhooks-store-pos"><span class="method-badge method-post">POST</span> /api/v1/pos/developers/webhooks</a>
    <a href="#ep-developer-webhooks-update-pos"><span class="method-badge method-patch">PATCH</span> /api/v1/pos/developers/webhooks/{id}</a>
    <a href="#ep-developer-webhooks-regenerate-secret-pos"><span class="method-badge method-post">POST</span> /api/v1/pos/developers/webhooks/{id}/regenerate-secret</a>
    <a href="#ep-developer-webhooks-destroy-pos"><span class="method-badge method-delete">DELETE</span> /api/v1/pos/developers/webhooks/{id}</a>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-index">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/developers/webhooks</code>
      <span class="endpoint-name">List webhooks</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns every webhook subscription for the current business plus <code>available_events</code>, the full catalog of subscribable event keys. Unlike API keys, the webhook <code>secret</code> is stored in the clear and returned in full on every read — not masked, and not one-time.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 2,
      "name": "Inventory Bridge",
      "url": "https://example.com/hooks/zeebroo",
      "secret": "hQ3nP9mZ7xR2vK8tL4wC6yB1dF5sA0eG",
      "events": ["stock.updated", "product.updated"],
      "is_active": true,
      "failure_count": 0,
      "last_triggered_at": "2026-07-29 18:22:10",
      "created_at": "2026-07-15 08:00:00"
    }
  ],
  "available_events": {
    "sale.created": "Sale Created",
    "sale.voided": "Sale Voided",
    "sale.refunded": "Sale Refunded",
    "invoice.created": "Invoice Created",
    "invoice.paid": "Invoice Paid",
    "product.created": "Product Created",
    "product.updated": "Product Updated",
    "stock.updated": "Stock Updated",
    "grn.created": "GRN Created",
    "customer.created": "Customer Created",
    "order.created": "Purchase Order Created"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/developers/webhooks</code>
      <span class="endpoint-name">Create webhook</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Registers a new webhook for the current business, auto-generating a 32-character HMAC secret via <code>Webhook::generateSecret()</code> and defaulting it to active with <code>failure_count</code> 0. Each entry in <code>events</code> must be one of the keys listed in <code>available_events</code> (see the list endpoint above).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Label shown in the webhooks list. Max 100 characters.</td></tr>
            <tr><td>url</td><td class="param-type">string</td><td>Must be a valid URL, max 500 characters. Receives the signed POST payload.</td></tr>
            <tr><td>events</td><td class="param-type">array</td><td>At least one event key, each validated against <code>Webhook::availableEvents()</code> (e.g. <code>sale.created</code>, <code>stock.updated</code>).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 7,
    "name": "Order Sync",
    "url": "https://example.com/hooks/orders",
    "secret": "tR8mK1pQ4nX7vZ2sC5wB9dF0eG6yA3hL",
    "events": ["sale.created", "sale.refunded"],
    "is_active": true,
    "failure_count": 0,
    "last_triggered_at": null,
    "created_at": "2026-07-30 10:10:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected events.0 is invalid.",
  "errors": { "events.0": ["The selected events.0 is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/developers/webhooks/{id}</code>
      <span class="endpoint-name">Update webhook</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates a webhook's name, URL, subscribed events, or active flag for the current business. All fields are optional (<code>sometimes</code>) and only the supplied ones are written — this is the endpoint used to pause a webhook by sending <code>is_active: false</code>.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 100 characters.</td></tr>
            <tr><td>url<span class="param-required">opt</span></td><td class="param-type">string</td><td>Must be a valid URL, max 500 characters.</td></tr>
            <tr><td>events<span class="param-required">opt</span></td><td class="param-type">array</td><td>At least one event key when supplied; replaces the full events list.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Pause or resume delivery without deleting the subscription.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 2,
    "name": "Inventory Bridge",
    "url": "https://example.com/hooks/zeebroo",
    "secret": "hQ3nP9mZ7xR2vK8tL4wC6yB1dF5sA0eG",
    "events": ["stock.updated"],
    "is_active": false,
    "failure_count": 3,
    "last_triggered_at": "2026-07-29 18:22:10",
    "created_at": "2026-07-15 08:00:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The url must be a valid URL.",
  "errors": { "url": ["The url must be a valid URL."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-regenerate-secret">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/developers/webhooks/{id}/regenerate-secret</code>
      <span class="endpoint-name">Regenerate webhook secret</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Issues a fresh random HMAC secret for the webhook and resets <code>failure_count</code> back to 0, without touching name/url/events. Use after a suspected secret leak, or to clear a webhook that has been failing delivery. Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 2,
    "name": "Inventory Bridge",
    "url": "https://example.com/hooks/zeebroo",
    "secret": "vK2sN8xM5pQ0tR7wL3dC9yB4eF1hA6gZ",
    "events": ["stock.updated"],
    "is_active": true,
    "failure_count": 0,
    "last_triggered_at": "2026-07-29 18:22:10",
    "created_at": "2026-07-15 08:00:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/developers/webhooks/{id}</code>
      <span class="endpoint-name">Delete webhook</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently removes the webhook subscription, scoped to the current business. No further events will be delivered to its URL.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Webhook deleted."
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-index-pos">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/developers/webhooks</code>
      <span class="endpoint-name">List webhooks (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperWebhookApiController@index</code> handler as <code>/api/v1/developers/webhooks</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.webhooks.index</code>). Identical response shape, including the full <code>secret</code> value and <code>available_events</code> catalog.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 2,
      "name": "Inventory Bridge",
      "url": "https://example.com/hooks/zeebroo",
      "secret": "hQ3nP9mZ7xR2vK8tL4wC6yB1dF5sA0eG",
      "events": ["stock.updated", "product.updated"],
      "is_active": true,
      "failure_count": 0,
      "last_triggered_at": "2026-07-29 18:22:10",
      "created_at": "2026-07-15 08:00:00"
    }
  ],
  "available_events": {
    "sale.created": "Sale Created",
    "sale.voided": "Sale Voided",
    "sale.refunded": "Sale Refunded",
    "invoice.created": "Invoice Created",
    "invoice.paid": "Invoice Paid",
    "product.created": "Product Created",
    "product.updated": "Product Updated",
    "stock.updated": "Stock Updated",
    "grn.created": "GRN Created",
    "customer.created": "Customer Created",
    "order.created": "Purchase Order Created"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-store-pos">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/developers/webhooks</code>
      <span class="endpoint-name">Create webhook (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperWebhookApiController@store</code> handler as <code>/api/v1/developers/webhooks</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.webhooks.store</code>). Same validation rules and auto-generated secret.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Label shown in the webhooks list. Max 100 characters.</td></tr>
            <tr><td>url</td><td class="param-type">string</td><td>Must be a valid URL, max 500 characters.</td></tr>
            <tr><td>events</td><td class="param-type">array</td><td>At least one event key, validated against <code>Webhook::availableEvents()</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 8,
    "name": "Accounting Export",
    "url": "https://example.com/hooks/accounting",
    "secret": "wE5tY8uI2oP9aS3dF6gH1jK4lZ7xC0vB",
    "events": ["invoice.created", "invoice.paid"],
    "is_active": true,
    "failure_count": 0,
    "last_triggered_at": null,
    "created_at": "2026-07-30 10:15:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The events field is required.",
  "errors": { "events": ["The events field is required."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-update-pos">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/developers/webhooks/{id}</code>
      <span class="endpoint-name">Update webhook (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperWebhookApiController@update</code> handler as <code>/api/v1/developers/webhooks/{id}</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.webhooks.update</code>). All fields optional; only supplied ones are changed.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 100 characters.</td></tr>
            <tr><td>url<span class="param-required">opt</span></td><td class="param-type">string</td><td>Must be a valid URL, max 500 characters.</td></tr>
            <tr><td>events<span class="param-required">opt</span></td><td class="param-type">array</td><td>At least one event key when supplied; replaces the full events list.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Pause or resume delivery.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 8,
    "name": "Accounting Export",
    "url": "https://example.com/hooks/accounting-v2",
    "secret": "wE5tY8uI2oP9aS3dF6gH1jK4lZ7xC0vB",
    "events": ["invoice.created", "invoice.paid"],
    "is_active": true,
    "failure_count": 0,
    "last_triggered_at": null,
    "created_at": "2026-07-30 10:15:00"
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The events must have at least 1 items.",
  "errors": { "events": ["The events must have at least 1 items."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-regenerate-secret-pos">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/developers/webhooks/{id}/regenerate-secret</code>
      <span class="endpoint-name">Regenerate webhook secret (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperWebhookApiController@regenerateSecret</code> handler as <code>/api/v1/developers/webhooks/{id}/regenerate-secret</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.webhooks.regenerate-secret</code>). Resets <code>failure_count</code> to 0. Takes no request body.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 8,
    "name": "Accounting Export",
    "url": "https://example.com/hooks/accounting-v2",
    "secret": "nJ6bV3cX9zL1kM4qW7eR0tY5uI8oP2aS",
    "events": ["invoice.created", "invoice.paid"],
    "is_active": true,
    "failure_count": 0,
    "last_triggered_at": null,
    "created_at": "2026-07-30 10:15:00"
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-developer-webhooks-destroy-pos">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/developers/webhooks/{id}</code>
      <span class="endpoint-name">Delete webhook (POS-prefixed mount)</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Same <code>DeveloperWebhookApiController@destroy</code> handler as <code>/api/v1/developers/webhooks/{id}</code> above, registered under the <code>/api/v1/pos</code> prefix (route name <code>api.pos.developers.webhooks.destroy</code>).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Webhook deleted."
}</code></pre>
      </div>
@endverbatim
