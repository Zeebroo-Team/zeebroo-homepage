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
    <a href="{{ route('admin.dashboard') }}" data-key="g d" data-key-label="Go to dashboard" @class(['on' => request()->routeIs('admin.dashboard')])><i class="fa-solid fa-gauge"></i>Dashboard</a>
    @can('view enquiries')
      @php($unreadEnquiries = \App\Models\Enquiry::unread()->count())
      <a href="{{ route('admin.enquiries.index') }}" data-key="g e" data-key-label="Go to enquiries" @class(['on' => request()->routeIs('admin.enquiries.*')])><i class="fa-solid fa-inbox"></i>Enquiries <b class="adm-nav-count" id="admEnquiryCount" title="New enquiries" @if (! $unreadEnquiries) hidden @endif>{{ $unreadEnquiries }}</b></a>
    @endcan
    @canany(['view blogs', 'view blog categories', 'view blog tags'])
      <span class="adm-nav-h">Blog</span>
    @endcanany
    @can('view blogs')
      <a href="{{ route('admin.blog.posts.index') }}" data-key="g p" data-key-label="Go to posts" @class(['on' => request()->routeIs('admin.blog.posts.*')])><i class="fa-solid fa-newspaper"></i>Posts</a>
    @endcan
    @can('view blog categories')
      <a href="{{ route('admin.blog.categories.index') }}" @class(['on' => request()->routeIs('admin.blog.categories.*')])><i class="fa-solid fa-folder"></i>Categories</a>
    @endcan
    @can('view blog tags')
      <a href="{{ route('admin.blog.tags.index') }}" @class(['on' => request()->routeIs('admin.blog.tags.*')])><i class="fa-solid fa-tags"></i>Tags</a>
    @endcan
    @canany(['view features', 'view industries', 'view testimonials'])
      <span class="adm-nav-h">Website</span>
    @endcanany
    @can('view features')
      <a href="{{ route('admin.features.index') }}" data-key="g f" data-key-label="Go to features" @class(['on' => request()->routeIs('admin.features.*')])><i class="fa-solid fa-layer-group"></i>Features</a>
    @endcan
    @can('view industries')
      <a href="{{ route('admin.industries.index') }}" data-key="g i" data-key-label="Go to industries" @class(['on' => request()->routeIs('admin.industries.*')])><i class="fa-solid fa-briefcase"></i>Industries</a>
    @endcan
    @can('view testimonials')
      <a href="{{ route('admin.testimonials.index') }}" data-key="g t" data-key-label="Go to testimonials" @class(['on' => request()->routeIs('admin.testimonials.*')])><i class="fa-solid fa-comment-dots"></i>Testimonials</a>
    @endcan
    @canany(['view partners', 'view partner categories'])
      <span class="adm-nav-h">Partners</span>
    @endcanany
    @can('view partners')
      <a href="{{ route('admin.partners.index') }}" data-key="g a" data-key-label="Go to partners" @class(['on' => request()->routeIs('admin.partners.*')])><i class="fa-solid fa-handshake"></i>All partners</a>
    @endcan
    @can('view partner categories')
      <a href="{{ route('admin.partner-categories.index') }}" @class(['on' => request()->routeIs('admin.partner-categories.*')])><i class="fa-solid fa-folder-tree"></i>Categories</a>
    @endcan
    @can('view seo')
      <span class="adm-nav-h">SEO</span>
      <a href="{{ route('admin.seo.pages.index') }}" @class(['on' => request()->routeIs('admin.seo.pages.*')])><i class="fa-solid fa-magnifying-glass-chart"></i>Pages</a>
    @endcan
  </nav>
  <a class="adm-site" href="{{ route('blog.index') }}" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i>View blog</a>
</aside>

<div class="adm-main">
  <header class="adm-top">
    <button type="button" class="adm-burger" id="admBurger" aria-label="Toggle menu"><i class="fa-solid fa-bars"></i></button>
    <h1>@yield('title', 'Dashboard')</h1>
    <div class="adm-user">
      @php($unreadNotifications = auth()->user()->unreadNotifications()->count())
      <div class="adm-bell" id="admBell" data-feed="{{ route('admin.notifications.index') }}">
        <button type="button" class="adm-icon-btn" aria-expanded="false" aria-controls="admBellMenu" aria-label="Notifications">
          <i class="fa-solid fa-bell"></i>
          <b class="adm-bell-count" @if (! $unreadNotifications) hidden @endif>{{ $unreadNotifications }}</b>
        </button>
        <div class="adm-bell-menu" id="admBellMenu" hidden>
          <div class="adm-bell-h">
            <b>Notifications</b>
            <form method="post" action="{{ route('admin.notifications.read-all') }}">
              @csrf
              <button type="submit">Mark all as read</button>
            </form>
          </div>
          <div class="adm-bell-list">
            @include('admin.partials.notifications', ['notifications' => auth()->user()->notifications()->take(\App\Http\Controllers\Admin\NotificationController::LIMIT)->get()])
          </div>
        </div>
      </div>
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

{{-- keyboard shortcut help (press "?"); the list is built from every [data-key] link on the page --}}
<dialog class="adm-keys" id="admKeys" aria-labelledby="admKeysTitle">
  <div class="adm-card-h"><h2 id="admKeysTitle">Keyboard shortcuts</h2><button type="button" class="adm-icon-btn" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button></div>
  <p class="adm-muted">Press the keys one after the other, e.g. <kbd>g</kbd> then <kbd>e</kbd>.</p>
  <dl id="admKeysList"></dl>
</dialog>

<script src="{{ asset('assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
