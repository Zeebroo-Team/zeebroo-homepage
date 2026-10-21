{{-- One highlight row in the feature / industry form. Needs: $i (row index, or "__i__" in the template), $h (icon, title, text, and title_si, text_si when $bilingual) --}}
@php($bilingual = $bilingual ?? false)
<div class="adm-repeat-row" data-repeat-row>
  <div class="adm-icon-in">
    <i class="fa-solid {{ $h['icon'] ?? 'fa-check' }}" data-icon-preview></i>
    <input type="text" name="highlights[{{ $i }}][icon]" value="{{ $h['icon'] ?? '' }}" maxlength="64" placeholder="fa-check" aria-label="Icon" data-icon-input @class(['bad' => $errors->has("highlights.{$i}.icon")])>
  </div>
  <button type="button" class="adm-icon-btn danger" data-repeat-remove title="Remove" aria-label="Remove highlight"><i class="fa-solid fa-xmark"></i></button>
  <div class="adm-lang-inline" @if ($bilingual) data-lang-pane="en" @endif>
    <input type="text" name="highlights[{{ $i }}][title]" value="{{ $h['title'] ?? '' }}" maxlength="255" placeholder="Title" aria-label="Title" @class(['bad' => $errors->has("highlights.{$i}.title")])>
    <textarea name="highlights[{{ $i }}][text]" rows="2" maxlength="500" placeholder="One or two sentences" aria-label="Text" @class(['bad' => $errors->has("highlights.{$i}.text")])>{{ $h['text'] ?? '' }}</textarea>
  </div>
  @if ($bilingual)
    <div class="adm-lang-inline" data-lang-pane="si" lang="si">
      <input type="text" name="highlights[{{ $i }}][title_si]" value="{{ $h['title_si'] ?? '' }}" maxlength="255" placeholder="Title in Sinhala" aria-label="Sinhala title" @class(['bad' => $errors->has("highlights_si.{$i}.title")])>
      <textarea name="highlights[{{ $i }}][text_si]" rows="2" maxlength="500" placeholder="Text in Sinhala" aria-label="Sinhala text" @class(['bad' => $errors->has("highlights_si.{$i}.text")])>{{ $h['text_si'] ?? '' }}</textarea>
      @foreach (['title', 'text'] as $key)
        @error("highlights_si.{$i}.{$key}")<small class="adm-err">{{ $message }}</small>@enderror
      @endforeach
    </div>
  @endif
  @foreach (['icon', 'title', 'text'] as $key)
    @error("highlights.{$i}.{$key}")<small class="adm-err">{{ $message }}</small>@enderror
  @endforeach
</div>
