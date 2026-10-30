{{-- Open Graph and Twitter card tags; include after the page's title and description sections.
     Shares the image saved in /admin/seo when $seoPage has one, else the site-wide default (config/social.php `default`). --}}
@php
  $socialDefault = config('social.default');
  $socialImage = isset($seoPage) && $seoPage?->og_image_url
      ? [
          'url' => $seoPage->og_image_url,
          'type' => 'jpeg',
          'width' => \App\Models\SeoPage::OG_IMAGE_WIDTH,
          'height' => \App\Models\SeoPage::OG_IMAGE_HEIGHT,
          'alt' => $seoPage->localized('og_image_alt') ?? $socialDefault['image_alt'],
      ]
      : [
          'url' => asset($socialDefault['image']),
          'type' => pathinfo($socialDefault['image'], PATHINFO_EXTENSION) === 'png' ? 'png' : 'jpeg',
          'width' => $socialDefault['image_width'],
          'height' => $socialDefault['image_height'],
          'alt' => $socialDefault['image_alt'],
      ];
@endphp
@push('head')
<meta property="og:type" content="website">
<meta property="og:site_name" content="Zeebroo">
<meta property="og:title" content="@yield('title', $socialDefault['title'])">
<meta property="og:description" content="@yield('description', $socialDefault['description'])">
<meta property="og:url" content="{{ $canonical ?? url()->current() }}">
<meta property="og:image" content="{{ $socialImage['url'] }}">
<meta property="og:image:type" content="image/{{ $socialImage['type'] }}">
<meta property="og:image:width" content="{{ $socialImage['width'] }}">
<meta property="og:image:height" content="{{ $socialImage['height'] }}">
<meta property="og:image:alt" content="{{ $socialImage['alt'] }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'si' ? 'si_LK' : 'en_LK' }}">

{{-- a square image only fills the small card; a 1200x630 image gets the large one --}}
<meta name="twitter:card" content="{{ $socialImage['width'] === $socialImage['height'] ? 'summary' : 'summary_large_image' }}">
<meta name="twitter:title" content="@yield('title', $socialDefault['title'])">
<meta name="twitter:description" content="@yield('description', $socialDefault['description'])">
<meta name="twitter:image" content="{{ $socialImage['url'] }}">
<meta name="twitter:image:alt" content="{{ $socialImage['alt'] }}">
@endpush
