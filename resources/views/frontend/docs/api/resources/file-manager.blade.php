@verbatim
  <div class="endpoint" id="ep-file-manager-browse">
    <div class="endpoint-head">
      <span class="method-badge method-get">GET</span>
      <code class="endpoint-path">/api/v1/pos/online/file-manager</code>
      <span class="endpoint-name">Browse files and folders</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Lists the folders and files inside a given folder (root if omitted) for the current business's file manager, along with a breadcrumb trail back to root. Pass <code>images_only=1</code> to filter the file list down to images only.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Query parameters</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>folder<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Parent folder ID. Omit for the root folder.</td></tr>
            <tr><td>images_only<span class="param-required">opt</span></td><td class="param-type">boolean</td><td>Filter files to images only. Defaults to false.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "folders": [
    { "id": 2, "name": "Product Images" }
  ],
  "files": [
    {
      "id": 41,
      "name": "logo.png",
      "url": "https://cdn.example.com/storage/logo.png",
      "mime": "image/png",
      "size": "128.0 KB",
      "is_image": true
    }
  ],
  "breadcrumbs": [
    { "id": null, "name": "Root" },
    { "id": 2, "name": "Product Images" }
  ]
}</code></pre>
      </div>
    </div>
  </div>

  <div class="endpoint" id="ep-file-manager-upload">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/online/file-manager/upload</code>
      <span class="endpoint-name">Upload files</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Uploads one or more files to the current business's file manager, optionally into a specific folder. Files over 20 MB or outside the allowed MIME types are rejected.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
        <span class="meta-pill">Business-scoped</span>
      </div>

      <div class="endpoint-block">
        <h4>Request body <span class="param-type">multipart/form-data</span></h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>files</td><td class="param-type">array</td><td>At least 1 file.</td></tr>
            <tr><td>files.*</td><td class="param-type">file</td><td>Max 20,480 KB each. Allowed: pdf, jpg, jpeg, png, gif, webp, svg, doc, docx, xls, xlsx, ppt, pptx, txt, csv, zip, rar, 7z.</td></tr>
            <tr><td>folder_id<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Destination folder. Omit to upload into the root folder.</td></tr>
          </tbody>
        </table>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill">201</span></h4>
        <pre class="code-block"><code>{
  "data": [
    {
      "id": 42,
      "name": "invoice-template.pdf",
      "url": "https://cdn.example.com/storage/invoice-template.pdf",
      "mime": "application/pdf",
      "is_image": false
    }
  ]
}</code></pre>
      </div>

      <div class="endpoint-block">
        <h4>Response <span class="status-pill status-4xx">422</span></h4>
        <pre class="code-block"><code>{
  "message": "The files.0 field must not be greater than 20480 kilobytes.",
  "errors": { "files.0": ["The files.0 field must not be greater than 20480 kilobytes."] }
}</code></pre>
      </div>
@endverbatim
