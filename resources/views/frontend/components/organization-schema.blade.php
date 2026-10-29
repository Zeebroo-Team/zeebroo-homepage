{{-- Organization structured data for search engines; pushed into <head> on the home page (both languages) --}}
@push('head')
<script type="application/ld+json">{!! json_encode([
  '@@context' => 'https://schema.org',
  '@type' => 'Organization',
  'name' => 'Zeebroo',
  'url' => route('home').'/',
  'logo' => asset('assets/logo.png'),
  'description' => 'All-in-one POS and business management platform for Sri Lankan businesses.',
  'sameAs' => [
      'https://www.linkedin.com/company/zeebroo/',
  ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
