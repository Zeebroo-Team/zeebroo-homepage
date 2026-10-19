@push('scripts')
<script src="{{ asset('assets/js/admin-features.js') }}"></script>
@endpush

<label class="adm-field">
  <span>Name <em>e.g. Technology partners, Payment partners, Clients</em></span>
  <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required maxlength="255" @class(['bad' => $errors->has('name')])>
  @error('name')<small class="adm-err">{{ $message }}</small>@enderror
</label>

@include('admin.partials.slug', ['source' => 'name', 'value' => old('slug', $category->slug), 'prefix' => '/partners?category='])

<label class="adm-field">
  <span>Description <em>shown under the section heading on /partners</em></span>
  <textarea name="description" rows="3" maxlength="2000" @class(['bad' => $errors->has('description')])>{{ old('description', $category->description) }}</textarea>
  @error('description')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-field">
  <span>Icon <em><a href="https://fontawesome.com/search?o=r&amp;s=solid&amp;f=classic" target="_blank" rel="noopener">Font Awesome</a> solid name</em></span>
  <div class="adm-icon-in">
    <i class="fa-solid {{ old('icon', $category->icon) }}" data-icon-preview></i>
    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" maxlength="64" required placeholder="fa-handshake" data-icon-input @class(['bad' => $errors->has('icon')])>
  </div>
  @error('icon')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-field">
  <span>Sort order <em>lower first</em></span>
  <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
  @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
</label>

<label class="adm-switch">
  <input type="hidden" name="is_active" value="0">
  <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))>
  <span></span> Active <small>Inactive categories and their partners are hidden from the site.</small>
</label>
