@php
    $siteUrl  = rtrim(url('/'), '/');
    $canonical = route('product.show', $product->slug);
    $catName  = $category?->name ?: ucfirst((string) $product->cat);

    $gallery = array_values(array_filter(array_merge(
        [$product->image],
        is_array($product->images) ? $product->images : []
    )));
    $absGallery = array_map(
        fn ($src) => \Illuminate\Support\Str::startsWith($src, ['http://', 'https://']) ? $src : url($src),
        $gallery
    );
    $shareImage = $absGallery[0] ?? asset('og-image.png');

    $stock    = (int) $product->stock;
    $unitMap  = ['ədəd' => __('site.unit.piece'), 'dəst' => __('site.unit.set'), 'ay' => __('site.unit.month')];
    $unit     = $unitMap[$product->unit] ?? ($product->unit ?: __('site.unit.piece'));
    $priceNum = preg_replace('/[^0-9.]/', '', (string) $product->price);

    $metaTitle = $product->name . ' – ' . $catName . ' | Texnobəy';
    $metaDesc  = \Illuminate\Support\Str::limit(
        trim((string) $product->desc) ?: ($product->name . ' – Bakıda Texnobəy-də ' . $priceNum . ' ₼ qiymətinə.'),
        158
    );

    $productSchema = array_filter([
        '@context'      => 'https://schema.org',
        '@type'         => 'Product',
        '@id'           => $canonical . '#product',
        'name'          => $product->name,
        'description'   => trim((string) $product->desc) ?: $product->name,
        'sku'           => 'TB-' . $product->id,
        'category'      => $catName,
        'image'         => $absGallery ?: [asset('og-image.png')],
        'url'           => $canonical,
        'itemCondition' => 'https://schema.org/NewCondition',
        'offers'        => [
            '@type'           => 'Offer',
            'url'             => $canonical,
            'price'           => $priceNum,
            'priceCurrency'   => 'AZN',
            'priceValidUntil' => now()->addYear()->toDateString(),
            'availability'    => $stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'seller'          => ['@id' => $siteUrl . '/#store'],
        ],
    ], fn ($v) => $v !== null && $v !== '');

    $breadcrumb = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana səhifə', 'item' => $siteUrl],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('site.nav.products'), 'item' => $siteUrl . '/#products'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => $canonical],
        ],
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
<meta name="author" content="Texnobəy">
<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="theme-color" content="#0057ff">
<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph -->
<meta property="og:type" content="product">
<meta property="og:site_name" content="Texnobəy">
<meta property="og:locale" content="az_AZ">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:image" content="{{ $shareImage }}">
<meta property="og:image:alt" content="{{ $product->name }}">
<meta property="product:price:amount" content="{{ $priceNum }}">
<meta property="product:price:currency" content="AZN">
<meta property="product:availability" content="{{ $stock > 0 ? 'in stock' : 'out of stock' }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">
<meta name="twitter:image" content="{{ $shareImage }}">
<meta name="twitter:image:alt" content="{{ $product->name }}">

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

<script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
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
      <li><a href="{{ url('/') }}#contact">{{ __('site.nav.contact') }}</a></li>
      <li><a href="{{ route('order.status') }}">{{ __('site.nav.track') }}</a></li>
    </ul>
    <button type="button" class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="{{ __('site.nav.theme') }}" aria-label="{{ __('site.nav.theme') }}"><span id="themeBtnIco">🌙</span></button>
  </div>
</nav>

<main class="pdp">
  <nav class="pdp-crumbs" aria-label="Breadcrumb">
    <a href="{{ url('/') }}">Ana səhifə</a>
    <span>/</span>
    <a href="{{ url('/') }}#products">{{ __('site.nav.products') }}</a>
    <span>/</span>
    <span aria-current="page">{{ $product->name }}</span>
  </nav>

  <div class="pdp-grid">
    <div class="pdp-media">
      @if (!empty($gallery))
        <img src="{{ $gallery[0] }}" alt="{{ $product->name }}" id="pdpMainImg" class="pdp-main-img" width="800" height="600">
        @if (count($gallery) > 1)
          <div class="pdp-thumbs">
            @foreach ($gallery as $i => $img)
              <button type="button" class="pdp-thumb{{ $i === 0 ? ' active' : '' }}" onclick="pdpShow(this, '{{ $img }}')" aria-label="Şəkil {{ $i + 1 }}">
                <img src="{{ $img }}" alt="{{ $product->name }} – şəkil {{ $i + 1 }}" loading="lazy">
              </button>
            @endforeach
          </div>
        @endif
      @else
        <div class="pdp-emoji">{{ $product->emoji ?: '📦' }}</div>
      @endif
    </div>

    <div class="pdp-info">
      <div class="pdp-cat">{{ $catName }}</div>
      <h1>{{ $product->name }}</h1>

      @if ($stock <= 0)
        <div class="stock-badge stock-out pdp-stock">{{ __('site.stock.out') }}</div>
      @elseif ($stock <= 3)
        <div class="stock-badge stock-low pdp-stock">{{ __('site.stock.low', ['n' => $stock]) }}</div>
      @else
        <div class="stock-badge stock-in pdp-stock">{{ __('site.stock.in_stock') }}</div>
      @endif

      <div class="pdp-price">{{ $product->price }} ₼ <span>/ {{ $unit }}</span></div>

      @if (trim((string) $product->desc) !== '')
        <p class="pdp-desc">{{ $product->desc }}</p>
      @endif

      <div class="pdp-actions">
        @if ($stock > 0)
          {{-- ?product= ilə ana səhifədəki sifariş forması bu məhsulla dolur --}}
          <a href="{{ url('/') }}?product={{ $product->slug }}#order" class="btn-primary">{{ __('site.nav.order') }}</a>
        @else
          <span class="btn-order btn-order-disabled">{{ __('site.stock.out') }}</span>
        @endif
        @if (!empty($contact['phone']))
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact['phone']) }}" class="btn-secondary">📞 {{ $contact['phone'] }}</a>
        @endif
      </div>
    </div>
  </div>

  @if ($related->isNotEmpty())
  <section class="pdp-related">
    <h2>Oxşar məhsullar</h2>
    <div class="pdp-related-grid">
      @foreach ($related as $r)
        <a href="{{ route('product.show', $r->slug) }}" class="pdp-related-card">
          @if ($r->image)
            <img src="{{ $r->image }}" alt="{{ $r->name }}" loading="lazy">
          @else
            <div class="pdp-related-emoji">{{ $r->emoji ?: '📦' }}</div>
          @endif
          <div class="pdp-related-body">
            <h3>{{ $r->name }}</h3>
            <div class="price">{{ $r->price }} ₼</div>
          </div>
        </a>
      @endforeach
    </div>
  </section>
  @endif
</main>

<script>
function pdpShow(btn, src) {
  const img = document.getElementById('pdpMainImg');
  if (img) img.src = src;
  document.querySelectorAll('.pdp-thumb').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>
<script src="{{ asset('js/main.js') }}?v={{ filemtime(public_path('js/main.js')) }}"></script>
</body>
</html>
