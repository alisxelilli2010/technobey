// Theme (dark/light) — persistent via localStorage, shared with admin panel
const THEME_KEY = 'tb_theme';
function applyTheme(theme) {
  document.documentElement.setAttribute('data-theme', theme);
  const label = theme === 'light' ? '☀️' : '🌙';
  ['themeBtnIco', 'themeBtnIcoMobile'].forEach(id => {
    const el = document.getElementById(id); if (el) el.textContent = label;
  });
  try { localStorage.setItem(THEME_KEY, theme); } catch {}
}
function toggleTheme() {
  const cur = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
  applyTheme(cur === 'light' ? 'dark' : 'light');
}
(function initTheme() {
  let saved = 'dark';
  try { saved = localStorage.getItem(THEME_KEY) || 'dark'; } catch {}
  applyTheme(saved);
})();

// Navbar scroll effect
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 30);
  const st = document.getElementById('scrollTopBtn');
  if (st) st.classList.toggle('visible', window.scrollY > 400);
});

// ===== SCROLL REVEAL =====
document.addEventListener('DOMContentLoaded', () => {
  const targets = document.querySelectorAll('.reveal, .reveal-up, .reveal-left, .reveal-right, .reveal-zoom, .reveal-stagger');
  if (!('IntersectionObserver' in window)) {
    targets.forEach(el => el.classList.add('revealed'));
    return;
  }
  const io = new IntersectionObserver((entries, obs) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('revealed');
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
  targets.forEach(el => io.observe(el));
});

// ===== NUMBER COUNTER =====
function animateCounter(el) {
  if (el.dataset.counted === '1') return;
  el.dataset.counted = '1';
  const raw = (el.dataset.target || el.textContent || '').trim();
  const match = raw.match(/([0-9.]+)/);
  if (!match) return;
  const target = parseFloat(match[1]);
  if (isNaN(target)) return;
  const prefix = raw.slice(0, match.index);
  const suffix = raw.slice(match.index + match[1].length);
  const duration = 1400;
  const start = performance.now();
  const isInt = Number.isInteger(target);
  function tick(now) {
    const p = Math.min(1, (now - start) / duration);
    const eased = 1 - Math.pow(1 - p, 3); // ease-out cubic
    const val = target * eased;
    el.textContent = prefix + (isInt ? Math.round(val) : val.toFixed(1)) + suffix;
    if (p < 1) requestAnimationFrame(tick);
    else el.textContent = prefix + (isInt ? Math.round(target) : target) + suffix;
  }
  requestAnimationFrame(tick);
}
document.addEventListener('DOMContentLoaded', () => {
  const nums = document.querySelectorAll('[data-counter]');
  if (!nums.length) return;
  if (!('IntersectionObserver' in window)) {
    nums.forEach(animateCounter);
    return;
  }
  const io = new IntersectionObserver((entries, obs) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        animateCounter(e.target);
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.4 });
  nums.forEach(el => io.observe(el));
});

// ===== SCROLL TO TOP =====
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ===== PRODUCT VIEW COUNTER =====
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.product-card[data-product-id]');
  if (!cards.length) return;
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (!csrf) return;
  const sentIds = new Set();
  const timers = new Map();
  const sendView = (id) => {
    if (sentIds.has(id)) return;
    sentIds.add(id);
    fetch(`/api/products/${id}/view`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'X-Requested-With': 'XMLHttpRequest',
      },
      keepalive: true,
    }).catch(() => sentIds.delete(id));
  };
  if (!('IntersectionObserver' in window)) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      const id = e.target.dataset.productId;
      if (!id || id === '0') return;
      if (e.isIntersecting) {
        // Kart 1.2 saniyə görünsə view sayılır
        const t = setTimeout(() => sendView(id), 1200);
        timers.set(id, t);
      } else {
        const t = timers.get(id);
        if (t) { clearTimeout(t); timers.delete(id); }
      }
    });
  }, { threshold: 0.55 });
  cards.forEach(c => io.observe(c));
});

// Mobile menu
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
const mobileClose = document.getElementById('mobileClose');
hamburger.addEventListener('click', () => mobileMenu.classList.add('open'));
mobileClose.addEventListener('click', () => mobileMenu.classList.remove('open'));
function closeMobile() { mobileMenu.classList.remove('open'); }

// Product filter (search + category — hər ikisi eyni funksiya)
let _activeCat = 'all';
function setCatFilter(cat, btn) {
  _activeCat = cat;
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
  filterProducts();
}
function filterProducts() {
  const input = document.getElementById('productSearch');
  const q = input ? input.value.trim().toLowerCase() : '';
  let visible = 0;
  document.querySelectorAll('.product-card').forEach(card => {
    const catMatch = _activeCat === 'all' || card.dataset.cat === _activeCat;
    const searchMatch = !q || (card.dataset.search || '').includes(q);
    const show = catMatch && searchMatch;
    card.style.display = show ? 'block' : 'none';
    if (show) { visible++; card.style.animation = 'none'; card.offsetHeight; card.style.animation = 'fadeIn 0.3s ease'; }
  });
  const empty = document.getElementById('productsEmpty');
  if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
}

// Product image gallery
function galleryTo(dot, idx) {
  const wrap = dot.closest('.product-img-wrap');
  if (!wrap) return;
  wrap.querySelectorAll('.product-gallery-img').forEach(img => img.classList.toggle('active', +img.dataset.idx === idx));
  wrap.querySelectorAll('.gallery-dot').forEach((d, i) => d.classList.toggle('active', i === idx));
}
// Kart üzərinə mouse gələndə şəkilləri avtomatik keçid
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.product-img-wrap').forEach(wrap => {
    const imgs = wrap.querySelectorAll('.product-gallery-img');
    if (imgs.length < 2) return;
    let timer = null;
    wrap.addEventListener('mouseenter', () => {
      let i = 0;
      timer = setInterval(() => {
        i = (i + 1) % imgs.length;
        wrap.querySelectorAll('.product-gallery-img').forEach(im => im.classList.toggle('active', +im.dataset.idx === i));
        wrap.querySelectorAll('.gallery-dot').forEach((d, j) => d.classList.toggle('active', j === i));
      }, 1500);
    });
    wrap.addEventListener('mouseleave', () => {
      if (timer) { clearInterval(timer); timer = null; }
      wrap.querySelectorAll('.product-gallery-img').forEach((im, j) => im.classList.toggle('active', j === 0));
      wrap.querySelectorAll('.gallery-dot').forEach((d, j) => d.classList.toggle('active', j === 0));
    });
  });
});

// Language menu
function toggleLangMenu(e) {
  e.stopPropagation();
  const m = document.getElementById('langMenu');
  if (!m) return;
  m.classList.toggle('open');
}
document.addEventListener('click', (e) => {
  const m = document.getElementById('langMenu');
  if (m && !e.target.closest('.lang-switcher')) m.classList.remove('open');
});

// Məhsul kartından "Sifariş et" klikləyəndə formu doldur
function selectProduct(linkEl, name, cat, price, unit) {
  const form = document.getElementById('orderForm');
  if (!form) return;
  const catToService = {
    komputer:  'Kompüter alışı',
    printer:   'Printer alışı',
    proyektor: 'Proyektor alışı',
    aksesuar:  'Digər',
  };
  const wantedService = catToService[cat] || 'Digər';
  const serviceSel = form.querySelector('select[name="service"]');
  if (serviceSel) {
    let matched = false;
    Array.from(serviceSel.options).forEach(opt => {
      if (opt.value === wantedService || opt.textContent.trim() === wantedService) {
        serviceSel.value = opt.value;
        matched = true;
      }
    });
    if (!matched) serviceSel.value = 'Digər';
  }
  const notes = form.querySelector('textarea[name="notes"]');
  if (notes) {
    const label = form.dataset.productLabel || 'Product';
    const line = `${label}: ${name} — ${price} ₼ / ${unit}`;
    notes.value = notes.value ? line + '\n' + notes.value : line;
  }
  // Smooth scroll to form, then focus name field
  const orderSection = document.getElementById('order');
  if (orderSection) orderSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  setTimeout(() => { const n = form.querySelector('input[name="name"]'); if (n) n.focus(); }, 500);
}

// Form submit – sifarişi serverə göndər
async function handleSubmit() {
  const form = document.getElementById('orderForm');
  const btn = form.querySelector('.submit-btn');
  const idle    = btn.dataset.labelIdle    || btn.textContent;
  const sending = btn.dataset.labelSending || '⏳ ...';
  const ok      = btn.dataset.labelOk      || '✅';
  const err     = btn.dataset.labelErr     || '❌';
  btn.disabled = true;
  btn.textContent = sending;

  try {
    const fd = new FormData(form);
    const res = await fetch(form.action, {
      method: 'POST',
      body: fd,
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    btn.textContent = ok;
    btn.style.background = '#16a34a';
    form.reset();
  } catch (e) {
    btn.textContent = err;
    btn.style.background = '#dc2626';
  }
  setTimeout(() => {
    btn.textContent = idle;
    btn.style.background = '';
    btn.disabled = false;
  }, 4000);
}

// Fade-in on scroll
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.style.opacity = '1'; e.target.style.transform = 'translateY(0)'; }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.service-card, .product-card, .metric-card, .contact-card, .device-card').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'opacity 0.5s ease, transform 0.5s ease, border-color 0.25s, box-shadow 0.25s';
  observer.observe(el);
});
