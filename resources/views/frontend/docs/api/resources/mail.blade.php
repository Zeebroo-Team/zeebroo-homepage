@verbatim
  <div class="chapter-endpoint-nav">
    <a href="#ep-mail-threads-list"><span class="method-badge method-get">GET</span> /mail/threads</a>
    <a href="#ep-mail-thread-show"><span class="method-badge method-get">GET</span> /mail/thread</a>
    <a href="#ep-mail-messages-list"><span class="method-badge method-get">GET</span> /mail/messages</a>
    <a href="#ep-mail-messages-show"><span class="method-badge method-get">GET</span> /mail/messages/{message}</a>
    <a href="#ep-mail-messages-read"><span class="method-badge method-post">POST</span> /mail/messages/{message}/read</a>
    <a href="#ep-mail-send"><span class="method-badge method-post">POST</span> /mail/send</a>
    <a href="#ep-mail-templates-list"><span class="method-badge method-get">GET</span> /mail/templates</a>
    <a href="#ep-mail-templates-store"><span class="method-badge method-post">POST</span> /mail/templates</a>
    <a href="#ep-mail-templates-destroy"><span class="method-badge method-delete">DELETE</span> /mail/templates/{template}</a>
    <a href="#ep-mail-scheduled-list"><span class="method-badge method-get">GET</span> /mail/scheduled</a>
    <a href="#ep-mail-scheduled-destroy"><span class="method-badge method-delete">DELETE</span> /mail/scheduled/{scheduledMail}</a>
    <a href="#ep-mail-filters-list"><span class="method-badge method-get">GET</span> /mail/filters</a>
    <a href="#ep-mail-settings-show"><span class="method-badge method-get">GET</span> /mail/settings</a>
    <a href="#ep-mail-settings-update"><span class="method-badge method-patch">PATCH</span> /mail/settings</a>
    <a href="#ep-mail-sync"><span class="method-badge method-post">POST</span> /mail/sync</a>
    <a href="#ep-mail-test"><span class="method-badge method-post">POST</span> /mail/test</a>
    <a href="#ep-mail-verify-credentials"><span class="method-badge method-post">POST</span> /mail/verify-credentials</a>
  </div>

  <h3>Threads &amp; messages</h3>

  <div class="endpoint" id="ep-mail-threads-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/threads</code>
      <span class="endpoint-name">List conversation threads</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Groups the last 200 matching messages (inbox or sent) by counterpart email address into a conversation list, sorted by most recent message. Mirrors the web inbox index view.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>box<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>inbox</code> or <code>sent</code>. Defaults to <code>inbox</code>; any other value also falls back to <code>inbox</code>.</td></tr>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Searches subject, from name/address, to address, and body text.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>read</code> or <code>unread</code>. Ignored for other values.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "contact_email": "jane@acmecafe.com",
      "contact_name": "Jane Silva",
      "message_count": 4,
      "unread_count": 1,
      "has_unread": true,
      "latest_subject": "Re: Your quote request",
      "latest_label": "28 Jul, 14:32",
      "latest_ts": "2026-07-28T14:32:00+00:00",
      "preview": "Thanks for the quick response, I have a follow-up question..."
    }
  ],
  "meta": {
    "box": "inbox",
    "total_unread": 5,
    "status_counts": { "all": 42, "unread": 5, "read": 37 }
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-thread-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/thread</code>
      <span class="endpoint-name">Get thread timeline</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the full conversation timeline (up to 50 messages, oldest first) with a given counterpart email — both inbound and outbound — plus any matching POS customer record. When <code>box=inbox</code>, all unread inbound messages from that address are marked as read as a side effect of this call.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>contact</td><td class="param-type">string</td><td>Counterpart email address. Returns HTTP 422 with <code>{"message": "Contact email is required."}</code> if blank.</td></tr>
            <tr><td>box<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>inbox</code> or <code>sent</code>. Defaults to <code>inbox</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "contact_email": "jane@acmecafe.com",
    "contact_name": "Jane Silva",
    "reply_subject": "Re: Your quote request",
    "customer": { "id": 88, "name": "Jane Silva", "email": "jane@acmecafe.com", "phone": "0771234567" },
    "messages": [
      {
        "id": 501,
        "direction": "inbound",
        "from_name": "Jane Silva",
        "from_address": "jane@acmecafe.com",
        "to_address": "sales@business.com",
        "subject": "Your quote request",
        "body_text": "Hi, could you send a quote for...",
        "body_html": "&lt;p&gt;Hi, could you send a quote for...&lt;/p&gt;",
        "is_read": true,
        "occurred_at": "2026-07-27T09:00:00+00:00",
        "date_label": "27 Jul, 09:00"
      }
    ]
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-messages-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/messages</code>
      <span class="endpoint-name">List messages</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Flat (non-grouped) list of up to 100 messages for the inbox or sent box, newest first, without message bodies.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>box<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>inbox</code> or <code>sent</code>. Defaults to <code>inbox</code>.</td></tr>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Searches subject, from name/address, to address.</td></tr>
            <tr><td>status<span class="param-required">opt</span></td><td class="param-type">string</td><td><code>read</code> or <code>unread</code>.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 501,
      "direction": "inbound",
      "from_address": "jane@acmecafe.com",
      "from_name": "Jane Silva",
      "to_address": "sales@business.com",
      "subject": "Your quote request",
      "is_read": true,
      "occurred_at": "2026-07-27T09:00:00+00:00",
      "date_label": "27 Jul 2026, 09:00"
    }
  ],
  "meta": { "box": "inbox", "unread": 5 }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-messages-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/messages/{message}</code>
      <span class="endpoint-name">Get message</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns a single message with its body. If the message is inbound and unread, it is marked read as a side effect. Returns a 404-style message envelope if the message does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>message</td><td class="param-type">integer</td><td>Message ID (route-model-bound <code>MailMessage</code>).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "id": 501,
    "direction": "inbound",
    "from_address": "jane@acmecafe.com",
    "from_name": "Jane Silva",
    "to_address": "sales@business.com",
    "subject": "Your quote request",
    "is_read": true,
    "occurred_at": "2026-07-27T09:00:00+00:00",
    "date_label": "27 Jul 2026, 09:00",
    "body_text": "Hi, could you send a quote for..."
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-messages-read">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/mail/messages/{message}/read</code>
      <span class="endpoint-name">Mark message read</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Marks a message as read regardless of direction. Returns a 404-style message envelope if the message does not belong to the current business.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>message</td><td class="param-type">integer</td><td>Message ID (route-model-bound <code>MailMessage</code>).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Marked as read." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-send">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/mail/send</code>
      <span class="endpoint-name">Send (or schedule) an email</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sends an email immediately through the business's configured mail provider and logs it as an outbound <code>MailMessage</code>. If <code>scheduled_at</code> is given, the email is queued as a <code>ScheduledMail</code> instead and sent later by the scheduler — no message log entry is created at request time. Requires the <code>mail_compose</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: mail_compose</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>to</td><td class="param-type">string</td><td>Recipient email address.</td></tr>
            <tr><td>subject</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>body</td><td class="param-type">string</td><td>Plain-text body; converted to HTML with <code>nl2br</code>/escaping for immediate sends.</td></tr>
            <tr><td>scheduled_at<span class="param-required">opt</span></td><td class="param-type">date</td><td>Must be after now. When present, the send is deferred instead of immediate.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Email sent." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Failed to send email. Check your mail settings." }</code></pre>
      </div>
    </div>
  </div>

  <h3>Templates</h3>

  <div class="endpoint" id="ep-mail-templates-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/templates</code>
      <span class="endpoint-name">List mail templates</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists the business's reusable email templates, ordered by name, optionally filtered by name search.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>q<span class="param-required">opt</span></td><td class="param-type">string</td><td>Filters templates by name.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    { "id": 1, "name": "Quote Follow-up", "subject": "Following up on your quote", "body": "Hi {{name}}, just checking in..." }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-templates-store">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/mail/templates</code>
      <span class="endpoint-name">Create mail template</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Creates a reusable email template for the business. Requires the <code>mail_templates</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: mail_templates</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>name</td><td class="param-type">string</td><td>Max 255 chars.</td></tr>
            <tr><td>subject<span class="param-required">opt</span></td><td class="param-type">string</td><td>Max 255 chars. Stored as an empty string when omitted.</td></tr>
            <tr><td>body</td><td class="param-type">string</td><td>Template body.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": { "id": 2, "name": "Thank You Note", "subject": "Thanks for your business!", "body": "Hi {{name}}, thank you..." },
  "message": "Template created."
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

  <div class="endpoint" id="ep-mail-templates-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/mail/templates/{template}</code>
      <span class="endpoint-name">Delete mail template</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Permanently deletes a mail template. Returns a 404-style message envelope if the template does not belong to the current business. Requires the <code>mail_templates</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: mail_templates</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>template</td><td class="param-type">integer</td><td>Template ID (route-model-bound <code>MailTemplate</code>).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Template deleted." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Template not found." }</code></pre>
      </div>
    </div>
  </div>

  <h3>Scheduled mail</h3>

  <div class="endpoint" id="ep-mail-scheduled-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/scheduled</code>
      <span class="endpoint-name">List scheduled emails</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists up to 100 pending scheduled emails for the business, soonest first.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 9,
      "to_address": "jane@acmecafe.com",
      "subject": "Reminder: your quote expires soon",
      "scheduled_at": "2026-08-01T08:00:00+00:00",
      "scheduled_label": "01 Aug 2026, 08:00"
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-scheduled-destroy">
    <div class="endpoint-head">
      <span class="method-badge method-delete">DELETE</span>
      <code class="endpoint-path">/api/v1/pos/mail/scheduled/{scheduledMail}</code>
      <span class="endpoint-name">Cancel scheduled email</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Cancels a pending scheduled email. Fails with a validation error if the email has already been sent. Requires the <code>mail_compose</code> permission for non-owner business members.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
        <span class="meta-pill">Permission: mail_compose</span>
      </div>

      <div class="endpoint-block">
        <h4>Path parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>scheduledMail</td><td class="param-type">integer</td><td>Scheduled mail ID (route-model-bound <code>ScheduledMail</code>).</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Scheduled email cancelled." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "That email has already been sent and cannot be cancelled." }</code></pre>
      </div>
    </div>
  </div>

  <h3>Filters</h3>

  <div class="endpoint" id="ep-mail-filters-list">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/filters</code>
      <span class="endpoint-name">List inbound mail filters</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists automatic inbound filters (e.g. mark-as-read or delete rules matched against the from-address or subject) ordered by <code>sort_order</code>.</p>
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
      "field": "from",
      "field_label": "From",
      "value": "newsletter@",
      "action": "mark_read",
      "action_label": "Mark as read",
      "is_active": true,
      "sort_order": 1
    }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <h3>Settings &amp; mailbox</h3>

  <div class="endpoint" id="ep-mail-settings-show">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/mail/settings</code>
      <span class="endpoint-name">Get mail settings</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Returns the business's mail provider configuration. Secrets (SMTP password, Resend API key) are never returned in plaintext — only booleans indicating whether one is saved.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "data": {
    "provider": "smtp",
    "from_address": "sales@business.com",
    "from_name": "Acme Cafe",
    "letterhead_enabled": true,
    "smtp_host": "smtp.example.com",
    "smtp_port": 587,
    "smtp_username": "sales@business.com",
    "smtp_encryption": "tls",
    "has_smtp_password": true,
    "has_resend_api_key": false
  }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-settings-update">
    <div class="endpoint-head">
      <span class="method-badge method-patch">PATCH</span>
      <code class="endpoint-path">/api/v1/pos/mail/settings</code>
      <span class="endpoint-name">Update mail settings</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Partially updates the business's mail provider configuration. All fields are optional (<code>sometimes</code> validation) — only send the keys you want to change. No extra permission check beyond business auth.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>provider<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>platform</code>, <code>smtp</code>, <code>resend</code>.</td></tr>
            <tr><td>from_address<span class="param-required">opt</span></td><td class="param-type">string</td><td>Nullable email, max 190 chars.</td></tr>
            <tr><td>from_name<span class="param-required">opt</span></td><td class="param-type">string</td><td>Nullable, max 150 chars.</td></tr>
            <tr><td>letterhead_enabled<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Whether outgoing mail uses the business letterhead template.</td></tr>
            <tr><td>smtp_host<span class="param-required">opt</span></td><td class="param-type">string</td><td>Nullable, max 190 chars.</td></tr>
            <tr><td>smtp_port<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Nullable, 1–65535.</td></tr>
            <tr><td>smtp_username<span class="param-required">opt</span></td><td class="param-type">string</td><td>Nullable, max 190 chars.</td></tr>
            <tr><td>smtp_password<span class="param-required">opt</span></td><td class="param-type">string</td><td>Nullable, max 255 chars. Stored encrypted; not echoed back.</td></tr>
            <tr><td>smtp_encryption<span class="param-required">opt</span></td><td class="param-type">string</td><td>One of <code>tls</code>, <code>ssl</code>, <code>none</code>.</td></tr>
            <tr><td>resend_api_key<span class="param-required">opt</span></td><td class="param-type">string</td><td>Nullable, max 255 chars. Stored encrypted; not echoed back.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Mail settings saved." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The selected provider is invalid.",
  "errors": { "provider": ["The selected provider is invalid."] }
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-sync">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/mail/sync</code>
      <span class="endpoint-name">Sync mailbox now</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Triggers an on-demand IMAP sync for the business's configured mailbox to pull in new inbound messages. No extra permission check beyond business auth.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Sync queued — new messages will appear shortly." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Sync failed." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-test">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/mail/test</code>
      <span class="endpoint-name">Send test email</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sends a test email through the business's currently configured mail provider, used to verify settings are working end-to-end. No extra permission check beyond business auth.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>to</td><td class="param-type">string</td><td>Recipient email address, max 190 chars.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "Test email sent to jane@acmecafe.com." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Failed to send test email." }</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-mail-verify-credentials">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/mail/verify-credentials</code>
      <span class="endpoint-name">Verify mail provider credentials</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Validates the currently saved mail provider credentials without sending anything: for <code>resend</code> it calls the Resend domains API with the saved API key; for <code>smtp</code> it opens a raw socket to the host/port, optionally negotiates STARTTLS, and attempts <code>AUTH LOGIN</code> if a username/password are saved; for <code>platform</code> it always succeeds (no credentials to check). Takes no request body — it reads the provider config already saved via the settings endpoint. No extra permission check beyond business auth.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{ "message": "SMTP credentials verified successfully." }</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{ "message": "Cannot connect to smtp.example.com:587 — Connection refused (61)" }</code></pre>
      </div>
@endverbatim
