<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login - Sistema de Canchas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{ --bg:#0b1220; --card:#0f172a; --ring:#1f2937; --brand:#2563eb; --muted:#9ca3af; }
    *{box-sizing:border-box} body{margin:0;background:var(--bg);font-family:Inter,system-ui,Arial,sans-serif;color:#fff}
    .wrap{min-height:100vh;display:grid;place-items:center;padding:24px}
    .card{background:var(--card);border:1px solid var(--ring);border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.25);
          width:100%;max-width:420px;padding:28px}
    h1{margin:0 0 8px 0} p{color:var(--muted);margin:0 0 18px 0}
    label{display:block;margin:10px 0 6px 0} input{width:100%;padding:12px;border-radius:12px;border:1px solid var(--ring);
          background:#111827;color:#fff}
    .btn{margin-top:16px;width:100%;padding:12px;border-radius:12px;border:1px solid #1d4ed8;background:#2563eb;color:#fff;font-weight:600}
    .error{background:rgba(239,68,68,.15);border:1px solid #b91c1c;color:#fecaca;padding:10px;border-radius:12px;margin-bottom:12px}
    .logo{display:flex;gap:8px;align-items:center;margin-bottom:10px;font-weight:700}
  </style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="logo"></div>
