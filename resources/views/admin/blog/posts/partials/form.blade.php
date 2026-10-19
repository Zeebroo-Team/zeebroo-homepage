@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="{{ asset('assets/js/admin-editor.js') }}"></script>
@endpush

@php
  $canPublish = auth()->user()->can('publish blogs');
  $selectedTags = collect(old('tags', $blog->exists ? $blog->tags->pluck('id')->all() : []))->map(fn ($id) => (int) $id);
@endphp

<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      <label class="adm-field">
        <span>Title</span>
        <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}" required maxlength="255" @class(['bad' => $errors->has('title')])>
        @error('title')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      @include('admin.partials.slug', ['source' => 'title', 'value' => old('slug', $blog->slug), 'prefix' => '/blog/'])

      <div class="adm-field">
        <span>Description</span>
        <div class="adm-editor" data-editor="#description"></div>
        <textarea name="description" id="description" hidden>{{ old('description', $blog->description) }}</textarea>
        @error('description')<small class="adm-err">{{ $message }}</small>@enderror
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-h"><h2>SEO</h2><small>Left empty, the title and the start of the description are used.</small></div>
      <label class="adm-field">
        <span>Meta title</span>
        <input type="text" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}" maxlength="255" data-count="60" @class(['bad' => $errors->has('meta_title')])>
        @error('meta_title')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Meta description</span>
        <textarea name="meta_description" rows="3" maxlength="500" data-count="160" @class(['bad' => $errors->has('meta_description')])>{{ old('meta_description', $blog->meta_description) }}</textarea>
        @error('meta_description')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <label class="adm-field">
        <span>Meta keywords <em>comma separated</em></span>
        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords) }}" maxlength="500" placeholder="pos, inventory, small business" @class(['bad' => $errors->has('meta_keywords')])>
        @error('meta_keywords')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
  </div>

  <div class="adm-split-side">
    <div class="adm-card">
      <div class="adm-card-h"><h2>Publish</h2></div>
      <label class="adm-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $blog->is_active)) @disabled(! $canPublish)>
        <span></span> Active
      </label>
      <label class="adm-field">
        <span>Publish at <em>empty = draft</em></span>
        <input type="datetime-local" name="published_at" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}" @disabled(! $canPublish) @class(['bad' => $errors->has('published_at')])>
        @error('published_at')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      @unless ($canPublish)
        <p class="adm-note"><i class="fa-solid fa-lock"></i>An editor publishes your post once it's ready.</p>
      @endunless
      <button type="submit" class="adm-btn ink wide">{{ $submit }}</button>
      <a class="adm-btn line wide" href="{{ route('admin.blog.posts.index') }}">Cancel</a>
    </div>

    <div class="adm-card">
      <label class="adm-field">
        <span>Category</span>
        <select name="category_id" @class(['bad' => $errors->has('category_id')])>
          <option value="">Uncategorised</option>
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}" @selected((int) old('category_id', $blog->category_id) === $id)>{{ $name }}</option>
          @endforeach
        </select>
        @error('category_id')<small class="adm-err">{{ $message }}</small>@enderror
      </label>

      <div class="adm-field">
        <span>Tags</span>
        @if ($tags->isEmpty())
          <small class="adm-muted">No tags yet.@can('create blog tags') <a href="{{ route('admin.blog.tags.create') }}">Create one</a>@endcan</small>
        @else
          <div class="adm-tags">
            @foreach ($tags as $id => $name)
              <label><input type="checkbox" name="tags[]" value="{{ $id }}" @checked($selectedTags->contains($id))><span>{{ $name }}</span></label>
            @endforeach
          </div>
        @endif
        @error('tags.*')<small class="adm-err">{{ $message }}</small>@enderror
      </div>

      <label class="adm-field">
        <span>Author name</span>
        <input type="text" name="author_name" value="{{ old('author_name', $blog->author_name) }}" maxlength="255" @class(['bad' => $errors->has('author_name')])>
        @error('author_name')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Featured image <em>JPG, PNG, WebP or GIF, max 4 MB</em></span>
        <label class="adm-drop" data-preview>
          <img src="{{ $blog->image_url }}" alt="" @if (! $blog->image_url) hidden @endif>
          <span @if ($blog->image_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose an image</span>
          <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
        </label>
        @error('image')<small class="adm-err">{{ $message }}</small>@enderror
        @if ($blog->image_url)
          <label class="adm-check"><input type="checkbox" name="remove_image" value="1"> Remove current image</label>
        @endif
      </div>
    </div>
  </div>
</div>
