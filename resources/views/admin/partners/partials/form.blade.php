<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      <label class="adm-field">
        <span>Company name</span>
        <input type="text" name="name" value="{{ old('name', $partner->name) }}" required maxlength="255" @class(['bad' => $errors->has('name')])>
        @error('name')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Tagline <em>short line under the name, e.g. "Card terminals and online payments"</em></span>
        <input type="text" name="tagline" value="{{ old('tagline', $partner->tagline) }}" maxlength="255" @class(['bad' => $errors->has('tagline')])>
        @error('tagline')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>About <em>how you work together, shown on the partner card</em></span>
        <textarea name="description" rows="4" maxlength="1000" data-count="220" @class(['bad' => $errors->has('description')])>{{ old('description', $partner->description) }}</textarea>
        @error('description')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Website</span>
        <input type="text" name="website_url" value="{{ old('website_url', $partner->website_url) }}" maxlength="255" placeholder="https://example.com" @class(['bad' => $errors->has('website_url')])>
        @error('website_url')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Location <em>optional, e.g. Colombo, Sri Lanka</em></span>
        <input type="text" name="location" value="{{ old('location', $partner->location) }}" maxlength="255" @class(['bad' => $errors->has('location')])>
        @error('location')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Partner since <em>year, optional</em></span>
        <input type="number" name="since_year" value="{{ old('since_year', $partner->since_year) }}" min="1900" max="{{ now()->year + 1 }}" placeholder="{{ now()->year }}" @class(['bad' => $errors->has('since_year')])>
        @error('since_year')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
  </div>

  <div class="adm-split-side">
    <div class="adm-card">
      <div class="adm-card-h"><h2>Publish</h2></div>
      <label class="adm-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->is_active))>
        <span></span> Active
        <small>Inactive partners are hidden from the site.</small>
      </label>
      <label class="adm-switch">
        <input type="hidden" name="is_featured" value="0">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $partner->is_featured))>
        <span></span> Featured on home page
        <small>Adds the logo to the home page partner strip. Only shown while the partner is active.</small>
      </label>
      <label class="adm-field">
        <span>Sort order <em>lower first</em></span>
        <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
        @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <button type="submit" class="adm-btn ink wide">{{ $submit }}</button>
      <a class="adm-btn line wide" href="{{ route('admin.partners.index') }}">Cancel</a>
    </div>

    <div class="adm-card">
      <label class="adm-field">
        <span>Category</span>
        <select name="partner_category_id" @class(['bad' => $errors->has('partner_category_id')])>
          <option value="">Uncategorised</option>
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}" @selected((int) old('partner_category_id', $partner->partner_category_id) === $id)>{{ $name }}</option>
          @endforeach
        </select>
        @error('partner_category_id')<small class="adm-err">{{ $message }}</small>@enderror
        @can('create partner categories')
          <small class="adm-muted"><a href="{{ route('admin.partner-categories.create') }}">Add a category</a></small>
        @endcan
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Logo <em>PNG or WebP with a transparent background works best, max 2 MB</em></span>
        <label class="adm-drop adm-drop-contain adm-drop-sm" data-preview>
          <img src="{{ $partner->logo_url }}" alt="" @if (! $partner->logo_url) hidden @endif>
          <span @if ($partner->logo_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose a logo</span>
          <input type="file" name="logo" accept="image/jpeg,image/png,image/webp,image/gif">
        </label>
        @error('logo')<small class="adm-err">{{ $message }}</small>@enderror
        @if ($partner->logo_url)
          <label class="adm-check"><input type="checkbox" name="remove_logo" value="1"> Remove current logo</label>
        @endif
      </div>
    </div>
  </div>
</div>
