{{-- Active / inactive pill. Needs: $active, optional $label to override the text --}}
<span @class(['adm-pill', 'ok' => $active])>{{ $label ?? ($active ? 'Active' : 'Inactive') }}</span>
