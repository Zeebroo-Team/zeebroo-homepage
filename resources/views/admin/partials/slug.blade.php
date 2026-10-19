{{-- Slug input that follows the source field until edited by hand. Needs: $source (id of the name/title input), $value, $prefix (URL shown before it) --}}
<div class="adm-field">
  <span>Slug <em>auto-generated, editable</em></span>
  <div class="adm-slug">
    <small>{{ $prefix }}</small>
    <input type="text" name="slug" id="slug" value="{{ $value }}" data-slug-source="#{{ $source }}" placeholder="generated-from-{{ $source }}" @class(['bad' => $errors->has('slug')])>
    <button type="button" class="adm-icon-btn" data-slug-reset title="Regenerate from {{ $source }}" aria-label="Regenerate slug"><i class="fa-solid fa-rotate"></i></button>
  </div>
  @error('slug')<small class="adm-err">{{ $message }}</small>@enderror
</div>
