<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') — TechnoBey</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
<script>(function(){try{var t=localStorage.getItem('tb_theme')||'dark';document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<style>
  .error-page {
    min-height: 100vh; display: flex; align-items: center; justify-content: center;
    padding: 40px 20px; position: relative; overflow: hidden;
  }
  .error-page::before {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background:
      radial-gradient(circle at 20% 30%, rgba(0,87,255,0.15), transparent 55%),
      radial-gradient(circle at 80% 70%, rgba(0,194,255,0.12), transparent 55%);
    z-index: 0;
  }
  .error-box {
    position: relative; z-index: 1;
    background: var(--card); border: 1px solid var(--border);
    border-radius: 24px; padding: 48px 40px; max-width: 560px; width: 100%;
    text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  }
  .error-emoji {
    font-size: 5.5rem; line-height: 1; margin-bottom: 8px;
    animation: err-float 3.5s ease-in-out infinite;
  }
  @keyframes err-float {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-14px); }
  }
  .error-code {
    display: inline-block;
    font-size: 5rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, var(--blue), var(--cyan));
    -webkit-background-clip: text; background-clip: text; color: transparent;
    letter-spacing: -3px; margin-bottom: 12px;
  }
  .error-title { color: var(--white); font-size: 1.6rem; font-weight: 800; margin-bottom: 10px; }
  .error-text { color: var(--muted); font-size: 0.95rem; line-height: 1.7; margin-bottom: 28px; }
  .error-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
  .error-actions .btn-primary,
  .error-actions .btn-secondary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; border-radius: 100px;
    font-size: 0.9rem; font-weight: 700; cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
  }
  .error-actions .btn-primary {
    background: linear-gradient(135deg, var(--blue), var(--cyan));
    color: #fff; border: 0; box-shadow: 0 4px 16px rgba(0,87,255,0.3);
  }
  .error-actions .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,87,255,0.4); }
  .error-actions .btn-secondary {
    background: transparent; border: 1.5px solid var(--border); color: var(--text);
  }
  .error-actions .btn-secondary:hover { border-color: var(--blue); color: var(--white); }
  .error-brand { margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); color: var(--muted); font-size: 0.8rem; }
  .error-brand a { color: var(--cyan); font-weight: 600; }
</style>
</head>
<body>
<div class="error-page">
  <div class="error-box">
    @yield('content')
    <div class="error-brand">
      <a href="{{ url('/') }}">💻 TechnoBey</a> — Bakıda №1 texnologiya mağazası
    </div>
  </div>
</div>
</body>
</html>
