<?php
require_once __DIR__ . '/../library/conexion.php';

class Cancha {
    public static function all(): array {
        $sql = "SELECT * FROM canchas ORDER BY id_cancha DESC";
        return Conexion::getConexion()->query($sql)->fetchAll();
    }

    public static function find(int $id): ?array {
        $st = Conexion::getConexion()->prepare("SELECT * FROM canchas WHERE id_cancha=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function create(array $data): int {
        $sql = "INSERT INTO canchas (nombre, ubicacion, descripcion, estado, precio_hora, telefono)
                VALUES (:nombre,:ubicacion,:descripcion,:estado,:precio_hora,:telefono)";
        $st = Conexion::getConexion()->prepare($sql);
        $st->execute([
            ':nombre'      => trim($data['nombre'] ?? ''),
            ':ubicacion'   => trim($data['ubicacion'] ?? ''),
            ':descripcion' => $data['descripcion'] ?? null,
            ':estado'      => $data['estado'] ?? 'Disponible',
            ':precio_hora' => ($data['precio_hora'] ?? '') !== '' ? $data['precio_hora'] : 0,
            ':telefono'    => $data['telefono'] ?? null,
        ]);
        return (int) Conexion::getConexion()->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $sql = "UPDATE canchas SET
                    nombre=:nombre, ubicacion=:ubicacion, descripcion=:descripcion,
                    estado=:estado, precio_hora=:precio_hora, telefono=:telefono
                WHERE id_cancha=:id";
        $st = Conexion::getConexion()->prepare($sql);
        return $st->execute([
            ':nombre'      => trim($data['nombre'] ?? ''),
            ':ubicacion'   => trim($data['ubicacion'] ?? ''),
            ':descripcion' => $data['descripcion'] ?? null,
            ':estado'      => $data['estado'] ?? 'Disponible',
            ':precio_hora' => ($data['precio_hora'] ?? '') !== '' ? $data['precio_hora'] : 0,
            ':telefono'    => $data['telefono'] ?? null,
            ':id'          => $id
        ]);
    }

    public static function delete(int $id): bool {
        $st = Conexion::getConexion()->prepare("DELETE FROM canchas WHERE id_cancha=?");
        return $st->execute([$id]);
    }
}
