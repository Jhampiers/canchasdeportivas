<?php
require_once __DIR__ . '/../config/config.php';

class Conexion {
    public static function getConexion(): PDO {
        static $pdo = null;
        if ($pdo === null) {
            $dsn = "mysql:host=" . BD_HOST . ";dbname=" . BD_NAME . ";charset=" . BD_CHARSET;
            $opts = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, BD_USER, BD_PASSWORD, $opts);
            date_default_timezone_set("America/Lima");
        }
        return $pdo;
    }
}
