<?php
require_once __DIR__ . '/../model/ClienteApi.php';

class ClienteApiController
{
    private function requireAuth()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?c=auth&a=loginForm');
            exit;
        }
    }

    private function requireAdmin()
    {
        $this->requireAuth();
        if (($_SESSION['user']['rol'] ?? '') !== 'admin') {
            http_response_code(403);
            echo 'Acceso restringido';
            exit;
        }
    }

    public function index()
    {
        $this->requireAdmin();
        $clientes = ClienteApi::all();
        require __DIR__ . '/../view/cliente_api/index.php';
    }

    public function create()
    {
        $this->requireAdmin();
        $cliente = [
            'id' => null,
            'ruc' => '',
            'razon_social' => '',
            'telefono' => '',
            'correo' => '',
            'estado' => 'Activo'
        ];
        $isEdit = false;
        require __DIR__ . '/../view/cliente_api/form.php';
    }

    public function store()
    {
        $this->requireAdmin();
        if (empty($_POST['ruc']) || empty($_POST['razon_social'])) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'RUC y Razón social son obligatorios';
            header('Location: ' . BASE_URL . '?c=clienteapi&a=create');
            exit;
        }

        ClienteApi::create($_POST);
        header('Location: ' . BASE_URL . '?c=clienteapi&a=index');
    }

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

    public function delete()
    {
        $this->requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        ClienteApi::delete($id);
        header('Location: ' . BASE_URL . '?c=clienteapi&a=index');
    }

    public function show()
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $cliente = ClienteApi::find($id);
        if (!$cliente) {
            http_response_code(404);
            echo 'Cliente no encontrado';
            exit;
        }
        require __DIR__ . '/../view/cliente_api/show.php';
    }

    // clase
    public function verCanchaApiByNombre()
    {
        $tipo = $_POST['tipo'] ?? '';
        $token = $_POST['token'] ?? '';
        $objApi = new ClienteApi();

        if ($tipo == "verCanchaApiByNombre") {
            $token_arr = explode("-", $token);
            $id_cliente = $token_arr[2] ?? null;
            $arr_cliente = $objApi->buscarclienteById($id_cliente);

            if ($arr_cliente && $arr_cliente->estado) {
                $data = $_POST['data'] ?? '';
                $arr_canchas = $objApi->buscarCanchaByDenominacion($data);
                $arr_Respuesta = array(
                    'status' => true,
                    'msg' => '',
                    'contenido' => $arr_canchas
                );
            } else {
                $arr_Respuesta = array(
                    'status' => false,
                    'msg' => 'Error, cliente no activo.'
                );
            }

            echo json_encode($arr_Respuesta);
        }
    }
}


