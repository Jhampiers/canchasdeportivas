<?php
require_once __DIR__ . '/../model/Usuario.php';

class AuthController {
    public function loginForm() {
        require __DIR__ . '/../view/auth/login.php';
    }

    public function login() {
        session_start();
        $usuario = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $row = Usuario::findByUsuario($usuario);
        if ($row && Usuario::verifyPassword($row, $password)) {
            $_SESSION['user'] = [
                'id'   => $row['id_usuario'],
                'name' => $row['usuario'],
                'rol'  => $row['rol']
            ];
            header('Location: ' . BASE_URL . '?c=dashboard&a=index');
            exit;
        }
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
        header('Location: ' . BASE_URL . '?c=auth&a=loginForm');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '?c=auth&a=loginForm');
    }
}
