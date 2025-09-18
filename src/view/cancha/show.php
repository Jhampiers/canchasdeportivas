<?php require __DIR__ . '/../layout/header.php'; ?>
<h2><?= htmlspecialchars($cancha['nombre']) ?></h2>
<p><strong>Ubicación:</strong> <?= htmlspecialchars($cancha['ubicacion']) ?></p>
<p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($cancha['descripcion'])) ?></p>
<p><strong>Estado:</strong> <?= htmlspecialchars($cancha['estado']) ?></p>
<p><strong>Precio/Hora:</strong> S/ <?= number_format($cancha['precio_hora'],2) ?></p>
<p><strong>Teléfono:</strong> <?= htmlspecialchars($cancha['telefono']) ?></p>
<p><strong>Registrado:</strong> <?= htmlspecialchars($cancha['fecha_registro']) ?></p>
<p>
  <a class="btn" href="<?= BASE_URL ?>?c=cancha&a=edit&id=<?= $cancha['id_cancha'] ?>">Editar</a>
  <a class="btn" href="<?= BASE_URL ?>?c=cancha&a=index">Volver</a>
</p>
<?php require __DIR__ . '/../layout/footer.php'; ?>
