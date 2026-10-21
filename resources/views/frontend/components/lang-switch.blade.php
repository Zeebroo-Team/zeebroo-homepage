{{-- website language switch; each option reloads the current page in that language --}}
<nav class="lang-switch" id="langSwitch" aria-label="Language / භාෂාව">
  @foreach (config('app.locales') as $locale => $name)
    <a href="{{ route('locale.switch', $locale) }}" @class(['lang-opt', 'is-active' => app()->getLocale() === $locale]) lang="{{ $locale }}" hreflang="{{ $locale }}" title="{{ $name }}" @if (app()->getLocale() === $locale) aria-current="true" @endif>{{ $locale === 'si' ? 'සිං' : Str::upper($locale) }}</a>
  @endforeach
</nav>
