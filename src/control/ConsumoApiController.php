<?php
require_once __DIR__ . '/../model/Token.php';
require_once __DIR__ . '/../model/ClienteApi.php';
require_once __DIR__ . '/../model/Cancha.php';

class ConsumoApiController
{
    /**
     * Punto de entrada principal para consumo de API
     * Valida token, procesa petición y devuelve JSON
     */
    public function procesar()
    {
        // Configurar headers para JSON
        header('Content-Type: application/json; charset=utf-8');
        
        // 1. VALIDAR MÉTODO HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responderError('Método no permitido. Use POST', 405);
            return;
        }

        // 2. OBTENER DATOS DE LA PETICIÓN
        $tipo = $_POST['tipo'] ?? '';
        $token = $_POST['token'] ?? '';
        $data = $_POST['data'] ?? '';

        // 3. VALIDAR QUE SE ENVIÓ UN TOKEN
        if (empty($token)) {
            $this->responderError('Token no proporcionado', 401);
            return;
        }

        // 4. VALIDAR TOKEN EN BASE DE DATOS
        $tokenData = Token::findByToken($token);
        
        if (!$tokenData) {
            $this->responderError('Token inválido', 401);
            return;
        }

        // 5. VERIFICAR QUE EL TOKEN ESTÉ ACTIVO
        if ($tokenData['estado'] !== 'Activo') {
            $this->responderError('Token inactivo', 401);
            return;
        }

        // 6. VERIFICAR QUE EL CLIENTE API ESTÉ ACTIVO
        if ($tokenData['cliente_estado'] !== 'Activo') {
            $this->responderError('Cliente API no está activo', 403);
            return;
        }

        // 7. PROCESAR LA PETICIÓN SEGÚN EL TIPO
        switch ($tipo) {
            case 'buscar_cancha_nombre':
                $this->buscarCanchaPorNombre($data, $tokenData);
                break;

            case 'buscar_cancha_ubicacion':
                $this->buscarCanchaPorUbicacion($data, $tokenData);
                break;

            case 'listar_canchas':
                $this->listarCanchas($tokenData);
                break;

            case 'listar_canchas_disponibles':
                $this->listarCanchasDisponibles($tokenData);
                break;

            default:
                $this->responderError('Tipo de operación no válida', 400);
        }
    }

    /**
     * Buscar canchas por nombre
     */
    private function buscarCanchaPorNombre($nombre, $tokenData)
    {
        if (empty($nombre)) {
            $this->responderError('Debe proporcionar un nombre para buscar', 400);
            return;
        }

        $canchas = ClienteApi::buscarCanchasPorNombre($nombre);
        
        $this->responderExito([
            'cliente' => $tokenData['razon_social'],
            'total' => count($canchas),
            'canchas' => $canchas
        ]);
    }

    /**
     * Buscar canchas por ubicación
     */
    private function buscarCanchaPorUbicacion($ubicacion, $tokenData)
    {
        if (empty($ubicacion)) {
            $this->responderError('Debe proporcionar una ubicación para buscar', 400);
            return;
        }

        $canchas = ClienteApi::buscarCanchasPorUbicacion($ubicacion);
        
        $this->responderExito([
            'cliente' => $tokenData['razon_social'],
            'total' => count($canchas),
            'canchas' => $canchas
        ]);
    }

    /**
     * Listar todas las canchas
     */
    private function listarCanchas($tokenData)
    {
        $canchas = Cancha::all();
        
        $this->responderExito([
            'cliente' => $tokenData['razon_social'],
            'total' => count($canchas),
            'canchas' => $canchas
        ]);
    }

    /**
     * Listar solo canchas disponibles
     */
    private function listarCanchasDisponibles($tokenData)
    {
        $todasCanchas = Cancha::all();
        $disponibles = array_filter($todasCanchas, function($cancha) {
            return $cancha['estado'] === 'Disponible';
        });
        
        $this->responderExito([
            'cliente' => $tokenData['razon_social'],
            'total' => count($disponibles),
            'canchas' => array_values($disponibles)
        ]);
    }

    /**
     * Responder con éxito
     */
    private function responderExito($contenido)
    {
        echo json_encode([
            'status' => true,
            'mensaje' => 'Consulta exitosa',
            'data' => $contenido
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Responder con error
     */
    private function responderError($mensaje, $codigo = 400)
    {
        http_response_code($codigo);
        echo json_encode([
            'status' => false,
            'mensaje' => $mensaje,
            'data' => null
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Vista de prueba en el dashboard (solo para pruebas)
     */
    /** public function vistaTest()
    {
        // Verificar autenticación
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '?c=auth&a=loginForm'); 
            exit;
        }

        // Obtener todos los tokens activos para el formulario
        $tokens = Token::all();
        
        require __DIR__ . '/../view/consumoapi/test.php';
    }  */
public function vistaTest()
    {
        //  Ya no pedimos login ni sesión
        $tokens = Token::all();

        // Usa tu header y footer propios
        require __DIR__ . '/../view/consumoapi/header_test.php';
        require __DIR__ . '/../view/consumoapi/test.php';
        require __DIR__ . '/../view/consumoapi/footer_test.php';
    }
    

}