<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Sign in | Zeebroo Admin</title>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32x32.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Geist:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="adm-auth">
<form class="adm-auth-card" method="post" action="{{ route('admin.login.store') }}">
  @csrf
  <a href="{{ route('home') }}" class="adm-logo"><img src="{{ asset('assets/mark.png') }}" alt="" width="20" height="26">Zeebroo <span>Admin</span></a>
  <h1>Sign in</h1>
  <p>Manage the blog, categories and tags.</p>

  <label class="adm-field">
    <span>Email</span>
    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" @class(['bad' => $errors->has('email')])>
    @error('email')<small class="adm-err">{{ $message }}</small>@enderror
  </label>
  <label class="adm-field">
    <span>Password</span>
    <input type="password" name="password" required autocomplete="current-password">
  </label>
  <label class="adm-check"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>

  <button type="submit" class="adm-btn ink wide">Sign in <i class="fa-solid fa-arrow-right"></i></button>
</form>
</body>
</html>
