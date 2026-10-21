<div class="adm-split">
  <div class="adm-split-main">
    <div class="adm-card">
      @include('admin.partials.lang-tabs')

      <div class="adm-lang-pane" data-lang-pane="en">
        <label class="adm-field">
          <span>Customer name</span>
          <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required maxlength="255" @class(['bad' => $errors->has('name')])>
          @error('name')<small class="adm-err">{{ $message }}</small>@enderror
        </label>

        <label class="adm-field">
          <span>Position <em>optional, e.g. "Owner, Corner Café"</em></span>
          <input type="text" name="position" value="{{ old('position', $testimonial->position) }}" maxlength="255" @class(['bad' => $errors->has('position')])>
          @error('position')<small class="adm-err">{{ $message }}</small>@enderror
        </label>

        <label class="adm-field">
          <span>Message <em>what the customer said, in their words</em></span>
          <textarea name="message" rows="6" required maxlength="1000" data-count="320" @class(['bad' => $errors->has('message')])>{{ old('message', $testimonial->message) }}</textarea>
          @error('message')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
      </div>

      <div class="adm-lang-pane" data-lang-pane="si" lang="si">
        <label class="adm-field">
          <span>Customer name <em>Sinhala, optional</em></span>
          <input type="text" name="name_si" value="{{ old('name_si', $testimonial->name_si) }}" maxlength="255" @class(['bad' => $errors->has('name_si')])>
          @error('name_si')<small class="adm-err">{{ $message }}</small>@enderror
        </label>

        <label class="adm-field">
          <span>Position <em>Sinhala, optional</em></span>
          <input type="text" name="position_si" value="{{ old('position_si', $testimonial->position_si) }}" maxlength="255" @class(['bad' => $errors->has('position_si')])>
          @error('position_si')<small class="adm-err">{{ $message }}</small>@enderror
        </label>

        <label class="adm-field">
          <span>Message <em>Sinhala</em></span>
          <textarea name="message_si" rows="6" maxlength="1000" data-count="320" @class(['bad' => $errors->has('message_si')])>{{ old('message_si', $testimonial->message_si) }}</textarea>
          @error('message_si')<small class="adm-err">{{ $message }}</small>@enderror
        </label>
      </div>

      <label class="adm-field">
        <span>Star rating</span>
        <select name="rating" @class(['bad' => $errors->has('rating')])>
          @for ($stars = \App\Models\Testimonial::MAX_RATING; $stars >= \App\Models\Testimonial::MIN_RATING; $stars--)
            <option value="{{ $stars }}" @selected((int) old('rating', $testimonial->rating) === $stars)>{{ str_repeat('★', $stars).str_repeat('☆', \App\Models\Testimonial::MAX_RATING - $stars) }} &nbsp;{{ $stars }} {{ Str::plural('star', $stars) }}</option>
          @endfor
        </select>
        @error('rating')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
    </div>
  </div>

  <div class="adm-split-side">
    <div class="adm-card">
      <div class="adm-card-h"><h2>Publish</h2></div>
      <label class="adm-switch">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active))>
        <span></span> Active
        <small>Inactive testimonials are hidden from the site.</small>
      </label>
      <label class="adm-switch">
        <input type="hidden" name="is_featured" value="0">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->is_featured))>
        <span></span> Show on home page
        <small>Only featured testimonials appear in the home page section.</small>
      </label>
      <label class="adm-field">
        <span>Sort order <em>lower first</em></span>
        <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}" min="0" max="9999" @class(['bad' => $errors->has('sort_order')])>
        @error('sort_order')<small class="adm-err">{{ $message }}</small>@enderror
      </label>
      <button type="submit" class="adm-btn ink wide">{{ $submit }}</button>
      <a class="adm-btn line wide" href="{{ route('admin.testimonials.index') }}">Cancel</a>
    </div>

    <div class="adm-card">
      <div class="adm-field">
        <span>Photo <em>square image of the customer, max 2 MB</em></span>
        <label class="adm-drop adm-drop-sm" data-preview>
          <img src="{{ $testimonial->image_url }}" alt="" @if (! $testimonial->image_url) hidden @endif>
          <span @if ($testimonial->image_url) hidden @endif><i class="fa-solid fa-cloud-arrow-up"></i>Choose a photo</span>
          <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        </label>
        @error('image')<small class="adm-err">{{ $message }}</small>@enderror
        @if ($testimonial->image_url)
          <label class="adm-check"><input type="checkbox" name="remove_image" value="1"> Remove current photo</label>
        @endif
      </div>
    </div>
  </div>
</div>
