<label class="adm-field">
  <span>Name</span>
  <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required maxlength="255" @class(['bad' => $errors->has('name')])>
  @error('name')<small class="adm-err">{{ $message }}</small>@enderror
</label>

@include('admin.partials.slug', ['source' => 'name', 'value' => old('slug', $category->slug), 'prefix' => '/blog/category/'])

<label class="adm-field">
  <span>Description</span>
  <textarea name="description" rows="4" maxlength="2000" @class(['bad' => $errors->has('description')])>{{ old('description', $category->description) }}</textarea>
  @error('description')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-switch">
  <input type="hidden" name="is_active" value="0">
  <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))>
  <span></span> Active <small>Inactive categories are hidden from the blog.</small>
</label>
