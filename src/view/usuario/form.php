<?php require __DIR__ . '/../layout/header.php'; ?>
<h2><?= $isEdit ? 'Editar usuario' : 'Nuevo usuario' ?></h2>

<form method="post" action="<?= BASE_URL ?>?c=usuario&a=<?= $isEdit ? 'update' : 'store' ?>" class="card" style="max-width:700px">
  <?php if ($isEdit): ?>
    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
  <?php endif; ?>

  <div class="form-grid" style="display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(250px,1fr))">
    <div>
      <label>Usuario *</label><br>
      <input name="usuario" required value="<?= htmlspecialchars($usuario['usuario']) ?>"
        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
    </div>
    <div>
      <label>Rol *</label><br>
      <select name="rol" required
        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
        <?php foreach (['admin', 'invitado'] as $r): ?>
          <option value="<?= $r ?>" <?= ($usuario['rol'] ?? 'invitado') === $r ? 'selected' : '' ?>>
            <?= ucfirst($r) ?>
          </option>
        <?php endforeach; ?>
      </select>

      </select>
    </div>
    <div class="full" style="grid-column:1/-1">
      <label><?= $isEdit ? 'Nueva contraseña (opcional)' : 'Contraseña *' ?></label><br>
      <input type="password" name="password" <?= $isEdit ? '' : 'required' ?>
        style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
    </div>
  </div>


  <div class="form-actions">
    <button class="btn primary" type="submit">Guardar</button>
    <a class="btn" href="<?= BASE_URL ?>?c=usuario&a=index">Cancelar</a>
  </div>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>