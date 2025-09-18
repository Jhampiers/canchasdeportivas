<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require __DIR__ . '/../layout/auth_header.php';
?>
<h1>Iniciar sesión</h1>
<p>Ingresa tus datos para continuar.</p>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="error"><?= htmlspecialchars($_SESSION['error']); $_SESSION['error']=null; ?></div>
<?php endif; ?>
<form method="post" action="<?= BASE_URL ?>?c=auth&a=login">
  <label>Usuario</label>
  <input name="usuario" required autofocus>
  <label>Contraseña</label>
  <input type="password" name="password" required>
  <button class="btn" type="submit">Entrar</button>
</form>
<?php require __DIR__ . '/../layout/auth_footer.php'; ?>
