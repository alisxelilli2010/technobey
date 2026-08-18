<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDesc }}">
<meta name="author" content="Texnobəy">
<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="theme-color" content="#0057ff">
<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph -->
<meta property="og:type" content="{{ $ogType ?? 'website' }}">
<meta property="og:site_name" content="Texnobəy">
<meta property="og:locale" content="az_AZ">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:image" content="{{ $shareImage }}">
<meta property="og:image:alt" content="{{ $shareAlt ?? 'Texnobəy' }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">
<meta name="twitter:image" content="{{ $shareImage }}">
<meta name="twitter:image:alt" content="{{ $shareAlt ?? 'Texnobəy' }}">

@stack('head')

<!-- Favicons -->
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

<script>(function(){try{if(!localStorage.getItem('tb_theme_v2')){localStorage.removeItem('tb_theme');localStorage.setItem('tb_theme_v2','1');}var t=localStorage.getItem('tb_theme')||'light';document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>
<body>

<nav class="navbar" id="navbar">
  <a href="{{ url('/') }}" class="logo">
    <div class="logo-icon"><img src="{{ asset('logo.svg') }}" alt="Texnobəy"></div>
    Texno<span>bəy</span>
  </a>
  <div class="nav-right">
    <ul class="nav-links">
      <li><a href="{{ url('/') }}#products">{{ __('site.nav.products') }}</a></li>
      <li><a href="{{ route('blog.index') }}">Bloq</a></li>
      <li><a href="{{ url('/') }}#contact">{{ __('site.nav.contact') }}</a></li>
      <li><a href="{{ route('order.status') }}">{{ __('site.nav.track') }}</a></li>
    </ul>
    <button type="button" class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="{{ __('site.nav.theme') }}" aria-label="{{ __('site.nav.theme') }}"><span id="themeBtnIco">🌙</span></button>
  </div>
</nav>

@yield('content')

<footer class="blog-foot">
  <div class="container">
    <p>© {{ date('Y') }} Texnobəy — Bakıda kompüter, printer və proyektor satışı və servisi.</p>
    <div class="blog-foot-links">
      <a href="{{ url('/') }}">Ana səhifə</a>
      <a href="{{ url('/') }}#products">{{ __('site.nav.products') }}</a>
      <a href="{{ route('blog.index') }}">Bloq</a>
      <a href="{{ url('/') }}#contact">{{ __('site.nav.contact') }}</a>
    </div>
  </div>
</footer>

<script src="{{ asset('js/main.js') }}?v={{ filemtime(public_path('js/main.js')) }}"></script>
@stack('scripts')
</body>
</html>
