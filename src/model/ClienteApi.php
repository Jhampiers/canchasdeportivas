<?php
require_once __DIR__ . '/../library/conexion.php';

class ClienteApi {
  public static function all(): array {
    $sql = "SELECT * FROM client_api ORDER BY id DESC";
    return Conexion::getConexion()->query($sql)->fetchAll();
  }

  public static function find(int $id): ?array {
    $st = Conexion::getConexion()->prepare("SELECT * FROM client_api WHERE id=? LIMIT 1");
    $st->execute([$id]);
    $r = $st->fetch();
    return $r ?: null;
  }

  public static function create(array $d): int {
    $st = Conexion::getConexion()->prepare("
      INSERT INTO client_api (ruc, razon_social, telefono, correo, estado)
      VALUES (?,?,?,?,?)
    ");
    $st->execute([
      trim($d['ruc']),
      trim($d['razon_social']),
      trim($d['telefono'] ?? ''),
      trim($d['correo'] ?? ''),
      trim($d['estado'] ?? 'Activo'),
    ]);
    return (int) Conexion::getConexion()->lastInsertId();
  }

  public static function update(int $id, array $d): bool {
    $st = Conexion::getConexion()->prepare("
      UPDATE client_api
         SET ruc=?, razon_social=?, telefono=?, correo=?, estado=?
       WHERE id=?
    ");
    return $st->execute([
      trim($d['ruc']),
      trim($d['razon_social']),
      trim($d['telefono'] ?? ''),
      trim($d['correo'] ?? ''),
      trim($d['estado'] ?? 'Activo'),
      $id
    ]);
  }

  public static function delete(int $id): bool {
    $st = Conexion::getConexion()->prepare("DELETE FROM client_api WHERE id=?");
    return $st->execute([$id]);
  }
}
