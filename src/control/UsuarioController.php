<?php
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioController {
    private function requireAdmin() {
        session_start();
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?c=auth&a=loginForm'); exit;
        }
        if (($_SESSION['user']['rol'] ?? '') !== 'admin') {
            http_response_code(403); echo 'Acceso restringido'; exit;
        }
    }

    public function index() {
        $this->requireAdmin();
        $usuarios = Usuario::all();
        require __DIR__ . '/../view/usuario/index.php';
    }

    public function create() {
        $this->requireAdmin();
        $usuario = ['id_usuario'=>null, 'usuario'=>'', 'rol'=>'editor'];
        $isEdit = false;
        require __DIR__ . '/../view/usuario/form.php';
    }

    public function store() {
        $this->requireAdmin();
        Usuario::create($_POST);
        header('Location: ' . BASE_URL . '?c=usuario&a=index');
    }

    public function edit() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $usuario = Usuario::find($id);
        if (!$usuario) { http_response_code(404); echo 'Usuario no encontrado'; exit; }
        $isEdit = true;
        require __DIR__ . '/../view/usuario/form.php';
    }

    public function update() {
        $this->requireAdmin();
        $id = (int)($_POST['id_usuario'] ?? 0);
        Usuario::update($id, $_POST);
        header('Location: ' . BASE_URL . '?c=usuario&a=index');
    }

    public function delete() {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        if (!empty($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
            http_response_code(400); echo 'No puedes eliminar tu propio usuario.'; exit;
        }
        Usuario::delete($id);
        header('Location: ' . BASE_URL . '?c=usuario&a=index');
    }
}
