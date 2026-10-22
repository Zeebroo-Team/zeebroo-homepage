@verbatim
  <div class="endpoint" id="ep-hr-management-core-ingest">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/hr/attendance/device-punches</code>
      <span class="endpoint-name">Ingest attendance device punches</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Not a Sanctum route — it sits only behind <code>throttle:api</code> and is authenticated by a per-business shared secret sent as <code>X-Attendance-Key</code>, checked against the business's <code>hr.attendance.device_ingestion_key</code> setting (constant-time compare). Each punch is deduplicated by a hash of business+device+employee_code+punch_time+punch_type (or by <code>external_event_id</code> if supplied), then matched to an employee via an active biometric device mapping and merged into that day's attendance record (earliest punch as check-in, latest as check-out unless explicit <code>in</code>/<code>out</code> types are given).</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">X-Attendance-Key header required (per-business secret) — no Sanctum token, no session</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>business_id</td><td class="param-type">integer</td><td>Must exist in <code>businesses</code>.</td></tr>
            <tr><td>device_id</td><td class="param-type">string</td><td>Max 100 chars.</td></tr>
            <tr><td>punches</td><td class="param-type">array</td><td>1 to 1000 entries.</td></tr>
            <tr><td>punches.*.employee_code</td><td class="param-type">string</td><td>Max 120 chars; matched against the device's biometric employee mapping.</td></tr>
            <tr><td>punches.*.punch_time</td><td class="param-type">date</td><td></td></tr>
            <tr><td>punches.*.punch_type<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>in</code>, <code>out</code>, <code>check_in</code>, <code>check_out</code>, <code>auto</code>.</td></tr>
            <tr><td>punches.*.external_event_id<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 191 chars. Used as the dedup key when present.</td></tr>
            <tr><td>punches.*.payload<span class="param-required">opt</span></td><td class="param-type">array</td><td>Raw device metadata, stored as-is.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "message": "Attendance punches ingested.",
  "data": {
    "accepted": 3,
    "processed": 2,
    "duplicates": 1,
    "errors": 0
  }
}</code></pre>
        <p class="endpoint-desc"><code>accepted</code> counts punches that weren't duplicates; <code>processed</code> counts those successfully folded into an attendance record; a punch can be accepted but not processed if no active biometric mapping matches its <code>employee_code</code> — it's logged on the device log row rather than surfaced as an error here.</p>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "Invalid biometric attendance payload.",
  "errors": { "punches.0.punch_time": ["The punches.0.punch_time field is required."] }
}</code></pre>
      </div>
    </div>
  </div>
@endverbatim
