{{-- partner logo, or its initials when no logo is uploaded. Needs: $partner --}}
@if ($partner->logo_url)
  <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }} ලාංඡනය" loading="lazy">
@else
  <span class="ptn-initials" aria-hidden="true">{{ $partner->initials }}</span>
@endif
