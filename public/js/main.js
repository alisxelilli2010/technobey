// Navbar scroll effect
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 30);
});

// Mobile menu
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
const mobileClose = document.getElementById('mobileClose');
hamburger.addEventListener('click', () => mobileMenu.classList.add('open'));
mobileClose.addEventListener('click', () => mobileMenu.classList.remove('open'));
function closeMobile() { mobileMenu.classList.remove('open'); }

// Product filter
function filterProducts(cat, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.product-card').forEach(card => {
    const show = cat === 'all' || card.dataset.cat === cat;
    card.style.display = show ? 'block' : 'none';
    if (show) { card.style.animation = 'none'; card.offsetHeight; card.style.animation = 'fadeIn 0.3s ease'; }
  });
}

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
    const line = `Məhsul: ${name} — ${price} ₼ / ${unit}`;
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
  const originalText = btn.textContent;
  btn.disabled = true;
  btn.textContent = '⏳ Göndərilir...';

  try {
    const fd = new FormData(form);
    const res = await fetch(form.action, {
      method: 'POST',
      body: fd,
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    btn.textContent = '✅ Sifariş qəbul edildi! Tezliklə əlaqə saxlayacağıq.';
    btn.style.background = '#16a34a';
    form.reset();
  } catch (e) {
    btn.textContent = '❌ Xəta baş verdi, yenidən cəhd edin';
    btn.style.background = '#dc2626';
  }
  setTimeout(() => {
    btn.textContent = originalText;
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
