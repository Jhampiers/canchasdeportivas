<?php require __DIR__ . '/../layout/header.php'; ?>
<div style="display:flex;justify-content:space-between;align-items:center">
  <h2>Canchas</h2>
  <a class="btn primary" href="<?= BASE_URL ?>?c=cancha&a=create">+ Nueva cancha</a>
</div>
<table>
  <thead>
    <tr>
      <th>ID</th><th>Nombre</th><th>Ubicación</th><th>Estado</th>
      <th>Precio/Hora</th><th>Teléfono</th><th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($canchas as $c): ?>
      <tr>
        <td><?= $c['id_cancha'] ?></td>
        <td><a href="<?= BASE_URL ?>?c=cancha&a=show&id=<?= $c['id_cancha'] ?>">
          <?= htmlspecialchars($c['nombre']) ?></a></td>
        <td><?= htmlspecialchars($c['ubicacion']) ?></td>
        <td><?= htmlspecialchars($c['estado']) ?></td>
        <td>S/ <?= number_format($c['precio_hora'],2) ?></td>
        <td><?= htmlspecialchars($c['telefono']) ?></td>
        <td>
          <a class="btn" href="<?= BASE_URL ?>?c=cancha&a=edit&id=<?= $c['id_cancha'] ?>">Editar</a>
          <a class="btn" style="background:#dc2626;color:#fff;border-color:#b91c1c"
             onclick="return confirm('¿Eliminar cancha?')"
             href="<?= BASE_URL ?>?c=cancha&a=delete&id=<?= $c['id_cancha'] ?>">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
