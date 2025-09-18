<?php
require_once __DIR__ . '/../library/conexion.php';

class Usuario {
    public static function all(): array {
        $sql = "SELECT id_usuario, usuario, rol, fecha_registro FROM usuarios ORDER BY id_usuario DESC";
        return Conexion::getConexion()->query($sql)->fetchAll();
    }

    public static function find(int $id): ?array {
        $st = Conexion::getConexion()->prepare("SELECT * FROM usuarios WHERE id_usuario=? LIMIT 1");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function findByUsuario(string $usuario): ?array {
        $st = Conexion::getConexion()->prepare("SELECT * FROM usuarios WHERE usuario=? LIMIT 1");
        $st->execute([$usuario]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function create(array $data): int {
        $st = Conexion::getConexion()->prepare(
            "INSERT INTO usuarios (usuario, password, rol) VALUES (:usuario, :password, :rol)"
        );
        $st->execute([
            ':usuario'  => trim($data['usuario']),
            ':password' => md5($data['password'] ?? ''), // Compatibilidad con seed
            ':rol'      => $data['rol'] ?? 'editor'
        ]);
        return (int) Conexion::getConexion()->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        if (!empty($data['password'])) {
            $sql = "UPDATE usuarios SET usuario=:usuario, rol=:rol, password=:password WHERE id_usuario=:id";
            $params = [
                ':usuario' => trim($data['usuario']),
                ':rol' => $data['rol'] ?? 'editor',
                ':password' => md5($data['password']),
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE usuarios SET usuario=:usuario, rol=:rol WHERE id_usuario=:id";
            $params = [
                ':usuario' => trim($data['usuario']),
                ':rol' => $data['rol'] ?? 'editor',
                ':id' => $id
            ];
        }
        $st = Conexion::getConexion()->prepare($sql);
        return $st->execute($params);
    }

    public static function delete(int $id): bool {
        $st = Conexion::getConexion()->prepare("DELETE FROM usuarios WHERE id_usuario=?");
        return $st->execute([$id]);
    }

    // Login helper
    public static function verifyPassword(array $row, string $plain): bool {
        return isset($row['password']) && strtolower($row['password']) === md5($plain);
    }
}
