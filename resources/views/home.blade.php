@php
    $siteUrl        = rtrim(url('/'), '/');
    $canonical      = url()->current();
    // OG/Twitter şəkli PNG olmalıdır — Facebook və X (Twitter) SVG-ni render etmir
    $ogImage        = asset('og-image.png');
    $metaTitle      = __('site.meta.title');
    $metaDesc       = __('site.meta.description');
    $metaKeywords   = __('site.meta.keywords');

    $orgPhone   = $contact['phone']   ?? '+994 55 789 57 45';
    $orgEmail   = $contact['email']   ?? 'info@texnobey.az';
    $orgAddress = $contact['addr']    ?? 'Nəsimi rayonu, Bakı şəhəri, Azərbaycan';
    $orgHours   = $contact['hours']   ?? '';

    $organization = [
        '@context' => 'https://schema.org',
        '@type'    => 'Store',
        '@id'      => $siteUrl . '/#store',
        'name'     => 'Texnobəy',
        'url'      => $siteUrl,
        'logo'     => asset('favicon.svg'),
        'image'    => $ogImage,
        'description' => $metaDesc,
        'telephone'   => $orgPhone,
        'email'       => $orgEmail,
        'priceRange'  => '₼₼',
        'address'  => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Nəsimi rayonu',
            'addressLocality' => 'Bakı',
            'addressCountry'  => 'AZ',
        ],
        'areaServed' => [
            '@type' => 'City',
            'name'  => 'Bakı',
        ],
        'sameAs' => [
            'https://www.instagram.com/texnobey.az/',
            'https://www.facebook.com/p/TexnoBeyaz-61568468586277/',
        ],
        'contactPoint' => [
            '@type'             => 'ContactPoint',
            'contactType'       => 'customer service',
            'telephone'         => $orgPhone,
            'email'             => $orgEmail,
            'areaServed'        => 'AZ',
            'availableLanguage' => ['az', 'ru', 'en'],
        ],
    ];

    $website = [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        '@id'      => $siteUrl . '/#website',
        'url'      => $siteUrl,
        'name'     => 'Texnobəy',
        'inLanguage' => 'az-AZ',
        'publisher' => ['@id' => $siteUrl . '/#store'],
    ];

    $priceValidUntil = now()->addYear()->toDateString();
    $productItems = [];
    foreach (($products['list'] ?? []) as $p) {
        // Qalereyadakı bütün şəkilləri mütləq (absolute) URL kimi veririk
        $gallery = array_values(array_filter(array_merge(
            [$p['image'] ?? null],
            is_array($p['images'] ?? null) ? $p['images'] : []
        )));
        $gallery = array_map(fn ($src) => \Illuminate\Support\Str::startsWith($src, ['http://', 'https://']) ? $src : url($src), $gallery);

        $productItems[] = array_filter([
            '@type'         => 'Product',
            'name'          => $p['name'] ?? '',
            'description'   => $p['desc'] ?? '',
            'sku'           => !empty($p['id']) ? 'TB-' . $p['id'] : null,
            'category'      => $p['cat'] ?? null,
            'image'         => $gallery ?: [$ogImage],
            'itemCondition' => 'https://schema.org/NewCondition',
            'offers'      => [
                '@type'         => 'Offer',
                'price'         => preg_replace('/[^0-9.]/', '', (string)($p['price'] ?? '')),
                'priceCurrency' => 'AZN',
                'priceValidUntil' => $priceValidUntil,
                'availability'  => (int)($p['stock'] ?? 0) > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'url'           => $siteUrl . '/#products',
                'seller'        => ['@id' => $siteUrl . '/#store'],
            ],
        ], fn ($v) => $v !== null && $v !== '');
    }
    $itemList = [
        '@context'         => 'https://schema.org',
        '@type'            => 'ItemList',
        'itemListElement'  => array_map(function ($i, $prod) {
            return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => $prod];
        }, array_keys($productItems), $productItems),
    ];
@endphp
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDesc }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="Texnobəy">
<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="theme-color" content="#0057ff">
<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Texnobəy">
<meta property="og:locale" content="az_AZ">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:secure_url" content="{{ $ogImage }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Texnobəy – Bakıda №1 Texnologiya Mağazası">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:image:alt" content="Texnobəy – Bakıda №1 Texnologiya Mağazası">

<!-- Yerli axtarış (local SEO) -->
<meta name="geo.region" content="AZ-BA">
<meta name="geo.placename" content="Bakı">
<meta name="format-detection" content="telephone=yes">

<!-- Favicons — Google axtarış nəticəsi üçün ən azı 48x48 ICO/PNG lazımdır,
     apple-touch-icon isə mütləq PNG olmalıdır (iOS SVG qəbul etmir) -->
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

<script>(function(){try{if(!localStorage.getItem('tb_theme_v2')){localStorage.removeItem('tb_theme');localStorage.setItem('tb_theme_v2','1');}var t=localStorage.getItem('tb_theme')||'light';document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">

<!-- Structured data (Schema.org / JSON-LD) -->
<script type="application/ld+json">{!! json_encode($organization, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($website, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@if (!empty($productItems))
<script type="application/ld+json">{!! json_encode($itemList, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
  <a href="#" class="logo" onclick="event.preventDefault(); history.replaceState(null, '', window.location.pathname); window.scrollTo({ top: 0, behavior: 'smooth' });">
    <div class="logo-icon"><img src="{{ asset('logo.svg') }}" alt="Texnobəy" loading="lazy"></div>
    Texno<span>bəy</span>
  </a>
  <div class="nav-right">
    <ul class="nav-links">
      <li><a href="#services">{{ __('site.nav.services') }}</a></li>
      <li><a href="#products">{{ __('site.nav.products') }}</a></li>
      <li><a href="#about">{{ __('site.nav.about') }}</a></li>
      <li><a href="#contact">{{ __('site.nav.contact') }}</a></li>
      <li><a href="{{ route('order.status') }}">{{ __('site.nav.track') }}</a></li>
      <li><a href="#order" class="nav-cta">{{ __('site.nav.order') }}</a></li>
    </ul>
    <button type="button" class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="{{ __('site.nav.theme') }}" aria-label="{{ __('site.nav.theme') }}"><span id="themeBtnIco">🌙</span></button>
    <button type="button" class="hamburger" id="hamburger" aria-label="{{ __('site.nav.menu') }}" aria-controls="mobileMenu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <button type="button" class="mobile-close" id="mobileClose" aria-label="{{ __('site.nav.menu') }}">✕</button>
  <a href="#services" onclick="closeMobile()">{{ __('site.nav.services') }}</a>
  <a href="#products" onclick="closeMobile()">{{ __('site.nav.products') }}</a>
  <a href="#about" onclick="closeMobile()">{{ __('site.nav.about') }}</a>
  <a href="#contact" onclick="closeMobile()">{{ __('site.nav.contact') }}</a>
  <a href="{{ route('order.status') }}" onclick="closeMobile()">{{ __('site.nav.track') }}</a>
  {{-- Tema düyməsi yalnız navbar-da qalır — burada təkrarlanmır --}}
  <a href="#order" onclick="closeMobile()" class="btn-primary">{{ __('site.nav.order') }}</a>
</div>

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero-grid">
    <div>
      <div class="hero-badge">{{ $hero['badge'] ?? '' }}</div>
      <h1>{!! $hero['title'] ?? '' !!}</h1>
      <p>{{ $hero['sub'] ?? '' }}</p>
      <div class="hero-actions">
        <a href="{{ $hero['btn1Link'] ?? '#' }}" class="btn-primary">{{ $hero['btn1Text'] ?? '' }}</a>
        <a href="{{ $hero['btn2Link'] ?? '#' }}" class="btn-secondary">{{ $hero['btn2Text'] ?? '' }}</a>
      </div>
      <div class="hero-stats reveal-stagger">
        @foreach (($hero['stats'] ?? []) as $stat)
        @php
          $numRaw = $stat['num'] ?? '';
          preg_match('/([0-9.]+)/u', $numRaw, $m1);
          $numDigits = $m1[1] ?? '';
          preg_match('/([^0-9A-Za-z]+)$/u', $numRaw, $m2);
          $numSuffix = $m2[1] ?? '';
        @endphp
        <div class="stat-item">
          <div class="stat-num"><span data-counter data-target="{{ $numDigits }}">0</span><span>{{ $numSuffix }}</span></div>
          <div class="stat-label">{{ $stat['label'] ?? '' }}</div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="hero-visual reveal-stagger">
      @foreach (($hero['devices'] ?? []) as $idx => $dev)
      <div class="device-card{{ $idx === 0 ? ' featured' : '' }}">
        @if (!empty($dev['image']))
          <div class="device-img"><img src="{{ $dev['image'] }}" alt="{{ $dev['title'] ?? '' }}" loading="lazy"></div>
        @else
          <div class="device-icon">{{ $dev['emoji'] ?? '' }}</div>
        @endif
        @if ($idx === 0)
        <div>
          <div class="device-tag">{{ __('site.hero.bestseller') }}</div>
          <h3>{{ $dev['title'] ?? '' }}</h3>
          <p>{{ $dev['desc'] ?? '' }}</p>
        </div>
        @else
        <h3>{{ $dev['title'] ?? '' }}</h3>
        <p>{{ $dev['desc'] ?? '' }}</p>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- TRUST BADGES -->
@if (!empty($trust['enabled']) && !empty($trust['cards']))
<section class="trust-strip" id="trust">
  <div class="container">
    <div class="trust-grid reveal-stagger">
      @foreach ($trust['cards'] as $card)
      <div class="trust-card">
        <div class="trust-icon">{{ $card['icon'] ?? '✅' }}</div>
        <div class="trust-body">
          <h4>{{ $card['title'] ?? '' }}</h4>
          <p>{{ $card['desc'] ?? '' }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- SERVICES -->
<section class="section services" id="services">
  <div class="container">
    <div class="section-header reveal-up">
      <div class="eyebrow">{{ $services['eyebrow'] ?? '' }}</div>
      <h2 class="section-title">{!! $services['title'] ?? '' !!}</h2>
      <p class="section-sub">{{ $services['sub'] ?? '' }}</p>
    </div>
    <div class="services-grid reveal-stagger">
      @foreach (($services['cards'] ?? []) as $card)
      <div class="service-card">
        @if (!empty($card['image']))
          <div class="service-img"><img src="{{ $card['image'] }}" alt="{{ $card['title'] ?? '' }}" loading="lazy"></div>
        @else
          <div class="service-ico">{{ $card['icon'] ?? '' }}</div>
        @endif
        <h3>{{ $card['title'] ?? '' }}</h3>
        <p>{{ $card['desc'] ?? '' }}</p>
        <a href="{{ $card['link'] ?? '#' }}" class="service-link">{{ $card['linkText'] ?? '' }}</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- PRODUCTS -->
<section class="section products" id="products">
  <div class="container">
    <div class="section-header reveal-up">
      <div class="eyebrow">{{ $products['eyebrow'] ?? '' ?: __('site.nav.products') }}</div>
      <h2 class="section-title">{!! $products['title'] ?? '' !!}</h2>
      <p class="section-sub">{{ $products['sub'] ?? '' }}</p>
    </div>
    <div class="product-toolbar" id="productToolbar">
      <input type="text" class="search-input" id="productSearch" placeholder="{{ __('site.filter.search') }}" oninput="filterProducts()">
      <div class="filter-bar" id="filterBar">
        <button class="filter-btn active" data-cat="all" onclick="setCatFilter('all', this)">{{ __('site.filter.all') }}</button>
        @foreach ($categories as $c)
          <button class="filter-btn" data-cat="{{ $c->slug }}" onclick="setCatFilter('{{ $c->slug }}', this)">{{ $c->icon }} {{ $c->name }}</button>
        @endforeach
      </div>
    </div>
    @php
      $catNames = [];
      foreach ($categories as $c) $catNames[$c->slug] = $c->name;
      $unitMap = [
        'ədəd' => __('site.unit.piece'),
        'dəst' => __('site.unit.set'),
        'ay'   => __('site.unit.month'),
      ];
    @endphp
    <div class="products-empty" id="productsEmpty" style="display:none">🔍 {{ __('site.filter.no_results') }}</div>
    <div class="products-grid reveal-stagger" id="productsGrid">
      @foreach (($products['list'] ?? []) as $p)
      @php
        $gallery = array_values(array_filter($p['images'] ?? []));
        if (!empty($p['image']) && !in_array($p['image'], $gallery, true)) array_unshift($gallery, $p['image']);
        $stock = (int)($p['stock'] ?? 0);
        $pName = $p['name'] ?? '';
        $pDesc = $p['desc'] ?? '';
        $searchBlob = mb_strtolower(
          ($p['name'] ?? '') . ' ' . ($p['desc'] ?? '') . ' ' .
          ($catNames[$p['cat'] ?? ''] ?? '')
        );
      @endphp
      <div class="product-card" data-cat="{{ $p['cat'] ?? '' }}" data-search="{{ $searchBlob }}" data-product-id="{{ $p['id'] ?? 0 }}"
           data-name="{{ $pName }}" data-price="{{ $p['price'] ?? '' }}" data-unit="{{ $p['unit'] ?? 'ədəd' }}">
        <div class="product-img-wrap">
          @if (!empty($gallery))
            <div class="product-gallery">
              @foreach ($gallery as $i => $imgUrl)
                <img src="{{ $imgUrl }}" alt="{{ $p['name'] ?? '' }}" loading="lazy" class="product-gallery-img{{ $i === 0 ? ' active' : '' }}" data-idx="{{ $i }}">
              @endforeach
            </div>
            @if (count($gallery) > 1)
            <div class="product-gallery-dots">
              @foreach ($gallery as $i => $imgUrl)
                <button type="button" class="gallery-dot{{ $i === 0 ? ' active' : '' }}" onclick="galleryTo(this, {{ $i }})" aria-label="Şəkil {{ $i + 1 }}"></button>
              @endforeach
            </div>
            @endif
          @else
            <div class="product-img">{{ $p['emoji'] ?? '📦' }}</div>
          @endif
          @if ($stock <= 0)
            <div class="stock-badge stock-out">{{ __('site.stock.out') }}</div>
          @elseif ($stock <= 3)
            <div class="stock-badge stock-low">{{ __('site.stock.low', ['n' => $stock]) }}</div>
          @else
            <div class="stock-badge stock-in">{{ __('site.stock.in_stock') }}</div>
          @endif
        </div>
        <div class="product-body">
          <div class="product-meta-row">
            <div class="product-cat">{{ $catNames[$p['cat'] ?? ''] ?? ucfirst($p['cat'] ?? '') }}</div>
            @if (($p['views'] ?? 0) >= 20)
              <div class="product-views" title="{{ __('site.views.title') }}">👁️ {{ number_format($p['views'], 0, '.', ' ') }}</div>
            @endif
          </div>
          <h3>{{ $pName }}</h3>
          <p>{{ $pDesc }}</p>
          <div class="product-footer">
            <div class="price">{{ $p['price'] ?? '' }} ₼ <span>/ {{ $unitMap[$p['unit'] ?? 'ədəd'] ?? ($p['unit'] ?? '') }}</span></div>
            <div class="product-actions">
              <button type="button" class="btn-details" onclick="openProductDetail(this)">{{ __('site.nav.details') }}</button>
              @if ($stock <= 0)
                <button class="btn-order btn-order-disabled" disabled>{{ __('site.stock.out') }}</button>
              @else
                <a href="#order" class="btn-order"
                   onclick="selectProduct(this, '{{ addslashes($pName) }}', '{{ $p['cat'] ?? '' }}', '{{ $p['price'] ?? '' }}', '{{ $p['unit'] ?? 'ədəd' }}')">{{ __('site.nav.order') }}</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Məhsul detalları modal -->
  <div class="pd-modal" id="productDetailModal" onclick="closeProductDetail(event)">
    <div class="pd-dialog" role="dialog" aria-modal="true">
      <button type="button" class="pd-close" onclick="closeProductDetail()" aria-label="{{ __('site.nav.close') }}">✕</button>
      <div class="pd-media" id="pdMedia"></div>
      <div class="pd-info">
        <div class="pd-cat" id="pdCat"></div>
        <h3 class="pd-name" id="pdName"></h3>
        <div class="pd-price" id="pdPrice"></div>
        <div class="pd-desc" id="pdDesc"></div>
        <div class="pd-actions" id="pdActions"></div>
      </div>
    </div>
  </div>
</section>

<!-- WHY US -->
<section class="section why-us">
  <div class="container">
    <div class="why-grid">
      <div class="why-text">
        <div class="eyebrow">{{ $why['eyebrow'] ?? '' }}</div>
        <h2>{!! $why['title'] ?? '' !!}</h2>
        <p>{{ $why['sub'] ?? '' }}</p>
        <div class="why-features reveal-stagger">
          @foreach (($why['features'] ?? []) as $feat)
          <div class="why-feature">
            <div class="feature-icon">{{ $feat['icon'] ?? '' }}</div>
            <div class="feature-txt">
              <h4>{{ $feat['title'] ?? '' }}</h4>
              <p>{{ $feat['desc'] ?? '' }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="why-visual reveal-stagger">
        @foreach (($why['metrics'] ?? []) as $idx => $met)
        @php
          preg_match('/([0-9.]+)/u', $met['num'] ?? '', $mm);
          $metDigits = $mm[1] ?? '';
        @endphp
        <div class="metric-card{{ ($idx === count($why['metrics'] ?? []) - 1 && count($why['metrics'] ?? []) % 2 === 1) ? ' wide' : '' }}">
          <div class="big"><span data-counter data-target="{{ $metDigits }}">0</span><span>{{ $met['suffix'] ?? '' }}</span></div>
          <small>{{ $met['label'] ?? '' }}</small>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- ORDER FORM -->
<section class="section order-section" id="order">
  <div class="container">
    <div class="section-header reveal-up">
      <div class="eyebrow">{{ __('site.order.eyebrow') }}</div>
      <h2 class="section-title">{{ __('site.order.title') }}</h2>
      <p class="section-sub">{{ __('site.order.sub') }}</p>
    </div>
    <div class="order-wrap">
      <form class="form-grid" id="orderForm" action="{{ url('/order') }}" method="POST" onsubmit="event.preventDefault(); handleSubmit();" data-product-label="{{ __('site.order.product_prefix') }}">
        @csrf
        <div class="form-group">
          <label>{{ __('site.order.name') }}</label>
          <input type="text" name="name" placeholder="{{ __('site.order.name_ph') }}" required>
        </div>
        <div class="form-group">
          <label>{{ __('site.order.phone') }}</label>
          <input type="tel" name="phone" placeholder="{{ __('site.order.phone_ph') }}" required>
        </div>
        <div class="form-group">
          <label>{{ __('site.order.email') }}</label>
          <input type="email" name="email" placeholder="{{ __('site.order.email_ph') }}">
        </div>
        <div class="form-group">
          <label>{{ __('site.order.service') }}</label>
          <select name="service" required>
            <option value="">{{ __('site.order.select') }}</option>
            <option value="Kompüter alışı">{{ __('site.order.service.computer_buy') }}</option>
            <option value="Printer alışı">{{ __('site.order.service.printer_buy') }}</option>
            <option value="Proyektor alışı">{{ __('site.order.service.projector_buy') }}</option>
            <option value="Kompüter təmiri">{{ __('site.order.service.computer_fix') }}</option>
            <option value="Printer servis / kartrij">{{ __('site.order.service.printer_svc') }}</option>
            <option value="Texniki konsultasiya">{{ __('site.order.service.consult') }}</option>
            <option value="Korporativ təchizat">{{ __('site.order.service.corporate') }}</option>
            <option value="Digər">{{ __('site.order.service.other') }}</option>
          </select>
        </div>
        <div class="form-group full">
          <label>{{ __('site.order.notes') }}</label>
          <textarea name="notes" placeholder="{{ __('site.order.notes_ph') }}"></textarea>
        </div>
        <div class="form-group full">
          <button type="submit" class="submit-btn" data-label-idle="{{ __('site.order.submit') }}" data-label-sending="{{ __('site.order.sending') }}" data-label-ok="{{ __('site.order.success') }}" data-label-err="{{ __('site.order.error') }}">{{ __('site.order.submit') }}</button>
          <p class="form-note">{{ __('site.order.privacy') }}</p>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="section about" id="about">
  <div class="container">
    <div class="about-grid reveal-up">
      <div class="about-text">
        <div class="about-badges">
          <span class="badge">{{ $about['badge1'] ?? '' }}</span>
          <span class="badge">{{ $about['badge2'] ?? '' }}</span>
          <span class="badge">{{ $about['badge3'] ?? '' }}</span>
        </div>
        <h2>{{ $about['title'] ?? '' }}</h2>
        <p>{{ $about['text'] ?? '' }}</p>

        <a href="{{ $about['btnLink'] ?? '#' }}" class="btn-primary" style="display:inline-flex">{{ $about['btnText'] ?? '' }}</a>
      </div>
      <div class="about-img-wrap">
        <div class="about-icon">{{ $about['icon'] ?? '🏪' }}</div>
        <h3>{{ $about['centerName'] ?? '' }}</h3>
        <p>{{ $about['centerAddr'] ?? '' }}</p>
        <br>
        @php
          preg_match('/([0-9.]+)/u', $about['met1Num'] ?? '', $am1);
          preg_match('/([0-9.]+)/u', $about['met2Num'] ?? '', $am2);
          $am1d = $am1[1] ?? ''; $am2d = $am2[1] ?? '';
          $am1s = trim(str_replace($am1d, '', $about['met1Num'] ?? ''));
          $am2s = trim(str_replace($am2d, '', $about['met2Num'] ?? ''));
        @endphp
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;width:100%">
          <div class="metric-card"><div class="big"><span data-counter data-target="{{ $am1d }}">0</span>{{ $am1s }}</div><small>{{ $about['met1Lbl'] ?? '' }}</small></div>
          <div class="metric-card"><div class="big"><span data-counter data-target="{{ $am2d }}">0</span>{{ $am2s }}</div><small>{{ $about['met2Lbl'] ?? '' }}</small></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
@if (($testimonials ?? collect())->isNotEmpty())
<section class="section testimonials" id="testimonials">
  <div class="container">
    <div class="section-header reveal-up">
      <div class="eyebrow">{{ __('site.testimonials.eyebrow') }}</div>
      <h2 class="section-title">{{ __('site.testimonials.title') }}</h2>
      <p class="section-sub">{{ __('site.testimonials.sub') }}</p>
    </div>
    <div class="testimonials-grid reveal-stagger">
      @foreach ($testimonials as $t)
      @php
        $tText = $t->text;
        $tPos  = $t->position;
      @endphp
      <div class="testimonial-card">
        <div class="testimonial-stars">
          @for ($i = 0; $i < 5; $i++)
            <span class="star{{ $i < $t->rating ? ' filled' : '' }}">★</span>
          @endfor
        </div>
        <p class="testimonial-text">"{{ $tText }}"</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">
            @if ($t->avatar)
              <img src="{{ $t->avatar }}" alt="{{ $t->name }}" loading="lazy">
            @else
              <span>{{ mb_substr($t->name, 0, 1) }}</span>
            @endif
          </div>
          <div>
            <div class="testimonial-name">{{ $t->name }}</div>
            @if ($tPos)<div class="testimonial-pos">{{ $tPos }}</div>@endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- CONTACT -->
@php
  $phoneRaw = preg_replace('/[^0-9+]/', '', $contact['phone'] ?? '');
  $waRaw = preg_replace('/[^0-9]/', '', $contact['whatsapp'] ?? '');
  $waMsg = rawurlencode(__('site.contact.wa_msg'));
@endphp
<section class="section contact" id="contact">
  <div class="container">
    <div class="section-header reveal-up">
      <div class="eyebrow">{{ $contact['eyebrow'] ?? '' }}</div>
      <h2 class="section-title">{{ $contact['title'] ?? '' }}</h2>
      <p class="section-sub">{{ $contact['sub'] ?? '' }}</p>
    </div>
    <div class="contact-grid reveal-up">
      <div class="contact-info">
        <div class="contact-card">
          <div class="contact-ico">📍</div>
          <div>
            <h4>{{ __('site.contact.address') }}</h4>
            <p>{{ $contact['addr'] ?? '' }}<br><small style="color:var(--muted)">{{ $contact['addrNote'] ?? '' }}</small></p>
          </div>
        </div>
        <div class="contact-card">
          <div class="contact-ico">📞</div>
          <div>
            <h4>{{ __('site.contact.phone') }}</h4>
            <a href="tel:{{ $phoneRaw }}">{{ $contact['phone'] ?? '' }}</a>
          </div>
        </div>
        <div class="contact-card">
          <div class="contact-ico">🕐</div>
          <div>
            <h4>{{ __('site.contact.hours') }}</h4>
            <p>{!! nl2br(e($contact['hours'] ?? '')) !!}</p>
          </div>
        </div>
        <div class="contact-card">
          <div class="contact-ico">✉️</div>
          <div>
            <h4>{{ __('site.contact.email') }}</h4>
            <a href="mailto:{{ $contact['email'] ?? '' }}">{{ $contact['email'] ?? '' }}</a>
          </div>
        </div>
        <div class="contact-actions">
          <a href="https://wa.me/{{ $waRaw }}?text={{ $waMsg }}" class="whatsapp-btn" target="_blank">
            {{ __('site.contact.whatsapp') }}
          </a>
          <a href="tel:{{ $phoneRaw }}" class="call-btn">
            {{ __('site.contact.call') }}
          </a>
        </div>
      </div>
      <div class="map-placeholder">
        <iframe
          src="{{ $contact['mapSrc'] ?? '' }}"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="{{ __('site.contact.map_title') }}">
        </iframe>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="#" class="logo" onclick="event.preventDefault(); history.replaceState(null, '', window.location.pathname); window.scrollTo({ top: 0, behavior: 'smooth' });">
          <div class="logo-icon"><img src="{{ asset('logo.svg') }}" alt="Texnobəy" loading="lazy"></div>
          Texno<span>bəy</span>
        </a>
        <p>{{ __('site.footer.about') }}</p>
      </div>
      <div class="footer-col">
        <h4>{{ __('site.footer.services') }}</h4>
        <ul>
          <li><a href="#services">{{ __('site.footer.svc.computer') }}</a></li>
          <li><a href="#services">{{ __('site.footer.svc.printer') }}</a></li>
          <li><a href="#services">{{ __('site.footer.svc.projector') }}</a></li>
          <li><a href="#services">{{ __('site.footer.svc.consult') }}</a></li>
          <li><a href="#services">{{ __('site.footer.svc.corp') }}</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>{{ __('site.footer.products') }}</h4>
        <ul>
          <li><a href="#products">{{ __('site.footer.prod.desktop') }}</a></li>
          <li><a href="#products">{{ __('site.footer.prod.laptop') }}</a></li>
          <li><a href="#products">{{ __('site.footer.prod.printer') }}</a></li>
          <li><a href="#products">{{ __('site.footer.prod.proj') }}</a></li>
          <li><a href="#products">{{ __('site.footer.prod.acc') }}</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>{{ __('site.footer.company') }}</h4>
        <ul>
          <li><a href="#about">{{ __('site.footer.about_link') }}</a></li>
          <li><a href="#contact">{{ __('site.footer.contact_link') }}</a></li>
          <li><a href="#order">{{ __('site.footer.order_link') }}</a></li>
          <li><a href="https://wa.me/994557895745" target="_blank">WhatsApp</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} <span>Texnobəy.az</span> – {{ __('site.footer.rights') }}</p>
      <p>{{ __('site.footer.seo') }}</p>
    </div>
  </div>
</footer>

<!-- FLOATING CTA (bottom-left social panel) -->
<div class="floating-cta" aria-label="Əlaqə">
  <a href="https://www.instagram.com/texnobey.az/" target="_blank" rel="noopener" class="float-btn float-ig" title="Instagram" aria-label="Instagram">
    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.247 2.242 1.309 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.975.975-2.242 1.247-3.608 1.309-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.975-1.247-2.242-1.309-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608C4.517 2.567 5.784 2.295 7.15 2.233 8.416 2.175 8.796 2.163 12 2.163zm0 1.802c-3.155 0-3.507.012-4.744.068-1.006.046-1.556.216-1.92.36-.483.19-.827.418-1.19.78-.362.363-.59.707-.78 1.19-.144.364-.314.914-.36 1.92-.056 1.237-.068 1.589-.068 4.744s.012 3.507.068 4.744c.046 1.006.216 1.556.36 1.92.19.483.418.827.78 1.19.363.362.707.59 1.19.78.364.144.914.314 1.92.36 1.237.056 1.589.068 4.744.068s3.507-.012 4.744-.068c1.006-.046 1.556-.216 1.92-.36.483-.19.827-.418 1.19-.78.362-.363.59-.707.78-1.19.144-.364.314-.914.36-1.92.056-1.237.068-1.589.068-4.744s-.012-3.507-.068-4.744c-.046-1.006-.216-1.556-.36-1.92-.19-.483-.418-.827-.78-1.19-.363-.362-.707-.59-1.19-.78-.364-.144-.914-.314-1.92-.36-1.237-.056-1.589-.068-4.744-.068zM12 6.865a5.135 5.135 0 1 0 0 10.27 5.135 5.135 0 0 0 0-10.27zm0 8.468a3.333 3.333 0 1 1 0-6.666 3.333 3.333 0 0 1 0 6.666zm5.338-9.87a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4z"/></svg>
  </a>
  <a href="https://www.facebook.com/p/Texnobəyaz-61568468586277/" target="_blank" rel="noopener" class="float-btn float-fb" title="Facebook" aria-label="Facebook">
    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.35C0 23.407.593 24 1.325 24h11.495v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.894-4.788 4.66-4.788 1.325 0 2.464.099 2.796.143v3.24h-1.918c-1.504 0-1.796.716-1.796 1.765v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.407 24 24 23.407 24 22.675V1.325C24 .593 23.407 0 22.675 0z"/></svg>
  </a>
  <a href="https://wa.me/{{ $waRaw }}?text={{ $waMsg }}" target="_blank" rel="noopener" class="float-btn float-wa" title="WhatsApp" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M20.52 3.48A11.94 11.94 0 0 0 12.02 0C5.4 0 .04 5.36.04 11.98a11.9 11.9 0 0 0 1.6 5.99L0 24l6.19-1.62a11.98 11.98 0 0 0 5.83 1.49h.01c6.62 0 11.98-5.36 11.98-11.98 0-3.2-1.25-6.2-3.49-8.41zM12.03 21.9h-.01a9.94 9.94 0 0 1-5.06-1.39l-.36-.22-3.68.96.98-3.58-.23-.37a9.93 9.93 0 0 1-1.52-5.32c0-5.5 4.47-9.98 9.98-9.98 2.67 0 5.17 1.04 7.05 2.93a9.93 9.93 0 0 1 2.93 7.06c0 5.5-4.48 9.98-9.98 9.98zm5.47-7.47c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.27-.47-2.42-1.5-.9-.8-1.5-1.79-1.67-2.09-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.1 3.21 5.09 4.5.71.31 1.27.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35z"/></svg>
  </a>
  <a href="tel:{{ $phoneRaw }}" class="float-btn float-call" title="Zəng et" aria-label="Zəng et">
    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.05-.24 11.36 11.36 0 0 0 3.57.57 1 1 0 0 1 1 1v3.5a1 1 0 0 1-1 1A17 17 0 0 1 3 5a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.36 11.36 0 0 0 .57 3.57 1 1 0 0 1-.24 1.05l-2.21 2.17z"/></svg>
  </a>
</div>

<button type="button" class="scroll-top" id="scrollTopBtn" onclick="scrollToTop()" aria-label="Yuxarı">↑</button>
<script src="{{ asset('js/main.js') }}?v={{ filemtime(public_path('js/main.js')) }}"></script>
</body>
</html>
