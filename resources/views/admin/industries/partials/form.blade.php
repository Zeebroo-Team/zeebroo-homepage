@push('scripts')
<script src="{{ asset('assets/js/admin-features.js') }}"></script>
@endpush

@php
  $highlights = array_values(old('highlights', $industry->highlights ?? []));
  if (! $industry->exists && ! old('highlights')) {
      $highlights = array_fill(0, 3, ['icon' => 'fa-check', 'title' => '', 'text' => '']);
  }
  $capabilities = old('capabilities', $industry->capabilities ?? []);
  $capabilities = is_array($capabilities) ? implode("\n", $capabilities) : $capabilities;
  $selectedModules = collect(old('modules', $industry->exists ? $industry->modules->pluck('id')->all() : []))->map(fn ($id) => (int) $id);
@endphp

<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      <label class="adm-field">
        <span>Title</span>
        <input type="text" name="title" id="title" value="{{ old('title', $industry->title) }}" required maxlength="255" @class(['bad' => $errors->has('title')])>
        @error('title')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      @include('admin.partials.slug', ['source' => 'title', 'value' => old('slug', $industry->slug), 'prefix' => '/industries/'])

      <label class="adm-field">
        <span>Menu tagline <em>short line under the title in the Industries menu and grid</em></span>
        <input type="text" name="menu" value="{{ old('menu', $industry->menu) }}" maxlength="255" placeholder="Tables, orders and kitchen flow" @class(['bad' => $errors->has('menu')])>
        @error('menu')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Headline <em>big heading on the industry page</em></span>
        <input type="text" name="headline" value="{{ old('headline', $industry->headline) }}" maxlength="255" placeholder="From the table to the kitchen without a lost order" @class(['bad' => $errors->has('headline')])>
        @error('headline')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <label class="adm-field">
        <span>Intro <em>shown under the headline</em></span>
        <textarea name="lead" rows="4" maxlength="2000" @class(['bad' => $errors->has('lead')])>{{ old('lead', $industry->lead) }}</textarea>
        @error('lead')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>Highlights</h2><small>"Why it fits" cards, up to 6. The first three also orbit the icon in the page hero.</small></div>
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
        <span>Capabilities <em>one per line, listed under "Everything … needs"</em></span>
        <textarea name="capabilities" rows="7" placeholder="Dine in, takeaway and delivery orders&#10;Table layout with live order status" @class(['bad' => $errors->has('capabilities') || $errors->has('capabilities.*')])>{{ $capabilities }}</textarea>
        @error('capabilities')<small class="adm-err">{{ $message }}</small>@enderror
        @error('capabilities.*')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>SEO</h2><small>Left empty, "Zeebroo for …" and the intro are used.</small></div>
      <label class="adm-field">
        <span>Meta title</span>
        <input type="text" name="meta_title" value="{{ old('meta_title', $industry->meta_title) }}" maxlength="255" data-count="60" @class(['bad' => $errors->has('meta_title')])>
        @error('meta_title')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Meta description</span>
        <textarea name="meta_description" rows="3" maxlength="500" data-count="160" @class(['bad' => $errors->has('meta_description')])>{{ old('meta_description', $industry->meta_description) }}</textarea>
        @error('meta_description')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Meta keywords <em>comma separated</em></span>
        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $industry->meta_keywords) }}" maxlength="500" placeholder="restaurant pos, kitchen orders" @class(['bad' => $errors->has('meta_keywords')])>
        @error('meta_keywords')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
  </div>

  <div class="adm-split-side">
    <div class="adm-card">
      <div class="adm-card-h"><h2>Publish</h2></div>
      <label class="adm-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $industry->is_active))>
        <span></span> Active
        <small>Inactive industries are hidden from the site and their page returns 404.</small>
      </label>
      <label class="adm-field">
        <span>Sort order <em>lower first</em></span>
        <input type="number" name="sort_order" value="{{ old('sort_order', $industry->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
        @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <button type="submit" class="adm-btn ink wide">{{ $submit }}</button>
      <a class="adm-btn line wide" href="{{ route('admin.industries.index') }}">Cancel</a>
      @if ($industry->exists && $industry->is_active)
        <a class="adm-btn line wide" href="{{ route('industries.show', $industry->slug) }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>View page</a>
      @endif
    </div>

    <div class="adm-card">
      <label class="adm-field">
        <span>Icon <em><a href="https://fontawesome.com/search?o=r&amp;s=solid&amp;f=classic" target="_blank" rel="noopener">Font Awesome</a> solid name</em></span>
        <div class="adm-icon-in">
          <i class="fa-solid {{ old('icon', $industry->icon) }}" data-icon-preview></i>
          <input type="text" name="icon" value="{{ old('icon', $industry->icon) }}" maxlength="64" required placeholder="fa-utensils" data-icon-input @class(['bad' => $errors->has('icon')])>
        </div>
        @error('icon')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Badge <em>optional, e.g. Popular or New</em></span>
        <input type="text" name="badge" value="{{ old('badge', $industry->badge) }}" maxlength="32" @class(['bad' => $errors->has('badge')])>
        @error('badge')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Scene image <em>wide, shown below the hero</em></span>
        <label class="adm-drop adm-drop-contain" data-preview>
          <img src="{{ $industry->scene_url }}" alt="" @if (! $industry->scene_url) hidden @endif>
          <span @if ($industry->scene_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose an image</span>
          <input type="file" name="scene" accept="image/jpeg,image/png,image/webp,image/gif">
        </label>
        @error('scene')<small class="adm-err">{{ $message }}</small>@enderror
        @if ($industry->scene_url)
          <label class="adm-check"><input type="checkbox" name="remove_scene" value="1"> Remove current image</label>
        @endif
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Recommended modules <em>"Modules for …"</em></span>
        @if ($features->isEmpty())
          <small class="adm-muted">No features yet.</small>
        @else
          <div class="adm-tags">
            @foreach ($features as $feature)
              <label><input type="checkbox" name="modules[]" value="{{ $feature->id }}" @checked($selectedModules->contains($feature->id))><span>{{ $feature->title }}</span></label>
            @endforeach
          </div>
          <small class="adm-muted">Inactive features are not shown on the site.</small>
        @endif
        @error('modules.*')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
    </div>
  </div>
</div>
