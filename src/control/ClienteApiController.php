<?php
require_once __DIR__ . '/../model/ClienteApi.php';

class ClienteApiController
{
    /**
     * Requiere sesión iniciada (sirve para vistas de solo lectura, como show).
     */
    private function requireAuth()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?c=auth&a=loginForm');
            exit;
        }
    }

    /**
     * Requiere sesión + rol admin (gestión completa).
     */
    private function requireAdmin()
    {
        $this->requireAuth();
        if (($_SESSION['user']['rol'] ?? '') !== 'admin') {
            http_response_code(403);
            echo 'Acceso restringido';
            exit;
        }
    }

    /**
     * Listado de clientes (solo admin).
     */
    public function index()
    {
        $this->requireAdmin();
        $clientes = ClienteApi::all();
        require __DIR__ . '/../view/cliente_api/index.php';
    }

    /**
     * Formulario de nuevo cliente (solo admin).
     */
    public function create()
    {
        $this->requireAdmin();
        $cliente = [
            'id'            => null,
            'ruc'           => '',
            'razon_social'  => '',
            'telefono'      => '',
            'correo'        => '',
            'estado'        => 'Activo'
        ];
        $isEdit = false;
        require __DIR__ . '/../view/cliente_api/form.php';
    }

    /**
     * Guarda un nuevo cliente (solo admin).
     */
    public function store()
    {
        $this->requireAdmin();

        // Validación mínima
        if (empty($_POST['ruc']) || empty($_POST['razon_social'])) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'RUC y Razón social son obligatorios';
            header('Location: ' . BASE_URL . '?c=clienteapi&a=create');
            exit;
        }

        ClienteApi::create($_POST);
        header('Location: ' . BASE_URL . '?c=clienteapi&a=index');
    }

    /**
     * Formulario de edición (solo admin).
     */
    public function edit()
    {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $cliente = ClienteApi::find($id);
        if (!$cliente) {
            http_response_code(404);
            echo 'Cliente no encontrado';
            exit;
        }
        $isEdit = true;
        require __DIR__ . '/../view/cliente_api/form.php';
    }

    /**
     * Actualiza cliente (solo admin).
     */
    public function update()
    {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);

        if (empty($_POST['ruc']) || empty($_POST['razon_social'])) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'RUC y Razón social son obligatorios';
            header('Location: ' . BASE_URL . '?c=clienteapi&a=edit&id=' . $id);
            exit;
        }

        ClienteApi::update($id, $_POST);
        header('Location: ' . BASE_URL . '?c=clienteapi&a=index');
    }

    /**
     * Elimina cliente (solo admin). En la vista ya no mostramos "Eliminar".
     * Si no quieres permitirlo en absoluto, puedes comentar o borrar este método.
     */
    public function delete()
    {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        ClienteApi::delete($id);
        header('Location: ' . BASE_URL . '?c=clienteapi&a=index');
    }

    /**
     * Ver detalle de un cliente (requiere sesión, puede ver invitado).
     */
    public function show()
    {
        $this->requireAuth(); // cambia a requireAdmin() si quieres que solo admin pueda ver
        $id = (int)($_GET['id'] ?? 0);
        $cliente = ClienteApi::find($id);
        if (!$cliente) {
            http_response_code(404);
            echo 'Cliente no encontrado';
            exit;
        }
        require __DIR__ . '/../view/cliente_api/show.php';
    }
}


