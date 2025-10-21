<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Sistema de Canchas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root{
      --bg:#f5f7fb; --card:#ffffff; --muted:#6b7280; --text:#0f172a; --brand:#2563eb;
      --sidebar:#0f172a; --ring:#e5e7eb; --danger:#dc2626; --success:#10b981;
      --radius:14px; --shadow:0 8px 24px rgba(15,23,42,.08);
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,Arial,sans-serif;background:var(--bg);color:var(--text)}
    a{color:inherit;text-decoration:none}
    .layout{display:grid;grid-template-columns:260px 1fr;min-height:100vh}
    .sidebar{background:var(--sidebar);color:#fff;padding:22px 16px}
    .logo{font-weight:700;font-size:20px;margin-bottom:18px}
    .nav{display:flex;flex-direction:column;gap:6px}
    .nav a{padding:10px 12px;border-radius:10px;color:#cbd5e1;display:flex;align-items:center;gap:10px}
    .nav a i{color:#fff;font-size:18px}
    .nav a.active,.nav a:hover{background:#1f2937;color:#fff}
    .nav a.active i,.nav a:hover i{color:#fff}
    .main{display:flex;flex-direction:column}
    .topbar{background:#0b1220;color:#fff;display:flex;align-items:center;gap:12px;
            padding:12px 20px;position:sticky;top:0;z-index:5}
    .search{flex:1}
    .search input{width:100%;padding:10px 12px;border-radius:12px;border:1px solid #374151;background:#0f172a;color:#fff}
    .user{display:flex;align-items:center;gap:10px}
    .avatar{width:32px;height:32px;border-radius:50%;background:#374151}
    .content{padding:24px;max-width:1200px;margin:0 auto;width:100%}
    .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
    .card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);padding:16px}
    .kpi{display:flex;align-items:center;gap:12px}
    .kpi .dot{width:38px;height:38px;border-radius:10px;display:grid;place-items:center}
    .muted{color:var(--muted)}
    .two{display:grid;grid-template-columns:2fr 1.2fr;gap:16px;margin-top:16px}
    table{width:100%;border-collapse:collapse}
    th,td{padding:12px;border-bottom:1px solid var(--ring);text-align:left;font-size:14px}
    .tag{padding:4px 8px;border-radius:999px;font-size:12px}
    .tag.ok{background:rgba(16,185,129,.12);color:#047857}
    .tag.closed{background:rgba(239,68,68,.12);color:#991b1b}
    .tag.maint{background:rgba(245,158,11,.12);color:#92400e}
    .btn{display:inline-block;padding:10px 14px;border-radius:12px;border:1px solid var(--ring);background:#fff;cursor:pointer}
    .btn.primary{background:var(--brand);color:#fff;border-color:#1d4ed8}
    .btn:focus{outline:none;box-shadow:0 0 0 4px rgba(37,99,235,.2)}
    /* Formularios */
    label{display:block;margin:6px 0 6px 2px;font-weight:600}
    input[type="text"], input[type="number"], input[type="password"], textarea, select{
      width:100%;padding:11px 12px;border-radius:12px;border:1px solid var(--ring);
      background:#fff;color:var(--text);
    }
    input:focus, textarea:focus, select:focus{outline:none;border-color:#c7d2fe;box-shadow:0 0 0 4px rgba(37,99,235,.15)}
    textarea{resize:vertical;min-height:110px}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .form-grid .full{grid-column:1/-1}
    .form-actions{display:flex;gap:10px;margin-top:12px}
    @media(max-width:900px){ .form-grid{grid-template-columns:1fr} }
    @media(max-width:1100px){
      .layout{grid-template-columns:80px 1fr}
      .nav a span{display:none}
      .grid{grid-template-columns:repeat(2,1fr)}
      .two{grid-template-columns:1fr}
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="logo">SISTEMA FUTBOL</div>
    <nav class="nav">
      <a href="<?= BASE_URL ?>?c=dashboard&a=index" class="<?= ($_GET['c']??'')==='dashboard'?'active':'' ?>">
        <i class="fa-solid fa-house"></i> <span>Inicio</span>
      </a>
      <a href="<?= BASE_URL ?>?c=cancha&a=index" class="<?= ($_GET['c']??'')==='cancha'?'active':'' ?>">
        <i class="fa-solid fa-futbol"></i> <span>Canchas</span>
      </a>
      <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['rol'] ?? '')==='admin'): ?>
      <a href="<?= BASE_URL ?>?c=usuario&a=index" class="<?= ($_GET['c']??'')==='usuario'?'active':'' ?>">
        <i class="fa-solid fa-user"></i> <span>Usuarios</span>
      </a>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['rol'] ?? '')==='admin'): ?>
  <a href="<?= BASE_URL ?>?c=clienteapi&a=index" class="<?= ($_GET['c']??'')==='clienteapi'?'active':'' ?>">
    <i class="fa-solid fa-building"></i> <span>Clientes</span>
  </a>
<?php endif; ?>
<?php if (!empty($_SESSION['user'])): ?>
  <a href="<?= BASE_URL ?>?c=token&a=index" class="<?= (($_GET['c'] ?? '')==='token')?'active':'' ?>">
    <i class="fa-solid fa-key"></i> <span>Tokens</span>
  </a>
<?php endif; ?>
<?php if (!empty($_SESSION['user'])): ?>
  <a href="<?= BASE_URL ?>?c=consumoApi&a=vistaTest" class="<?= (($_GET['c'] ?? '')==='consumoApi')?'active':'' ?>">
    <i class="fa-solid fa-vial"></i> <span>Consumo API</span>
  </a>
<?php endif; ?>

      <div style="margin-top:auto;border-top:1px solid #1f2937;padding-top:12px">
        <a href="<?= BASE_URL ?>?c=auth&a=logout">
          <i class="fa-solid fa-right-from-bracket"></i> <span>Salir</span>
        </a>
      </div>
    </nav>
  </aside>

  <main class="main">
    <div class="topbar">
      <div class="search"><input placeholder="Buscar..." /></div>
      <div class="user"><div class="avatar"></div>
        <div style="font-size:14px">
          <div><strong><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?></strong></div>
          <div class="muted"><?= htmlspecialchars($_SESSION['user']['rol'] ?? 'Administrador') ?></div>
        </div>
      </div>
    </div>

    <div class="content">
