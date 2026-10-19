<label class="adm-field">
  <span>Name</span>
  <input type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" required maxlength="255" @class(['bad' => $errors->has('name')])>
  @error('name')<small class="adm-err">{{ $message }}</small>@enderror
</label>

@include('admin.partials.slug', ['source' => 'name', 'value' => old('slug', $tag->slug), 'prefix' => '/blog/tag/'])

<label class="adm-switch">
  <input type="hidden" name="is_active" value="0">
  <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $tag->is_active))>
  <span></span> Active <small>Inactive tags are hidden from posts.</small>
</label>
