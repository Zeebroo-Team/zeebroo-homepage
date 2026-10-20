@push('scripts')
<script src="{{ asset('assets/js/admin-features.js') }}"></script>
@endpush

@php
  $highlights = array_values(old('highlights', $feature->highlights ?? []));
  if (! $feature->exists && ! old('highlights')) {
      $highlights = array_fill(0, 3, ['icon' => 'fa-check', 'title' => '', 'text' => '']);
  }
  $capabilities = old('capabilities', $feature->capabilities ?? []);
  $capabilities = is_array($capabilities) ? implode("\n", $capabilities) : $capabilities;
  $selectedRelated = collect(old('related', $feature->exists ? $feature->related->pluck('id')->all() : []))->map(fn ($id) => (int) $id);
  $removeScreenshots = collect(old('remove_screenshots', []))->map(fn ($id) => (int) $id);
@endphp

<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      <label class="adm-field">
        <span>Title</span>
        <input type="text" name="title" id="title" value="{{ old('title', $feature->title) }}" required maxlength="255" @class(['bad' => $errors->has('title')])>
        @error('title')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      @include('admin.partials.slug', ['source' => 'title', 'value' => old('slug', $feature->slug), 'prefix' => '/features/'])

      <label class="adm-field">
        <span>Menu tagline <em>short line under the title in the Modules menu</em></span>
        <input type="text" name="menu" value="{{ old('menu', $feature->menu) }}" maxlength="255" placeholder="Fast checkout and receipts" @class(['bad' => $errors->has('menu')])>
        @error('menu')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Headline <em>big heading on the feature page</em></span>
        <input type="text" name="headline" value="{{ old('headline', $feature->headline) }}" maxlength="255" placeholder="Checkout that keeps the queue moving" @class(['bad' => $errors->has('headline')])>
        @error('headline')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Intro <em>shown under the headline and on the feature cards</em></span>
        <textarea name="lead" rows="4" maxlength="2000" @class(['bad' => $errors->has('lead')])>{{ old('lead', $feature->lead) }}</textarea>
        @error('lead')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Highlights</h2><small>"What it does for you" cards, up to 6. The first three also orbit the icon when no preview image is set.</small></div>
      <div class="adm-repeat" data-repeat data-max="6">
        @foreach ($highlights as $i => $h)
          @include('admin.features.partials.highlight', ['i' => $i, 'h' => $h])
        @endforeach
        <template>@include('admin.features.partials.highlight', ['i' => '__i__', 'h' => ['icon' => 'fa-check', 'title' => '', 'text' => '']])</template>
        <button type="button" class="adm-btn line" data-repeat-add><i class="fa-solid fa-plus"></i>Add highlight</button>
      </div>
      @error('highlights')<small class="adm-err">{{ $message }}</small>@enderror
    </div>

    <div class="adm-card">
      <label class="adm-field">
        <span>Capabilities <em>one per line, listed under "Everything in …"</em></span>
        <textarea name="capabilities" rows="7" placeholder="Web POS and a desktop app&#10;Barcode scanning" @class(['bad' => $errors->has('capabilities') || $errors->has('capabilities.*')])>{{ $capabilities }}</textarea>
        @error('capabilities')<small class="adm-err">{{ $message }}</small>@enderror
        @error('capabilities.*')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Screenshots</h2><small>Product screenshots shown in a gallery on the feature page. JPG, PNG, WebP or GIF, max 4 MB each, up to 12 per upload.</small></div>

      @if ($feature->exists && $feature->screenshots->isNotEmpty())
        <div class="adm-shots">
          @foreach ($feature->screenshots as $shot)
            <div class="adm-shot">
              <a href="{{ $shot->url }}" target="_blank" rel="noopener"><img src="{{ $shot->url }}" alt="" loading="lazy"></a>
              <input type="text" name="screenshot_captions[{{ $shot->id }}]" value="{{ old('screenshot_captions.'.$shot->id, $shot->caption) }}" maxlength="255" placeholder="Caption (optional)" aria-label="Caption">
              <div class="adm-shot-f">
                <label>Order <input type="number" name="screenshot_order[{{ $shot->id }}]" value="{{ old('screenshot_order.'.$shot->id, $shot->sort_order) }}" min="0" max="9999"></label>
                <label class="adm-shot-rm"><input type="checkbox" name="remove_screenshots[]" value="{{ $shot->id }}" @checked($removeScreenshots->contains($shot->id))><i class="fa-solid fa-trash-can"></i> Remove</label>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <label class="adm-drop adm-drop-sm" data-multi-preview data-max="12">
        <span><i class="fa-solid fa-images"></i>Add screenshots (pick or drop several at once)</span>
        <input type="file" name="screenshots[]" multiple accept="image/jpeg,image/png,image/webp,image/gif">
      </label>
      <div class="adm-shots adm-shots-new" hidden></div>
      @error('screenshots')<small class="adm-err">{{ $message }}</small>@enderror
      @error('screenshots.*')<small class="adm-err">{{ $message }}</small>@enderror
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>SEO</h2><small>Left empty, the title and the intro are used.</small></div>
      <label class="adm-field">
        <span>Meta title</span>
        <input type="text" name="meta_title" value="{{ old('meta_title', $feature->meta_title) }}" maxlength="255" data-count="60" @class(['bad' => $errors->has('meta_title')])>
        @error('meta_title')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Meta description</span>
        <textarea name="meta_description" rows="3" maxlength="500" data-count="160" @class(['bad' => $errors->has('meta_description')])>{{ old('meta_description', $feature->meta_description) }}</textarea>
        @error('meta_description')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Meta keywords <em>comma separated</em></span>
        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $feature->meta_keywords) }}" maxlength="500" placeholder="pos, checkout, receipts" @class(['bad' => $errors->has('meta_keywords')])>
        @error('meta_keywords')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
  </div>

  <div class="adm-split-side">
    <div class="adm-card">
      <div class="adm-card-h"><h2>Publish</h2></div>
      <label class="adm-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $feature->is_active))>
        <span></span> Active
        <small>Inactive features are hidden from the site and their page returns 404.</small>
      </label>
      <label class="adm-field">
        <span>Sort order <em>lower first</em></span>
        <input type="number" name="sort_order" value="{{ old('sort_order', $feature->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
        @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <button type="submit" class="adm-btn ink wide">{{ $submit }}</button>
      <a class="adm-btn line wide" href="{{ route('admin.features.index') }}">Cancel</a>
      @if ($feature->exists && $feature->is_active)
        <a class="adm-btn line wide" href="{{ route('features.show', $feature->slug) }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>View page</a>
      @endif
    </div>

    <div class="adm-card">
      <label class="adm-field">
        <span>Icon <em><a href="https://fontawesome.com/search?o=r&amp;s=solid&amp;f=classic" target="_blank" rel="noopener">Font Awesome</a> solid name</em></span>
        <div class="adm-icon-in">
          <i class="fa-solid {{ old('icon', $feature->icon) }}" data-icon-preview></i>
          <input type="text" name="icon" value="{{ old('icon', $feature->icon) }}" maxlength="64" required placeholder="fa-cash-register" data-icon-input @class(['bad' => $errors->has('icon')])>
        </div>
        @error('icon')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Group</span>
        <select name="group" @class(['bad' => $errors->has('group')])>
          @foreach (\App\Models\Feature::GROUPS as $key => $label)
            <option value="{{ $key }}" @selected(old('group', $feature->group) === $key)>{{ $label }}</option>
          @endforeach
        </select>
        <small class="adm-muted">Core modules get a large card with the preview image and appear in the home page module switcher.</small>
        @error('group')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Badge <em>optional, e.g. Popular or New</em></span>
        <input type="text" name="badge" value="{{ old('badge', $feature->badge) }}" maxlength="32" @class(['bad' => $errors->has('badge')])>
        @error('badge')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Preview image <em>square, shown on cards and the page hero</em></span>
        <label class="adm-drop adm-drop-contain" data-preview>
          <img src="{{ $feature->spot_url }}" alt="" @if (! $feature->spot_url) hidden @endif>
          <span @if ($feature->spot_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose an image</span>
          <input type="file" name="spot" accept="image/jpeg,image/png,image/webp,image/gif">
        </label>
        @error('spot')<small class="adm-err">{{ $message }}</small>@enderror
        @if ($feature->spot_url)
          <label class="adm-check"><input type="checkbox" name="remove_spot" value="1"> Remove current image</label>
        @endif
      </div>

      <div class="adm-field">
        <span>Scene image <em>wide, shown below the hero</em></span>
        <label class="adm-drop adm-drop-contain" data-preview>
          <img src="{{ $feature->scene_url }}" alt="" @if (! $feature->scene_url) hidden @endif>
          <span @if ($feature->scene_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose an image</span>
          <input type="file" name="scene" accept="image/jpeg,image/png,image/webp,image/gif">
        </label>
        @error('scene')<small class="adm-err">{{ $message }}</small>@enderror
        @if ($feature->scene_url)
          <label class="adm-check"><input type="checkbox" name="remove_scene" value="1"> Remove current image</label>
        @endif
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Related modules <em>"Better together"</em></span>
        @if ($others->isEmpty())
          <small class="adm-muted">No other features yet.</small>
        @else
          <div class="adm-tags">
            @foreach ($others as $other)
              <label><input type="checkbox" name="related[]" value="{{ $other->id }}" @checked($selectedRelated->contains($other->id))><span>{{ $other->title }}</span></label>
            @endforeach
          </div>
        @endif
        @error('related.*')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
    </div>
  </div>
</div>
