@extends('admin.layouts.app')

@section('title', 'SEO: '.$page->name)

@php
  $defaultTitle = config('social.default.title');
  $defaultDescription = config('social.default.description');
  $defaultImage = asset(config('social.default.image'));
@endphp

@section('content')
<form class="adm-form" method="post" action="{{ route('admin.seo.pages.update', $page->key) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="adm-split">
    <div class="adm-split-main">
      <div class="adm-card">
        @include('admin.partials.lang-tabs')

        <div class="adm-lang-pane" data-lang-pane="en">
          <label class="adm-field">
            <span>Meta title <em>shown in Google and as the browser tab, best 50–60 characters</em></span>
            <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" maxlength="255" data-count="60" placeholder="{{ $defaultTitle }}" data-seo-title @class(['bad' => $errors->has('meta_title')])>
            @error('meta_title')<small class="adm-err">{{ $message }}</small>@enderror
          </label>

          <label class="adm-field">
            <span>Meta description <em>the line under the title in Google, best 120–160 characters</em></span>
            <textarea name="meta_description" rows="3" maxlength="500" data-count="160" placeholder="{{ $defaultDescription }}" data-seo-description @class(['bad' => $errors->has('meta_description')])>{{ old('meta_description', $page->meta_description) }}</textarea>
            @error('meta_description')<small class="adm-err">{{ $message }}</small>@enderror
          </label>

          <label class="adm-field">
            <span>Share image description <em>alt text for people using screen readers</em></span>
            <input type="text" name="og_image_alt" value="{{ old('og_image_alt', $page->og_image_alt) }}" maxlength="255" placeholder="{{ config('social.default.image_alt') }}" @class(['bad' => $errors->has('og_image_alt')])>
            @error('og_image_alt')<small class="adm-err">{{ $message }}</small>@enderror
          </label>
        </div>

        <div class="adm-lang-pane" data-lang-pane="si" lang="si">
          <label class="adm-field">
            <span>Meta title <em>Sinhala, optional</em></span>
            <input type="text" name="meta_title_si" value="{{ old('meta_title_si', $page->meta_title_si) }}" maxlength="255" data-count="60" placeholder="Empty keeps the page's built-in Sinhala title" @class(['bad' => $errors->has('meta_title_si')])>
            @error('meta_title_si')<small class="adm-err">{{ $message }}</small>@enderror
          </label>

          <label class="adm-field">
            <span>Meta description <em>Sinhala, optional</em></span>
            <textarea name="meta_description_si" rows="3" maxlength="500" data-count="160" placeholder="Empty keeps the page's built-in Sinhala description" @class(['bad' => $errors->has('meta_description_si')])>{{ old('meta_description_si', $page->meta_description_si) }}</textarea>
            @error('meta_description_si')<small class="adm-err">{{ $message }}</small>@enderror
          </label>

          <label class="adm-field">
            <span>Share image description <em>Sinhala, optional</em></span>
            <input type="text" name="og_image_alt_si" value="{{ old('og_image_alt_si', $page->og_image_alt_si) }}" maxlength="255" @class(['bad' => $errors->has('og_image_alt_si')])>
            @error('og_image_alt_si')<small class="adm-err">{{ $message }}</small>@enderror
          </label>
        </div>
      </div>

      <div class="adm-card">
        <div class="adm-card-h"><h2>Preview</h2><small>How the English page looks in Google and when shared. Updates as you type.</small></div>
        <div class="adm-seo-serp">
          <small>{{ $page->url }}</small>
          <b data-seo-preview-title>{{ $page->meta_title ?: $defaultTitle }}</b>
          <p data-seo-preview-description>{{ $page->meta_description ?: $defaultDescription }}</p>
        </div>
        <div class="adm-seo-card">
          <img src="{{ $page->og_image_url ?: $defaultImage }}" alt="" data-seo-preview-image>
          <div>
            <small>{{ parse_url((string) $page->url, PHP_URL_HOST) }}</small>
            <b data-seo-preview-title>{{ $page->meta_title ?: $defaultTitle }}</b>
            <p data-seo-preview-description>{{ $page->meta_description ?: $defaultDescription }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="adm-split-side">
      <div class="adm-card">
        <div class="adm-card-h"><h2>Save</h2></div>
        <button type="submit" class="adm-btn ink wide">Save changes</button>
        <a class="adm-btn line wide" href="{{ route('admin.seo.pages.index') }}">Cancel</a>
        <a class="adm-btn line wide" href="{{ $page->url }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>View page</a>
      </div>

      <div class="adm-card">
        <div class="adm-field">
          <span>Share image <em>JPG or PNG, max 5 MB; cropped from the centre to {{ \App\Models\SeoPage::OG_IMAGE_WIDTH }} × {{ \App\Models\SeoPage::OG_IMAGE_HEIGHT }}</em></span>
          <label class="adm-drop adm-drop-wide" data-preview>
            <img src="{{ $page->og_image_url }}" alt="" @if (! $page->og_image_url) hidden @endif>
            <span @if ($page->og_image_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose an image</span>
            <input type="file" name="image" accept="image/jpeg,image/png" data-seo-image>
          </label>
          @error('image')<small class="adm-err">{{ $message }}</small>@enderror
          @if ($page->og_image_url)
            <label class="adm-check"><input type="checkbox" name="remove_image" value="1"> Remove and use the default image</label>
          @else
            <small class="adm-help">No image yet, so the default image is shared.</small>
          @endif
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
// live Google / share card preview from the English fields
(() => {
  const title = document.querySelector('[data-seo-title]');
  const description = document.querySelector('[data-seo-description]');
  const image = document.querySelector('[data-seo-image]');
  const sync = (field, target) => {
    const text = field.value.trim() || field.placeholder;
    document.querySelectorAll(target).forEach((el) => { el.textContent = text; });
  };
  title.addEventListener('input', () => sync(title, '[data-seo-preview-title]'));
  description.addEventListener('input', () => sync(description, '[data-seo-preview-description]'));
  image.addEventListener('change', () => {
    if (image.files[0]) {
      document.querySelector('[data-seo-preview-image]').src = URL.createObjectURL(image.files[0]);
    }
  });
})();
</script>
@endpush
