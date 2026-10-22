<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>@yield('title') | Zeebroo</title>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32x32.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/apple-touch-icon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Geist:wght@400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
{{-- standalone page: no database-driven nav or footer, so it still renders when the site itself is failing --}}
<div class="err">
  <header class="err-top">
    <a href="{{ route('home') }}" class="logo" aria-label="Zeebroo home"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a>
  </header>

  <main class="err-main">
    <div class="err-in">
      <img class="err-art" src="{{ asset('assets/ufo.webp') }}" alt="" width="179" height="187">
      <span class="label">Error @yield('code')</span>
      <div class="err-code" aria-hidden="true">@yield('code')</div>
      <h1>@yield('heading')</h1>
      <p>@yield('message')</p>
      <div class="err-acts">
        @section('actions')
          <a class="btn btn-ink" href="{{ route('home') }}">Back to home <i class="fa-solid fa-arrow-right"></i></a>
          <a class="btn btn-line" href="{{ route('contact') }}">Contact support</a>
        @show
      </div>
    </div>
  </main>

  <footer class="err-foot">
    <span>&copy; {{ date('Y') }} Zeebroo. All rights reserved.</span>
    <span>Still stuck? Email <a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a></span>
  </footer>
</div>

@include('frontend.components.lang-switch')
</body>
</html>
