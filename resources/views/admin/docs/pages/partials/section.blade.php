{{-- One section row of the docs page form. Needs: $i (row index, or "__i__" in the template), $s (anchor, heading, heading_si, body, body_si, is_custom) --}}
<div class="adm-doc-sec" data-repeat-row data-doc-section>
  <div class="adm-doc-sec-h">
    <b data-section-title>{{ ($s['heading'] ?? '') ?: 'New section' }}</b>
    <span>
      <button type="button" class="adm-icon-btn" data-section-move="up" title="Move up" aria-label="Move section up"><i class="fa-solid fa-arrow-up"></i></button>
      <button type="button" class="adm-icon-btn" data-section-move="down" title="Move down" aria-label="Move section down"><i class="fa-solid fa-arrow-down"></i></button>
      <button type="button" class="adm-icon-btn danger" data-repeat-remove title="Remove" aria-label="Remove section"><i class="fa-solid fa-xmark"></i></button>
    </span>
  </div>

  <div class="adm-doc-sec-row">
    <div data-lang-pane="en">
      <label class="adm-field">
        <span>Heading <em>shown on the page and in "On this page"</em></span>
        <input type="text" name="sections[{{ $i }}][heading]" value="{{ $s['heading'] ?? '' }}" maxlength="255" data-section-heading @class(['bad' => $errors->has("sections.{$i}.heading")])>
        @error("sections.{$i}.heading")<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
    <div data-lang-pane="si" lang="si">
      <label class="adm-field">
        <span>Heading <em>Sinhala, optional</em></span>
        <input type="text" name="sections[{{ $i }}][heading_si]" value="{{ $s['heading_si'] ?? '' }}" maxlength="255" @class(['bad' => $errors->has("sections.{$i}.heading_si")])>
        @error("sections.{$i}.heading_si")<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
    <label class="adm-field">
      <span>Anchor <em>the #link, made from the heading</em></span>
      <input type="text" name="sections[{{ $i }}][anchor]" value="{{ $s['anchor'] ?? '' }}" maxlength="255" data-section-anchor @class(['bad' => $errors->has("sections.{$i}.anchor")])>
      @error("sections.{$i}.anchor")<small class="adm-err">{{ $message }}</small>@enderror
    </label>
  </div>

  <div data-lang-pane="en">
    <div class="adm-field">
      <span>Content <em>HTML; use the buttons to add steps, tips, screenshots…</em></span>
      @include('admin.docs.pages.partials.toolbar')
      <textarea class="adm-code" name="sections[{{ $i }}][body]" rows="12" data-doc-html @class(['bad' => $errors->has("sections.{$i}.body")])>{{ $s['body'] ?? '' }}</textarea>
      @error("sections.{$i}.body")<small class="adm-err">{{ $message }}</small>@enderror
    </div>
  </div>
  <div data-lang-pane="si" lang="si">
    <div class="adm-field">
      <span>Content <em>Sinhala; empty shows the English content</em></span>
      @include('admin.docs.pages.partials.toolbar')
      <textarea class="adm-code" name="sections[{{ $i }}][body_si]" rows="12" data-doc-html @class(['bad' => $errors->has("sections.{$i}.body_si")])>{{ $s['body_si'] ?? '' }}</textarea>
      @error("sections.{$i}.body_si")<small class="adm-err">{{ $message }}</small>@enderror
    </div>
  </div>

  <label class="adm-check">
    <input type="hidden" name="sections[{{ $i }}][is_custom]" value="0">
    <input type="checkbox" name="sections[{{ $i }}][is_custom]" value="1" @checked(filter_var($s['is_custom'] ?? false, FILTER_VALIDATE_BOOLEAN))>
    Custom layout <small>the content is shown as written, without the standard heading box; it must contain an element with id="anchor"</small>
  </label>
</div>
