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
    <div class="cap-title"><i class="fa-solid fa-building"></i> Detalle de cliente</div>

    <div class="cap-grid">
      <div class="cap-item">
        <div class="cap-label">RUC</div>
        <div class="cap-value"><?= htmlspecialchars($cliente['ruc']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Razón social</div>
        <div class="cap-value"><?= htmlspecialchars($cliente['razon_social']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Teléfono</div>
        <div class="cap-value"><?= htmlspecialchars($cliente['telefono']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Correo</div>
        <div class="cap-value"><?= htmlspecialchars($cliente['correo']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Estado</div>
        <div class="cap-value"><?= htmlspecialchars($cliente['estado']) ?></div>
      </div>
      <div class="cap-item">
        <div class="cap-label">Fecha registro</div>
        <div class="cap-value"><?= htmlspecialchars($cliente['fecha_registro']) ?></div>
      </div>
    </div>

    <div class="cap-actions">
      <a class="cap-btn" href="<?= BASE_URL ?>?c=clienteapi&a=index">Volver</a>
      <a class="cap-btn primary" href="<?= BASE_URL ?>?c=clienteapi&a=edit&id=<?= (int)$cliente['id'] ?>">Editar</a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
