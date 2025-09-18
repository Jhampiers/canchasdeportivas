<?php
require_once __DIR__ . '/../model/Cancha.php';

class CanchaController {
    private function requireAuth() {
        session_start();
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?c=auth&a=loginForm');
            exit;
        }
    }

    public function index() {
        $this->requireAuth();
        $canchas = Cancha::all();
        require __DIR__ . '/../view/cancha/index.php';
    }

    public function create() {
        $this->requireAuth();
        $cancha = [
            'id_cancha'=> null, 'nombre'=>'', 'ubicacion'=>'', 'descripcion'=>'',
            'estado'=>'Disponible', 'precio_hora'=>'0.00', 'telefono'=>''
        ];
        $isEdit = false;
        require __DIR__ . '/../view/cancha/form.php';
    }

    public function store() {
        $this->requireAuth();
        Cancha::create($_POST);
        header('Location: ' . BASE_URL . '?c=cancha&a=index');
    }

    public function edit() {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $cancha = Cancha::find($id);
        if (!$cancha) { http_response_code(404); echo "Cancha no encontrada"; exit; }
        $isEdit = true;
        require __DIR__ . '/../view/cancha/form.php';
    }

    public function update() {
        $this->requireAuth();
        $id = (int)($_POST['id_cancha'] ?? 0);
        Cancha::update($id, $_POST);
        header('Location: ' . BASE_URL . '?c=cancha&a=index');
    }

    public function delete() {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        Cancha::delete($id);
        header('Location: ' . BASE_URL . '?c=cancha&a=index');
    }

    public function show() {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $cancha = Cancha::find($id);
        if (!$cancha) { http_response_code(404); echo "Cancha no encontrada"; exit; }
        require __DIR__ . '/../view/cancha/show.php';
    }
}
