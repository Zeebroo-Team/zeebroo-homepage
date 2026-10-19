<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title', 'Dashboard') | Zeebroo Admin</title>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32x32.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Geist:wght@400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@stack('head')
<link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="adm">
<aside class="adm-side" id="admSide">
  <a href="{{ route('admin.dashboard') }}" class="adm-logo"><img src="{{ asset('assets/mark.png') }}" alt="" width="20" height="26">Zeebroo <span>Admin</span></a>
  <nav class="adm-nav">
    <a href="{{ route('admin.dashboard') }}" @class(['on' => request()->routeIs('admin.dashboard')])><i class="fa-solid fa-gauge"></i>Dashboard</a>
    @canany(['view blogs', 'view blog categories', 'view blog tags'])
      <span class="adm-nav-h">Blog</span>
    @endcanany
    @can('view blogs')
      <a href="{{ route('admin.blog.posts.index') }}" @class(['on' => request()->routeIs('admin.blog.posts.*')])><i class="fa-solid fa-newspaper"></i>Posts</a>
    @endcan
    @can('view blog categories')
      <a href="{{ route('admin.blog.categories.index') }}" @class(['on' => request()->routeIs('admin.blog.categories.*')])><i class="fa-solid fa-folder"></i>Categories</a>
    @endcan
    @can('view blog tags')
      <a href="{{ route('admin.blog.tags.index') }}" @class(['on' => request()->routeIs('admin.blog.tags.*')])><i class="fa-solid fa-tags"></i>Tags</a>
    @endcan
    @canany(['view features', 'view industries', 'view partners', 'view partner categories'])
      <span class="adm-nav-h">Website</span>
    @endcanany
    @can('view features')
      <a href="{{ route('admin.features.index') }}" @class(['on' => request()->routeIs('admin.features.*')])><i class="fa-solid fa-layer-group"></i>Features</a>
    @endcan
    @can('view industries')
      <a href="{{ route('admin.industries.index') }}" @class(['on' => request()->routeIs('admin.industries.*')])><i class="fa-solid fa-briefcase"></i>Industries</a>
    @endcan
    @can('view partners')
      <a href="{{ route('admin.partners.index') }}" @class(['on' => request()->routeIs('admin.partners.*')])><i class="fa-solid fa-handshake"></i>Partners</a>
    @endcan
    @can('view partner categories')
      <a href="{{ route('admin.partner-categories.index') }}" @class(['on' => request()->routeIs('admin.partner-categories.*')])><i class="fa-solid fa-folder-tree"></i>Partner categories</a>
    @endcan
  </nav>
  <a class="adm-site" href="{{ route('blog.index') }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>View blog</a>
</aside>

<div class="adm-main">
  <header class="adm-top">
    <button type="button" class="adm-burger" id="admBurger" aria-label="Toggle menu"><i class="fa-solid fa-bars"></i></button>
    <h1>@yield('title', 'Dashboard')</h1>
    <div class="adm-user">
      <span><b>{{ auth()->user()->name }}</b><small>{{ auth()->user()->getRoleNames()->implode(', ') }}</small></span>
      <form method="post" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="adm-icon-btn" title="Sign out" aria-label="Sign out"><i class="fa-solid fa-right-from-bracket"></i></button>
      </form>
    </div>
  </header>

  <main class="adm-body">
    @if (session('status'))
      <div class="adm-alert ok"><i class="fa-solid fa-circle-check"></i>{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="adm-alert err"><i class="fa-solid fa-circle-exclamation"></i>Please fix the highlighted fields.</div>
    @endif

    @yield('content')
  </main>
</div>

<script src="{{ asset('assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
