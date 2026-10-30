@php
  $sections = old('sections', $page->exists
      ? $page->sections->map(fn ($section) => $section->only(['anchor', 'heading', 'heading_si', 'body', 'body_si', 'is_custom']))->all()
      : [['anchor' => '', 'heading' => '', 'body' => '', 'is_custom' => false]]);
  // the live site's stylesheets, so the preview looks like /docs
  $previewStyles = [
      asset('assets/css/style.css'),
      asset('assets/css/docs.css'),
      'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
      'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Geist:wght@400;500;600&family=Geist+Mono:wght@400;500&family=Noto+Sans+Sinhala:wght@400;500;600;700&display=swap',
  ];
@endphp

<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      @include('admin.partials.lang-tabs')

      <div class="adm-lang-pane" data-lang-pane="en">
        <label class="adm-field">
          <span>Title</span>
          <input type="text" name="title" value="{{ old('title', $page->title) }}" required maxlength="255" @class(['bad' => $errors->has('title')])>
          @error('title')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
        <label class="adm-field">
          <span>Description <em>the line under the title, on the docs home card and in Google</em></span>
          <textarea name="description" rows="2" required maxlength="500" data-count="160" @class(['bad' => $errors->has('description')])>{{ old('description', $page->description) }}</textarea>
          @error('description')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
      </div>

      <div class="adm-lang-pane" data-lang-pane="si" lang="si">
        <label class="adm-field">
          <span>Title <em>Sinhala, optional</em></span>
          <input type="text" name="title_si" value="{{ old('title_si', $page->title_si) }}" maxlength="255" @class(['bad' => $errors->has('title_si')])>
          @error('title_si')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
        <label class="adm-field">
          <span>Description <em>Sinhala, optional</em></span>
          <textarea name="description_si" rows="2" maxlength="500" data-count="160" @class(['bad' => $errors->has('description_si')])>{{ old('description_si', $page->description_si) }}</textarea>
          @error('description_si')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Intro</h2><small>Optional content above the first section, e.g. the main screenshot.</small></div>
      <div class="adm-field" data-lang-pane="en">
        @include('admin.docs.pages.partials.toolbar')
        <textarea class="adm-code" name="intro" rows="6" data-doc-html data-doc-part="intro" @class(['bad' => $errors->has('intro')])>{{ old('intro', $page->intro) }}</textarea>
        @error('intro')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
      <div class="adm-field" data-lang-pane="si" lang="si">
        @include('admin.docs.pages.partials.toolbar')
        <textarea class="adm-code" name="intro_si" rows="6" data-doc-html data-doc-part="intro" @class(['bad' => $errors->has('intro_si')])>{{ old('intro_si', $page->intro_si) }}</textarea>
        @error('intro_si')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Sections</h2><small>Each section is one "On this page" topic. Drag order with the arrows.</small></div>
      @error('sections')<small class="adm-err">{{ $message }}</small>@enderror
      <div class="adm-repeat" data-repeat data-max="50">
        @foreach ($sections as $i => $s)
          @include('admin.docs.pages.partials.section', ['i' => $i, 's' => $s])
        @endforeach
        <template>@include('admin.docs.pages.partials.section', ['i' => '__i__', 's' => []])</template>
        <button type="button" class="adm-btn line" data-repeat-add><i class="fa-solid fa-plus"></i>Add section</button>
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Closing content</h2><small>Optional content below the last section, e.g. a final warning or note.</small></div>
      <div class="adm-field" data-lang-pane="en">
        @include('admin.docs.pages.partials.toolbar')
        <textarea class="adm-code" name="outro" rows="5" data-doc-html @class(['bad' => $errors->has('outro')])>{{ old('outro', $page->outro) }}</textarea>
        @error('outro')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
      <div class="adm-field" data-lang-pane="si" lang="si">
        @include('admin.docs.pages.partials.toolbar')
        <textarea class="adm-code" name="outro_si" rows="5" data-doc-html @class(['bad' => $errors->has('outro_si')])>{{ old('outro_si', $page->outro_si) }}</textarea>
        @error('outro_si')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-h">
        <h2>Preview</h2>
        <button type="button" class="adm-btn line" data-doc-preview-refresh><i class="fa-solid fa-rotate"></i>Refresh</button>
        <small>The page body as visitors see it, in the language of the open tab. Sinhala sections left empty show English.</small>
      </div>
      <iframe class="adm-doc-preview" title="Docs page preview" data-doc-preview data-styles="{{ json_encode($previewStyles) }}"></iframe>
    </div>
  </div>

  <div class="adm-split-side">
    <div class="adm-card">
      <div class="adm-card-h"><h2>Publish</h2></div>
      <label class="adm-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $page->is_active))>
        <span></span> Active
        <small>Inactive pages are hidden from /docs and the sitemap.</small>
      </label>
      <button type="submit" class="adm-btn ink wide">{{ $submit }}</button>
      <a class="adm-btn line wide" href="{{ route('admin.docs.pages.index') }}">Cancel</a>
      @if ($page->exists)
        <a class="adm-btn line wide" href="{{ route('docs.show', $page->slug) }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>View page</a>
      @endif
    </div>

    <div class="adm-card">
      <label class="adm-field">
        <span>Group <em>the sidebar heading it sits under</em></span>
        <select name="doc_group_id" required @class(['bad' => $errors->has('doc_group_id')])>
          @foreach ($groups as $group)
            <option value="{{ $group->id }}" @selected((int) old('doc_group_id', $page->doc_group_id) === $group->id)>{{ $group->name }}</option>
          @endforeach
        </select>
        @error('doc_group_id')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Address @if ($page->exists)<em>fixed once created, so links and search rankings keep working</em>@else<em>lowercase words and dashes</em>@endif</span>
        @if ($page->exists)
          <input type="text" value="/docs/{{ $page->slug }}" readonly>
        @else
          <input type="text" name="slug" value="{{ old('slug') }}" required maxlength="255" placeholder="point-of-sale" @class(['bad' => $errors->has('slug')])>
          @error('slug')<small class="adm-err">{{ $message }}</small>@enderror
        @endif
      </label>

      <label class="adm-field">
        <span>Number <em>e.g. 03, or v3.1 for release notes</em></span>
        <input type="text" name="number" value="{{ old('number', $page->number) }}" required maxlength="16" @class(['bad' => $errors->has('number')])>
        @error('number')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Icon <em>Font Awesome name</em></span>
        <span class="adm-icon-in">
          <i class="fa-solid {{ old('icon', $page->icon) }}" data-icon-preview></i>
          <input type="text" name="icon" value="{{ old('icon', $page->icon) }}" required maxlength="64" data-icon-input @class(['bad' => $errors->has('icon')])>
        </span>
        @error('icon')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Sort order <em>within its group, lower first</em></span>
        <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
        @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
  </div>
</div>

@push('scripts')
<script>window.ZB_DOC_IMAGE_URL = @json(route('admin.docs.images.store'));</script>
<script src="{{ asset('assets/js/admin-docs.js') }}"></script>
@endpush
