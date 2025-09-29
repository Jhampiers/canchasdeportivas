<?php require __DIR__ . '/../layout/header.php'; ?>
<style>
  .cap-card{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08);padding:16px;margin-bottom:16px}
  .cap-title{font-size:20px;font-weight:700;margin-bottom:10px}
  .cap-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  .cap-grid .full{grid-column:1/-1}
  label{display:block;margin:6px 0 6px 2px;font-weight:600}
  input,select{width:100%;padding:11px 12px;border-radius:12px;border:1px solid #e5e7eb;background:#fff}
  .cap-actions{display:flex;gap:10px;margin-top:12px;flex-wrap:wrap}
  .cap-btn{display:inline-block;padding:10px 12px;border-radius:10px;border:1px solid #e5e7eb;background:#fff;cursor:pointer}
  .cap-btn.primary{background:#2563eb;color:#fff;border-color:#1d4ed8}
  .alert{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:12px}
  @media (max-width:700px){ .cap-grid{grid-template-columns:1fr} }
</style>

<div class="cap-card">
  <div class="cap-title"><i class="fa-solid fa-building"></i> <?= !empty($isEdit)?'Editar':'Nuevo' ?> cliente</div>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>?c=clienteapi&a=<?= !empty($isEdit)?'update':'store' ?>">
    <?php if (!empty($isEdit)): ?>
      <input type="hidden" name="id" value="<?= (int)$cliente['id'] ?>">
    <?php endif; ?>

    <div class="cap-grid">
      <div>
        <label>RUC *</label>
        <input name="ruc" maxlength="20" required value="<?= htmlspecialchars($cliente['ruc'] ?? '') ?>">
      </div>
      <div>
        <label>Razón social *</label>
        <input name="razon_social" maxlength="150" required value="<?= htmlspecialchars($cliente['razon_social'] ?? '') ?>">
      </div>
      <div>
        <label>Teléfono</label>
        <input name="telefono" maxlength="20" value="<?= htmlspecialchars($cliente['telefono'] ?? '') ?>">
      </div>
      <div>
        <label>Correo</label>
        <input type="email" name="correo" maxlength="150" value="<?= htmlspecialchars($cliente['correo'] ?? '') ?>">
      </div>
      <div class="full">
        <label>Estado</label>
        <select name="estado">
          <?php foreach (['Activo','Inactivo','Pendiente'] as $e): ?>
            <option value="<?= $e ?>" <?= (($cliente['estado'] ?? 'Activo')===$e?'selected':'') ?>><?= $e ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="cap-actions">
      <button class="cap-btn primary" type="submit">Guardar</button>
      <a class="cap-btn" href="<?= BASE_URL ?>?c=clienteapi&a=index">Cancelar</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
