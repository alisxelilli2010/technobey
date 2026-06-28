<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TechnoBey – Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --night: #080D1A; --deep: #0A1128; --card: #111827;
    --border: #1E2D4A; --blue: #0057FF; --cyan: #00C2FF;
    --text: #E8EEFF; --muted: #7B8DB0; --white: #FFFFFF;
    --green: #16a34a; --red: #dc2626; --orange: #d97706;
  }
  body { background: var(--night); color: var(--text); font-family: 'Inter', sans-serif; min-height: 100vh; }

  /* LOGIN */
  .login-screen {
    min-height: 100vh; display: flex; align-items: center; justify-content: center;
    background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(0,87,255,0.15) 0%, transparent 70%), var(--night);
  }
  .login-box {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 400px; text-align: center;
  }
  .login-box h1 { font-size: 1.6rem; font-weight: 800; color: var(--white); margin-bottom: 8px; }
  .login-box p { color: var(--muted); font-size: 0.88rem; margin-bottom: 32px; }
  .login-box input {
    width: 100%; background: rgba(255,255,255,0.04); border: 1.5px solid var(--border);
    color: var(--white); border-radius: 10px; padding: 13px 16px;
    font-size: 0.95rem; font-family: inherit; outline: none; margin-bottom: 14px;
    transition: border-color 0.2s;
  }
  .login-box input:focus { border-color: var(--blue); }
  .login-btn {
    width: 100%; background: linear-gradient(135deg, var(--blue), var(--cyan));
    color: var(--white); padding: 14px; border-radius: 10px;
    font-size: 1rem; font-weight: 700; cursor: pointer; border: none;
    transition: opacity 0.2s, transform 0.2s;
  }
  .login-btn:hover { opacity: 0.9; transform: translateY(-1px); }
  .login-err { color: #f87171; font-size: 0.82rem; margin-top: 10px; display: none; }

  /* LAYOUT */
  .admin-layout { display: flex; min-height: 100vh; }
  .sidebar {
    width: 240px; background: var(--deep); border-right: 1px solid var(--border);
    padding: 28px 0; display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0;
    overflow-y: auto;
  }
  .sidebar-logo {
    display: flex; align-items: center; gap: 10px;
    font-weight: 800; font-size: 1.1rem; color: var(--white);
    padding: 0 24px 28px; border-bottom: 1px solid var(--border);
  }
  .sidebar-logo-icon {
    width: 32px; height: 32px; background: linear-gradient(135deg, var(--blue), var(--cyan));
    border-radius: 8px; display: grid; place-items: center; font-size: 1rem;
  }
  .sidebar-logo span { color: var(--white); }
  .sidebar-nav { padding: 20px 12px; flex: 1; }
  .nav-group-label {
    font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 1.5px;
    font-weight: 700; padding: 12px 14px 6px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 14px; border-radius: 10px; cursor: pointer;
    color: var(--muted); font-size: 0.85rem; font-weight: 500;
    transition: all 0.2s; margin-bottom: 3px;
  }
  .nav-item:hover, .nav-item.active { background: rgba(0,87,255,0.15); color: var(--white); }
  .nav-item.active { border-left: 3px solid var(--blue); }
  .nav-ico { font-size: 1.05rem; }
  .sidebar-footer { padding: 16px 12px; border-top: 1px solid var(--border); }
  .logout-btn {
    display: flex; align-items: center; gap: 10px;
    width: 100%; padding: 10px 14px; border-radius: 10px;
    background: rgba(220,38,38,0.1); color: #f87171;
    border: none; cursor: pointer; font-size: 0.85rem; font-weight: 600; font-family: inherit;
    transition: background 0.2s;
  }
  .logout-btn:hover { background: rgba(220,38,38,0.2); }

  /* MAIN */
  .main-content { margin-left: 240px; padding: 32px; flex: 1; }
  .page { display: none; }
  .page.active { display: block; }
  .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; gap: 16px; flex-wrap: wrap; }
  .page-header h2 { font-size: 1.5rem; font-weight: 800; color: var(--white); }
  .page-header p { color: var(--muted); font-size: 0.88rem; margin-top: 4px; }

  /* CHARTS */
  .charts-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 24px;
  }
  .chart-panel {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 12px; padding: 14px 16px;
  }
  .chart-panel.wide { grid-column: span 2; }
  .chart-header { margin-bottom: 8px; }
  .chart-header h3 { font-size: 0.82rem; font-weight: 700; color: var(--white); }
  .chart-body { position: relative; height: 200px; }
  .chart-body.sm { height: 170px; }
  @media (max-width: 900px) {
    .charts-grid { grid-template-columns: 1fr; }
    .chart-panel.wide { grid-column: span 1; }
    .chart-body, .chart-body.sm { height: 180px; }
  }

  /* STATS */
  .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
  .stat-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; padding: 22px 20px;
  }
  .stat-card .label { font-size: 0.78rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
  .stat-card .value { font-size: 2rem; font-weight: 800; color: var(--white); letter-spacing: -1px; }
  .stat-card .value span { color: var(--cyan); font-size: 1.3rem; }

  /* BUTTONS */
  .add-btn {
    background: linear-gradient(135deg, var(--blue), var(--cyan));
    color: var(--white); padding: 11px 22px; border-radius: 10px;
    font-size: 0.88rem; font-weight: 700; cursor: pointer; border: none;
    display: inline-flex; align-items: center; gap: 8px; font-family: inherit;
    transition: opacity 0.2s, transform 0.2s; box-shadow: 0 4px 16px rgba(0,87,255,0.3);
  }
  .add-btn:hover { opacity: 0.9; transform: translateY(-1px); }
  .ghost-btn {
    background: transparent; border: 1.5px solid var(--border);
    color: var(--muted); padding: 10px 18px; border-radius: 10px;
    font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: inherit;
    transition: border-color 0.2s;
  }
  .ghost-btn:hover { border-color: var(--blue); color: var(--white); }

  /* PRODUCT TABLE */
  .table-wrap { background: var(--card); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
  .table-toolbar {
    padding: 16px 20px; display: flex; gap: 12px; align-items: center;
    border-bottom: 1px solid var(--border); flex-wrap: wrap;
  }
  .search-input {
    background: rgba(255,255,255,0.04); border: 1.5px solid var(--border);
    color: var(--white); border-radius: 8px; padding: 9px 14px;
    font-size: 0.85rem; font-family: inherit; outline: none; width: 240px;
    transition: border-color 0.2s;
  }
  .search-input:focus { border-color: var(--blue); }
  .filter-select {
    background: rgba(255,255,255,0.04); border: 1.5px solid var(--border);
    color: var(--white); border-radius: 8px; padding: 9px 14px;
    font-size: 0.85rem; font-family: inherit; outline: none; cursor: pointer;
  }
  .filter-select option { background: var(--card); }
  table { width: 100%; border-collapse: collapse; }
  thead tr { border-bottom: 1px solid var(--border); }
  th { padding: 13px 16px; font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; text-align: left; }
  td { padding: 14px 16px; font-size: 0.87rem; color: var(--text); border-bottom: 1px solid rgba(30,45,74,0.5); }
  tr:last-child td { border-bottom: none; }
  tr:hover td { background: rgba(255,255,255,0.02); }
  .cat-badge {
    background: rgba(0,87,255,0.15); color: var(--cyan);
    font-size: 0.72rem; font-weight: 700; padding: 3px 10px;
    border-radius: 100px; text-transform: uppercase; letter-spacing: 0.5px;
  }
  .price-cell { font-weight: 700; color: var(--white); }
  .action-btns { display: flex; gap: 8px; }
  .edit-btn, .del-btn {
    padding: 6px 14px; border-radius: 7px; font-size: 0.78rem;
    font-weight: 600; cursor: pointer; border: none; font-family: inherit; transition: opacity 0.2s;
  }
  .edit-btn { background: rgba(0,87,255,0.2); color: var(--cyan); }
  .del-btn { background: rgba(220,38,38,0.15); color: #f87171; }
  .edit-btn:hover, .del-btn:hover { opacity: 0.75; }
  .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
  .empty-state .ico { font-size: 3rem; margin-bottom: 12px; }

  /* CARD / FORM PANEL */
  .panel {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; padding: 28px; margin-bottom: 20px;
  }
  .panel h3 { font-size: 1rem; font-weight: 800; color: var(--white); margin-bottom: 18px; display: flex; align-items: center; gap: 10px; }
  .panel h3 small { font-weight: 500; color: var(--muted); font-size: 0.78rem; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-row.three { grid-template-columns: 1fr 1fr 1fr; }
  .form-grp { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
  .form-grp.full { grid-column: 1 / -1; }
  .form-grp label { font-size: 0.8rem; font-weight: 600; color: var(--muted); }
  .form-grp input, .form-grp select, .form-grp textarea {
    background: rgba(255,255,255,0.04); border: 1.5px solid var(--border);
    color: var(--white); border-radius: 9px; padding: 11px 14px;
    font-size: 0.9rem; font-family: inherit; outline: none; transition: border-color 0.2s;
  }
  .form-grp input:focus, .form-grp select:focus, .form-grp textarea:focus { border-color: var(--blue); }
  .form-grp select option { background: var(--card); }
  .form-grp textarea { min-height: 70px; resize: vertical; }
  .modal-actions { display: flex; gap: 12px; margin-top: 6px; }
  .save-btn {
    flex: 1; background: linear-gradient(135deg, var(--blue), var(--cyan));
    color: var(--white); padding: 13px; border-radius: 10px;
    font-size: 0.95rem; font-weight: 700; cursor: pointer; border: none; font-family: inherit;
    transition: opacity 0.2s;
  }
  .save-btn:hover { opacity: 0.9; }
  .cancel-btn {
    flex: 1; background: transparent; border: 1.5px solid var(--border);
    color: var(--muted); padding: 13px; border-radius: 10px;
    font-size: 0.95rem; font-weight: 600; cursor: pointer; font-family: inherit;
    transition: border-color 0.2s;
  }
  .cancel-btn:hover { border-color: var(--blue); color: var(--white); }

  /* DYNAMIC LIST ITEMS */
  .item-row {
    background: rgba(255,255,255,0.02); border: 1px solid var(--border);
    border-radius: 10px; padding: 16px; margin-bottom: 12px;
    position: relative;
  }
  .item-row-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 12px;
  }
  .item-row-title { font-size: 0.85rem; font-weight: 700; color: var(--white); }
  .item-row-del {
    background: rgba(220,38,38,0.15); color: #f87171; border: none;
    padding: 5px 12px; border-radius: 7px; font-size: 0.76rem;
    font-weight: 600; cursor: pointer; font-family: inherit;
  }
  .item-row-del:hover { opacity: 0.8; }

  .info-note {
    background: rgba(0,194,255,0.08); border: 1px solid rgba(0,194,255,0.2);
    border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;
    color: var(--cyan); font-size: 0.83rem; line-height: 1.6;
  }
  .info-note strong { color: var(--white); }

  /* MODAL (delete confirm) */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.7);
    display: none; align-items: center; justify-content: center; z-index: 2000;
    backdrop-filter: blur(4px);
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 20px; padding: 36px; width: 100%; max-width: 520px;
    max-height: 90vh; overflow-y: auto;
  }
  .modal h3 { font-size: 1.2rem; font-weight: 800; color: var(--white); margin-bottom: 24px; }

  /* TOAST */
  .toast {
    position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(80px);
    background: var(--green); color: var(--white); padding: 12px 24px; border-radius: 10px;
    font-weight: 600; font-size: 0.9rem; z-index: 3000; transition: transform 0.3s ease;
    box-shadow: 0 4px 20px rgba(0,0,0,0.4);
  }
  .toast.show { transform: translateX(-50%) translateY(0); }
  .toast.error { background: var(--red); }

  /* RESPONSIVE */
  @media (max-width: 768px) {
    .sidebar { width: 200px; }
    .main-content { margin-left: 200px; padding: 20px; }
    .stats-row { grid-template-columns: 1fr 1fr; }
    .form-row, .form-row.three { grid-template-columns: 1fr; }
  }
  @media (max-width: 560px) {
    .sidebar { display: none; }
    .main-content { margin-left: 0; }
  }
</style>
</head>
<body>

<!-- LOGIN -->
<div class="login-screen" id="loginScreen">
  <div class="login-box">
    <div style="font-size:2.5rem;margin-bottom:12px">💻</div>
    <h1>TechnoBey Admin</h1>
    <p>İdarəetmə panelinə daxil olmaq üçün şifrənizi daxil edin</p>
    <input type="text" id="loginUser" placeholder="İstifadəçi adı" autocomplete="off" oninput="document.getElementById('loginErr').style.display='none'">
    <input type="password" id="loginPass" placeholder="Şifrə" oninput="document.getElementById('loginErr').style.display='none'" onkeydown="if(event.key==='Enter')doLogin()">
    <button class="login-btn" onclick="doLogin()">Daxil ol →</button>
    <div class="login-err" id="loginErr">❌ İstifadəçi adı və ya şifrə yanlışdır</div>
  </div>
</div>

<!-- ADMIN PANEL -->
<div class="admin-layout" id="adminPanel" style="display:none">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo" onclick="showPage('dashboard', document.querySelector('[data-page=dashboard]'))" style="cursor:pointer">
      <div class="sidebar-logo-icon">💻</div>
      Techno<span>Bey</span>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-group-label">Ümumi</div>
      <div class="nav-item active" data-page="dashboard" onclick="showPage('dashboard', this)">
        <span class="nav-ico">📊</span> İdarə Paneli
      </div>
      <div class="nav-item" data-page="orders" onclick="showPage('orders', this)">
        <span class="nav-ico">📋</span> Sifarişlər
      </div>

      <div class="nav-group-label">Səhifə Bölmələri</div>
      <div class="nav-item" data-page="hero" onclick="showPage('hero', this)">
        <span class="nav-ico">🎯</span> Hero
      </div>
      <div class="nav-item" data-page="services" onclick="showPage('services', this)">
        <span class="nav-ico">🛠️</span> Xidmətlər
      </div>
      <div class="nav-item" data-page="why" onclick="showPage('why', this)">
        <span class="nav-ico">⭐</span> Niyə Biz?
      </div>
      <div class="nav-item" data-page="about" onclick="showPage('about', this)">
        <span class="nav-ico">ℹ️</span> Haqqımızda
      </div>
      <div class="nav-item" data-page="contact" onclick="showPage('contact', this)">
        <span class="nav-ico">📞</span> Əlaqə
      </div>

      <div class="nav-group-label">Məhsullar</div>
      <div class="nav-item" data-page="products" onclick="showPage('products', this)">
        <span class="nav-ico">📦</span> Məhsullar
      </div>
      <div class="nav-item" data-page="add" onclick="showPage('add', this)">
        <span class="nav-ico">➕</span> Yeni Məhsul
      </div>
    </nav>
    <div class="sidebar-footer">
      <button class="logout-btn" onclick="doLogout()">🚪 Çıxış</button>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main-content">

    <!-- DASHBOARD -->
    <div class="page active" id="pageDashboard">
      <div class="page-header">
        <div>
          <h2>İdarə Paneli</h2>
          <p>TechnoBey məhsul idarəetmə sistemi</p>
        </div>
      </div>
      <div class="stats-row" id="statsRow"></div>

      <div class="charts-grid">
        <div class="chart-panel wide">
          <div class="chart-header"><h3>📈 Son 12 ay – Sifariş / Ziyarətçi</h3></div>
          <div class="chart-body sm"><canvas id="chartMonthly"></canvas></div>
        </div>
        <div class="chart-panel">
          <div class="chart-header"><h3>📊 Kateqoriya üzrə məhsullar</h3></div>
          <div class="chart-body"><canvas id="chartByCat"></canvas></div>
        </div>
        <div class="chart-panel">
          <div class="chart-header"><h3>📅 Son 7 gün ziyarətçi</h3></div>
          <div class="chart-body"><canvas id="chartWeekly"></canvas></div>
        </div>
        <div class="chart-panel wide">
          <div class="chart-header"><h3>🛒 Ən çox sifariş edilən xidmət növləri</h3></div>
          <div class="chart-body sm"><canvas id="chartByService"></canvas></div>
        </div>
      </div>

      <div class="table-wrap">
        <div style="padding:20px 20px 0; border-bottom:1px solid var(--border); margin-bottom:0">
          <span style="font-size:0.85rem;font-weight:700;color:var(--white)">Son əlavə edilən məhsullar</span>
        </div>
        <table>
          <thead><tr>
            <th>Məhsul adı</th><th>Kateqoriya</th><th>Qiymət</th><th>Əməliyyat</th>
          </tr></thead>
          <tbody id="recentTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- ORDERS -->
    <div class="page" id="pageOrders">
      <div class="page-header">
        <div>
          <h2>Gələn Sifarişlər</h2>
          <p>Saytdakı formdan göndərilən sifarişlər</p>
        </div>
        <button class="ghost-btn" onclick="clearAllOrders()">🗑️ Hamısını sil</button>
      </div>
      <div class="info-note">
        ℹ️ <strong>Qeyd:</strong> Sayt formdan gələn sifarişlər hazırda Laravel log-da yazılır (<code>storage/logs/laravel.log</code>). Brauzer tərəfdə test üçün saxlanan sifarişlər aşağıda görünür.
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr>
            <th>Tarix</th><th>Ad</th><th>Telefon</th><th>Xidmət</th><th>Qeyd</th><th>Əməliyyat</th>
          </tr></thead>
          <tbody id="ordersTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- HERO -->
    <div class="page" id="pageHero">
      <div class="page-header">
        <div>
          <h2>🎯 Hero Bölməsi</h2>
          <p>Saytın yuxarı baş bölməsinin məzmunu</p>
        </div>
        <button class="add-btn" onclick="saveHero()">💾 Yadda saxla</button>
      </div>
      <div class="panel">
        <h3>Əsas məzmun</h3>
        <div class="form-row">
          <div class="form-grp full">
            <label>Badge mətni</label>
            <input type="text" id="heroBadge" placeholder="🟢 Bakıda №1 Texnologiya Mağazası">
          </div>
          <div class="form-grp full">
            <label>Başlıq (HTML icazəlidir: &lt;br&gt;, &lt;span class="accent"&gt;)</label>
            <textarea id="heroTitle" placeholder="Texnologiyanı&lt;br&gt;&lt;span class=&quot;accent&quot;&gt;Güvənilir&lt;/span&gt; Əllərdə..."></textarea>
          </div>
          <div class="form-grp full">
            <label>Alt mətn</label>
            <textarea id="heroSub" placeholder="Kompüter, printer, proyektor satışı..."></textarea>
          </div>
          <div class="form-grp">
            <label>Birinci düymə mətni</label>
            <input type="text" id="heroBtn1Text" placeholder="🛍️ Məhsullara bax">
          </div>
          <div class="form-grp">
            <label>Birinci düymə linki</label>
            <input type="text" id="heroBtn1Link" placeholder="#products">
          </div>
          <div class="form-grp">
            <label>İkinci düymə mətni</label>
            <input type="text" id="heroBtn2Text" placeholder="📞 Bizimlə əlaqə">
          </div>
          <div class="form-grp">
            <label>İkinci düymə linki</label>
            <input type="text" id="heroBtn2Link" placeholder="#contact">
          </div>
        </div>
      </div>
      <div class="panel">
        <h3>Hero Statistikalar <small>(3 ədəd)</small></h3>
        <div class="form-row three">
          <div class="form-grp"><label>Stat 1 rəqəm</label><input type="text" id="heroStat1Num" placeholder="5K+"></div>
          <div class="form-grp"><label>Stat 2 rəqəm</label><input type="text" id="heroStat2Num" placeholder="8+"></div>
          <div class="form-grp"><label>Stat 3 rəqəm</label><input type="text" id="heroStat3Num" placeholder="500+"></div>
          <div class="form-grp"><label>Stat 1 etiket</label><input type="text" id="heroStat1Lbl" placeholder="Məmnun müştəri"></div>
          <div class="form-grp"><label>Stat 2 etiket</label><input type="text" id="heroStat2Lbl" placeholder="İl təcrübə"></div>
          <div class="form-grp"><label>Stat 3 etiket</label><input type="text" id="heroStat3Lbl" placeholder="Məhsul çeşidi"></div>
        </div>
      </div>
      <div class="panel">
        <h3>Sağdakı Cihaz Kartları <small>(3 ədəd)</small></h3>
        <div class="form-row three">
          <div class="form-grp"><label>Kart 1 emoji</label><input type="text" id="heroDev1Emoji" placeholder="🖥️" maxlength="4"></div>
          <div class="form-grp"><label>Kart 2 emoji</label><input type="text" id="heroDev2Emoji" placeholder="🖨️" maxlength="4"></div>
          <div class="form-grp"><label>Kart 3 emoji</label><input type="text" id="heroDev3Emoji" placeholder="📽️" maxlength="4"></div>
          <div class="form-grp"><label>Kart 1 başlıq</label><input type="text" id="heroDev1Title" placeholder="Gaming & Office PC"></div>
          <div class="form-grp"><label>Kart 2 başlıq</label><input type="text" id="heroDev2Title" placeholder="Printerlər"></div>
          <div class="form-grp"><label>Kart 3 başlıq</label><input type="text" id="heroDev3Title" placeholder="Proyektorlar"></div>
          <div class="form-grp"><label>Kart 1 açıqlama</label><input type="text" id="heroDev1Desc" placeholder="Intel Core..."></div>
          <div class="form-grp"><label>Kart 2 açıqlama</label><input type="text" id="heroDev2Desc" placeholder="HP, Canon, Epson..."></div>
          <div class="form-grp"><label>Kart 3 açıqlama</label><input type="text" id="heroDev3Desc" placeholder="4K, Full HD..."></div>
        </div>
      </div>
    </div>

    <!-- SERVICES -->
    <div class="page" id="pageServices">
      <div class="page-header">
        <div>
          <h2>🛠️ Xidmətlər Bölməsi</h2>
          <p>Saytın xidmət kartları</p>
        </div>
        <div style="display:flex;gap:10px">
          <button class="ghost-btn" onclick="addServiceCard()">➕ Yeni kart</button>
          <button class="add-btn" onclick="saveServices()">💾 Yadda saxla</button>
        </div>
      </div>
      <div class="panel">
        <h3>Bölmə başlığı</h3>
        <div class="form-row">
          <div class="form-grp"><label>Eyebrow (kiçik üst etiket)</label><input type="text" id="srvEyebrow" placeholder="Xidmətlərimiz"></div>
          <div class="form-grp full"><label>Başlıq (HTML icazəlidir)</label><textarea id="srvTitle" placeholder="Hər Texnoloji Ehtiyacınız&lt;br&gt;Üçün Buradayıq"></textarea></div>
          <div class="form-grp full"><label>Alt mətn</label><textarea id="srvSub" placeholder="Satışdan sonrakı dəstəkdən..."></textarea></div>
        </div>
      </div>
      <div id="servicesCardsContainer"></div>
    </div>

    <!-- WHY US -->
    <div class="page" id="pageWhy">
      <div class="page-header">
        <div>
          <h2>⭐ Niyə Biz?</h2>
          <p>Üstünlüklər və metrikalar bölməsi</p>
        </div>
        <button class="add-btn" onclick="saveWhy()">💾 Yadda saxla</button>
      </div>
      <div class="panel">
        <h3>Mətn</h3>
        <div class="form-row">
          <div class="form-grp"><label>Eyebrow</label><input type="text" id="whyEyebrow" placeholder="Niyə TechnoBey?"></div>
          <div class="form-grp full"><label>Başlıq</label><textarea id="whyTitle" placeholder="Bakıda 8 İllik Etibar..."></textarea></div>
          <div class="form-grp full"><label>Alt mətn</label><textarea id="whySub" placeholder="2016-cı ildən bəri..."></textarea></div>
        </div>
      </div>
      <div class="panel">
        <h3>Üstünlüklər <small>(4 ədəd)</small></h3>
        <div id="whyFeaturesContainer"></div>
        <button class="ghost-btn" onclick="addWhyFeature()" style="margin-top:8px">➕ Yeni üstünlük</button>
      </div>
      <div class="panel">
        <h3>Metrika Kartları <small>(5 ədəd)</small></h3>
        <div id="whyMetricsContainer"></div>
        <button class="ghost-btn" onclick="addWhyMetric()" style="margin-top:8px">➕ Yeni metrika</button>
      </div>
    </div>

    <!-- ABOUT -->
    <div class="page" id="pageAbout">
      <div class="page-header">
        <div>
          <h2>ℹ️ Haqqımızda</h2>
          <p>Şirkət haqqında məlumat bölməsi</p>
        </div>
        <button class="add-btn" onclick="saveAbout()">💾 Yadda saxla</button>
      </div>
      <div class="panel">
        <h3>Mətn və başlıq</h3>
        <div class="form-row">
          <div class="form-grp"><label>Badge 1</label><input type="text" id="abBadge1" placeholder="🏆 2016-dan bəri"></div>
          <div class="form-grp"><label>Badge 2</label><input type="text" id="abBadge2" placeholder="✅ Rəsmi distribütor"></div>
          <div class="form-grp"><label>Badge 3</label><input type="text" id="abBadge3" placeholder="🇦🇿 Yerli şirkət"></div>
          <div class="form-grp"></div>
          <div class="form-grp full"><label>Başlıq</label><input type="text" id="abTitle" placeholder="Bakının Etibarlı Texnologiya Ortağı"></div>
          <div class="form-grp full"><label>Mətn</label><textarea id="abText" placeholder="TechnoBey 2016-cı ildə..."></textarea></div>
          <div class="form-grp"><label>Düymə mətni</label><input type="text" id="abBtnText" placeholder="📞 Bizimlə tanış olun"></div>
          <div class="form-grp"><label>Düymə linki</label><input type="text" id="abBtnLink" placeholder="#contact"></div>
        </div>
      </div>
      <div class="panel">
        <h3>Servis Mərkəzi Kartı</h3>
        <div class="form-row">
          <div class="form-grp"><label>İkon emoji</label><input type="text" id="abIcon" placeholder="🏪" maxlength="4"></div>
          <div class="form-grp"><label>Mərkəz adı</label><input type="text" id="abCenterName" placeholder="TechnoBey Servis Mərkəzi"></div>
          <div class="form-grp full"><label>Ünvan</label><input type="text" id="abCenterAddr" placeholder="Nəsimi rayonu, Bakı şəhəri"></div>
          <div class="form-grp"><label>Metrika 1 rəqəm</label><input type="text" id="abMet1Num" placeholder="12"></div>
          <div class="form-grp"><label>Metrika 1 etiket</label><input type="text" id="abMet1Lbl" placeholder="Texniki mütəxəssis"></div>
          <div class="form-grp"><label>Metrika 2 rəqəm</label><input type="text" id="abMet2Num" placeholder="3"></div>
          <div class="form-grp"><label>Metrika 2 etiket</label><input type="text" id="abMet2Lbl" placeholder="Xidmət sahəsi"></div>
        </div>
      </div>
    </div>

    <!-- CONTACT -->
    <div class="page" id="pageContact">
      <div class="page-header">
        <div>
          <h2>📞 Əlaqə</h2>
          <p>Əlaqə məlumatları və xəritə bölməsi</p>
        </div>
        <button class="add-btn" onclick="saveContact()">💾 Yadda saxla</button>
      </div>
      <div class="panel">
        <h3>Bölmə başlığı</h3>
        <div class="form-row">
          <div class="form-grp"><label>Eyebrow</label><input type="text" id="ctEyebrow" placeholder="Əlaqə"></div>
          <div class="form-grp"><label>Başlıq</label><input type="text" id="ctTitle" placeholder="Bizə Çatın"></div>
          <div class="form-grp full"><label>Alt mətn</label><textarea id="ctSub" placeholder="Sual, sifariş, xidmət tələbi..."></textarea></div>
        </div>
      </div>
      <div class="panel">
        <h3>Əlaqə kartları</h3>
        <div class="form-row">
          <div class="form-grp full"><label>📍 Ünvan</label><input type="text" id="ctAddr" placeholder="Nəsimi rayonu, Bakı şəhəri..."></div>
          <div class="form-grp"><label>📍 Yaxınlıq qeydi</label><input type="text" id="ctAddrNote" placeholder="Metro: 28 May, 5 dəq piyada"></div>
          <div class="form-grp"><label>📞 Telefon</label><input type="text" id="ctPhone" placeholder="+994 55 789 57 45"></div>
          <div class="form-grp full"><label>🕐 İş saatları</label><textarea id="ctHours" placeholder="B.e. – Şənbə: 09:00 – 19:00&#10;Bazar: 10:00 – 17:00"></textarea></div>
          <div class="form-grp"><label>✉️ E-poçt</label><input type="text" id="ctEmail" placeholder="info@technobey.az"></div>
          <div class="form-grp"><label>💬 WhatsApp nömrəsi</label><input type="text" id="ctWhatsapp" placeholder="994557895745"></div>
          <div class="form-grp full"><label>🗺️ Google Maps iframe src</label><textarea id="ctMapSrc" placeholder="https://www.google.com/maps/embed?pb=..."></textarea></div>
        </div>
      </div>
    </div>

    <!-- PRODUCTS LIST -->
    <div class="page" id="pageProducts">
      <div class="page-header">
        <div>
          <h2>📦 Məhsullar</h2>
          <p id="productCountLabel">Cəmi 0 məhsul</p>
        </div>
        <button class="add-btn" onclick="showPage('add', document.querySelector('[data-page=add]'))">
          ➕ Yeni məhsul
        </button>
      </div>
      <div class="table-wrap">
        <div class="table-toolbar">
          <input class="search-input" id="searchInput" placeholder="🔍 Məhsul axtar..." oninput="renderProductTable()">
          <select class="filter-select" id="catFilter" onchange="renderProductTable()">
            <option value="">Bütün kateqoriyalar</option>
            <option value="komputer">💻 Kompüterlər</option>
            <option value="printer">🖨️ Printerlər</option>
            <option value="proyektor">📽️ Proyektorlar</option>
            <option value="aksesuar">🖱️ Aksesuarlar</option>
          </select>
        </div>
        <table>
          <thead><tr>
            <th>Emoji</th><th>Məhsul adı</th><th>Kateqoriya</th><th>Qiymət</th><th>Açıqlama</th><th>Əməliyyat</th>
          </tr></thead>
          <tbody id="productTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- ADD / EDIT PRODUCT -->
    <div class="page" id="pageAdd">
      <div class="page-header">
        <div>
          <h2 id="formTitle">Yeni Məhsul Əlavə Et</h2>
          <p>Məlumatları doldurun və yadda saxlayın</p>
        </div>
        <button class="ghost-btn" onclick="showPage('products', document.querySelector('[data-page=products]'))">← Geri</button>
      </div>
      <div class="panel" style="max-width:620px">
        <input type="hidden" id="editId">
        <div class="form-row">
          <div class="form-grp">
            <label>Məhsul adı *</label>
            <input type="text" id="fName" placeholder="məs. HP LaserJet Pro">
          </div>
          <div class="form-grp">
            <label>Kateqoriya *</label>
            <select id="fCat">
              <option value="">Seçin...</option>
              <option value="komputer">💻 Kompüter / Laptop</option>
              <option value="printer">🖨️ Printer</option>
              <option value="proyektor">📽️ Proyektor</option>
              <option value="aksesuar">🖱️ Aksesuar</option>
            </select>
          </div>
          <div class="form-grp">
            <label>Qiymət (₼) *</label>
            <input type="number" id="fPrice" placeholder="məs. 450">
          </div>
          <div class="form-grp">
            <label>Emoji ikonu</label>
            <input type="text" id="fEmoji" placeholder="məs. 🖨️" maxlength="4">
          </div>
          <div class="form-grp full">
            <label>Qısa açıqlama *</label>
            <textarea id="fDesc" placeholder="məs. Rəngli çap, Wi-Fi dəstəkli, 3-ü 1-də"></textarea>
          </div>
          <div class="form-grp">
            <label>Qiymət vahidi</label>
            <select id="fUnit">
              <option value="ədəd">/ ədəd</option>
              <option value="dəst">/ dəst</option>
              <option value="ay">/ ay</option>
            </select>
          </div>
        </div>
        <div class="modal-actions">
          <button class="save-btn" onclick="saveProduct()">💾 Yadda Saxla</button>
          <button class="cancel-btn" onclick="clearForm()">🗑️ Təmizlə</button>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:400px;text-align:center">
    <div style="font-size:2.5rem;margin-bottom:12px">🗑️</div>
    <h3>Məhsulu sil?</h3>
    <p style="color:var(--muted);font-size:0.88rem;margin:12px 0 28px">"<span id="deleteProductName"></span>" məhsulunu silmək istədiyinizə əminsiniz? Bu əməliyyat geri alına bilməz.</p>
    <div class="modal-actions">
      <button class="save-btn" style="background:var(--red);box-shadow:none" onclick="confirmDelete()">Bəli, sil</button>
      <button class="cancel-btn" onclick="closeDeleteModal()">Ləğv et</button>
    </div>
  </div>
</div>

<!-- ORDER DELETE CONFIRM MODAL -->
<div class="modal-overlay" id="orderDeleteModal">
  <div class="modal" style="max-width:400px;text-align:center">
    <div style="font-size:2.5rem;margin-bottom:12px">🗑️</div>
    <h3>Sifarişi sil?</h3>
    <p style="color:var(--muted);font-size:0.88rem;margin:12px 0 28px">"<span id="deleteOrderName"></span>" adlı müştərinin sifarişini silmək istədiyinizə əminsiniz? Bu əməliyyat geri alına bilməz.</p>
    <div class="modal-actions">
      <button class="save-btn" style="background:var(--red);box-shadow:none" onclick="confirmDeleteOrder()">Bəli, sil</button>
      <button class="cancel-btn" onclick="closeOrderDeleteModal()">Ləğv et</button>
    </div>
  </div>
</div>

<!-- GENERIC CONFIRM MODAL (used by all delete buttons that don't have a dedicated modal) -->
<div class="modal-overlay" id="confirmModal">
  <div class="modal" style="max-width:400px;text-align:center">
    <div style="font-size:2.5rem;margin-bottom:12px" id="confirmModalIcon">🗑️</div>
    <h3 id="confirmModalTitle">Silmək istəyirsiniz?</h3>
    <p style="color:var(--muted);font-size:0.88rem;margin:12px 0 28px" id="confirmModalMsg">Bu əməliyyat geri alına bilməz.</p>
    <div class="modal-actions">
      <button class="save-btn" id="confirmModalOk" style="background:var(--red);box-shadow:none">Bəli, sil</button>
      <button class="cancel-btn" onclick="closeConfirmModal()">Ləğv et</button>
    </div>
  </div>
</div>

<!-- NEW SERVICE CARD MODAL -->
<div class="modal-overlay" id="newServiceModal">
  <div class="modal" style="max-width:520px">
    <h3>➕ Yeni Xidmət Kartı</h3>
    <div class="form-row">
      <div class="form-grp"><label>İkon emoji</label><input type="text" id="newSrvIcon" placeholder="🔧" maxlength="4"></div>
      <div class="form-grp"><label>Başlıq *</label><input type="text" id="newSrvTitle" placeholder="məs. Kompüter Təmiri"></div>
      <div class="form-grp full"><label>Açıqlama *</label><textarea id="newSrvDesc" placeholder="Xidmət haqqında qısa məlumat..."></textarea></div>
      <div class="form-grp"><label>Düymə mətni</label><input type="text" id="newSrvLinkText" placeholder="Sifariş et →"></div>
      <div class="form-grp"><label>Düymə linki</label><input type="text" id="newSrvLink" placeholder="#order"></div>
    </div>
    <div class="modal-actions">
      <button class="save-btn" onclick="confirmAddServiceCard()">💾 Əlavə et</button>
      <button class="cancel-btn" onclick="closeNewServiceModal()">Ləğv et</button>
    </div>
  </div>
</div>

<!-- SERVICE CARD DELETE CONFIRM MODAL -->
<div class="modal-overlay" id="srvDeleteModal">
  <div class="modal" style="max-width:400px;text-align:center">
    <div style="font-size:2.5rem;margin-bottom:12px">🗑️</div>
    <h3>Xidmət kartını sil?</h3>
    <p style="color:var(--muted);font-size:0.88rem;margin:12px 0 28px">"<span id="deleteSrvName"></span>" kartını silmək istədiyinizə əminsiniz? Bu əməliyyat geri alına bilməz.</p>
    <div class="modal-actions">
      <button class="save-btn" style="background:var(--red);box-shadow:none" onclick="confirmRemoveServiceCard()">Bəli, sil</button>
      <button class="cancel-btn" onclick="closeSrvDeleteModal()">Ləğv et</button>
    </div>
  </div>
</div>

<!-- CLEAR ALL ORDERS CONFIRM MODAL -->
<div class="modal-overlay" id="clearOrdersModal">
  <div class="modal" style="max-width:400px;text-align:center">
    <div style="font-size:2.5rem;margin-bottom:12px">⚠️</div>
    <h3>Bütün sifarişləri sil?</h3>
    <p style="color:var(--muted);font-size:0.88rem;margin:12px 0 28px">Bütün sifarişlər birdəfəlik silinəcək. Bu əməliyyat geri alına bilməz.</p>
    <div class="modal-actions">
      <button class="save-btn" style="background:var(--red);box-shadow:none" onclick="confirmClearOrders()">Bəli, hamısını sil</button>
      <button class="cancel-btn" onclick="closeClearOrdersModal()">Ləğv et</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
  // ===== AUTH =====
  const ADMIN_USER = 'Rufat';
  const ADMIN_PASS = 'totuTbrufuzor26';
  const AUTH_KEY = 'tb_admin_auth';

  function enterAdmin() {
    document.getElementById('loginScreen').style.display = 'none';
    document.getElementById('adminPanel').style.display = 'flex';
    const hash = (location.hash || '').replace('#', '');
    const initial = hash && hash !== 'login' && document.getElementById('page' + hash.charAt(0).toUpperCase() + hash.slice(1)) ? hash : 'dashboard';
    showPage(initial);
  }
  function showLoginHash() {
    try { history.replaceState(null, '', '#login'); } catch {}
  }

  function doLogin() {
    const u = document.getElementById('loginUser').value.trim();
    const p = document.getElementById('loginPass').value.trim();
    if (u === ADMIN_USER && p === ADMIN_PASS) {
      try { localStorage.setItem(AUTH_KEY, '1'); } catch {}
      enterAdmin();
    } else {
      document.getElementById('loginErr').style.display = 'block';
    }
  }
  function doLogout() {
    try { localStorage.removeItem(AUTH_KEY); } catch {}
    document.getElementById('adminPanel').style.display = 'none';
    document.getElementById('loginScreen').style.display = 'flex';
    document.getElementById('loginUser').value = '';
    document.getElementById('loginPass').value = '';
    showLoginHash();
  }

  // Auto-login if already logged in earlier; otherwise show #login in URL
  try {
    if (localStorage.getItem(AUTH_KEY) === '1') {
      document.addEventListener('DOMContentLoaded', enterAdmin);
    } else {
      document.addEventListener('DOMContentLoaded', showLoginHash);
    }
  } catch {}

  // ===== API HELPERS =====
  async function apiGet(section) {
    const res = await fetch('/api/site/' + section, { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error('Fetch failed: ' + res.status);
    return await res.json();
  }
  async function apiSave(section, data) {
    const res = await fetch('/api/site/' + section, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Admin-Password': ADMIN_PASS,
      },
      body: JSON.stringify(data),
    });
    if (!res.ok) throw new Error('Save failed: ' + res.status);
    return await res.json();
  }

  // ===== IN-MEMORY CACHE =====
  // products and orders are stored server-side as {list: [...], ...sectionMeta}.
  // We cache the products list locally so multiple CRUD ops are responsive,
  // then persist via apiSave on every mutation.
  let productsState = null; // current full products payload (with .list)

  async function loadProductsState() {
    productsState = await apiGet('products');
    if (!Array.isArray(productsState.list)) productsState.list = [];
    return productsState;
  }
  async function getProducts() {
    if (productsState === null) await loadProductsState();
    return productsState.list;
  }
  async function saveProducts(arr) {
    if (productsState === null) await loadProductsState();
    productsState = { ...productsState, list: arr };
    await apiSave('products', productsState);
  }

  // ===== NAV =====
  const VALID_PAGES = ['dashboard','orders','hero','services','why','about','contact','products','add'];

  async function showPage(name, el) {
    if (!VALID_PAGES.includes(name)) name = 'dashboard';
    // Əgər artıq başqa bölmədəyiksə və yeni bölməyə keçid baş verirsə → səhifəni tam yenilə
    const currentHash = (location.hash || '').replace('#', '');
    if (currentHash && currentHash !== 'login' && currentHash !== name && VALID_PAGES.includes(currentHash)) {
      location.hash = '#' + name;
      location.reload();
      return;
    }
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    const pageEl = document.getElementById('page' + name.charAt(0).toUpperCase() + name.slice(1));
    if (pageEl) pageEl.classList.add('active');
    if (!el) el = document.querySelector(`[data-page=${name}]`);
    if (el) el.classList.add('active');
    try { history.replaceState(null, '', '#' + name); } catch {}
    window.scrollTo({ top: 0, behavior: 'smooth' });
    try {
      if (name === 'dashboard') await renderDashboard();
      if (name === 'products') await renderProductTable();
      if (name === 'add') {
        document.getElementById('formTitle').textContent = 'Yeni Məhsul Əlavə Et';
        document.getElementById('editId').value = '';
        ['fName','fCat','fPrice','fEmoji','fDesc'].forEach(id => {
          const el = document.getElementById(id);
          if (el) el.value = '';
        });
        const unitEl = document.getElementById('fUnit');
        if (unitEl) unitEl.value = 'ədəd';
      }
      if (name === 'orders') await renderOrders();
      if (name === 'hero') await loadHero();
      if (name === 'services') await loadServices();
      if (name === 'why') await loadWhy();
      if (name === 'about') await loadAbout();
      if (name === 'contact') await loadContact();
    } catch (e) {
      showToast('❌ Server xətası: ' + e.message, true);
    }
  }

  // ===== DASHBOARD =====
  const catLabels = { komputer: '💻 Kompüterlər', printer: '🖨️ Printerlər', proyektor: '📽️ Proyektorlar', aksesuar: '🖱️ Aksesuarlar' };
  const _charts = {};

  async function renderDashboard() {
    const products = await getProducts();
    const stats = await fetch('/api/stats').then(r => r.json()).catch(() => null);
    if (!stats) { showToast('❌ Statistika yüklənmədi', true); return; }

    const s = stats.summary;
    document.getElementById('statsRow').innerHTML = `
      <div class="stat-card"><div class="label">Bu ay sifariş</div><div class="value">${s.monthOrders}<span></span></div></div>
      <div class="stat-card"><div class="label">Bu ay ziyarətçi</div><div class="value">${s.monthVisits}<span></span></div></div>
      <div class="stat-card"><div class="label">Ümumi məhsul</div><div class="value">${s.totalProducts}<span>+</span></div></div>
      <div class="stat-card"><div class="label">Ümumi sifariş</div><div class="value">${s.totalOrders}<span></span></div></div>
    `;

    renderChartMonthly(stats.monthly);
    renderChartByCat(stats.byCat);
    renderChartWeekly(stats.weekly);
    renderChartByService(stats.byService);

    const recent = products.slice(-5).reverse();
    document.getElementById('recentTableBody').innerHTML = recent.length
      ? recent.map(p => `<tr>
          <td>${p.emoji || '📦'} ${p.name}</td>
          <td><span class="cat-badge">${p.cat}</span></td>
          <td class="price-cell">${p.price} ₼</td>
          <td><div class="action-btns">
            <button class="edit-btn" onclick="editProduct(${p.id})">✏️ Redaktə</button>
            <button class="del-btn" onclick="openDeleteModal(${p.id})">🗑️</button>
          </div></td>
        </tr>`).join('')
      : '<tr><td colspan="4"><div class="empty-state"><div class="ico">📭</div><p>Hələ heç bir məhsul yoxdur</p></div></td></tr>';
  }

  function destroyChart(key) {
    if (_charts[key]) { _charts[key].destroy(); delete _charts[key]; }
  }

  function chartTheme() {
    return {
      grid: 'rgba(123,141,176,0.15)',
      ticks: '#7B8DB0',
      legend: '#E8EEFF',
      font: { size: 10 },
      legendFont: { size: 11 },
    };
  }

  function renderChartMonthly(data) {
    destroyChart('monthly');
    const ctx = document.getElementById('chartMonthly').getContext('2d');
    const t = chartTheme();
    _charts.monthly = new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.labels,
        datasets: [
          { label: 'Sifariş', data: data.orders, borderColor: '#0057FF', backgroundColor: 'rgba(0,87,255,0.15)', tension: 0.35, fill: true, borderWidth: 2 },
          { label: 'Ziyarətçi', data: data.visits, borderColor: '#00C2FF', backgroundColor: 'rgba(0,194,255,0.10)', tension: 0.35, fill: true, borderWidth: 2 },
        ],
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { labels: { color: t.legend, font: t.legendFont, boxWidth: 10 } } },
        scales: {
          x: { ticks: { color: t.ticks, font: t.font }, grid: { color: t.grid } },
          y: { ticks: { color: t.ticks, precision: 0, font: t.font }, grid: { color: t.grid }, beginAtZero: true },
        },
      },
    });
  }

  function renderChartByCat(byCat) {
    destroyChart('byCat');
    const ctx = document.getElementById('chartByCat').getContext('2d');
    const t = chartTheme();
    const labels = Object.keys(byCat).map(k => catLabels[k] || k);
    const values = Object.values(byCat);
    _charts.byCat = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels,
        datasets: [{
          data: values,
          backgroundColor: ['#0057FF','#00C2FF','#16a34a','#d97706','#a855f7','#ec4899'],
          borderColor: '#0A1128', borderWidth: 2,
        }],
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { color: t.legend, padding: 8, boxWidth: 10, font: t.legendFont } } },
      },
    });
  }

  function renderChartWeekly(data) {
    destroyChart('weekly');
    const ctx = document.getElementById('chartWeekly').getContext('2d');
    const t = chartTheme();
    _charts.weekly = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [{ label: 'Ziyarətçi', data: data.visits, backgroundColor: 'rgba(0,194,255,0.6)', borderColor: '#00C2FF', borderWidth: 1, borderRadius: 6 }],
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { ticks: { color: t.ticks, font: t.font }, grid: { display: false } },
          y: { ticks: { color: t.ticks, precision: 0, font: t.font }, grid: { color: t.grid }, beginAtZero: true },
        },
      },
    });
  }

  function renderChartByService(byService) {
    destroyChart('byService');
    const ctx = document.getElementById('chartByService').getContext('2d');
    const t = chartTheme();
    const labels = Object.keys(byService);
    const values = Object.values(byService);
    _charts.byService = new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{ label: 'Sifariş sayı', data: values, backgroundColor: 'rgba(0,87,255,0.6)', borderColor: '#0057FF', borderWidth: 1, borderRadius: 6 }],
      },
      options: {
        indexAxis: 'y',
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { ticks: { color: t.ticks, precision: 0, font: t.font }, grid: { color: t.grid }, beginAtZero: true },
          y: { ticks: { color: t.ticks, font: t.font }, grid: { display: false } },
        },
      },
    });
  }

  // ===== ORDERS =====
  let _ordersCache = [];
  let deleteOrderTargetIdx = null;

  async function renderOrders() {
    const data = await apiGet('orders');
    _ordersCache = data.list || [];
    document.getElementById('ordersTableBody').innerHTML = _ordersCache.length
      ? _ordersCache.slice().reverse().map((o, idx) => `<tr>
          <td style="white-space:nowrap;color:var(--muted);font-size:0.8rem">${o.date || '-'}</td>
          <td><strong style="color:var(--white)">${o.name || '-'}</strong></td>
          <td>${o.phone || '-'}</td>
          <td><span class="cat-badge">${o.service || '-'}</span></td>
          <td style="color:var(--muted);font-size:0.82rem;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${o.notes || '-'}</td>
          <td><button class="del-btn" onclick="openOrderDeleteModal(${_ordersCache.length - 1 - idx})">🗑️ Sil</button></td>
        </tr>`).join('')
      : '<tr><td colspan="6"><div class="empty-state"><div class="ico">📭</div><p>Hələ heç bir sifariş yoxdur</p></div></td></tr>';
  }

  function openOrderDeleteModal(idx) {
    const o = _ordersCache[idx];
    if (!o) return;
    deleteOrderTargetIdx = idx;
    document.getElementById('deleteOrderName').textContent = o.name || '';
    document.getElementById('orderDeleteModal').classList.add('open');
  }
  function closeOrderDeleteModal() {
    document.getElementById('orderDeleteModal').classList.remove('open');
    deleteOrderTargetIdx = null;
  }
  async function confirmDeleteOrder() {
    if (deleteOrderTargetIdx === null) return;
    try {
      const data = await apiGet('orders');
      data.list = data.list || [];
      data.list.splice(deleteOrderTargetIdx, 1);
      await apiSave('orders', data);
      closeOrderDeleteModal();
      await renderOrders();
      showToast('🗑️ Sifariş silindi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  function clearAllOrders() {
    if (!_ordersCache.length) { showToast('ℹ️ Silinəcək sifariş yoxdur'); return; }
    document.getElementById('clearOrdersModal').classList.add('open');
  }
  function closeClearOrdersModal() {
    document.getElementById('clearOrdersModal').classList.remove('open');
  }
  async function confirmClearOrders() {
    try {
      await apiSave('orders', { list: [] });
      closeClearOrdersModal();
      await renderOrders();
      showToast('🗑️ Bütün sifarişlər silindi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  // ===== HERO =====
  async function loadHero() {
    const h = await apiGet('hero');
    document.getElementById('heroBadge').value = h.badge || '';
    document.getElementById('heroTitle').value = h.title || '';
    document.getElementById('heroSub').value = h.sub || '';
    document.getElementById('heroBtn1Text').value = h.btn1Text || '';
    document.getElementById('heroBtn1Link').value = h.btn1Link || '';
    document.getElementById('heroBtn2Text').value = h.btn2Text || '';
    document.getElementById('heroBtn2Link').value = h.btn2Link || '';
    (h.stats || []).forEach((s, i) => {
      const n = document.getElementById(`heroStat${i+1}Num`); if (n) n.value = s.num || '';
      const l = document.getElementById(`heroStat${i+1}Lbl`); if (l) l.value = s.label || '';
    });
    (h.devices || []).forEach((d, i) => {
      const e = document.getElementById(`heroDev${i+1}Emoji`); if (e) e.value = d.emoji || '';
      const t = document.getElementById(`heroDev${i+1}Title`); if (t) t.value = d.title || '';
      const ds = document.getElementById(`heroDev${i+1}Desc`); if (ds) ds.value = d.desc || '';
    });
  }
  async function saveHero() {
    const h = {
      badge: document.getElementById('heroBadge').value,
      title: document.getElementById('heroTitle').value,
      sub: document.getElementById('heroSub').value,
      btn1Text: document.getElementById('heroBtn1Text').value,
      btn1Link: document.getElementById('heroBtn1Link').value,
      btn2Text: document.getElementById('heroBtn2Text').value,
      btn2Link: document.getElementById('heroBtn2Link').value,
      stats: [1,2,3].map(i => ({ num: document.getElementById(`heroStat${i}Num`).value, label: document.getElementById(`heroStat${i}Lbl`).value })),
      devices: [1,2,3].map(i => ({ emoji: document.getElementById(`heroDev${i}Emoji`).value, title: document.getElementById(`heroDev${i}Title`).value, desc: document.getElementById(`heroDev${i}Desc`).value })),
    };
    try { await apiSave('hero', h); showToast('✅ Hero bölməsi yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== SERVICES =====
  async function loadServices() {
    const s = await apiGet('services');
    document.getElementById('srvEyebrow').value = s.eyebrow || '';
    document.getElementById('srvTitle').value = s.title || '';
    document.getElementById('srvSub').value = s.sub || '';
    renderServiceCards(s.cards || []);
  }
  function renderServiceCards(cards) {
    const c = document.getElementById('servicesCardsContainer');
    c.innerHTML = '<div class="panel"><h3>Xidmət Kartları <small>(' + cards.length + ' ədəd)</small></h3>' +
      cards.map((card, i) => `
        <div class="item-row" data-srv-idx="${i}">
          <div class="item-row-header">
            <span class="item-row-title">Kart #${i+1}</span>
            <button class="item-row-del" onclick="removeServiceCard(${i})">🗑️ Sil</button>
          </div>
          <div class="form-row">
            <div class="form-grp"><label>İkon emoji</label><input type="text" value="${escapeAttr(card.icon)}" data-fld="icon" maxlength="4"></div>
            <div class="form-grp"><label>Başlıq</label><input type="text" value="${escapeAttr(card.title)}" data-fld="title"></div>
            <div class="form-grp full"><label>Açıqlama</label><textarea data-fld="desc">${escapeHtml(card.desc)}</textarea></div>
            <div class="form-grp"><label>Düymə mətni</label><input type="text" value="${escapeAttr(card.linkText)}" data-fld="linkText"></div>
            <div class="form-grp"><label>Düymə linki</label><input type="text" value="${escapeAttr(card.link)}" data-fld="link"></div>
          </div>
        </div>
      `).join('') + '</div>';
  }
  function collectServiceCards() {
    return Array.from(document.querySelectorAll('[data-srv-idx]')).map(row => {
      const get = fld => row.querySelector(`[data-fld="${fld}"]`).value;
      return { icon: get('icon'), title: get('title'), desc: get('desc'), linkText: get('linkText'), link: get('link') };
    });
  }
  function addServiceCard() {
    ['newSrvIcon','newSrvTitle','newSrvDesc','newSrvLinkText','newSrvLink'].forEach(id => {
      const el = document.getElementById(id); if (el) el.value = '';
    });
    document.getElementById('newSrvLinkText').value = 'Sifariş et →';
    document.getElementById('newSrvLink').value = '#order';
    document.getElementById('newServiceModal').classList.add('open');
    setTimeout(() => document.getElementById('newSrvTitle').focus(), 100);
  }
  function closeNewServiceModal() {
    document.getElementById('newServiceModal').classList.remove('open');
  }
  function confirmAddServiceCard() {
    const icon = document.getElementById('newSrvIcon').value.trim() || '✨';
    const title = document.getElementById('newSrvTitle').value.trim();
    const desc = document.getElementById('newSrvDesc').value.trim();
    const linkText = document.getElementById('newSrvLinkText').value.trim() || 'Sifariş et →';
    const link = document.getElementById('newSrvLink').value.trim() || '#order';
    if (!title || !desc) { showToast('❌ Başlıq və açıqlama mütləqdir', true); return; }
    const cards = collectServiceCards();
    cards.push({ icon, title, desc, linkText, link });
    renderServiceCards(cards);
    closeNewServiceModal();
    showToast('✅ Kart əlavə edildi. Yadda saxla düyməsini unutma!');
  }

  let _srvDeleteIdx = null;
  function removeServiceCard(idx) {
    const cards = collectServiceCards();
    const card = cards[idx];
    if (!card) return;
    _srvDeleteIdx = idx;
    document.getElementById('deleteSrvName').textContent = card.title || '(adsız)';
    document.getElementById('srvDeleteModal').classList.add('open');
  }
  function closeSrvDeleteModal() {
    document.getElementById('srvDeleteModal').classList.remove('open');
    _srvDeleteIdx = null;
  }
  function confirmRemoveServiceCard() {
    if (_srvDeleteIdx === null) return;
    const cards = collectServiceCards();
    cards.splice(_srvDeleteIdx, 1);
    renderServiceCards(cards);
    closeSrvDeleteModal();
    showToast('🗑️ Kart silindi. Yadda saxla düyməsini unutma!');
  }
  async function saveServices() {
    const s = {
      eyebrow: document.getElementById('srvEyebrow').value,
      title: document.getElementById('srvTitle').value,
      sub: document.getElementById('srvSub').value,
      cards: collectServiceCards(),
    };
    try { await apiSave('services', s); showToast('✅ Xidmətlər bölməsi yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== WHY US =====
  async function loadWhy() {
    const w = await apiGet('why');
    document.getElementById('whyEyebrow').value = w.eyebrow || '';
    document.getElementById('whyTitle').value = w.title || '';
    document.getElementById('whySub').value = w.sub || '';
    renderWhyFeatures(w.features || []);
    renderWhyMetrics(w.metrics || []);
  }
  function renderWhyFeatures(items) {
    document.getElementById('whyFeaturesContainer').innerHTML = items.map((f, i) => `
      <div class="item-row" data-why-feat="${i}">
        <div class="item-row-header">
          <span class="item-row-title">Üstünlük #${i+1}</span>
          <button class="item-row-del" onclick="removeWhyFeature(${i})">🗑️</button>
        </div>
        <div class="form-row">
          <div class="form-grp"><label>İkon</label><input type="text" value="${escapeAttr(f.icon)}" data-fld="icon" maxlength="4"></div>
          <div class="form-grp"><label>Başlıq</label><input type="text" value="${escapeAttr(f.title)}" data-fld="title"></div>
          <div class="form-grp full"><label>Açıqlama</label><textarea data-fld="desc">${escapeHtml(f.desc)}</textarea></div>
        </div>
      </div>
    `).join('');
  }
  function collectWhyFeatures() {
    return Array.from(document.querySelectorAll('[data-why-feat]')).map(row => {
      const get = fld => row.querySelector(`[data-fld="${fld}"]`).value;
      return { icon: get('icon'), title: get('title'), desc: get('desc') };
    });
  }
  function addWhyFeature() {
    const items = collectWhyFeatures();
    items.push({ icon: '✨', title: 'Yeni üstünlük', desc: 'Açıqlama...' });
    renderWhyFeatures(items);
  }
  async function removeWhyFeature(idx) {
    const items = collectWhyFeatures();
    const it = items[idx];
    if (!it) return;
    const ok = await confirmAction({
      title: 'Üstünlüyü sil?',
      message: `"${it.title || '(adsız)'}" üstünlüyünü silmək istədiyinizə əminsiniz?`,
    });
    if (!ok) return;
    items.splice(idx, 1);
    renderWhyFeatures(items);
    showToast('🗑️ Üstünlük silindi. Yadda saxla düyməsini unutma!');
  }
  function renderWhyMetrics(items) {
    document.getElementById('whyMetricsContainer').innerHTML = items.map((m, i) => `
      <div class="item-row" data-why-met="${i}">
        <div class="item-row-header">
          <span class="item-row-title">Metrika #${i+1}</span>
          <button class="item-row-del" onclick="removeWhyMetric(${i})">🗑️</button>
        </div>
        <div class="form-row three">
          <div class="form-grp"><label>Rəqəm</label><input type="text" value="${escapeAttr(m.num)}" data-fld="num"></div>
          <div class="form-grp"><label>Şəkilçi (+, %, il...)</label><input type="text" value="${escapeAttr(m.suffix)}" data-fld="suffix"></div>
          <div class="form-grp"><label>Etiket</label><input type="text" value="${escapeAttr(m.label)}" data-fld="label"></div>
        </div>
      </div>
    `).join('');
  }
  function collectWhyMetrics() {
    return Array.from(document.querySelectorAll('[data-why-met]')).map(row => {
      const get = fld => row.querySelector(`[data-fld="${fld}"]`).value;
      return { num: get('num'), suffix: get('suffix'), label: get('label') };
    });
  }
  function addWhyMetric() {
    const items = collectWhyMetrics();
    items.push({ num: '100', suffix: '+', label: 'Yeni metrika' });
    renderWhyMetrics(items);
  }
  async function removeWhyMetric(idx) {
    const items = collectWhyMetrics();
    const it = items[idx];
    if (!it) return;
    const ok = await confirmAction({
      title: 'Metrikanı sil?',
      message: `"${it.label || '(adsız)'}" metrikasını silmək istədiyinizə əminsiniz?`,
    });
    if (!ok) return;
    items.splice(idx, 1);
    renderWhyMetrics(items);
    showToast('🗑️ Metrika silindi. Yadda saxla düyməsini unutma!');
  }
  async function saveWhy() {
    const w = {
      eyebrow: document.getElementById('whyEyebrow').value,
      title: document.getElementById('whyTitle').value,
      sub: document.getElementById('whySub').value,
      features: collectWhyFeatures(),
      metrics: collectWhyMetrics(),
    };
    try { await apiSave('why', w); showToast('✅ Niyə Biz bölməsi yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== ABOUT =====
  async function loadAbout() {
    const a = await apiGet('about');
    Object.keys(a).forEach(k => {
      const el = document.getElementById('ab' + k.charAt(0).toUpperCase() + k.slice(1));
      if (el) el.value = a[k] || '';
    });
  }
  async function saveAbout() {
    const ids = ['Badge1','Badge2','Badge3','Title','Text','BtnText','BtnLink','Icon','CenterName','CenterAddr','Met1Num','Met1Lbl','Met2Num','Met2Lbl'];
    const a = {};
    ids.forEach(id => {
      const key = id.charAt(0).toLowerCase() + id.slice(1);
      a[key] = document.getElementById('ab' + id).value;
    });
    try { await apiSave('about', a); showToast('✅ Haqqımızda bölməsi yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== CONTACT =====
  async function loadContact() {
    const c = await apiGet('contact');
    const map = { Eyebrow:'eyebrow', Title:'title', Sub:'sub', Addr:'addr', AddrNote:'addrNote', Phone:'phone', Hours:'hours', Email:'email', Whatsapp:'whatsapp', MapSrc:'mapSrc' };
    Object.entries(map).forEach(([id, key]) => {
      const el = document.getElementById('ct' + id);
      if (el) el.value = c[key] || '';
    });
  }
  async function saveContact() {
    const map = { Eyebrow:'eyebrow', Title:'title', Sub:'sub', Addr:'addr', AddrNote:'addrNote', Phone:'phone', Hours:'hours', Email:'email', Whatsapp:'whatsapp', MapSrc:'mapSrc' };
    const c = {};
    Object.entries(map).forEach(([id, key]) => {
      c[key] = document.getElementById('ct' + id).value;
    });
    try { await apiSave('contact', c); showToast('✅ Əlaqə bölməsi yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== PRODUCT TABLE =====
  async function renderProductTable() {
    const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const cat = document.getElementById('catFilter')?.value || '';
    let products = await getProducts();
    if (q) products = products.filter(p => p.name.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));
    if (cat) products = products.filter(p => p.cat === cat);
    document.getElementById('productCountLabel').textContent = `Cəmi ${products.length} məhsul`;
    document.getElementById('productTableBody').innerHTML = products.length
      ? products.map(p => `<tr>
          <td style="font-size:1.5rem">${p.emoji || '📦'}</td>
          <td><strong style="color:var(--white)">${p.name}</strong></td>
          <td><span class="cat-badge">${catLabels[p.cat] || p.cat}</span></td>
          <td class="price-cell">${p.price} ₼<span style="font-size:0.75rem;color:var(--muted);font-weight:400"> /${p.unit}</span></td>
          <td style="color:var(--muted);font-size:0.82rem;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${p.desc}</td>
          <td><div class="action-btns">
            <button class="edit-btn" onclick="editProduct(${p.id})">✏️ Redaktə</button>
            <button class="del-btn" onclick="openDeleteModal(${p.id})">🗑️ Sil</button>
          </div></td>
        </tr>`).join('')
      : '<tr><td colspan="6"><div class="empty-state"><div class="ico">🔍</div><p>Heç bir məhsul tapılmadı</p></div></td></tr>';
  }

  // ===== ADD / EDIT PRODUCT =====
  async function saveProduct() {
    const name = document.getElementById('fName').value.trim();
    const cat  = document.getElementById('fCat').value;
    const price= document.getElementById('fPrice').value.trim();
    const emoji= document.getElementById('fEmoji').value.trim() || '📦';
    const desc = document.getElementById('fDesc').value.trim();
    const unit = document.getElementById('fUnit').value;
    const editId = document.getElementById('editId').value;

    if (!name || !cat || !price || !desc) { showToast('❌ Bütün məcburi sahələri doldurun!', true); return; }

    try {
      const products = (await getProducts()).slice();
      if (editId) {
        const idx = products.findIndex(p => p.id == editId);
        if (idx > -1) { products[idx] = { ...products[idx], name, cat, price, emoji, desc, unit }; }
        await saveProducts(products);
        showToast('✅ Məhsul yeniləndi!');
      } else {
        const newId = products.length ? Math.max(...products.map(p => p.id)) + 1 : 1;
        products.push({ id: newId, name, cat, price, emoji, desc, unit });
        await saveProducts(products);
        showToast('✅ Məhsul əlavə edildi!');
      }
      clearForm();
      await showPage('products', document.querySelector('[data-page=products]'));
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }
  async function editProduct(id) {
    const products = await getProducts();
    const p = products.find(x => x.id === id);
    if (!p) return;
    // showPage('add', ...) ilkin olaraq editId-i təmizləyir, ona görə əvvəl səhifəni keç,
    // SONRA fieldləri doldur.
    await showPage('add', document.querySelector('[data-page=add]'));
    document.getElementById('editId').value = p.id;
    document.getElementById('fName').value = p.name;
    document.getElementById('fCat').value = p.cat;
    document.getElementById('fPrice').value = p.price;
    document.getElementById('fEmoji').value = p.emoji || '';
    document.getElementById('fDesc').value = p.desc;
    document.getElementById('fUnit').value = p.unit || 'ədəd';
    document.getElementById('formTitle').textContent = '✏️ Məhsulu Redaktə Et';
  }
  function clearForm() {
    ['fName','fCat','fPrice','fEmoji','fDesc','fUnit'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    document.getElementById('editId').value = '';
    document.getElementById('formTitle').textContent = 'Yeni Məhsul Əlavə Et';
  }

  // ===== DELETE =====
  let deleteTargetId = null;
  async function openDeleteModal(id) {
    const products = await getProducts();
    const p = products.find(x => x.id === id);
    if (!p) return;
    deleteTargetId = id;
    document.getElementById('deleteProductName').textContent = p.name;
    document.getElementById('deleteModal').classList.add('open');
  }
  function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    deleteTargetId = null;
  }
  async function confirmDelete() {
    if (!deleteTargetId) return;
    try {
      const products = (await getProducts()).filter(p => p.id !== deleteTargetId);
      await saveProducts(products);
      closeDeleteModal();
      await renderProductTable();
      await renderDashboard();
      showToast('🗑️ Məhsul silindi!');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  // ===== HELPERS =====
  function escapeHtml(s) { return (s ?? '').toString().replace(/[&<>]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[c])); }
  function escapeAttr(s) { return (s ?? '').toString().replace(/"/g, '&quot;'); }

  // Generic confirm modal — promise-based
  function confirmAction({ title = 'Silmək istəyirsiniz?', message = 'Bu əməliyyat geri alına bilməz.', icon = '🗑️', okText = 'Bəli, sil' } = {}) {
    return new Promise(resolve => {
      document.getElementById('confirmModalIcon').textContent = icon;
      document.getElementById('confirmModalTitle').textContent = title;
      document.getElementById('confirmModalMsg').textContent = message;
      const ok = document.getElementById('confirmModalOk');
      ok.textContent = okText;
      const modal = document.getElementById('confirmModal');
      const cleanup = () => { ok.onclick = null; modal.classList.remove('open'); };
      ok.onclick = () => { cleanup(); resolve(true); };
      modal._cancel = () => { cleanup(); resolve(false); };
      modal.classList.add('open');
    });
  }
  function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    if (modal._cancel) modal._cancel(); else modal.classList.remove('open');
  }
  function showToast(msg, isError = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast' + (isError ? ' error' : '');
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  async function renderAll() { try { await renderDashboard(); } catch (e) { showToast('❌ ' + e.message, true); } }
</script>
</body>
</html>
