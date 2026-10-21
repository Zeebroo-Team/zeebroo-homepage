<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Zeebroo: the POS that runs your whole business')</title>
<meta name="description" content="@yield('description', 'Zeebroo brings sales, stock, money, people and marketing into one workspace. Web and desktop POS, inventory, bills, HR and campaigns. All modules included.')">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32x32.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/apple-touch-icon.png') }}">
@stack('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Geist:wght@400;500;600&family=Geist+Mono:wght@400;500{{ app()->getLocale() === 'si' ? '&family=Noto+Sans+Sinhala:wght@400;500;600;700;800' : '' }}&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
<span id="topSentinel" style="position:absolute;top:0;height:1px;width:1px"></span>

    <!-- header begin -->
         @include('frontend.components.header')
    <!-- header close -->

        <main id="top">
            @yield('content')
        </main>

    <!-- footer begin -->
        @include('frontend.components.footer')
    <!-- footer close -->

    @include('frontend.components.lang-switch')

<script src="{{ asset('assets/js/nav.js') }}"></script>
@stack('scripts')
</body>
</html>
