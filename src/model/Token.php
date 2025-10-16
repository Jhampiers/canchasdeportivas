<?php
require_once __DIR__ . '/../library/conexion.php';

class Token {

  public static function all(): array {
    $sql = "SELECT t.*, c.razon_social, c.ruc
              FROM tokens t
              JOIN client_api c ON c.id = t.id_client_api
             ORDER BY t.id DESC";
    return Conexion::getConexion()->query($sql)->fetchAll();
  }

  public static function find(int $id): ?array {
    $st = Conexion::getConexion()->prepare("
      SELECT t.*, c.razon_social, c.ruc, c.telefono, c.correo
        FROM tokens t
        JOIN client_api c ON c.id = t.id_client_api
       WHERE t.id = ? LIMIT 1
    ");
    $st->execute([$id]);
    $r = $st->fetch();
    return $r ?: null;
  }

  public static function clients(): array {
    $sql = "SELECT id, ruc, razon_social FROM client_api ORDER BY razon_social";
    return Conexion::getConexion()->query($sql)->fetchAll();
  }

  public static function create(array $d): int {
    $st = Conexion::getConexion()->prepare("
      INSERT INTO tokens (id_client_api, token, estado)
      VALUES (?, ?, ?)
    ");
    $st->execute([
      (int)$d['id_client_api'],
      trim($d['token']),
      trim($d['estado'] ?? 'Activo'),
    ]);
    return (int) Conexion::getConexion()->lastInsertId();
  }

  public static function update(int $id, array $d): bool {
    $st = Conexion::getConexion()->prepare("
      UPDATE tokens SET id_client_api=?, token=?, estado=? WHERE id=?
    ");
    return $st->execute([
      (int)$d['id_client_api'],
      trim($d['token']),
      trim($d['estado'] ?? 'Activo'),
      $id
    ]);
  }
  //nuevo
  // Buscar token por su valor
  public static function findByToken(string $tokenValue): ?array {
    $st = Conexion::getConexion()->prepare("
      SELECT t.*, c.razon_social, c.ruc, c.estado as cliente_estado
        FROM tokens t
        JOIN client_api c ON c.id = t.id_client_api
       WHERE t.token = ? LIMIT 1
    ");
    $st->execute([trim($tokenValue)]);
    $r = $st->fetch();
    return $r ?: null;
  }
}
