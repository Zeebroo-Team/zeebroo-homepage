@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-payroll-rule-sets-list"><span class="method-badge method-get">GET</span> /hr/payroll/rule-sets</a>
    <a href="#ep-payroll-rule-sets-store"><span class="method-badge method-post">POST</span> /hr/payroll/rule-sets</a>
    <a href="#ep-payroll-rule-sets-show"><span class="method-badge method-get">GET</span> /hr/payroll/rule-sets/{ruleSet}</a>
    <a href="#ep-payroll-rule-sets-update"><span class="method-badge method-patch">PATCH</span> /hr/payroll/rule-sets/{ruleSet}</a>
    <a href="#ep-payroll-rule-sets-destroy"><span class="method-badge method-delete">DELETE</span> /hr/payroll/rule-sets/{ruleSet}</a>
    <a href="#ep-payroll-rule-sets-rule-store"><span class="method-badge method-post">POST</span> /hr/payroll/rule-sets/{ruleSet}/rules</a>
    <a href="#ep-payroll-rule-sets-rule-update"><span class="method-badge method-patch">PATCH</span> /hr/payroll/rule-sets/{ruleSet}/rules/{rule}</a>
    <a href="#ep-payroll-rule-sets-rule-destroy"><span class="method-badge method-delete">DELETE</span> /hr/payroll/rule-sets/{ruleSet}/rules/{rule}</a>
    <a href="#ep-payroll-rule-sets-templates-list"><span class="method-badge method-get">GET</span> /hr/payroll/templates</a>
    <a href="#ep-payroll-rule-sets-templates-install"><span class="method-badge method-post">POST</span> /hr/payroll/templates/{key}/install</a>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets</code>
      <span class="endpoint-name">List payroll rule sets</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists all payroll rule sets for the current business, ordered with the default rule set first and then by most recent effective_from. Each entry is annotated with its rule count. Returns an empty list if the HR payroll tables have not been migrated yet.</p>
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
      "name": "Sri Lanka Standard 2026",
      "currency": "LKR",
      "effective_from": "2026-01-01",
      "effective_to": null,
      "is_default": true,
      "is_active": true,
      "notes": null,
      "rules_count": 12
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets</code>
      <span class="endpoint-name">Create a payroll rule set</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a new payroll rule set for the business. If is_default is true, the default flag is cleared on all other rule sets for the business first. Fails with 422 if the HR payroll tables are not migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Rule set name, max 140 chars.</td></tr>
            <tr><td>currency</td><td class="param-type">string</td><td>Currency code, max 16 chars (e.g. "LKR").</td></tr>
            <tr><td>effective_from</td><td class="param-type">date</td><td>Date the rule set becomes effective.</td></tr>
            <tr><td>effective_to<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be on or after effective_from.</td></tr>
            <tr><td>is_default<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Marks this as the business's default rule set.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text notes, max 5000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 3,
    "name": "Sri Lanka Standard 2027",
    "currency": "LKR",
    "effective_from": "2027-01-01",
    "effective_to": null,
    "is_default": true,
    "is_active": true,
    "notes": null,
    "rules_count": 0
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

  <div class="endpoint" id="ep-payroll-rule-sets-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets/{ruleSet}</code>
      <span class="endpoint-name">Get rule set detail with rules</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single rule set together with its full ordered list of payroll rules (earnings, deductions, statutory components). Returns 404 if the rule set does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 1,
    "name": "Sri Lanka Standard 2026",
    "currency": "LKR",
    "effective_from": "2026-01-01",
    "effective_to": null,
    "is_default": true,
    "is_active": true,
    "notes": null,
    "rules_count": 2,
    "rules": [
      {
        "id": 10,
        "rule_set_id": 1,
        "code": "BASIC_SALARY",
        "name": "Basic Salary",
        "component_type": "earning",
        "calculation_mode": "fixed",
        "sort_order": 0,
        "is_taxable": true,
        "is_statutory": false,
        "is_active": true,
        "config_json": []
      },
      {
        "id": 11,
        "rule_set_id": 1,
        "code": "EPF_EMPLOYEE",
        "name": "EPF (Employee)",
        "component_type": "statutory",
        "calculation_mode": "percentage",
        "sort_order": 10,
        "is_taxable": false,
        "is_statutory": true,
        "is_active": true,
        "config_json": { "rate": 8 }
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets/{ruleSet}</code>
      <span class="endpoint-name">Update a rule set</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates a rule set's metadata. If is_default is set to true, the default flag is cleared from the business's other rule sets.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Rule set name, max 140 chars.</td></tr>
            <tr><td>currency<span class="param-required">opt</span></td><td class="param-type">string</td><td>Currency code, max 16 chars.</td></tr>
            <tr><td>effective_from<span class="param-required">opt</span></td><td class="param-type">date</td><td>Effective start date.</td></tr>
            <tr><td>effective_to<span class="param-required">opt</span></td><td class="param-type">date</td><td>Effective end date.</td></tr>
            <tr><td>is_default<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Marks this as the business's default rule set.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Deactivates the rule set without deleting it.</td></tr>
            <tr><td>notes<span class="param-required">opt</span></td><td class="param-type">string</td><td>Free-text notes, max 5000 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 1,
    "name": "Sri Lanka Standard 2026 (Revised)",
    "currency": "LKR",
    "effective_from": "2026-01-01",
    "effective_to": null,
    "is_default": true,
    "is_active": true,
    "notes": null,
    "rules_count": 12
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The effective from field must be a valid date.",
  "errors": { "effective_from": ["The effective from field must be a valid date."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets/{ruleSet}</code>
      <span class="endpoint-name">Delete a rule set</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Deletes a rule set. Rejected with a 422 if any payroll cycle references this rule set — those cycles must be removed first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Rule set deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-rule-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets/{ruleSet}/rules</code>
      <span class="endpoint-name">Add a rule to a rule set</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Adds a new payroll calculation rule (earning, deduction, statutory, overtime, informational, or employer-tracking component) to a rule set. The code is upper-cased and non-alphanumeric characters are replaced with underscores; duplicate codes within the same rule set are rejected with a 422.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>code</td><td class="param-type">string</td><td>Rule code, max 64 chars; normalized to uppercase.</td></tr>
            <tr><td>name</td><td class="param-type">string</td><td>Display name, max 140 chars.</td></tr>
            <tr><td>component_type</td><td class="param-type">string</td><td>One of: earning, deduction, statutory, overtime, informational, employer_tracking.</td></tr>
            <tr><td>calculation_mode</td><td class="param-type">string</td><td>One of: fixed, percentage, slab, formula.</td></tr>
            <tr><td>sort_order<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Display order, min 0. Defaults to 0.</td></tr>
            <tr><td>is_taxable<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Whether the component is included in taxable income.</td></tr>
            <tr><td>is_statutory<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Whether the component is a statutory requirement.</td></tr>
            <tr><td>config_json<span class="param-required">opt</span></td><td class="param-type">string</td><td>JSON string with calculation config (e.g. percentage rate, slab bands, formula).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 22,
    "rule_set_id": 1,
    "code": "TRANSPORT_ALLOWANCE",
    "name": "Transport Allowance",
    "component_type": "earning",
    "calculation_mode": "fixed",
    "sort_order": 5,
    "is_taxable": true,
    "is_statutory": false,
    "is_active": true,
    "config_json": { "amount": 5000 }
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "A rule with code TRANSPORT_ALLOWANCE already exists in this rule set." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-rule-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets/{ruleSet}/rules/{rule}</code>
      <span class="endpoint-name">Update a payroll rule</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates a payroll rule. Returns 404 if the rule does not belong to the given rule set. Note: the rule's code, component_type, and calculation_mode cannot be changed after creation.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Display name, max 140 chars.</td></tr>
            <tr><td>sort_order<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Display order, min 0.</td></tr>
            <tr><td>is_taxable<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Whether the component is included in taxable income.</td></tr>
            <tr><td>is_statutory<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Whether the component is a statutory requirement.</td></tr>
            <tr><td>is_active<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Deactivates the rule without deleting it.</td></tr>
            <tr><td>config_json<span class="param-required">opt</span></td><td class="param-type">string</td><td>JSON string with calculation config; send null/empty to clear it.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 22,
    "rule_set_id": 1,
    "code": "TRANSPORT_ALLOWANCE",
    "name": "Transport Allowance (Revised)",
    "component_type": "earning",
    "calculation_mode": "fixed",
    "sort_order": 6,
    "is_taxable": true,
    "is_statutory": false,
    "is_active": true,
    "config_json": { "amount": 6000 }
  }
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "config_json is not valid JSON." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-rule-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/rule-sets/{ruleSet}/rules/{rule}</code>
      <span class="endpoint-name">Delete a payroll rule</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Removes a rule from a rule set. Returns 404 if the rule does not belong to the given rule set.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Requires hr_payroll permission</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Rule deleted." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-templates-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/templates</code>
      <span class="endpoint-name">List regional payroll templates</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists the regional payroll templates available to install (e.g. Sri Lanka statutory starter, India illustrative PF/ESI/professional-tax scaffold), each with a title, description, and highlight bullet points. Not business-scoped — the same catalog is returned for everyone.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "key": "lk_26_day_epf_worksheet",
      "title": "Sri Lanka — 26-Day EPF Worksheet",
      "description": "Regional defaults for Sri Lanka payroll: statutory components, tax slabs, and starter cycle presets. Applying replaces rules on the linked starter rule set.",
      "highlights": ["EPF 8% / 12%", "ETF 3%", "APIT slabs"]
    },
    {
      "key": "india_standard",
      "title": "India — Standard Scaffold",
      "description": "Illustrative India payroll scaffolding: PF, ESI, professional tax slab, indicative monthly TDS-style slabs on taxable pay, plus overtime helper.",
      "highlights": ["PF 12%", "ESI", "Professional tax"]
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-payroll-rule-sets-templates-install">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/hr/payroll/templates/{key}/install</code>
      <span class="endpoint-name">Install a regional payroll template</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Installs the named regional template for the current business, creating (or replacing the rules on) a starter payroll rule set. Returns 404 if the template key is unknown, and 422 if the HR payroll tables have not been migrated yet.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>key</td><td class="param-type">string</td><td>Template key from the templates list, e.g. "lk_26_day_epf_worksheet".</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Template installed successfully." }</code></pre>
      </div>
@endverbatim
