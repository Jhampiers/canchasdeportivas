<?php require __DIR__ . '/../layout/header.php'; ?>
<h2><?= $isEdit ? 'Editar cancha' : 'Nueva cancha' ?></h2>

<form method="post" action="<?= BASE_URL ?>?c=cancha&a=<?= $isEdit ? 'update' : 'store' ?>" class="card">
  <?php if ($isEdit): ?>
    <input type="hidden" name="id_cancha" value="<?= $cancha['id_cancha'] ?>">
  <?php endif; ?>

<div class="form-grid" style="display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(250px,1fr))">
  <div>
    <label>Nombre *</label><br>
    <input name="nombre" required value="<?= htmlspecialchars($cancha['nombre']) ?>" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
  </div>
  <div>
    <label>Ubicación *</label><br>
    <input name="ubicacion" required value="<?= htmlspecialchars($cancha['ubicacion']) ?>" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
  </div>
  <div>
    <label>Estado</label><br>
    <select name="estado" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
      <?php foreach (['Disponible','Cerrado','Mantenimiento'] as $opt): ?>
        <option value="<?= $opt ?>" <?= $cancha['estado']===$opt?'selected':'' ?>><?= $opt ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label>Precio por hora (S/)</label><br>
    <input type="number" step="0.01" name="precio_hora" value="<?= htmlspecialchars($cancha['precio_hora']) ?>" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
  </div>
  <div>
    <label>Teléfono</label><br>
    <input name="telefono" value="<?= htmlspecialchars($cancha['telefono']) ?>" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px">
  </div>
  <div class="full" style="grid-column:1/-1">
    <label>Descripción</label><br>
    <textarea name="descripcion" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;min-height:100px"><?= htmlspecialchars($cancha['descripcion']) ?></textarea>
  </div>
</div>


  <div class="form-actions">
    <button class="btn primary" type="submit">Guardar</button>
    <a class="btn" href="<?= BASE_URL ?>?c=cancha&a=index">Cancelar</a>
  </div>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>
