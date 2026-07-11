@php
    $activePage = $activePage ?? 'dashboard';
    $nav = [
        ['dashboard',    '📊', 'İdarə Paneli'],
        ['orders',       '📋', 'Sifarişlər'],
        ['hero',         '🎯', 'Hero'],
        ['trust',        '🛡️', 'Zəmanətlər'],
        ['services',     '🛠️', 'Xidmətlər'],
        ['why',          '⭐', 'Niyə Biz?'],
        ['about',        'ℹ️', 'Haqqımızda'],
        ['contact',      '📞', 'Əlaqə'],
        ['products',     '📦', 'Məhsullar'],
        ['categories',   '🗂️', 'Kateqoriyalar'],
        ['add',          '➕', 'Yeni Məhsul'],
        ['testimonials', '⭐', 'Müştəri Rəyləri'],
    ];
@endphp
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<script>(function(){try{var t=localStorage.getItem('tb_theme')||'dark';document.documentElement.setAttribute('data-theme',t);}catch(e){}})();</script>
<title>Texnobəy – Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --night: #080D1A; --deep: #0A1128; --card: #111827;
    --border: #1E2D4A; --blue: #0057FF; --cyan: #00C2FF;
    --text: #E8EEFF; --muted: #7B8DB0; --white: #FFFFFF;
    --green: #16a34a; --red: #dc2626; --orange: #d97706;
    --card-soft: rgba(255,255,255,0.04);
    --input-bg: rgba(255,255,255,0.04);
    --shadow: 0 4px 20px rgba(0,0,0,0.4);
  }
  [data-theme="light"] {
    --night: #F5F7FB; --deep: #FFFFFF; --card: #FFFFFF;
    --border: #E4E9F2; --text: #1E2D4A; --muted: #6B7280; --white: #0A1128;
    --card-soft: #F8FAFC;
    --input-bg: #F8FAFC;
    --shadow: 0 4px 20px rgba(0,0,0,0.08);
  }
  body { background: var(--night); color: var(--text); font-family: 'Inter', sans-serif; min-height: 100vh; transition: background 0.25s, color 0.25s; }

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
    text-decoration: none;
  }
  .sidebar-logo-icon {
    width: 32px; height: 32px; display: grid; place-items: center;
  }
  .sidebar-logo-icon img, .sidebar-logo-icon svg { width: 100%; height: 100%; display: block; }
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
    text-decoration: none;
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
  .main-content { margin-left: 240px; padding: 92px 32px 32px; flex: 1; position: relative; }

  /* TOP NAVBAR */
  .admin-topbar {
    position: fixed; top: 0; left: 240px; right: 0; z-index: 500;
    height: 62px; padding: 0 32px;
    display: flex; align-items: center; justify-content: space-between; gap: 16px;
    background: color-mix(in srgb, var(--deep) 88%, transparent);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--border);
  }
  .topbar-home {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent; border: 1px solid var(--border);
    color: var(--text); padding: 8px 16px; border-radius: 100px;
    font-size: 0.9rem; font-weight: 600; font-family: inherit; cursor: pointer;
    text-decoration: none;
    transition: border-color 0.2s, background 0.2s, color 0.2s;
  }
  .topbar-home:hover { border-color: var(--blue); color: var(--white); background: rgba(0,87,255,0.08); }
  .topbar-home-ico { font-size: 1rem; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .theme-toggle {
    width: 40px; height: 40px; border-radius: 50%;
    background: transparent; border: 1px solid var(--border);
    color: var(--text); font-size: 1.1rem; cursor: pointer; font-family: inherit;
    display: inline-flex; align-items: center; justify-content: center;
    transition: border-color 0.2s, background 0.2s, transform 0.2s;
  }
  .theme-toggle:hover { border-color: var(--blue); background: rgba(0,87,255,0.08); transform: rotate(20deg); }

  /* USER BADGE */
  .user-badge {
    display: flex; align-items: center; gap: 10px;
    background: var(--card-soft); border: 1px solid var(--border);
    border-radius: 100px; padding: 5px 16px 5px 5px; cursor: pointer;
    text-decoration: none; color: inherit;
    transition: border-color 0.2s, background 0.2s;
  }
  .user-badge:hover { border-color: var(--blue); background: rgba(0,87,255,0.08); }
  .user-badge-avatar {
    width: 36px; height: 36px; border-radius: 50%; overflow: hidden;
    background: linear-gradient(135deg, var(--blue), var(--cyan));
    display: inline-flex; align-items: center; justify-content: center;
    color: #FFFFFF; font-weight: 800; font-size: 0.95rem;
    flex-shrink: 0;
  }
  .user-badge-avatar { width: 32px; height: 32px; font-size: 0.85rem; }
  .user-badge-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
  .user-badge-name { color: var(--white); font-weight: 700; font-size: 0.88rem; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
  @media (max-width: 768px) {
    .admin-topbar { left: 200px; padding: 0 20px; }
  }
  @media (max-width: 560px) {
    .admin-topbar { left: 0; padding: 0 14px; }
    .topbar-home { padding: 6px 12px; font-size: 0.82rem; }
    .user-badge { padding: 4px 12px 4px 4px; }
    .user-badge-avatar { width: 28px; height: 28px; font-size: 0.8rem; }
    .user-badge-name { max-width: 90px; font-size: 0.78rem; }
  }

  /* PROFILE PAGE */
  .profile-grid { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }
  @media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } }
  .profile-avatar-box {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; padding: 24px; text-align: center;
  }
  .profile-avatar {
    width: 160px; height: 160px; border-radius: 50%; overflow: hidden;
    background: linear-gradient(135deg, var(--blue), var(--cyan));
    margin: 0 auto 16px; display: flex; align-items: center; justify-content: center;
    color: #FFFFFF; font-weight: 800; font-size: 3.6rem;
    cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
    border: 3px solid var(--border);
  }
  .profile-avatar:hover { transform: scale(1.02); box-shadow: 0 8px 32px rgba(0,87,255,0.3); border-color: var(--blue); }
  .profile-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
  .profile-avatar-hint { color: var(--muted); font-size: 0.78rem; margin-top: 4px; }
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
  .stat-delta {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 10px; font-size: 0.78rem; font-weight: 700;
  }
  .stat-delta small { font-weight: 500; color: var(--muted); }
  .stat-delta.up   { color: #4ade80; }
  .stat-delta.down { color: #f87171; }
  .stat-delta.flat { color: var(--muted); }

  /* Dashboard feeds */
  .dashboard-feeds {
    display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 24px 0;
  }
  @media (max-width: 900px) { .dashboard-feeds { grid-template-columns: 1fr; } }
  .feed { display: flex; flex-direction: column; gap: 10px; max-height: 320px; overflow-y: auto; }
  .feed-row {
    display: flex; align-items: center; gap: 12px;
    padding: 12px; background: rgba(255,255,255,0.02);
    border: 1px solid var(--border); border-radius: 10px;
    transition: border-color 0.2s, background 0.2s;
  }
  .feed-row:hover { border-color: var(--blue); background: rgba(0,87,255,0.06); }
  .feed-avatar, .feed-thumb {
    width: 40px; height: 40px; border-radius: 50%; overflow: hidden;
    background: linear-gradient(135deg, var(--blue), var(--cyan));
    color: #fff; font-weight: 800; font-size: 1rem; flex-shrink: 0;
    display: inline-flex; align-items: center; justify-content: center;
  }
  .feed-thumb { border-radius: 10px; background: rgba(0,0,0,0.25); border: 1px solid var(--border); }
  .feed-thumb img { width: 100%; height: 100%; object-fit: cover; }
  .feed-body { flex: 1; min-width: 0; }
  .feed-title { color: var(--white); font-size: 0.88rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .feed-code { color: var(--cyan); font-family: monospace; font-size: 0.72rem; font-weight: 500; margin-left: 6px; }
  .feed-sub   { color: var(--muted); font-size: 0.76rem; margin-top: 2px; }
  .feed-empty { padding: 30px 12px; text-align: center; color: var(--muted); font-size: 0.85rem; }
  .status-pill-sm {
    padding: 3px 10px; border-radius: 100px; font-size: 0.68rem;
    font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;
  }
  .status-pill-sm.new        { background: rgba(0,194,255,0.15); color: #00c2ff; }
  .status-pill-sm.processing { background: rgba(217,119,6,0.15); color: #fbbf24; }
  .status-pill-sm.shipped    { background: rgba(0,87,255,0.15); color: #60a5fa; }
  .status-pill-sm.delivered  { background: rgba(22,163,74,0.15); color: #4ade80; }
  .status-pill-sm.cancelled  { background: rgba(220,38,38,0.15); color: #f87171; }

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
  .edit-btn, .del-btn, .info-btn {
    padding: 6px 14px; border-radius: 7px; font-size: 0.78rem;
    font-weight: 600; cursor: pointer; border: none; font-family: inherit; transition: opacity 0.2s;
  }
  .edit-btn { background: rgba(0,87,255,0.2); color: var(--cyan); }
  .del-btn { background: rgba(220,38,38,0.15); color: #f87171; }
  .info-btn { background: rgba(0,194,255,0.15); color: #22d3ee; }
  .edit-btn:hover, .del-btn:hover, .info-btn:hover { opacity: 0.75; }
  /* Order detail modal */
  .order-detail-grid { display: grid; grid-template-columns: 130px 1fr; gap: 10px 16px; margin-top: 8px; }
  .order-detail-grid dt { font-size: 0.78rem; color: var(--muted); align-self: center; }
  .order-detail-grid dd { margin: 0; font-size: 0.9rem; color: var(--white); font-weight: 600; word-break: break-word; }
  .order-detail-grid dd a { color: var(--cyan); text-decoration: none; }
  .order-detail-grid dd a:hover { text-decoration: underline; }
  .order-detail-grid dd.notes { font-weight: 500; white-space: pre-wrap; line-height: 1.6; color: var(--muted); }
  .order-detail-track {
    background: rgba(0,194,255,0.08); border: 1px solid rgba(0,194,255,0.25);
    border-radius: 12px; padding: 14px 18px; text-align: center; margin-bottom: 18px;
  }
  .order-detail-track .lbl { font-size: 0.72rem; color: var(--muted); margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
  .order-detail-track .code { font-family: monospace; font-size: 1.35rem; font-weight: 800; color: var(--cyan); letter-spacing: 1px; }
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

  /* IMAGE UPLOADER */
  .img-uploader {
    display: flex; gap: 16px; align-items: center; flex-wrap: wrap;
    background: rgba(255,255,255,0.02); border: 1.5px dashed var(--border);
    border-radius: 10px; padding: 14px;
  }
  .img-preview {
    width: 120px; height: 120px; border-radius: 10px; overflow: hidden;
    background: rgba(0,0,0,0.25); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .img-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
  .img-preview-empty { color: var(--muted); font-size: 0.78rem; text-align: center; padding: 8px; font-weight: 600; }
  .img-preview-clickable { cursor: pointer; transition: border-color 0.2s, background 0.2s; }
  .img-preview-clickable:hover { border-color: var(--blue); background: rgba(0,87,255,0.08); }
  .img-preview-clickable:hover .img-preview-empty { color: var(--cyan); }
  .img-uploader-actions { display: flex; gap: 8px; flex-wrap: wrap; }
  .img-preview-sm {
    width: 44px; height: 44px; border-radius: 8px; overflow: hidden;
    background: rgba(0,0,0,0.25); border: 1px solid var(--border);
    display: inline-flex; align-items: center; justify-content: center; vertical-align: middle;
  }
  .img-preview-sm img { width: 100%; height: 100%; object-fit: cover; display: block; }

  /* GALLERY THUMBNAILS (admin) */
  .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(96px, 1fr)); gap: 10px; }
  .gallery-thumb {
    position: relative; padding-top: 100%; border-radius: 10px; overflow: hidden;
    background: rgba(0,0,0,0.25); border: 1px solid var(--border);
  }
  .gallery-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block; }
  .gallery-thumb-del {
    position: absolute; top: 4px; right: 4px; z-index: 2;
    width: 26px; height: 26px; border-radius: 50%; border: 0;
    background: rgba(220,38,38,0.9); color: #fff; font-size: 0.85rem;
    cursor: pointer; padding: 0; line-height: 1;
    display: inline-flex; align-items: center; justify-content: center;
  }
  .gallery-thumb-del:hover { background: #dc2626; }

  /* STOCK BADGE (admin table) */
  .stock-tag {
    display: inline-block; padding: 3px 10px; border-radius: 100px;
    font-size: 0.72rem; font-weight: 700;
  }
  .stock-tag.in  { background: rgba(22,163,74,0.15); color: #4ade80; }
  .stock-tag.low { background: rgba(217,119,6,0.15); color: #fbbf24; }
  .stock-tag.out { background: rgba(220,38,38,0.15); color: #f87171; }

  /* ORDER STATUS SELECT */
  .order-status-select {
    background: rgba(255,255,255,0.04); border: 1.5px solid var(--border);
    color: var(--white); border-radius: 8px; padding: 6px 10px;
    font-size: 0.82rem; font-family: inherit; outline: none; cursor: pointer;
  }
  .order-status-select option { background: var(--card); }

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
  .modal { position: relative; }
  .modal-close {
    position: absolute; top: 14px; right: 14px;
    width: 34px; height: 34px; border-radius: 8px;
    background: rgba(255,255,255,0.05); border: 1px solid var(--border);
    color: var(--muted); font-size: 1.15rem; font-weight: 700;
    cursor: pointer; font-family: inherit; line-height: 1;
    display: inline-flex; align-items: center; justify-content: center;
    transition: color 0.2s, border-color 0.2s, background 0.2s;
  }
  .modal-close:hover { color: #f87171; border-color: #f87171; background: rgba(220,38,38,0.1); }

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
<div class="login-screen" id="loginScreen" style="display:{{ auth()->check() ? 'none' : 'flex' }}">
  <div class="login-box">
    <div style="font-size:2.5rem;margin-bottom:12px">💻</div>
    <h1>Texnobəy Admin</h1>
    <p>İdarəetmə panelinə daxil olmaq üçün məlumatları daxil edin</p>
    <input type="text" id="loginUser" placeholder="İstifadəçi adı" autocomplete="username" oninput="document.getElementById('loginErr').style.display='none'">
    <input type="password" id="loginPass" placeholder="Şifrə" autocomplete="current-password" oninput="document.getElementById('loginErr').style.display='none'" onkeydown="if(event.key==='Enter')doLogin()">
    <input type="text" id="loginOtp" placeholder="🔐 Google Authenticator 6 rəqəmli kod" autocomplete="one-time-code" inputmode="numeric" maxlength="8" style="display:none;letter-spacing:2px;text-align:center;font-family:monospace" oninput="document.getElementById('loginErr').style.display='none'" onkeydown="if(event.key==='Enter')doLogin()">
    <button class="login-btn" onclick="doLogin()">Daxil ol →</button>
    <div class="login-err" id="loginErr">❌ İstifadəçi adı və ya şifrə yanlışdır</div>
  </div>
</div>

<!-- ADMIN PANEL -->
<div class="admin-layout" id="adminPanel" style="display:{{ auth()->check() ? 'flex' : 'none' }}">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <a class="sidebar-logo" href="{{ url('/admin/dashboard') }}" style="cursor:pointer;text-decoration:none;color:inherit">
      <div class="sidebar-logo-icon"><img src="{{ asset('logo.svg') }}" alt="Texnobəy" loading="lazy"></div>
      Texno<span>bəy</span>
    </a>
    <nav class="sidebar-nav">
      <div class="nav-group-label">Ümumi</div>
      <a class="nav-item {{ $activePage === 'dashboard' ? 'active' : '' }}" data-page="dashboard" href="{{ url('/admin/dashboard') }}">
        <span class="nav-ico">📊</span> İdarə Paneli
      </a>
      <a class="nav-item {{ $activePage === 'orders' ? 'active' : '' }}" data-page="orders" href="{{ url('/admin/orders') }}">
        <span class="nav-ico">📋</span> Sifarişlər
      </a>

      <div class="nav-group-label">Səhifə Bölmələri</div>
      <a class="nav-item {{ $activePage === 'hero' ? 'active' : '' }}" data-page="hero" href="{{ url('/admin/hero') }}">
        <span class="nav-ico">🎯</span> Hero
      </a>
      <a class="nav-item {{ $activePage === 'trust' ? 'active' : '' }}" data-page="trust" href="{{ url('/admin/trust') }}">
        <span class="nav-ico">🛡️</span> Zəmanətlər
      </a>
      <a class="nav-item {{ $activePage === 'services' ? 'active' : '' }}" data-page="services" href="{{ url('/admin/services') }}">
        <span class="nav-ico">🛠️</span> Xidmətlər
      </a>
      <a class="nav-item {{ $activePage === 'why' ? 'active' : '' }}" data-page="why" href="{{ url('/admin/why') }}">
        <span class="nav-ico">⭐</span> Niyə Biz?
      </a>
      <a class="nav-item {{ $activePage === 'about' ? 'active' : '' }}" data-page="about" href="{{ url('/admin/about') }}">
        <span class="nav-ico">ℹ️</span> Haqqımızda
      </a>
      <a class="nav-item {{ $activePage === 'contact' ? 'active' : '' }}" data-page="contact" href="{{ url('/admin/contact') }}">
        <span class="nav-ico">📞</span> Əlaqə
      </a>

      <div class="nav-group-label">Məhsullar</div>
      <a class="nav-item {{ $activePage === 'products' ? 'active' : '' }}" data-page="products" href="{{ url('/admin/products') }}">
        <span class="nav-ico">📦</span> Məhsullar
      </a>
      <a class="nav-item {{ $activePage === 'categories' ? 'active' : '' }}" data-page="categories" href="{{ url('/admin/categories') }}">
        <span class="nav-ico">🗂️</span> Kateqoriyalar
      </a>
      <a class="nav-item {{ $activePage === 'add' ? 'active' : '' }}" data-page="add" href="{{ url('/admin/add') }}">
        <span class="nav-ico">➕</span> Yeni Məhsul
      </a>

      <div class="nav-group-label">Content</div>
      <a class="nav-item {{ $activePage === 'testimonials' ? 'active' : '' }}" data-page="testimonials" href="{{ url('/admin/testimonials') }}">
        <span class="nav-ico">⭐</span> Müştəri Rəyləri
      </a>
    </nav>
    <div class="sidebar-footer">
      <button class="logout-btn" onclick="doLogout()">🚪 Çıxış</button>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main-content">

    <!-- TOP NAVBAR -->
    <header class="admin-topbar">
      <a class="topbar-home" href="{{ url('/admin/dashboard') }}" style="text-decoration:none">
        <span class="topbar-home-ico">🏠</span> Əsas səhifə
      </a>
      <div class="topbar-right">
        <button type="button" class="theme-toggle" id="themeToggle" onclick="toggleTheme()" title="Rejimi dəyiş" aria-label="Rejimi dəyiş">
          <span id="themeToggleIco">🌙</span>
        </button>
        <a class="user-badge" id="userBadge" href="{{ url('/admin/profile') }}" title="Profil" style="text-decoration:none">
          <div class="user-badge-avatar" id="userBadgeAvatar"><span id="userBadgeInitial">?</span></div>
          <div class="user-badge-name" id="userBadgeName">…</div>
        </a>
      </div>
    </header>

    <!-- DASHBOARD -->
    <div class="page{{ $activePage === 'dashboard' ? ' active' : '' }}" id="pageDashboard">
      <div class="page-header">
        <div>
          <h2>İdarə Paneli</h2>
          <p>Texnobəy məhsul idarəetmə sistemi</p>
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

      <div class="dashboard-feeds">
        <div class="panel">
          <h3>📥 Son sifarişlər</h3>
          <div id="recentOrdersFeed" class="feed"></div>
        </div>
        <div class="panel">
          <h3>⚠️ Aşağı ehtiyat xəbərdarlığı</h3>
          <div id="lowStockFeed" class="feed"></div>
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
    <div class="page{{ $activePage === 'orders' ? ' active' : '' }}" id="pageOrders">
      <div class="page-header">
        <div>
          <h2>Gələn Sifarişlər</h2>
          <p>Saytdakı formdan göndərilən sifarişlər</p>
        </div>
        <button class="ghost-btn" onclick="clearAllOrders()">🗑️ Hamısını sil</button>
      </div>
      <div class="info-note">
        ℹ️ <strong>Qeyd:</strong> Formdan gələn sifarişlər verilənlər bazasına yazılır və admin email-inə bildiriş göndərilir. Status dəyişəndə müştəri də email ilə xəbərdar olur.
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr>
            <th>Tarix</th><th>Kod</th><th>Ad</th><th>Telefon</th><th>Xidmət</th><th>Status</th><th>Qeyd</th><th>Əməliyyat</th>
          </tr></thead>
          <tbody id="ordersTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- HERO -->
    <div class="page{{ $activePage === 'hero' ? ' active' : '' }}" id="pageHero">
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
        @foreach ([1, 2, 3] as $i)
        <div class="item-row">
          <div class="item-row-header">
            <span class="item-row-title">Kart #{{ $i }}</span>
          </div>
          <div class="form-row">
            <div class="form-grp"><label>Emoji (şəkil olmadıqda)</label><input type="text" id="heroDev{{ $i }}Emoji" maxlength="4"></div>
            <div class="form-grp"><label>Başlıq</label><input type="text" id="heroDev{{ $i }}Title"></div>
            <div class="form-grp full">
              <label>Kart şəkli (şəkil hissəsinə klikləyin)</label>
              <div class="img-uploader">
                <input type="hidden" id="heroDev{{ $i }}Image">
                <input type="file" id="heroDev{{ $i }}File" accept="image/*" style="display:none" onchange="uploadHeroDeviceImage(this, {{ $i }})">
                <div class="img-preview img-preview-clickable" id="heroDev{{ $i }}Preview" onclick="document.getElementById('heroDev{{ $i }}File').click()" title="Şəkil seçmək üçün klikləyin">
                  <span class="img-preview-empty">➕ Şəkil əlavə et</span>
                </div>
                <div class="img-uploader-actions">
                  <button type="button" class="cancel-btn" onclick="clearHeroDeviceImage({{ $i }})">🗑️ Sil</button>
                </div>
              </div>
            </div>
            <div class="form-grp full"><label>Açıqlama</label><input type="text" id="heroDev{{ $i }}Desc"></div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- TRUST -->
    <div class="page{{ $activePage === 'trust' ? ' active' : '' }}" id="pageTrust">
      <div class="page-header">
        <div>
          <h2>🛡️ Zəmanətlər / Trust Badges</h2>
          <p>Hero altında göstərilən zəmanət kartları</p>
        </div>
        <div style="display:flex;gap:10px">
          <button class="ghost-btn" onclick="addTrustCard()">➕ Yeni kart</button>
          <button class="add-btn" onclick="saveTrust()">💾 Yadda saxla</button>
        </div>
      </div>
      <div class="panel">
        <div class="form-grp">
          <label style="display:flex;align-items:center;gap:10px">
            <input type="checkbox" id="trustEnabled"> Bu bölməni sayta göstər
          </label>
        </div>
      </div>
      <div id="trustCardsContainer"></div>
    </div>

    <!-- SERVICES -->
    <div class="page{{ $activePage === 'services' ? ' active' : '' }}" id="pageServices">
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
    <div class="page{{ $activePage === 'why' ? ' active' : '' }}" id="pageWhy">
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
          <div class="form-grp"><label>Eyebrow</label><input type="text" id="whyEyebrow" placeholder="Niyə Texnobəy?"></div>
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
    <div class="page{{ $activePage === 'about' ? ' active' : '' }}" id="pageAbout">
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
          <div class="form-grp full"><label>Mətn</label><textarea id="abText" placeholder="Texnobəy 2016-cı ildə..."></textarea></div>
          <div class="form-grp"><label>Düymə mətni</label><input type="text" id="abBtnText" placeholder="📞 Bizimlə tanış olun"></div>
          <div class="form-grp"><label>Düymə linki</label><input type="text" id="abBtnLink" placeholder="#contact"></div>
        </div>
      </div>
      <div class="panel">
        <h3>Servis Mərkəzi Kartı</h3>
        <div class="form-row">
          <div class="form-grp"><label>İkon emoji</label><input type="text" id="abIcon" placeholder="🏪" maxlength="4"></div>
          <div class="form-grp"><label>Mərkəz adı</label><input type="text" id="abCenterName" placeholder="Texnobəy Servis Mərkəzi"></div>
          <div class="form-grp full"><label>Ünvan</label><input type="text" id="abCenterAddr" placeholder="Nəsimi rayonu, Bakı şəhəri"></div>
          <div class="form-grp"><label>Metrika 1 rəqəm</label><input type="text" id="abMet1Num" placeholder="12"></div>
          <div class="form-grp"><label>Metrika 1 etiket</label><input type="text" id="abMet1Lbl" placeholder="Texniki mütəxəssis"></div>
          <div class="form-grp"><label>Metrika 2 rəqəm</label><input type="text" id="abMet2Num" placeholder="3"></div>
          <div class="form-grp"><label>Metrika 2 etiket</label><input type="text" id="abMet2Lbl" placeholder="Xidmət sahəsi"></div>
        </div>
      </div>
    </div>

    <!-- CONTACT -->
    <div class="page{{ $activePage === 'contact' ? ' active' : '' }}" id="pageContact">
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
    <div class="page{{ $activePage === 'products' ? ' active' : '' }}" id="pageProducts">
      <div class="page-header">
        <div>
          <h2>📦 Məhsullar</h2>
          <p id="productCountLabel">Cəmi 0 məhsul</p>
        </div>
        <a class="add-btn" href="{{ url('/admin/add') }}" style="text-decoration:none;display:inline-flex;align-items:center;justify-content:center">
          ➕ Yeni məhsul
        </a>
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
            <th>Şəkil</th><th>Məhsul adı</th><th>Kateqoriya</th><th>Qiymət</th><th>Stok</th><th>Açıqlama</th><th>Əməliyyat</th>
          </tr></thead>
          <tbody id="productTableBody"></tbody>
        </table>
      </div>
    </div>

    <!-- ADD / EDIT PRODUCT -->
    <div class="page{{ $activePage === 'add' ? ' active' : '' }}" id="pageAdd">
      <div class="page-header">
        <div>
          <h2 id="formTitle">Yeni Məhsul Əlavə Et</h2>
          <p>Məlumatları doldurun və yadda saxlayın</p>
        </div>
        <a class="ghost-btn" href="{{ url('/admin/products') }}" style="text-decoration:none">← Geri</a>
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
            <label>Ehtiyat sayı (stock)</label>
            <input type="number" id="fStock" min="0" placeholder="0">
          </div>
          <div class="form-grp">
            <label>Emoji ikonu (şəkil olmadıqda göstərilir)</label>
            <input type="text" id="fEmoji" placeholder="məs. 🖨️" maxlength="4">
          </div>
          <div class="form-grp full">
            <label>Əsas şəkil</label>
            <div class="img-uploader" id="fImageBox">
              <input type="hidden" id="fImage">
              <input type="file" id="fImageFile" accept="image/*" style="display:none" onchange="uploadProductImage(this)">
              <div class="img-preview img-preview-clickable" id="fImagePreview" onclick="document.getElementById('fImageFile').click()" title="Şəkil seçmək üçün klikləyin">
                <span class="img-preview-empty">➕ Şəkil əlavə et</span>
              </div>
              <div class="img-uploader-actions">
                <button type="button" class="cancel-btn" onclick="clearProductImage()">🗑️ Sil</button>
              </div>
            </div>
          </div>
          <div class="form-grp full">
            <label>Əlavə şəkillər (galery)</label>
            <input type="file" id="fGalleryFile" accept="image/*" multiple style="display:none" onchange="uploadGalleryImages(this, 'f')">
            <div class="gallery-grid" id="fGalleryGrid"></div>
            <button type="button" class="ghost-btn" onclick="document.getElementById('fGalleryFile').click()" style="margin-top:8px">➕ Şəkil əlavə et</button>
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

    <!-- PROFILE -->
    <div class="page{{ $activePage === 'profile' ? ' active' : '' }}" id="pageProfile">
      <div class="page-header">
        <div>
          <h2>👤 Profil</h2>
          <p>İstifadəçi məlumatlarını idarə et</p>
        </div>
      </div>
      <div class="profile-grid">
        <div class="profile-avatar-box">
          <input type="file" id="profAvatarFile" accept="image/*" style="display:none" onchange="uploadProfileAvatar(this)">
          <div class="profile-avatar" id="profAvatar" onclick="document.getElementById('profAvatarFile').click()" title="Avatarı dəyişmək üçün klikləyin">
            <span id="profAvatarInitial">?</span>
          </div>
          <div class="profile-avatar-hint">Yükləmək üçün şəklə klikləyin</div>
          <button type="button" class="cancel-btn" style="margin-top:12px;width:100%" onclick="removeProfileAvatar()">🗑️ Avatarı sil</button>
        </div>
        <div>
          <div class="panel">
            <h3>👤 Ümumi məlumatlar</h3>
            <div class="form-row">
              <div class="form-grp full">
                <label>İstifadəçi adı</label>
                <input type="text" id="profName" autocomplete="username">
              </div>
              <div class="form-grp full">
                <label>Email</label>
                <input type="email" id="profEmail" autocomplete="email">
              </div>
            </div>
            <div class="modal-actions">
              <button class="save-btn" onclick="saveProfile()">💾 Yadda Saxla</button>
              <button class="cancel-btn" onclick="loadProfile()">↺ Geri qaytar</button>
            </div>
          </div>

          <div class="panel">
            <h3>🔒 Şifrəni dəyiş</h3>
            <div class="form-row">
              <div class="form-grp full">
                <label>Cari şifrə</label>
                <input type="password" id="profCurPass" autocomplete="current-password">
              </div>
              <div class="form-grp">
                <label>Yeni şifrə (min 6 simvol)</label>
                <input type="password" id="profNewPass" autocomplete="new-password">
              </div>
              <div class="form-grp">
                <label>Yeni şifrə (təkrar)</label>
                <input type="password" id="profNewPass2" autocomplete="new-password">
              </div>
            </div>
            <div class="modal-actions">
              <button class="save-btn" onclick="changePassword()">🔐 Şifrəni dəyiş</button>
              <button class="cancel-btn" onclick="clearPassFields()">Təmizlə</button>
            </div>
          </div>

          <div class="panel">
            <h3>🔐 Google Authenticator (2FA)
              <small id="twofaStatusPill" style="margin-left:auto"></small>
            </h3>
            <div id="twofaBody">
              <div style="color:var(--muted);font-size:0.88rem">Yüklənir…</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CATEGORIES -->
    <div class="page{{ $activePage === 'categories' ? ' active' : '' }}" id="pageCategories">
      <div class="page-header">
        <div>
          <h2>🗂️ Kateqoriyalar</h2>
          <p>Məhsul kateqoriyalarını idarə et</p>
        </div>
        <div style="display:flex;gap:10px">
          <button class="ghost-btn" onclick="addCategory()">➕ Yeni kateqoriya</button>
          <button class="add-btn" onclick="saveCategories()">💾 Yadda saxla</button>
        </div>
      </div>
      <div class="panel">
        <div class="info-note">
          <strong>Qeyd:</strong> Slug — URL və məhsul əlaqələndirməsi üçün istifadə olunan latın hərfli açardır (məs. <code>komputer</code>, <code>printer</code>).
          Mövcud məhsullar bu açara bağlıdır — slug-u dəyişəndə diqqətli ol.
        </div>
        <div id="categoriesContainer"></div>
      </div>
    </div>

    <!-- TESTIMONIALS -->
    <div class="page{{ $activePage === 'testimonials' ? ' active' : '' }}" id="pageTestimonials">
      <div class="page-header">
        <div>
          <h2>⭐ Müştəri Rəyləri</h2>
          <p>Ana səhifədə göstərilən rəyləri idarə et</p>
        </div>
        <div style="display:flex;gap:10px">
          <button class="ghost-btn" onclick="addTestimonial()">➕ Yeni rəy</button>
          <button class="add-btn" onclick="saveTestimonials()">💾 Yadda saxla</button>
        </div>
      </div>
      <div class="panel">
        <div id="testimonialsContainer"></div>
      </div>
    </div>

  </main>
</div>

<!-- EDIT PRODUCT MODAL -->
<div class="modal-overlay" id="editProductModal">
  <div class="modal" style="max-width:680px">
    <button type="button" class="modal-close" onclick="closeEditProductModal()" title="Bağla">✕</button>
    <h3>✏️ Məhsulu Redaktə Et</h3>
    <input type="hidden" id="eId">
    <div class="form-row">
      <div class="form-grp">
        <label>Məhsul adı *</label>
        <input type="text" id="eName" placeholder="məs. HP LaserJet Pro">
      </div>
      <div class="form-grp">
        <label>Kateqoriya *</label>
        <select id="eCat">
          <option value="">Seçin...</option>
          <option value="komputer">💻 Kompüter / Laptop</option>
          <option value="printer">🖨️ Printer</option>
          <option value="proyektor">📽️ Proyektor</option>
          <option value="aksesuar">🖱️ Aksesuar</option>
        </select>
      </div>
      <div class="form-grp">
        <label>Qiymət (₼) *</label>
        <input type="number" id="ePrice" placeholder="məs. 450">
      </div>
      <div class="form-grp">
        <label>Ehtiyat sayı (stock)</label>
        <input type="number" id="eStock" min="0" placeholder="0">
      </div>
      <div class="form-grp">
        <label>Emoji ikonu (şəkil olmadıqda)</label>
        <input type="text" id="eEmoji" placeholder="məs. 🖨️" maxlength="4">
      </div>
      <div class="form-grp full">
        <label>Əsas şəkil</label>
        <div class="img-uploader">
          <input type="hidden" id="eImage">
          <input type="file" id="eImageFile" accept="image/*" style="display:none" onchange="uploadEditImage(this)">
          <div class="img-preview img-preview-clickable" id="eImagePreview" onclick="document.getElementById('eImageFile').click()" title="Şəkil seçmək üçün klikləyin">
            <span class="img-preview-empty">➕ Şəkil əlavə et</span>
          </div>
          <div class="img-uploader-actions">
            <button type="button" class="cancel-btn" onclick="clearEditImage()">🗑️ Sil</button>
          </div>
        </div>
      </div>
      <div class="form-grp full">
        <label>Əlavə şəkillər (galery)</label>
        <input type="file" id="eGalleryFile" accept="image/*" multiple style="display:none" onchange="uploadGalleryImages(this, 'e')">
        <div class="gallery-grid" id="eGalleryGrid"></div>
        <button type="button" class="ghost-btn" onclick="document.getElementById('eGalleryFile').click()" style="margin-top:8px">➕ Şəkil əlavə et</button>
      </div>
      <div class="form-grp full">
        <label>Qısa açıqlama *</label>
        <textarea id="eDesc" placeholder="məs. Rəngli çap, Wi-Fi dəstəkli, 3-ü 1-də"></textarea>
      </div>
      <div class="form-grp">
        <label>Qiymət vahidi</label>
        <select id="eUnit">
          <option value="ədəd">/ ədəd</option>
          <option value="dəst">/ dəst</option>
          <option value="ay">/ ay</option>
        </select>
      </div>
    </div>
    <div class="modal-actions">
      <button class="save-btn" onclick="saveEditProduct()">💾 Yadda Saxla</button>
      <button class="cancel-btn" onclick="closeEditProductModal()">Ləğv et</button>
    </div>
  </div>
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
<!-- ORDER DETAIL MODAL -->
<div class="modal-overlay" id="orderDetailModal">
  <div class="modal" style="max-width:560px">
    <button type="button" class="modal-close" onclick="closeOrderDetailModal()" aria-label="Bağla">✕</button>
    <h3>📋 Sifariş detalları</h3>
    <div class="order-detail-track" id="orderDetailTrackWrap" style="display:none">
      <div class="lbl">İzləmə kodu</div>
      <div class="code" id="orderDetailTrack">—</div>
    </div>
    <dl class="order-detail-grid">
      <dt>Sifariş ID</dt><dd id="orderDetailId">—</dd>
      <dt>Ad Soyad</dt><dd id="orderDetailName">—</dd>
      <dt>Telefon</dt><dd id="orderDetailPhone">—</dd>
      <dt>Email</dt><dd id="orderDetailEmail">—</dd>
      <dt>Xidmət</dt><dd id="orderDetailService">—</dd>
      <dt>Status</dt><dd id="orderDetailStatus">—</dd>
      <dt>Sifariş vaxtı</dt><dd id="orderDetailDate">—</dd>
      <dt>Qeyd</dt><dd class="notes" id="orderDetailNotes">—</dd>
    </dl>
    <div class="modal-actions" style="margin-top:22px">
      <button class="cancel-btn" onclick="closeOrderDetailModal()">Bağla</button>
    </div>
  </div>
</div>

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
  const IS_AUTHED = {!! auth()->check() ? 'true' : 'false' !!};
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const ACTIVE_PAGE = @json($activePage);

  async function enterAdmin() {
    // Server-rendered active page — just kick off its loader.
    // Kateqoriyaları arxa planda yüklə ki, məhsul formasındakı select yenilənsin
    try {
      const res = await fetch('/api/categories', { headers: { 'Accept': 'application/json' } });
      if (res.ok) { _cats = await res.json(); refreshProductCategoryOptions(); }
    } catch {}
    await initActivePage();
    startDashboardAutoRefresh();
  }

  async function initActivePage() {
    const name = ACTIVE_PAGE;
    try {
      if (name === 'dashboard') await renderDashboard();
      else if (name === 'products') await renderProductTable();
      else if (name === 'add') {
        document.getElementById('formTitle').textContent = 'Yeni Məhsul Əlavə Et';
        document.getElementById('editId').value = '';
        ['fName','fCat','fPrice','fStock','fEmoji','fDesc'].forEach(id => {
          const el = document.getElementById(id);
          if (el) el.value = '';
        });
        const unitEl = document.getElementById('fUnit');
        if (unitEl) unitEl.value = 'ədəd';
        setProductImage('');
        _galleryF = [];
        renderGalleryGrid('f');
      }
      else if (name === 'orders') await renderOrders();
      else if (name === 'hero') await loadHero();
      else if (name === 'trust') await loadTrust();
      else if (name === 'services') await loadServices();
      else if (name === 'why') await loadWhy();
      else if (name === 'about') await loadAbout();
      else if (name === 'contact') await loadContact();
      else if (name === 'profile') await loadProfile();
      else if (name === 'categories') await loadCategories();
      else if (name === 'testimonials') await loadTestimonials();
    } catch (e) {
      showToast('❌ Server xətası: ' + e.message, true);
    }
  }

  // ===== DASHBOARD AUTO REFRESH =====
  let _dashRefreshTimer = null;
  function startDashboardAutoRefresh() {
    if (_dashRefreshTimer) return;
    _dashRefreshTimer = setInterval(() => {
      if (document.hidden) return;
      const pg = document.getElementById('pageDashboard');
      if (pg && pg.classList.contains('active')) {
        renderDashboard().catch(() => {});
      }
    }, 20000);
  }
  function stopDashboardAutoRefresh() {
    if (_dashRefreshTimer) { clearInterval(_dashRefreshTimer); _dashRefreshTimer = null; }
  }
  async function doLogin() {
    const u = document.getElementById('loginUser').value.trim();
    const p = document.getElementById('loginPass').value.trim();
    const otpEl = document.getElementById('loginOtp');
    const otp = otpEl.value.trim();
    if (!u || !p) {
      document.getElementById('loginErr').textContent = '❌ İstifadəçi adı və şifrə boş ola bilməz';
      document.getElementById('loginErr').style.display = 'block';
      return;
    }
    try {
      const body = { username: u, password: p };
      if (otp) body.otp = otp;
      const res = await fetch('/admin/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(body),
      });
      let j = null;
      try { j = await res.json(); } catch {}
      if (res.ok && j && j.ok) { location.reload(); return; }
      // 2FA tələb olunur — OTP sahəsini göstər
      if (j && j.otp_required) {
        otpEl.style.display = 'block';
        otpEl.focus();
        const err = document.getElementById('loginErr');
        err.textContent = j.error ? ('❌ ' + j.error) : '🔐 Google Authenticator kodunu daxil edin';
        err.style.color = j.error ? '#f87171' : 'var(--cyan)';
        err.style.display = 'block';
        return;
      }
      let msg = '❌ İstifadəçi adı və ya şifrə yanlışdır';
      if (j && j.error) msg = '❌ ' + j.error;
      const err = document.getElementById('loginErr');
      err.textContent = msg;
      err.style.color = '#f87171';
      err.style.display = 'block';
    } catch (e) {
      document.getElementById('loginErr').textContent = '❌ Server xətası: ' + e.message;
      document.getElementById('loginErr').style.display = 'block';
    }
  }
  async function doLogout() {
    stopDashboardAutoRefresh();
    try {
      await fetch('/admin/logout', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
      });
    } catch {}
    location.reload();
  }

  if (IS_AUTHED) {
    document.addEventListener('DOMContentLoaded', enterAdmin);
    document.addEventListener('DOMContentLoaded', refreshUserWidget);
  }

  // ===== THEME =====
  const THEME_KEY = 'tb_theme';
  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    const ico = document.getElementById('themeToggleIco');
    if (ico) ico.textContent = theme === 'light' ? '☀️' : '🌙';
    try { localStorage.setItem(THEME_KEY, theme); } catch {}
  }
  function toggleTheme() {
    const cur = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
    applyTheme(cur === 'light' ? 'dark' : 'light');
  }
  document.addEventListener('DOMContentLoaded', () => {
    let saved = 'dark';
    try { saved = localStorage.getItem(THEME_KEY) || 'dark'; } catch {}
    applyTheme(saved);
  });

  // Legacy content may still be stored as {az, en, ru} objects — read AZ string out
  // when displaying; new saves always write plain strings.
  function lGet(v) {
    if (v && typeof v === 'object' && !Array.isArray(v)) return v.az || '';
    return v || '';
  }
  function lSet(_current, newVal) { return newVal; }

  // ===== USER WIDGET =====
  let _currentUser = null;
  async function fetchMe() {
    const res = await fetch('/api/me', { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error('me failed');
    return await res.json();
  }
  function renderUserWidget(u) {
    _currentUser = u;
    const initial = (u.name || '?').trim().charAt(0).toUpperCase() || '?';
    document.getElementById('userBadgeName').textContent = u.name || '';
    const av = document.getElementById('userBadgeAvatar');
    av.innerHTML = u.avatar
      ? `<img src="${escapeAttr(u.avatar)}" alt="">`
      : `<span>${escapeHtml(initial)}</span>`;
  }
  async function refreshUserWidget() {
    try { renderUserWidget(await fetchMe()); } catch {}
  }

  // ===== PROFILE PAGE =====
  async function loadProfile() {
    let u;
    try { u = await fetchMe(); } catch (e) { showToast('❌ Yüklənmədi: ' + e.message, true); return; }
    document.getElementById('profName').value = u.name || '';
    document.getElementById('profEmail').value = u.email || '';
    renderProfileAvatar(u.avatar || '');
    renderUserWidget(u);
    clearPassFields();
    load2fa().catch(() => {});
  }
  function renderProfileAvatar(url) {
    const box = document.getElementById('profAvatar');
    const initial = (document.getElementById('profName').value || '?').trim().charAt(0).toUpperCase() || '?';
    box.innerHTML = url
      ? `<img src="${escapeAttr(url)}" alt="">`
      : `<span id="profAvatarInitial">${escapeHtml(initial)}</span>`;
    box.dataset.url = url || '';
  }
  async function uploadProfileAvatar(input) {
    const file = input.files && input.files[0];
    if (!file) return;
    try {
      showToast('⏳ Şəkil yüklənir...');
      const url = await apiUpload(file);
      renderProfileAvatar(url);
      await saveProfile(true);
      showToast('✅ Avatar yeniləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  async function removeProfileAvatar() {
    renderProfileAvatar('');
    await saveProfile(true);
    showToast('🗑️ Avatar silindi');
  }
  async function saveProfile(silent = false) {
    const name  = document.getElementById('profName').value.trim();
    const email = document.getElementById('profEmail').value.trim();
    const avatar = document.getElementById('profAvatar').dataset.url || null;
    if (!name || !email) { if (!silent) showToast('❌ Ad və email məcburidir', true); return; }
    try {
      const res = await fetch('/api/profile', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ name, email, avatar }),
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) {
        let msg = 'Yadda saxlanmadı';
        try { const j = await res.json(); if (j.message) msg = j.message; if (j.errors) msg = Object.values(j.errors).flat().join(', '); } catch {}
        throw new Error(msg);
      }
      const j = await res.json();
      if (j.user) renderUserWidget(j.user);
      if (!silent) showToast('✅ Profil yeniləndi');
    } catch (e) {
      if (!silent) showToast('❌ ' + e.message, true);
    }
  }
  function clearPassFields() {
    ['profCurPass','profNewPass','profNewPass2'].forEach(id => {
      const el = document.getElementById(id); if (el) el.value = '';
    });
  }
  async function changePassword() {
    const cur = document.getElementById('profCurPass').value;
    const nw  = document.getElementById('profNewPass').value;
    const nw2 = document.getElementById('profNewPass2').value;
    if (!cur || !nw) { showToast('❌ Cari və yeni şifrə məcburidir', true); return; }
    if (nw.length < 6) { showToast('❌ Yeni şifrə minimum 6 simvol olmalıdır', true); return; }
    if (nw !== nw2) { showToast('❌ Yeni şifrələr uyğun gəlmir', true); return; }
    try {
      const res = await fetch('/api/profile/password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          current_password: cur,
          new_password: nw,
          new_password_confirmation: nw2,
        }),
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) {
        let msg = 'Şifrə dəyişdirilmədi';
        try { const j = await res.json(); if (j.error) msg = j.error; else if (j.message) msg = j.message; } catch {}
        throw new Error(msg);
      }
      clearPassFields();
      showToast('✅ Şifrə uğurla dəyişdirildi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  // ===== 2FA (Google Authenticator) =====
  async function load2fa() {
    const body = document.getElementById('twofaBody');
    const pill = document.getElementById('twofaStatusPill');
    if (!body) return;
    try {
      const res = await fetch('/api/2fa/status', { headers: { 'Accept': 'application/json' } });
      if (!res.ok) throw new Error('Yüklənmədi');
      const s = await res.json();
      if (s.enabled) {
        pill.innerHTML = '<span style="background:rgba(22,163,74,0.15);color:#4ade80;padding:3px 10px;border-radius:100px;font-size:0.72rem;font-weight:700;text-transform:uppercase">Aktiv</span>';
        body.innerHTML = `
          <div class="info-note" style="background:rgba(22,163,74,0.08);border-color:rgba(22,163,74,0.25);color:#4ade80">
            ✅ <strong>2FA aktivdir.</strong> Hər dəfə giriş edərkən Google Authenticator-dən 6 rəqəmli kod tələb olunacaq.
          </div>
          <div class="form-row">
            <div class="form-grp">
              <label>Cari şifrə</label>
              <input type="password" id="twofaDisPass" autocomplete="current-password">
            </div>
            <div class="form-grp">
              <label>Authenticator kodu</label>
              <input type="text" id="twofaDisOtp" inputmode="numeric" maxlength="8" placeholder="123456" style="letter-spacing:2px;font-family:monospace">
            </div>
          </div>
          <div class="modal-actions">
            <button class="save-btn" style="background:var(--red);box-shadow:none" onclick="disable2fa()">🔓 2FA-nı söndür</button>
          </div>`;
      } else if (s.pending) {
        pill.innerHTML = '<span style="background:rgba(217,119,6,0.15);color:#fbbf24;padding:3px 10px;border-radius:100px;font-size:0.72rem;font-weight:700;text-transform:uppercase">Yarımçıq</span>';
        body.innerHTML = `
          <div class="info-note" style="background:rgba(217,119,6,0.08);border-color:rgba(217,119,6,0.25);color:#fbbf24">
            ⚠️ Quraşdırma başlandı amma təsdiqlənmədi. Yenidən başlayın və ya QR kodu skan edib kodu daxil edin.
          </div>
          <div class="modal-actions">
            <button class="add-btn" onclick="start2faSetup()">🔄 Yenidən başla</button>
          </div>`;
      } else {
        pill.innerHTML = '<span style="background:rgba(123,141,176,0.15);color:var(--muted);padding:3px 10px;border-radius:100px;font-size:0.72rem;font-weight:700;text-transform:uppercase">Söndürülüb</span>';
        body.innerHTML = `
          <div class="info-note">
            ℹ️ İki mərhələli təhlükəsizliyi aktivləşdirmək üçün Google Authenticator (və ya Authy, Microsoft Authenticator) tətbiqi lazımdır.
          </div>
          <div class="modal-actions">
            <button class="add-btn" onclick="start2faSetup()">🔐 2FA-nı aktivləşdir</button>
          </div>`;
      }
    } catch (e) {
      body.innerHTML = '<div style="color:#f87171;font-size:0.85rem">❌ ' + escapeHtml(e.message) + '</div>';
    }
  }

  async function start2faSetup() {
    const body = document.getElementById('twofaBody');
    body.innerHTML = '<div style="color:var(--muted);font-size:0.88rem">⏳ QR kod hazırlanır…</div>';
    try {
      const res = await fetch('/api/2fa/setup', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) {
        let msg = 'Xəta baş verdi';
        try { const j = await res.json(); if (j.error) msg = j.error; } catch {}
        throw new Error(msg);
      }
      const j = await res.json();
      // QR kod ya data URI (data:image/...;base64,...), ya da SVG XML kimi gələ bilər
      const qrRaw = (j.qr || '').trim();
      let qrHtml = '';
      if (qrRaw.startsWith('data:')) {
        qrHtml = `<img src="${escapeAttr(qrRaw)}" alt="2FA QR" width="200" height="200" style="display:block;width:200px;height:200px">`;
      } else if (qrRaw.startsWith('<svg') || qrRaw.startsWith('<?xml')) {
        qrHtml = `<div style="width:200px;height:200px;display:block">${qrRaw}</div>`;
      } else {
        // Ehtiyat: base64 kimi ehtimal edilir
        qrHtml = `<img src="data:image/png;base64,${escapeAttr(qrRaw)}" alt="2FA QR" width="200" height="200" style="display:block;width:200px;height:200px">`;
      }
      body.innerHTML = `
        <div class="info-note">
          <strong>Addım 1:</strong> Google Authenticator tətbiqini açın və QR kodu skan edin.
          <br><strong>Addım 2:</strong> Tətbiqdə görünən 6 rəqəmli kodu aşağıda daxil edin.
        </div>
        <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap;margin-bottom:14px">
          <div style="background:#fff;padding:10px;border-radius:12px;line-height:0;flex-shrink:0">
            ${qrHtml}
          </div>
          <div style="flex:1;min-width:220px">
            <div style="font-size:0.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;font-weight:700;margin-bottom:6px">Manual giriş açarı</div>
            <div style="font-family:monospace;font-size:0.9rem;color:var(--cyan);word-break:break-all;background:rgba(0,194,255,0.08);border:1px dashed rgba(0,194,255,0.3);border-radius:8px;padding:10px">${escapeHtml(j.secret)}</div>
            <div style="font-size:0.78rem;color:var(--muted);margin-top:8px">QR skan edə bilmirsinizsə, bu açarı əl ilə daxil edin.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-grp full">
            <label>Tətbiqdən 6 rəqəmli kod</label>
            <input type="text" id="twofaConfOtp" inputmode="numeric" maxlength="8" placeholder="123456" style="letter-spacing:4px;font-family:monospace;text-align:center;font-size:1.1rem" autofocus>
          </div>
        </div>
        <div class="modal-actions">
          <button class="save-btn" onclick="confirm2fa()">✅ Təsdiq et və aktivləşdir</button>
          <button class="cancel-btn" onclick="load2fa()">Ləğv et</button>
        </div>`;
    } catch (e) {
      showToast('❌ ' + e.message, true);
      load2fa();
    }
  }

  async function confirm2fa() {
    const otp = document.getElementById('twofaConfOtp').value.trim();
    if (!otp) { showToast('❌ Kod boş ola bilməz', true); return; }
    try {
      const res = await fetch('/api/2fa/confirm', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ otp }),
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) {
        let msg = 'Kod yanlışdır';
        try { const j = await res.json(); if (j.error) msg = j.error; } catch {}
        throw new Error(msg);
      }
      showToast('✅ 2FA aktivləşdirildi');
      await load2fa();
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  async function disable2fa() {
    const password = document.getElementById('twofaDisPass').value;
    const otp = document.getElementById('twofaDisOtp').value.trim();
    if (!password || !otp) { showToast('❌ Şifrə və kod məcburidir', true); return; }
    try {
      const res = await fetch('/api/2fa/disable', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ password, otp }),
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) {
        let msg = 'Söndürülmədi';
        try { const j = await res.json(); if (j.error) msg = j.error; } catch {}
        throw new Error(msg);
      }
      showToast('🔓 2FA söndürüldü');
      await load2fa();
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  // ===== CATEGORIES =====
  let _cats = [];
  async function loadCategories() {
    const res = await fetch('/api/categories', { headers: { 'Accept': 'application/json' } });
    _cats = res.ok ? await res.json() : [];
    renderCategories();
  }
  function renderCategories() {
    document.getElementById('categoriesContainer').innerHTML = _cats.map((c, i) => `
      <div class="item-row" data-cat-idx="${i}">
        <div class="item-row-header">
          <span class="item-row-title">${escapeHtml(c.icon || '📦')} ${escapeHtml(c.name || 'Yeni')}</span>
          <button class="item-row-del" onclick="removeCategory(${i})">🗑️ Sil</button>
        </div>
        <div class="form-row three">
          <div class="form-grp"><label>İkon (emoji)</label><input type="text" value="${escapeAttr(c.icon || '')}" data-fld="icon" maxlength="8"></div>
          <div class="form-grp"><label>Slug (latın hərfi)</label><input type="text" value="${escapeAttr(c.slug || '')}" data-fld="slug" placeholder="komputer"></div>
          <div class="form-grp"><label>Sıra</label><input type="number" value="${c.sort ?? 0}" data-fld="sort"></div>
          <div class="form-grp"><label>Ad</label><input type="text" value="${escapeAttr(c.name || '')}" data-fld="name"></div>
        </div>
      </div>
    `).join('') || '<div class="empty-state"><div class="ico">🗂️</div><p>Hələ kateqoriya yoxdur</p></div>';
  }
  function collectCategories() {
    return Array.from(document.querySelectorAll('[data-cat-idx]')).map((row, i) => {
      const get = fld => row.querySelector(`[data-fld="${fld}"]`).value.trim();
      return {
        id: _cats[i]?.id ?? null,
        slug: get('slug').toLowerCase().replace(/[^a-z0-9_-]/g, '-').slice(0, 60),
        name: get('name'),
        icon: get('icon') || '📦',
        sort: parseInt(get('sort'), 10) || 0,
      };
    });
  }
  function addCategory() {
    _cats.push({ id: null, slug: '', name: 'Yeni kateqoriya', icon: '📦', sort: _cats.length + 1 });
    renderCategories();
  }
  function removeCategory(idx) {
    const collected = collectCategories();
    collected.splice(idx, 1);
    _cats = collected;
    renderCategories();
  }
  async function saveCategories() {
    const items = collectCategories();
    for (const it of items) {
      if (!it.slug || !it.name) { showToast('❌ Hər kateqoriya üçün slug və ad məcburidir', true); return; }
    }
    try {
      const res = await fetch('/api/categories', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ items }),
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) {
        let msg = 'Yadda saxlanmadı';
        try { const j = await res.json(); if (j.errors) msg = Object.values(j.errors).flat().join(', '); } catch {}
        throw new Error(msg);
      }
      await loadCategories();
      // Product form kateqoriya select-lərini yenilə
      refreshProductCategoryOptions();
      showToast('✅ Kateqoriyalar yeniləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }
  function refreshProductCategoryOptions() {
    const opts = '<option value="">Seçin...</option>' + _cats.map(c => `<option value="${escapeAttr(c.slug)}">${escapeHtml(c.icon)} ${escapeHtml(c.name)}</option>`).join('');
    ['fCat', 'eCat'].forEach(id => {
      const sel = document.getElementById(id);
      if (sel) { const cur = sel.value; sel.innerHTML = opts; sel.value = cur; }
    });
  }

  // ===== TESTIMONIALS =====
  let _tests = [];
  async function loadTestimonials() {
    const res = await fetch('/api/admin/testimonials', { headers: { 'Accept': 'application/json' } });
    if (res.status === 401 || res.status === 419) { location.reload(); return; }
    _tests = res.ok ? await res.json() : [];
    renderTestimonials();
  }
  function renderTestimonials() {
    document.getElementById('testimonialsContainer').innerHTML = _tests.map((t, i) => `
      <div class="item-row" data-test-idx="${i}">
        <div class="item-row-header">
          <span class="item-row-title">Rəy #${i + 1} ${t.published ? '' : '<small style="color:var(--muted);margin-left:8px">(gizli)</small>'}</span>
          <button class="item-row-del" onclick="removeTestimonial(${i})">🗑️ Sil</button>
        </div>
        <div class="form-row">
          <div class="form-grp"><label>Ad Soyad</label><input type="text" value="${escapeAttr(t.name || '')}" data-fld="name"></div>
          <div class="form-grp full">
            <label>Vəzifə / şirkət</label>
            <input type="text" data-fld="position" value="${escapeAttr(t.position || '')}">
          </div>
          <div class="form-grp full">
            <label>Avatar (klikləyib şəkil yüklə)</label>
            <div class="img-uploader">
              <input type="hidden" data-fld="avatar" value="${escapeAttr(t.avatar || '')}">
              <input type="file" data-test-file accept="image/*" style="display:none" onchange="uploadTestimonialAvatar(this, ${i})">
              <div class="img-preview img-preview-clickable" data-test-prev onclick="_testRow(${i}).querySelector('[data-test-file]').click()">
                ${t.avatar ? `<img src="${escapeAttr(t.avatar)}" alt="">` : '<span class="img-preview-empty">➕ Şəkil</span>'}
              </div>
              <div class="img-uploader-actions">
                <button type="button" class="cancel-btn" onclick="clearTestimonialAvatar(${i})">🗑️ Sil</button>
              </div>
            </div>
          </div>
          <div class="form-grp full">
            <label>Rəy mətni</label>
            <textarea data-fld="text">${escapeHtml(t.text || '')}</textarea>
          </div>
          <div class="form-grp"><label>Reytinq (1-5)</label><input type="number" min="1" max="5" value="${t.rating ?? 5}" data-fld="rating"></div>
          <div class="form-grp"><label>Sıra</label><input type="number" value="${t.sort ?? 0}" data-fld="sort"></div>
          <div class="form-grp"><label style="display:flex;align-items:center;gap:8px"><input type="checkbox" data-fld="published" ${t.published !== false ? 'checked' : ''}> Sayta göstər</label></div>
        </div>
      </div>
    `).join('') || '<div class="empty-state"><div class="ico">⭐</div><p>Hələ heç bir rəy yoxdur</p></div>';
  }
  function _testRow(idx) { return document.querySelector(`[data-test-idx="${idx}"]`); }
  function collectTestimonials() {
    return Array.from(document.querySelectorAll('[data-test-idx]')).map((row, i) => {
      const get = fld => row.querySelector(`[data-fld="${fld}"]`)?.value.trim() ?? '';
      const isChecked = fld => row.querySelector(`[data-fld="${fld}"]`).checked;
      return {
        id: _tests[i]?.id ?? null,
        name: get('name'),
        position: get('position') || null,
        text: get('text'),
        avatar: get('avatar') || null,
        rating: Math.max(1, Math.min(5, parseInt(get('rating'), 10) || 5)),
        sort: parseInt(get('sort'), 10) || 0,
        published: isChecked('published'),
      };
    });
  }
  function addTestimonial() {
    _tests.push({ id: null, name: '', position: '', text: '', avatar: null, rating: 5, sort: _tests.length + 1, published: true });
    renderTestimonials();
  }
  function removeTestimonial(idx) {
    const collected = collectTestimonials();
    collected.splice(idx, 1);
    _tests = collected;
    renderTestimonials();
  }
  async function uploadTestimonialAvatar(input, idx) {
    const file = input.files && input.files[0];
    if (!file) return;
    try {
      showToast('⏳ Şəkil yüklənir...');
      const url = await apiUpload(file);
      const row = _testRow(idx);
      row.querySelector('[data-fld="avatar"]').value = url;
      row.querySelector('[data-test-prev]').innerHTML = `<img src="${escapeAttr(url)}" alt="">`;
      showToast('✅ Yükləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  function clearTestimonialAvatar(idx) {
    const row = _testRow(idx);
    row.querySelector('[data-fld="avatar"]').value = '';
    row.querySelector('[data-test-prev]').innerHTML = '<span class="img-preview-empty">➕ Şəkil</span>';
  }
  async function saveTestimonials() {
    const items = collectTestimonials();
    for (const it of items) {
      if (!it.name || !it.text) { showToast('❌ Ad və mətn məcburidir', true); return; }
    }
    try {
      const res = await fetch('/api/admin/testimonials', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ items }),
      });
      if (res.status === 401 || res.status === 419) { location.reload(); return; }
      if (!res.ok) throw new Error('Yadda saxlanmadı');
      await loadTestimonials();
      showToast('✅ Rəylər yeniləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

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
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify(data),
    });
    if (res.status === 401 || res.status === 419) { location.reload(); return; }
    if (!res.ok) throw new Error('Save failed: ' + res.status);
    return await res.json();
  }
  async function apiUpload(file) {
    const fd = new FormData();
    fd.append('file', file);
    const res = await fetch('/api/upload', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: fd,
    });
    if (res.status === 401 || res.status === 419) { location.reload(); return; }
    if (!res.ok) {
      let msg = 'Upload failed: ' + res.status;
      try { const j = await res.json(); if (j.message) msg = j.message; } catch {}
      throw new Error(msg);
    }
    const j = await res.json();
    return j.url;
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
  const VALID_PAGES = ['dashboard','orders','hero','trust','services','why','about','contact','products','add','profile','categories','testimonials'];

  function showPage(name) {
    if (!VALID_PAGES.includes(name)) name = 'dashboard';
    window.location.href = '/admin/' + name;
  }

  // ===== DASHBOARD =====
  const catLabels = { komputer: '💻 Kompüterlər', printer: '🖨️ Printerlər', proyektor: '📽️ Proyektorlar', aksesuar: '🖱️ Aksesuarlar' };
  const _charts = {};

  async function renderDashboard() {
    const products = await getProducts();
    const stats = await fetch('/api/stats').then(r => r.json()).catch(() => null);
    if (!stats) { showToast('❌ Statistika yüklənmədi', true); return; }

    const s = stats.summary;
    const deltaHtml = (pct) => {
      if (pct === undefined || pct === null) return '';
      const cls = pct > 0 ? 'up' : (pct < 0 ? 'down' : 'flat');
      const arrow = pct > 0 ? '▲' : (pct < 0 ? '▼' : '●');
      return `<span class="stat-delta ${cls}">${arrow} ${Math.abs(pct)}% <small>keçən həftədən</small></span>`;
    };
    document.getElementById('statsRow').innerHTML = `
      <div class="stat-card">
        <div class="label">Bu ay sifariş</div>
        <div class="value">${s.monthOrders}</div>
        ${deltaHtml(s.ordersDeltaPct)}
      </div>
      <div class="stat-card">
        <div class="label">Bu ay ziyarətçi</div>
        <div class="value">${s.monthVisits}</div>
        ${deltaHtml(s.visitsDeltaPct)}
      </div>
      <div class="stat-card">
        <div class="label">Ümumi məhsul</div>
        <div class="value">${s.totalProducts}<span>+</span></div>
        <span class="stat-delta flat"><small>anbar məhsulları</small></span>
      </div>
      <div class="stat-card">
        <div class="label">Ümumi sifariş</div>
        <div class="value">${s.totalOrders}</div>
        <span class="stat-delta flat"><small>bütün zamanlar</small></span>
      </div>
    `;

    renderChartMonthly(stats.monthly);
    renderChartByCat(stats.byCat);
    renderChartWeekly(stats.weekly);
    renderChartByService(stats.byService);

    // Yeni: son sifarişlər feed
    const roBox = document.getElementById('recentOrdersFeed');
    if (roBox) {
      const rows = (stats.recentOrders || []);
      roBox.innerHTML = rows.length
        ? rows.map(o => `
          <div class="feed-row">
            <div class="feed-avatar">${escapeHtml((o.name || '?').charAt(0).toUpperCase())}</div>
            <div class="feed-body">
              <div class="feed-title">${escapeHtml(o.name || '-')} <span class="feed-code">${escapeHtml(o.track_code || '')}</span></div>
              <div class="feed-sub">${escapeHtml(o.service || '')} · ${escapeHtml(o.date || '')}</div>
            </div>
            <span class="status-pill-sm ${o.status}">${ORDER_STATUSES[o.status] || o.status}</span>
          </div>
        `).join('')
        : '<div class="feed-empty">Hələ sifariş yoxdur</div>';
    }

    // Yeni: aşağı ehtiyat xəbərdarlığı
    const lsBox = document.getElementById('lowStockFeed');
    if (lsBox) {
      const items = (stats.lowStock || []);
      lsBox.innerHTML = items.length
        ? items.map(p => `
          <div class="feed-row" onclick="editProduct(${p.id})" style="cursor:pointer">
            <div class="feed-thumb">${p.image ? `<img src="${escapeAttr(p.image)}" alt="">` : (p.emoji || '📦')}</div>
            <div class="feed-body">
              <div class="feed-title">${escapeHtml(p.name)}</div>
              <div class="feed-sub">Anbar: <strong style="color:${p.stock <= 0 ? '#f87171' : '#fbbf24'}">${p.stock} ədəd</strong></div>
            </div>
            <span class="stock-tag ${p.stock <= 0 ? 'out' : 'low'}">${p.stock <= 0 ? 'Bitib' : 'Az qalıb'}</span>
          </div>
        `).join('')
        : '<div class="feed-empty">✅ Bütün məhsullar kifayət qədər anbarda var</div>';
    }

    const recent = products.slice(-5).reverse();
    const rt = document.getElementById('recentTableBody');
    if (rt) {
      rt.innerHTML = recent.length
        ? recent.map(p => `<tr>
            <td>${p.image ? `<span class="img-preview-sm" style="margin-right:8px"><img src="${escapeAttr(p.image)}" alt=""></span>` : (p.emoji || '📦') + ' '}${escapeHtml(p.name)}</td>
            <td><span class="cat-badge">${p.cat}</span></td>
            <td class="price-cell">${p.price} ₼</td>
            <td><div class="action-btns">
              <button class="edit-btn" onclick="editProduct(${p.id})">✏️ Redaktə</button>
              <button class="del-btn" onclick="openDeleteModal(${p.id})">🗑️</button>
            </div></td>
          </tr>`).join('')
        : '<tr><td colspan="4"><div class="empty-state"><div class="ico">📭</div><p>Hələ heç bir məhsul yoxdur</p></div></td></tr>';
    }
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

  const ORDER_STATUSES = { new: 'Yeni', processing: 'Hazırlanır', shipped: 'Yoldadır', delivered: 'Çatdırıldı', cancelled: 'Ləğv edildi' };
  async function renderOrders() {
    const data = await apiGet('orders');
    _ordersCache = data.list || [];
    document.getElementById('ordersTableBody').innerHTML = _ordersCache.length
      ? _ordersCache.slice().reverse().map((o, idx) => {
          const realIdx = _ordersCache.length - 1 - idx;
          const statusOpts = Object.entries(ORDER_STATUSES).map(([k, v]) => `<option value="${k}"${(o.status || 'new') === k ? ' selected' : ''}>${v}</option>`).join('');
          return `<tr>
          <td style="white-space:nowrap;color:var(--muted);font-size:0.8rem">${o.date || '-'}</td>
          <td style="font-family:monospace;font-size:0.78rem;color:var(--cyan)">${o.track_code || '-'}</td>
          <td><strong style="color:var(--white)">${o.name || '-'}</strong></td>
          <td>${o.phone || '-'}</td>
          <td><span class="cat-badge">${o.service || '-'}</span></td>
          <td><select class="order-status-select" onchange="changeOrderStatus(${realIdx}, this.value)">${statusOpts}</select></td>
          <td style="color:var(--muted);font-size:0.82rem;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${o.notes || '-'}</td>
          <td>
            <div class="action-btns">
              <button class="info-btn" onclick="openOrderDetailModal(${realIdx})">👁️ Daha çox</button>
              <button class="del-btn" onclick="openOrderDeleteModal(${realIdx})">🗑️ Sil</button>
            </div>
          </td>
        </tr>`;
        }).join('')
      : '<tr><td colspan="8"><div class="empty-state"><div class="ico">📭</div><p>Hələ heç bir sifariş yoxdur</p></div></td></tr>';
  }
  async function changeOrderStatus(idx, status) {
    if (!_ordersCache[idx]) return;
    _ordersCache[idx].status = status;
    try {
      await apiSave('orders', { list: _ordersCache });
      showToast('✅ Status yeniləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }

  function openOrderDetailModal(idx) {
    const o = _ordersCache[idx];
    if (!o) return;
    const setText = (id, val) => { document.getElementById(id).textContent = (val === undefined || val === null || val === '') ? '—' : val; };
    const trackWrap = document.getElementById('orderDetailTrackWrap');
    if (o.track_code) {
      trackWrap.style.display = '';
      document.getElementById('orderDetailTrack').textContent = o.track_code;
    } else {
      trackWrap.style.display = 'none';
    }
    setText('orderDetailId', o.id ? '#' + o.id : '—');
    setText('orderDetailName', o.name);
    const phoneCell = document.getElementById('orderDetailPhone');
    phoneCell.innerHTML = o.phone ? `<a href="tel:${o.phone.replace(/\s+/g,'')}">${o.phone}</a>` : '—';
    const emailCell = document.getElementById('orderDetailEmail');
    emailCell.innerHTML = o.email ? `<a href="mailto:${o.email}">${o.email}</a>` : '—';
    setText('orderDetailService', o.service);
    const statusKey = o.status || 'new';
    const statusLabel = ORDER_STATUSES[statusKey] || statusKey;
    document.getElementById('orderDetailStatus').innerHTML = `<span class="status-pill-sm ${statusKey}">${statusLabel}</span>`;
    setText('orderDetailDate', o.date);
    setText('orderDetailNotes', o.notes);
    document.getElementById('orderDetailModal').classList.add('open');
  }
  function closeOrderDetailModal() {
    document.getElementById('orderDetailModal').classList.remove('open');
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
  let _heroRaw = {}; // ham JSON — save vaxtı digər dilləri qorumaq üçün
  async function loadHero() {
    const h = await apiGet('hero');
    _heroRaw = h || {};
    document.getElementById('heroBadge').value    = lGet(h.badge);
    document.getElementById('heroTitle').value    = lGet(h.title);
    document.getElementById('heroSub').value      = lGet(h.sub);
    document.getElementById('heroBtn1Text').value = lGet(h.btn1Text);
    document.getElementById('heroBtn1Link').value = h.btn1Link || '';
    document.getElementById('heroBtn2Text').value = lGet(h.btn2Text);
    document.getElementById('heroBtn2Link').value = h.btn2Link || '';
    (h.stats || []).forEach((s, i) => {
      const n = document.getElementById(`heroStat${i+1}Num`); if (n) n.value = s.num || '';
      const l = document.getElementById(`heroStat${i+1}Lbl`); if (l) l.value = lGet(s.label);
    });
    (h.devices || []).forEach((d, i) => {
      const e = document.getElementById(`heroDev${i+1}Emoji`); if (e) e.value = d.emoji || '';
      const t = document.getElementById(`heroDev${i+1}Title`); if (t) t.value = lGet(d.title);
      const ds = document.getElementById(`heroDev${i+1}Desc`); if (ds) ds.value = lGet(d.desc);
      setHeroDeviceImage(i + 1, d.image || '');
    });
  }
  async function saveHero() {
    const raw = _heroRaw || {};
    const h = {
      badge:    lSet(raw.badge,    document.getElementById('heroBadge').value),
      title:    lSet(raw.title,    document.getElementById('heroTitle').value),
      sub:      lSet(raw.sub,      document.getElementById('heroSub').value),
      btn1Text: lSet(raw.btn1Text, document.getElementById('heroBtn1Text').value),
      btn1Link: document.getElementById('heroBtn1Link').value,
      btn2Text: lSet(raw.btn2Text, document.getElementById('heroBtn2Text').value),
      btn2Link: document.getElementById('heroBtn2Link').value,
      stats: [1,2,3].map(i => {
        const prev = (raw.stats || [])[i-1] || {};
        return {
          num: document.getElementById(`heroStat${i}Num`).value,
          label: lSet(prev.label, document.getElementById(`heroStat${i}Lbl`).value),
        };
      }),
      devices: [1,2,3].map(i => {
        const prev = (raw.devices || [])[i-1] || {};
        return {
          emoji: document.getElementById(`heroDev${i}Emoji`).value,
          title: lSet(prev.title, document.getElementById(`heroDev${i}Title`).value),
          desc:  lSet(prev.desc,  document.getElementById(`heroDev${i}Desc`).value),
          image: document.getElementById(`heroDev${i}Image`).value || null,
        };
      }),
    };
    try { await apiSave('hero', h); _heroRaw = h; showToast('✅ Hero (' + currentEditLang().toUpperCase() + ') yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }
  function setHeroDeviceImage(i, url) {
    const hid = document.getElementById(`heroDev${i}Image`);
    if (hid) hid.value = url || '';
    const box = document.getElementById(`heroDev${i}Preview`);
    if (!box) return;
    box.innerHTML = url
      ? `<img src="${escapeAttr(url)}" alt="">`
      : '<span class="img-preview-empty">➕ Şəkil əlavə et</span>';
  }
  async function uploadHeroDeviceImage(input, i) {
    const file = input.files && input.files[0];
    if (!file) return;
    try {
      showToast('⏳ Şəkil yüklənir...');
      const url = await apiUpload(file);
      setHeroDeviceImage(i, url);
      showToast('✅ Şəkil yükləndi. Yadda saxlamağı unutma!');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  function clearHeroDeviceImage(i) { setHeroDeviceImage(i, ''); }

  // ===== TRUST BADGES =====
  let _trustRaw = {};
  async function loadTrust() {
    const t = await apiGet('trust');
    _trustRaw = t || {};
    document.getElementById('trustEnabled').checked = t.enabled !== false;
    // Kartlarda display üçün cari dili göstərmək — amma raw-daki obyekt formasını saxlamaq üçün
    const displayCards = (t.cards || []).map(c => ({
      icon: c.icon || '✅',
      title: lGet(c.title),
      desc:  lGet(c.desc),
    }));
    renderTrustCards(displayCards);
  }
  function renderTrustCards(cards) {
    document.getElementById('trustCardsContainer').innerHTML = '<div class="panel"><h3>Zəmanət Kartları <small>(' + cards.length + ' ədəd)</small></h3>' +
      cards.map((card, i) => `
        <div class="item-row" data-trust-idx="${i}">
          <div class="item-row-header">
            <span class="item-row-title">Kart #${i+1}</span>
            <button class="item-row-del" onclick="removeTrustCard(${i})">🗑️ Sil</button>
          </div>
          <div class="form-row">
            <div class="form-grp"><label>İkon (emoji)</label><input type="text" value="${escapeAttr(card.icon)}" data-fld="icon" maxlength="4"></div>
            <div class="form-grp"><label>Başlıq</label><input type="text" value="${escapeAttr(card.title)}" data-fld="title"></div>
            <div class="form-grp full"><label>Açıqlama</label><textarea data-fld="desc">${escapeHtml(card.desc)}</textarea></div>
          </div>
        </div>
      `).join('') + '</div>';
  }
  function collectTrustCards() {
    return Array.from(document.querySelectorAll('[data-trust-idx]')).map(row => {
      const get = fld => row.querySelector(`[data-fld="${fld}"]`).value;
      return { icon: get('icon'), title: get('title'), desc: get('desc') };
    });
  }
  function addTrustCard() {
    // Cari display cards-a ekle
    const cards = collectTrustCards();
    cards.push({ icon: '✅', title: 'Yeni zəmanət', desc: 'Açıqlama...' });
    renderTrustCards(cards);
    // Raw-a da boş yer ekle
    (_trustRaw.cards = _trustRaw.cards || []).push({ icon: '✅', title: '', desc: '' });
  }
  function removeTrustCard(idx) {
    const cards = collectTrustCards();
    cards.splice(idx, 1);
    renderTrustCards(cards);
    if (Array.isArray(_trustRaw.cards)) _trustRaw.cards.splice(idx, 1);
  }
  async function saveTrust() {
    const display = collectTrustCards();
    const rawCards = _trustRaw.cards || [];
    const merged = display.map((c, i) => {
      const prev = rawCards[i] || {};
      return {
        icon:  c.icon,
        title: lSet(prev.title, c.title),
        desc:  lSet(prev.desc,  c.desc),
      };
    });
    const payload = {
      enabled: document.getElementById('trustEnabled').checked,
      cards: merged,
    };
    try { await apiSave('trust', payload); _trustRaw = payload; showToast('✅ Zəmanətlər (' + currentEditLang().toUpperCase() + ') yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== SERVICES =====
  let _srvRaw = {};
  async function loadServices() {
    const s = await apiGet('services');
    _srvRaw = s || {};
    document.getElementById('srvEyebrow').value = lGet(s.eyebrow);
    document.getElementById('srvTitle').value   = lGet(s.title);
    document.getElementById('srvSub').value     = lGet(s.sub);
    const display = (s.cards || []).map(c => ({
      icon: c.icon || '✨',
      title: lGet(c.title),
      image: c.image || null,
      desc:  lGet(c.desc),
      linkText: lGet(c.linkText),
      link: c.link || '#order',
    }));
    renderServiceCards(display);
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
            <div class="form-grp"><label>İkon emoji (şəkil olmadıqda)</label><input type="text" value="${escapeAttr(card.icon)}" data-fld="icon" maxlength="4"></div>
            <div class="form-grp"><label>Başlıq</label><input type="text" value="${escapeAttr(card.title)}" data-fld="title"></div>
            <div class="form-grp full">
              <label>Xidmət şəkli (şəkil hissəsinə klikləyin)</label>
              <div class="img-uploader">
                <input type="hidden" data-fld="image" value="${escapeAttr(card.image || '')}">
                <input type="file" data-srv-file accept="image/*" style="display:none" onchange="uploadServiceImage(this, ${i})">
                <div class="img-preview img-preview-clickable" data-srv-preview onclick="_srvRow(${i}).querySelector('[data-srv-file]').click()" title="Şəkil seçmək üçün klikləyin">
                  ${card.image ? `<img src="${escapeAttr(card.image)}" alt="">` : '<span class="img-preview-empty">➕ Şəkil əlavə et</span>'}
                </div>
                <div class="img-uploader-actions">
                  <button type="button" class="cancel-btn" onclick="clearServiceImage(${i})">🗑️ Sil</button>
                </div>
              </div>
            </div>
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
      return { icon: get('icon'), title: get('title'), image: get('image') || null, desc: get('desc'), linkText: get('linkText'), link: get('link') };
    });
  }
  function _srvRow(idx) { return document.querySelector(`[data-srv-idx="${idx}"]`); }
  function setServiceImage(idx, url) {
    const row = _srvRow(idx);
    if (!row) return;
    row.querySelector('[data-fld="image"]').value = url || '';
    const box = row.querySelector('[data-srv-preview]');
    box.innerHTML = url
      ? `<img src="${escapeAttr(url)}" alt="">`
      : '<span class="img-preview-empty">➕ Şəkil əlavə et</span>';
  }
  async function uploadServiceImage(input, idx) {
    const file = input.files && input.files[0];
    if (!file) return;
    try {
      showToast('⏳ Şəkil yüklənir...');
      const url = await apiUpload(file);
      setServiceImage(idx, url);
      showToast('✅ Şəkil yükləndi. Yadda saxlamağı unutma!');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  function clearServiceImage(idx) { setServiceImage(idx, ''); }
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
    cards.push({ icon, title, image: null, desc, linkText, link });
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
    const raw = _srvRaw || {};
    const displayCards = collectServiceCards();
    const rawCards = raw.cards || [];
    const merged = displayCards.map((c, i) => {
      const prev = rawCards[i] || {};
      return {
        icon: c.icon,
        title:    lSet(prev.title,    c.title),
        image:    c.image,
        desc:     lSet(prev.desc,     c.desc),
        linkText: lSet(prev.linkText, c.linkText),
        link:     c.link,
      };
    });
    const s = {
      eyebrow: lSet(raw.eyebrow, document.getElementById('srvEyebrow').value),
      title:   lSet(raw.title,   document.getElementById('srvTitle').value),
      sub:     lSet(raw.sub,     document.getElementById('srvSub').value),
      cards: merged,
    };
    try { await apiSave('services', s); _srvRaw = s; showToast('✅ Xidmətlər (' + currentEditLang().toUpperCase() + ') yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== WHY US =====
  let _whyRaw = {};
  async function loadWhy() {
    const w = await apiGet('why');
    _whyRaw = w || {};
    document.getElementById('whyEyebrow').value = lGet(w.eyebrow);
    document.getElementById('whyTitle').value   = lGet(w.title);
    document.getElementById('whySub').value     = lGet(w.sub);
    const feats = (w.features || []).map(f => ({ icon: f.icon || '✨', title: lGet(f.title), desc: lGet(f.desc) }));
    const mets  = (w.metrics  || []).map(m => ({ num: m.num || '', suffix: m.suffix || '', label: lGet(m.label) }));
    renderWhyFeatures(feats);
    renderWhyMetrics(mets);
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
    const raw = _whyRaw || {};
    const dispFeats = collectWhyFeatures();
    const rawFeats = raw.features || [];
    const feats = dispFeats.map((f, i) => {
      const prev = rawFeats[i] || {};
      return { icon: f.icon, title: lSet(prev.title, f.title), desc: lSet(prev.desc, f.desc) };
    });
    const dispMets = collectWhyMetrics();
    const rawMets = raw.metrics || [];
    const mets = dispMets.map((m, i) => {
      const prev = rawMets[i] || {};
      return { num: m.num, suffix: m.suffix, label: lSet(prev.label, m.label) };
    });
    const w = {
      eyebrow: lSet(raw.eyebrow, document.getElementById('whyEyebrow').value),
      title:   lSet(raw.title,   document.getElementById('whyTitle').value),
      sub:     lSet(raw.sub,     document.getElementById('whySub').value),
      features: feats,
      metrics: mets,
    };
    try { await apiSave('why', w); _whyRaw = w; showToast('✅ Niyə Biz (' + currentEditLang().toUpperCase() + ') yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== ABOUT =====
  // Hansı sahələr multi-lang olur (dəyəri obyekt kimi saxlanmalıdır)
  const ABOUT_LANG_KEYS = new Set(['badge1','badge2','badge3','title','text','btnText','centerName','centerAddr','met1Lbl','met2Lbl']);
  const CONTACT_LANG_KEYS = new Set(['eyebrow','title','sub','addr','addrNote','hours']);
  let _aboutRaw = {}, _contactRaw = {};

  async function loadAbout() {
    const a = await apiGet('about');
    _aboutRaw = a || {};
    Object.keys(a).forEach(k => {
      const el = document.getElementById('ab' + k.charAt(0).toUpperCase() + k.slice(1));
      if (el) el.value = ABOUT_LANG_KEYS.has(k) ? lGet(a[k]) : (a[k] || '');
    });
  }
  async function saveAbout() {
    const ids = ['Badge1','Badge2','Badge3','Title','Text','BtnText','BtnLink','Icon','CenterName','CenterAddr','Met1Num','Met1Lbl','Met2Num','Met2Lbl'];
    const a = {};
    ids.forEach(id => {
      const key = id.charAt(0).toLowerCase() + id.slice(1);
      const val = document.getElementById('ab' + id).value;
      a[key] = ABOUT_LANG_KEYS.has(key) ? lSet(_aboutRaw[key], val) : val;
    });
    try { await apiSave('about', a); _aboutRaw = a; showToast('✅ Haqqımızda (' + currentEditLang().toUpperCase() + ') yadda saxlandı'); }
    catch (e) { showToast('❌ ' + e.message, true); }
  }

  // ===== CONTACT =====
  async function loadContact() {
    const c = await apiGet('contact');
    _contactRaw = c || {};
    const map = { Eyebrow:'eyebrow', Title:'title', Sub:'sub', Addr:'addr', AddrNote:'addrNote', Phone:'phone', Hours:'hours', Email:'email', Whatsapp:'whatsapp', MapSrc:'mapSrc' };
    Object.entries(map).forEach(([id, key]) => {
      const el = document.getElementById('ct' + id);
      if (el) el.value = CONTACT_LANG_KEYS.has(key) ? lGet(c[key]) : (c[key] || '');
    });
  }
  async function saveContact() {
    const map = { Eyebrow:'eyebrow', Title:'title', Sub:'sub', Addr:'addr', AddrNote:'addrNote', Phone:'phone', Hours:'hours', Email:'email', Whatsapp:'whatsapp', MapSrc:'mapSrc' };
    const c = {};
    Object.entries(map).forEach(([id, key]) => {
      const val = document.getElementById('ct' + id).value;
      c[key] = CONTACT_LANG_KEYS.has(key) ? lSet(_contactRaw[key], val) : val;
    });
    try { await apiSave('contact', c); _contactRaw = c; showToast('✅ Əlaqə (' + currentEditLang().toUpperCase() + ') yadda saxlandı'); }
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
      ? products.map(p => {
          const stock = p.stock ?? 0;
          const stockClass = stock <= 0 ? 'out' : (stock <= 3 ? 'low' : 'in');
          const stockText = stock <= 0 ? 'Yoxdur' : (stock + ' ədəd');
          return `<tr>
          <td>${p.image ? `<span class="img-preview-sm"><img src="${escapeAttr(p.image)}" alt=""></span>` : `<span style="font-size:1.5rem">${p.emoji || '📦'}</span>`}</td>
          <td><strong style="color:var(--white)">${p.name}</strong></td>
          <td><span class="cat-badge">${catLabels[p.cat] || p.cat}</span></td>
          <td class="price-cell">${p.price} ₼<span style="font-size:0.75rem;color:var(--muted);font-weight:400"> /${p.unit}</span></td>
          <td><span class="stock-tag ${stockClass}">${stockText}</span></td>
          <td style="color:var(--muted);font-size:0.82rem;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${p.desc}</td>
          <td><div class="action-btns">
            <button class="edit-btn" onclick="editProduct(${p.id})">✏️ Redaktə</button>
            <button class="del-btn" onclick="openDeleteModal(${p.id})">🗑️ Sil</button>
          </div></td>
        </tr>`;
        }).join('')
      : '<tr><td colspan="7"><div class="empty-state"><div class="ico">🔍</div><p>Heç bir məhsul tapılmadı</p></div></td></tr>';
  }

  // ===== ADD / EDIT PRODUCT =====
  async function saveProduct() {
    const name  = document.getElementById('fName').value.trim();
    const cat   = document.getElementById('fCat').value;
    const price = document.getElementById('fPrice').value.trim();
    const stock = parseInt(document.getElementById('fStock').value, 10) || 0;
    const emoji = document.getElementById('fEmoji').value.trim() || '📦';
    const image = document.getElementById('fImage').value.trim() || null;
    const images = _galleryF.slice();
    const desc  = document.getElementById('fDesc').value.trim();
    const unit  = document.getElementById('fUnit').value;
    const editId = document.getElementById('editId').value;

    if (!name || !cat || !price || !desc) { showToast('❌ Bütün məcburi sahələri doldurun!', true); return; }

    try {
      const products = (await getProducts()).slice();
      if (editId) {
        const idx = products.findIndex(p => p.id == editId);
        if (idx > -1) { products[idx] = { ...products[idx], name, cat, price, stock, emoji, image, images, desc, unit }; }
        await saveProducts(products);
        showToast('✅ Məhsul yeniləndi!');
      } else {
        const newId = products.length ? Math.max(...products.map(p => p.id)) + 1 : 1;
        products.push({ id: newId, name, cat, price, stock, emoji, image, images, desc, unit });
        await saveProducts(products);
        showToast('✅ Məhsul əlavə edildi!');
      }
      clearForm();
      window.location.href = '/admin/products';
      return;
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }
  async function editProduct(id) {
    const products = await getProducts();
    const p = products.find(x => String(x.id) === String(id));
    if (!p) return;
    document.getElementById('eId').value = p.id;
    document.getElementById('eName').value  = p.name || '';
    document.getElementById('eCat').value   = p.cat || '';
    document.getElementById('ePrice').value = p.price || '';
    document.getElementById('eStock').value = p.stock ?? 0;
    document.getElementById('eEmoji').value = p.emoji || '';
    document.getElementById('eDesc').value  = p.desc || '';
    document.getElementById('eUnit').value  = p.unit || 'ədəd';
    setEditImage(p.image || '');
    _galleryE = Array.isArray(p.images) ? p.images.slice() : [];
    renderGalleryGrid('e');
    document.getElementById('editProductModal').classList.add('open');
  }
  function closeEditProductModal() {
    document.getElementById('editProductModal').classList.remove('open');
  }
  function setEditImage(url) {
    document.getElementById('eImage').value = url || '';
    const box = document.getElementById('eImagePreview');
    box.innerHTML = url
      ? `<img src="${escapeAttr(url)}" alt="">`
      : '<span class="img-preview-empty">➕ Şəkil əlavə et</span>';
  }
  async function uploadEditImage(input) {
    const file = input.files && input.files[0];
    if (!file) return;
    try {
      showToast('⏳ Şəkil yüklənir...');
      const url = await apiUpload(file);
      setEditImage(url);
      showToast('✅ Şəkil yükləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  function clearEditImage() { setEditImage(''); }
  async function saveEditProduct() {
    const id    = document.getElementById('eId').value;
    const name  = document.getElementById('eName').value.trim();
    const cat   = document.getElementById('eCat').value;
    const price = document.getElementById('ePrice').value.trim();
    const stock = parseInt(document.getElementById('eStock').value, 10) || 0;
    const emoji = document.getElementById('eEmoji').value.trim() || '📦';
    const image = document.getElementById('eImage').value.trim() || null;
    const images = _galleryE.slice();
    const desc  = document.getElementById('eDesc').value.trim();
    const unit  = document.getElementById('eUnit').value;
    if (!name || !cat || !price || !desc) { showToast('❌ Bütün məcburi sahələri doldurun!', true); return; }
    try {
      const products = (await getProducts()).slice();
      const idx = products.findIndex(p => String(p.id) === String(id));
      if (idx > -1) {
        products[idx] = { ...products[idx], name, cat, price, stock, emoji, image, images, desc, unit };
        await saveProducts(products);
        showToast('✅ Məhsul yeniləndi!');
      }
      closeEditProductModal();
      await renderProductTable();
    } catch (e) {
      showToast('❌ ' + e.message, true);
    }
  }
  function clearForm() {
    ['fName','fCat','fPrice','fStock','fEmoji','fDesc','fUnit'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    document.getElementById('editId').value = '';
    setProductImage('');
    _galleryF = [];
    renderGalleryGrid('f');
    document.getElementById('formTitle').textContent = 'Yeni Məhsul Əlavə Et';
  }

  // ===== GALLERY (product multi-images) =====
  let _galleryF = [];
  let _galleryE = [];
  function galleryArr(prefix) { return prefix === 'e' ? _galleryE : _galleryF; }
  function setGalleryArr(prefix, arr) {
    if (prefix === 'e') _galleryE = arr; else _galleryF = arr;
  }
  function renderGalleryGrid(prefix) {
    const grid = document.getElementById(prefix + 'GalleryGrid');
    if (!grid) return;
    const arr = galleryArr(prefix);
    grid.innerHTML = arr.map((url, i) => `
      <div class="gallery-thumb">
        <img src="${escapeAttr(url)}" alt="">
        <button type="button" class="gallery-thumb-del" onclick="removeGalleryImage('${prefix}', ${i})" title="Sil">✕</button>
      </div>
    `).join('');
  }
  async function uploadGalleryImages(input, prefix) {
    const files = Array.from(input.files || []);
    if (!files.length) return;
    try {
      showToast('⏳ ' + files.length + ' şəkil yüklənir...');
      for (const file of files) {
        const url = await apiUpload(file);
        galleryArr(prefix).push(url);
      }
      renderGalleryGrid(prefix);
      showToast('✅ Şəkillər yükləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  function removeGalleryImage(prefix, idx) {
    const arr = galleryArr(prefix);
    arr.splice(idx, 1);
    setGalleryArr(prefix, arr);
    renderGalleryGrid(prefix);
  }
  function setProductImage(url) {
    document.getElementById('fImage').value = url || '';
    const box = document.getElementById('fImagePreview');
    box.innerHTML = url
      ? `<img src="${escapeAttr(url)}" alt="">`
      : '<span class="img-preview-empty">➕ Şəkil əlavə et</span>';
  }
  async function uploadProductImage(input) {
    const file = input.files && input.files[0];
    if (!file) return;
    try {
      showToast('⏳ Şəkil yüklənir...');
      const url = await apiUpload(file);
      setProductImage(url);
      showToast('✅ Şəkil yükləndi');
    } catch (e) {
      showToast('❌ ' + e.message, true);
    } finally {
      input.value = '';
    }
  }
  function clearProductImage() {
    setProductImage('');
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
