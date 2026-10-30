@include('admin.partials.lang-tabs')

<div class="adm-lang-pane" data-lang-pane="en">
  <label class="adm-field">
    <span>Name <em>the heading above these pages in the /docs sidebar</em></span>
    <input type="text" name="name" value="{{ old('name', $group->name) }}" required maxlength="255" @class(['bad' => $errors->has('name')])>
    @error('name')<small class="adm-err">{{ $message }}</small>@enderror
  </label>
</div>

<div class="adm-lang-pane" data-lang-pane="si" lang="si">
  <label class="adm-field">
    <span>Name <em>Sinhala, optional</em></span>
    <input type="text" name="name_si" value="{{ old('name_si', $group->name_si) }}" maxlength="255" @class(['bad' => $errors->has('name_si')])>
    @error('name_si')<small class="adm-err">{{ $message }}</small>@enderror
  </label>
</div>

<label class="adm-field">
  <span>Key <em>internal name, made from the name when empty</em></span>
  <input type="text" name="key" value="{{ old('key', $group->key) }}" maxlength="64" placeholder="selling-and-stock" @class(['bad' => $errors->has('key')])>
  @error('key')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-field">
  <span>Sort order <em>lower first</em></span>
  <input type="number" name="sort_order" value="{{ old('sort_order', $group->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
  @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
</label>
