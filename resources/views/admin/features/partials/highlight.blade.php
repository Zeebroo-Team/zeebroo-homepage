{{-- One highlight row in the feature form. Needs: $i (row index, or "__i__" in the template), $h (icon, title, text) --}}
<div class="adm-repeat-row" data-repeat-row>
  <div class="adm-icon-in">
    <i class="fa-solid {{ $h['icon'] ?? 'fa-check' }}" data-icon-preview></i>
    <input type="text" name="highlights[{{ $i }}][icon]" value="{{ $h['icon'] ?? '' }}" maxlength="64" placeholder="fa-check" aria-label="Icon" data-icon-input @class(['bad' => $errors->has("highlights.{$i}.icon")])>
  </div>
  <input type="text" name="highlights[{{ $i }}][title]" value="{{ $h['title'] ?? '' }}" maxlength="255" placeholder="Title" aria-label="Title" @class(['bad' => $errors->has("highlights.{$i}.title")])>
  <button type="button" class="adm-icon-btn danger" data-repeat-remove title="Remove" aria-label="Remove highlight"><i class="fa-solid fa-xmark"></i></button>
  <textarea name="highlights[{{ $i }}][text]" rows="2" maxlength="500" placeholder="One or two sentences" aria-label="Text" @class(['bad' => $errors->has("highlights.{$i}.text")])>{{ $h['text'] ?? '' }}</textarea>
  @foreach (['icon', 'title', 'text'] as $key)
    @error("highlights.{$i}.{$key}")<small class="adm-err">{{ $message }}</small>@enderror
  @endforeach
</div>
