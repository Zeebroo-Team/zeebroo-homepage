@php
  $pageId = (int) old('doc_page_id', $task->doc_page_id);
  $anchor = old('anchor', $task->anchor);
@endphp

@include('admin.partials.lang-tabs')

<div class="adm-lang-pane" data-lang-pane="en">
  <label class="adm-field">
    <span>Title <em>the job, e.g. "Make a sale"</em></span>
    <input type="text" name="title" value="{{ old('title', $task->title) }}" required maxlength="255" @class(['bad' => $errors->has('title')])>
    @error('title')<small class="adm-err">{{ $message }}</small>@enderror
  </label>
</div>

<div class="adm-lang-pane" data-lang-pane="si" lang="si">
  <label class="adm-field">
    <span>Title <em>Sinhala, optional</em></span>
    <input type="text" name="title_si" value="{{ old('title_si', $task->title_si) }}" maxlength="255" @class(['bad' => $errors->has('title_si')])>
    @error('title_si')<small class="adm-err">{{ $message }}</small>@enderror
  </label>
</div>

<label class="adm-field">
  <span>Page</span>
  <select name="doc_page_id" required data-task-page @class(['bad' => $errors->has('doc_page_id')])>
    <option value="">Choose a page</option>
    @foreach ($pages as $page)
      <option value="{{ $page->id }}" @selected($pageId === $page->id)>{{ $page->number }} · {{ $page->title }}</option>
    @endforeach
  </select>
  @error('doc_page_id')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-field">
  <span>Section <em>the task links straight to this part of the page</em></span>
  <select name="anchor" required data-task-anchor @class(['bad' => $errors->has('anchor')])>
    <option value="">Choose a section</option>
    @foreach ($pages as $page)
      @foreach ($page->sections as $section)
        <option value="{{ $section->anchor }}" data-page="{{ $page->id }}" @selected($pageId === $page->id && $anchor === $section->anchor) @if ($pageId !== $page->id) hidden disabled @endif>{{ $section->heading }}</option>
      @endforeach
    @endforeach
  </select>
  @error('anchor')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-field">
  <span>Icon <em>Font Awesome name, e.g. fa-cart-shopping</em></span>
  <span class="adm-icon-in">
    <i class="fa-solid {{ old('icon', $task->icon) }}" data-icon-preview></i>
    <input type="text" name="icon" value="{{ old('icon', $task->icon) }}" required maxlength="64" data-icon-input @class(['bad' => $errors->has('icon')])>
  </span>
  @error('icon')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-field">
  <span>Sort order <em>lower first</em></span>
  <input type="number" name="sort_order" value="{{ old('sort_order', $task->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
  @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
</label>

@push('scripts')
<script src="{{ asset('assets/js/admin-docs.js') }}"></script>
@endpush
