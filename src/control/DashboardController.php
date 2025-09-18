<?php
require_once __DIR__ . '/../model/Cancha.php';
require_once __DIR__ . '/../library/conexion.php';

class DashboardController {
  private function requireAuth() {
    session_start();
    if (empty($_SESSION['user'])) {
      header('Location: ' . BASE_URL . '?c=auth&a=loginForm');
      exit;
    }
  }

  public function index() {
    $this->requireAuth();

    $db = Conexion::getConexion();
    $total     = (int)$db->query("SELECT COUNT(*) c FROM canchas")->fetch()['c'];
    $dispon    = (int)$db->query("SELECT COUNT(*) c FROM canchas WHERE estado='Disponible'")->fetch()['c'];
    $cerradas  = (int)$db->query("SELECT COUNT(*) c FROM canchas WHERE estado='Cerrado'")->fetch()['c'];
    $mant      = (int)$db->query("SELECT COUNT(*) c FROM canchas WHERE estado='Mantenimiento'")->fetch()['c'];
    $avgPrecio = (float)$db->query("SELECT COALESCE(AVG(precio_hora),0) p FROM canchas")->fetch()['p'];

    $ultimas = $db->query("SELECT id_cancha, nombre, ubicacion, estado, precio_hora, fecha_registro
                           FROM canchas ORDER BY fecha_registro DESC LIMIT 8")->fetchAll();

    $serie = $db->query("
      SELECT DATE(fecha_registro) d, COUNT(*) c
      FROM canchas
      WHERE fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
      GROUP BY DATE(fecha_registro)
      ORDER BY d
    ")->fetchAll();

    require __DIR__ . '/../view/dashboard/index.php';
  }
}
