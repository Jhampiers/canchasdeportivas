<?php require __DIR__ . '/../layout/header.php'; ?>
<style>
  .cap-wrap{padding:16px}
  .cap-card{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08);padding:16px;margin-bottom:16px}
  .cap-title{font-size:20px;font-weight:700;margin-bottom:10px}
  .cap-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
  .cap-item{background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:12px}
  .cap-label{font-size:12px;color:#6b7280;margin-bottom:4px}
  .cap-value{font-size:16px;font-weight:600}
  .cap-actions{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap}
  .cap-btn{display:inline-block;padding:10px 12px;border-radius:10px;border:1px solid #e5e7eb;background:#fff;color:#111827;text-decoration:none}
  .cap-btn.primary{background:#2563eb;color:#fff;border-color:#1d4ed8}
  @media (max-width:760px){ .cap-grid{grid-template-columns:1fr} }
</style>

<div class="cap-wrap">
  <div class="cap-card">
    <div class="cap-title"><i class="fa-solid fa-key"></i> Detalle de token</div>

    <div class="cap-grid">
      <div class="cap-item">
        <div class="cap-label">Cliente</div>
        <div class="cap-value"><?= htmlspecialchars(($token['razon_social'] ?? '').' — '.($token['ruc'] ?? '')) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Token</div>
        <div class="cap-value"><code><?= htmlspecialchars($token['token']) ?></code></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Estado</div>
        <div class="cap-value"><?= htmlspecialchars($token['estado']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Fecha registro</div>
        <div class="cap-value"><?= htmlspecialchars($token['fecha_reg']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Contacto</div>
        <div class="cap-value"><?= htmlspecialchars(($token['telefono'] ?? '').' — '.($token['correo'] ?? '')) ?></div>
      </div>
    </div>

    <div class="cap-actions">
      <a class="cap-btn" href="<?= BASE_URL ?>?c=token&a=index">Volver</a>
      <?php if (($_SESSION['user']['rol'] ?? '')==='admin'): ?>
        <a class="cap-btn primary" href="<?= BASE_URL ?>?c=token&a=edit&id=<?= (int)$token['id'] ?>">Editar</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
