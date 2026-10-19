{{-- Edit / delete buttons for a table row. Needs: $edit (url or null), $delete (url or null), $label --}}
<div class="adm-row-actions">
  @if ($edit)
    <a class="adm-icon-btn" href="{{ $edit }}" title="Edit" aria-label="Edit {{ $label }}"><i class="fa-solid fa-pen"></i></a>
  @endif
  @if ($delete)
    <form method="post" action="{{ $delete }}" data-confirm="Delete &quot;{{ $label }}&quot;? This cannot be undone.">
      @csrf
      @method('DELETE')
      <button type="submit" class="adm-icon-btn danger" title="Delete" aria-label="Delete {{ $label }}"><i class="fa-solid fa-trash"></i></button>
    </form>
  @endif
</div>
