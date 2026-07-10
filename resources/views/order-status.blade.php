<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ __('site.track.title') }} — Texnobəy</title>
<meta name="description" content="Sifariş kodunuzla sifariş statusunu Texnobəy-də onlayn izləyin.">
<meta name="robots" content="noindex, follow">
<meta name="theme-color" content="#0057ff">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
<script>(function(){try{var t=localStorage.getItem('tb_theme')||'dark';document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
</head>
<body>

<nav class="navbar" id="navbar">
  <a href="{{ url('/') }}" class="logo">
    <div class="logo-icon"><img src="{{ asset('logo.svg') }}" alt="Texnobəy" loading="lazy"></div>
    Texno<span>bəy</span>
  </a>
  <ul class="nav-links">
    <li><a href="{{ url('/') }}">{{ __('site.track.back') }}</a></li>
  </ul>
</nav>

<div class="status-page">
  <div class="status-card">
    <h1>{{ __('site.track.title') }}</h1>
    <p class="hint">{{ __('site.track.hint') }}</p>
    <form method="get" action="{{ route('order.status') }}" class="status-form">
      <input type="text" name="code" placeholder="{{ __('site.track.placeholder') }}" value="{{ $code }}" autocomplete="off" required>
      <button type="submit">{{ __('site.track.check') }}</button>
    </form>

    @if ($notFound)
      <div class="status-error">❌ {{ __('site.track.not_found') }}</div>
    @endif

    @if ($order)
      <div class="status-details">
        <div class="status-row">
          <span class="lbl">{{ __('site.track.code') }}</span>
          <span class="val">{{ $order->track_code }}</span>
        </div>
        <div class="status-row">
          <span class="lbl">{{ __('site.track.customer') }}</span>
          <span class="val">{{ $order->name }}</span>
        </div>
        <div class="status-row">
          <span class="lbl">{{ __('site.track.service') }}</span>
          <span class="val">{{ $order->service }}</span>
        </div>
        <div class="status-row">
          <span class="lbl">{{ __('site.track.date') }}</span>
          <span class="val">{{ optional($order->created_at)->setTimezone('Asia/Baku')->format('d.m.Y H:i') }}</span>
        </div>
        <div class="status-row">
          <span class="lbl">{{ __('site.track.status') }}</span>
          <span class="val"><span class="status-pill {{ $order->status ?: 'new' }}">{{ $labels[$order->status] ?? $order->status }}</span></span>
        </div>
      </div>
    @endif

    <a href="{{ url('/') }}" class="status-back">{{ __('site.track.back') }}</a>
  </div>
</div>

</body>
</html>
