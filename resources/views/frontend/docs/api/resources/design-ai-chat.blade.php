@verbatim
  <div class="endpoint" id="ep-design-ai-chat-chat">
    <div class="endpoint-head">
      <span class="method-badge method-post">POST</span>
      <code class="endpoint-path">/api/v1/pos/design-studio/ai-chat</code>
      <span class="endpoint-name">Design AI chat</span>
    </div>
    <div class="endpoint-body">
      <p class="endpoint-desc">Sends a design instruction to Google Gemini (models <code>gemini-2.5-flash</code> → <code>gemini-2.5-pro</code> → <code>gemini-2.5-flash-lite-preview-06-17</code>, configurable via <code>services.gemini.model</code>) and returns a conversational reply plus a list of low-level canvas commands (<code>set_background</code>, <code>add_rect</code>, <code>add_circle</code>, <code>add_triangle</code>, <code>add_line</code>, <code>add_text</code>, <code>set_shadow</code>, <code>set_fill</code>, <code>set_text_props</code>, <code>bring_front</code>, <code>send_back</code>, <code>delete_selected</code>, <code>zoom_fit</code>). Requests containing "letterhead" bypass Gemini entirely and randomly recombine one of 4 sample layouts with one of 8 color palettes (32 combinations) read from <code>public/model_data/letterheads</code>; requests mentioning a Facebook/Instagram/social post reuse a random sample layout from <code>public/model_data/fb_post</code> with Gemini writing only the on-canvas copy. Requires a configured <code>services.gemini.key</code>; if missing, or if all model attempts fail, the endpoint still responds 200 with a friendly fallback <code>reply</code> and an empty <code>commands</code> array rather than erroring.</p>
      <div class="endpoint-meta">
        <span class="meta-pill auth-required">Bearer token required</span>
      </div>
      <div class="endpoint-block">
        <h4>Request body</h4>
        <table class="data-table param-table">
          <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
          <tbody>
            <tr><td>message</td><td class="param-type">string</td><td>The user's chat message, max 800 characters (checked manually, not via Laravel validation — an empty or oversized message gets a plain 200 response rather than a 422).</td></tr>
            <tr><td>canvas_width<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Current canvas width in px; defaults to 794. Passed to the AI so coordinates match the real canvas.</td></tr>
            <tr><td>canvas_height<span class="param-required">opt</span></td><td class="param-type">integer</td><td>Current canvas height in px; defaults to 1123.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="endpoint-block">
        <h4>Response <span class="status-pill">200</span></h4>
        <pre class="code-block"><code>{
  "reply": "Here's a Navy · left arc letterhead! Click any element to edit the text, colors, or layout.",
  "commands": [
    { "type": "set_background", "fill": "#eef0f5" },
    { "type": "add_rect", "fill": "#0f1f4a", "left": -68, "top": -59, "width": 220, "height": 140, "scaleX": 4.23, "scaleY": 1.24 },
    { "type": "add_text", "text": "Your Company Name", "left": 370, "top": 15, "fontSize": 36, "fontWeight": "bold", "fill": "#ffffff", "fontFamily": "Inter" }
  ]
}</code></pre>
      </div>
@endverbatim
