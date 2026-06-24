<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="TechnoBey – Bakıda kompüter satışı, printer və proyektor satışı, təmir və texniki servis xidmətləri. Keyfiyyətli texnologiya məhsulları və peşəkar dəstək.">
<meta name="keywords" content="kompüter satışı Bakı, printer təmiri Bakı, proyektor satışı, laptop satışı, texniki servis Bakı, kompüter təmiri">
<title>TechnoBey – Kompüter, Printer & Proyektor | Bakı</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
  <a href="#" class="logo" onclick="event.preventDefault(); history.replaceState(null, '', window.location.pathname); window.scrollTo({ top: 0, behavior: 'smooth' });">
    <div class="logo-icon">💻</div>
    Techno<span>Bey</span>
  </a>
  <ul class="nav-links">
    <li><a href="#services">Xidmətlər</a></li>
    <li><a href="#products">Məhsullar</a></li>
    <li><a href="#about">Haqqımızda</a></li>
    <li><a href="#contact">Əlaqə</a></li>
    <li><a href="#order" class="nav-cta">Sifariş et →</a></li>
  </ul>
  <button class="hamburger" id="hamburger" aria-label="Menyu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <button class="mobile-close" id="mobileClose">✕</button>
  <a href="#services" onclick="closeMobile()">Xidmətlər</a>
  <a href="#products" onclick="closeMobile()">Məhsullar</a>
  <a href="#about" onclick="closeMobile()">Haqqımızda</a>
  <a href="#contact" onclick="closeMobile()">Əlaqə</a>
  <a href="#order" onclick="closeMobile()" class="btn-primary">Sifariş et →</a>
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
      <div class="hero-stats">
        @foreach (($hero['stats'] ?? []) as $stat)
        <div class="stat-item">
          <div class="stat-num">{{ preg_replace('/[^0-9A-Za-z]+$/u', '', $stat['num'] ?? '') }}<span>{{ preg_match('/([^0-9A-Za-z]+)$/u', $stat['num'] ?? '', $m) ? $m[1] : '' }}</span></div>
          <div class="stat-label">{{ $stat['label'] ?? '' }}</div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="hero-visual">
      @foreach (($hero['devices'] ?? []) as $idx => $dev)
      <div class="device-card{{ $idx === 0 ? ' featured' : '' }}">
        <div class="device-icon">{{ $dev['emoji'] ?? '' }}</div>
        @if ($idx === 0)
        <div>
          <div class="device-tag">Ən çox satılan</div>
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

<!-- SERVICES -->
<section class="section services" id="services">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">{{ $services['eyebrow'] ?? '' }}</div>
      <h2 class="section-title">{!! $services['title'] ?? '' !!}</h2>
      <p class="section-sub">{{ $services['sub'] ?? '' }}</p>
    </div>
    <div class="services-grid">
      @foreach (($services['cards'] ?? []) as $card)
      <div class="service-card">
        <div class="service-ico">{{ $card['icon'] ?? '' }}</div>
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
    <div class="section-header">
      <div class="eyebrow">{{ $products['eyebrow'] ?? 'Məhsullar' }}</div>
      <h2 class="section-title">{!! $products['title'] ?? '' !!}</h2>
      <p class="section-sub">{{ $products['sub'] ?? '' }}</p>
    </div>
    <div class="filter-bar">
      <button class="filter-btn active" onclick="filterProducts('all', this)">Hamısı</button>
      <button class="filter-btn" onclick="filterProducts('komputer', this)">💻 Kompüterlər</button>
      <button class="filter-btn" onclick="filterProducts('printer', this)">🖨️ Printerlər</button>
      <button class="filter-btn" onclick="filterProducts('proyektor', this)">📽️ Proyektorlar</button>
      <button class="filter-btn" onclick="filterProducts('aksesuar', this)">🖱️ Aksesuarlar</button>
    </div>
    @php
      $catNames = ['komputer' => 'Kompüter', 'printer' => 'Printer', 'proyektor' => 'Proyektor', 'aksesuar' => 'Aksesuar'];
    @endphp
    <div class="products-grid" id="productsGrid">
      @foreach (($products['list'] ?? []) as $p)
      <div class="product-card" data-cat="{{ $p['cat'] ?? '' }}">
        <div class="product-img">{{ $p['emoji'] ?? '📦' }}</div>
        <div class="product-body">
          <div class="product-cat">{{ $catNames[$p['cat'] ?? ''] ?? ucfirst($p['cat'] ?? '') }}</div>
          <h3>{{ $p['name'] ?? '' }}</h3>
          <p>{{ $p['desc'] ?? '' }}</p>
          <div class="product-footer">
            <div class="price">{{ $p['price'] ?? '' }} ₼ <span>/ {{ $p['unit'] ?? 'ədəd' }}</span></div>
            <a href="#order" class="btn-order">Sifariş et</a>
          </div>
        </div>
      </div>
      @endforeach
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
        <div class="why-features">
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
      <div class="why-visual">
        @foreach (($why['metrics'] ?? []) as $idx => $met)
        <div class="metric-card{{ ($idx === count($why['metrics'] ?? []) - 1 && count($why['metrics'] ?? []) % 2 === 1) ? ' wide' : '' }}">
          <div class="big">{{ $met['num'] ?? '' }}<span>{{ $met['suffix'] ?? '' }}</span></div>
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
    <div class="section-header">
      <div class="eyebrow">Onlayn Sifariş</div>
      <h2 class="section-title">Sifarişinizi Göndərin</h2>
      <p class="section-sub">Formu doldurun, 30 dəqiqə ərzində sizinlə əlaqə saxlayaq.</p>
    </div>
    <div class="order-wrap">
      <form class="form-grid" id="orderForm" action="{{ url('/order') }}" method="POST" onsubmit="event.preventDefault(); handleSubmit();">
        @csrf
        <div class="form-group">
          <label>Adınız *</label>
          <input type="text" name="name" placeholder="Texnobey" required>
        </div>
        <div class="form-group">
          <label>Telefon nömrəsi *</label>
          <input type="tel" name="phone" placeholder="+994 50 XXX XX XX" required>
        </div>
        <div class="form-group">
          <label>E-poçt</label>
          <input type="email" name="email" placeholder="email@example.com">
        </div>
        <div class="form-group">
          <label>Xidmət növü *</label>
          <select name="service" required>
            <option value="">Seçin...</option>
            <option>Kompüter alışı</option>
            <option>Printer alışı</option>
            <option>Proyektor alışı</option>
            <option>Kompüter təmiri</option>
            <option>Printer servis / kartrij</option>
            <option>Texniki konsultasiya</option>
            <option>Korporativ təchizat</option>
            <option>Digər</option>
          </select>
        </div>
        <div class="form-group full">
          <label>Əlavə qeydlər</label>
          <textarea name="notes" placeholder="Məhsul haqqında əlavə məlumat, büdcə, xüsusi tələblər..."></textarea>
        </div>
        <div class="form-group full">
          <button type="submit" class="submit-btn">🚀 Sifarişi Göndər</button>
          <p class="form-note">🔒 Məlumatlarınız tamamilə gizlidir. Spam göndərmirk.</p>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="section about" id="about">
  <div class="container">
    <div class="about-grid">
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
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;width:100%">
          <div class="metric-card"><div class="big">{{ $about['met1Num'] ?? '' }}</div><small>{{ $about['met1Lbl'] ?? '' }}</small></div>
          <div class="metric-card"><div class="big">{{ $about['met2Num'] ?? '' }}</div><small>{{ $about['met2Lbl'] ?? '' }}</small></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
@php
  $phoneRaw = preg_replace('/[^0-9+]/', '', $contact['phone'] ?? '');
  $waRaw = preg_replace('/[^0-9]/', '', $contact['whatsapp'] ?? '');
  $waMsg = rawurlencode('Salam, TechnoBey-dən məlumat almaq istəyirəm.');
@endphp
<section class="section contact" id="contact">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">{{ $contact['eyebrow'] ?? '' }}</div>
      <h2 class="section-title">{{ $contact['title'] ?? '' }}</h2>
      <p class="section-sub">{{ $contact['sub'] ?? '' }}</p>
    </div>
    <div class="contact-grid">
      <div class="contact-info">
        <div class="contact-card">
          <div class="contact-ico">📍</div>
          <div>
            <h4>Ünvan</h4>
            <p>{{ $contact['addr'] ?? '' }}<br><small style="color:var(--muted)">{{ $contact['addrNote'] ?? '' }}</small></p>
          </div>
        </div>
        <div class="contact-card">
          <div class="contact-ico">📞</div>
          <div>
            <h4>Telefon</h4>
            <a href="tel:{{ $phoneRaw }}">{{ $contact['phone'] ?? '' }}</a>
          </div>
        </div>
        <div class="contact-card">
          <div class="contact-ico">🕐</div>
          <div>
            <h4>İş saatları</h4>
            <p>{!! nl2br(e($contact['hours'] ?? '')) !!}</p>
          </div>
        </div>
        <div class="contact-card">
          <div class="contact-ico">✉️</div>
          <div>
            <h4>E-poçt</h4>
            <a href="mailto:{{ $contact['email'] ?? '' }}">{{ $contact['email'] ?? '' }}</a>
          </div>
        </div>
        <div class="contact-actions">
          <a href="https://wa.me/{{ $waRaw }}?text={{ $waMsg }}" class="whatsapp-btn" target="_blank">
            💬 WhatsApp-da Yazın
          </a>
          <a href="tel:{{ $phoneRaw }}" class="call-btn">
            📞 Zəng Et
          </a>
        </div>
      </div>
      <div class="map-placeholder">
        <iframe
          src="{{ $contact['mapSrc'] ?? '' }}"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="TechnoBey ünvanı xəritədə">
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
          <div class="logo-icon">💻</div>
          Techno<span>Bey</span>
        </a>
        <p>Bakıda kompüter, printer və proyektor satışı, təmir və texniki servis. 2016-dan bəri güvənilir texnologiya ortağınız.</p>
      </div>
      <div class="footer-col">
        <h4>Xidmətlər</h4>
        <ul>
          <li><a href="#services">Kompüter Təmiri</a></li>
          <li><a href="#services">Printer Servis</a></li>
          <li><a href="#services">Proyektor Quraşdırma</a></li>
          <li><a href="#services">Konsultasiya</a></li>
          <li><a href="#services">Korporativ Həllər</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Məhsullar</h4>
        <ul>
          <li><a href="#products">Masaüstü PC</a></li>
          <li><a href="#products">Laptoplar</a></li>
          <li><a href="#products">Printerlər</a></li>
          <li><a href="#products">Proyektorlar</a></li>
          <li><a href="#products">Aksesuarlar</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Şirkət</h4>
        <ul>
          <li><a href="#about">Haqqımızda</a></li>
          <li><a href="#contact">Əlaqə</a></li>
          <li><a href="#order">Sifariş et</a></li>
          <li><a href="https://wa.me/994557895745" target="_blank">WhatsApp</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} <span>TechnoBey.az</span> – Bütün hüquqlar qorunur.</p>
      <p>Bakıda kompüter satışı | Printer təmiri | Proyektor satışı</p>
    </div>
  </div>
</footer>

<!-- FLOATING CTA -->
<div class="floating-cta">
  <a href="tel:{{ $phoneRaw }}" class="float-btn float-call" title="Zəng et">📞</a>
  <a href="https://wa.me/{{ $waRaw }}?text={{ $waMsg }}" target="_blank" class="float-btn float-wa" title="WhatsApp">💬</a>
</div>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
