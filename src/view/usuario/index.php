<?php require __DIR__ . '/../layout/header.php'; ?>
<div style="display:flex;justify-content:space-between;align-items:center">
  <h2>Usuarios</h2>
  <a class="btn primary" href="<?= BASE_URL ?>?c=usuario&a=create">+ Nuevo usuario</a>
</div>
<table>
  <thead>
    <tr>
      <th>ID</th><th>Usuario</th><th>Rol</th><th>Fecha registro</th><th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($usuarios as $u): ?>
      <tr>
        <td><?= $u['id_usuario'] ?></td>
        <td><?= htmlspecialchars($u['usuario']) ?></td>
        <td><?= htmlspecialchars($u['rol']) ?></td>
        <td><?= htmlspecialchars($u['fecha_registro']) ?></td>
        <td>
          <a class="btn" href="<?= BASE_URL ?>?c=usuario&a=edit&id=<?= $u['id_usuario'] ?>">Editar</a>
          <!--<a class="btn" style="background:#dc2626;color:#fff;border-color:#b91c1c"
             onclick="return confirm('¿Eliminar usuario?')"
             href="<?= BASE_URL ?>?c=usuario&a=delete&id=<?= $u['id_usuario'] ?>">Eliminar</a>-->
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
