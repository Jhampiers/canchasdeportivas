<?php
require_once __DIR__ . '/src/config/config.php';

// Login primero
$c = $_GET['c'] ?? 'auth';
$a = $_GET['a'] ?? 'loginForm';

$controllers = [
    'auth'      => __DIR__ . '/src/control/AuthController.php',
    'cancha'    => __DIR__ . '/src/control/CanchaController.php',
    'dashboard' => __DIR__ . '/src/control/DashboardController.php',
    'usuario'   => __DIR__ . '/src/control/UsuarioController.php',
    'clienteapi'=> __DIR__ . '/src/control/ClienteApiController.php',
    'token'     => __DIR__ . '/src/control/TokenController.php', 
    'consumoApi'     => __DIR__ . '/src/control/ConsumoApiController.php', 

];

if (!isset($controllers[$c])) { http_response_code(404); exit('Controlador no encontrado'); }
require_once $controllers[$c];

$classname = ucfirst($c) . 'Controller';
$controller = new $classname();

if (!method_exists($controller, $a)) { http_response_code(404); exit('Acción no encontrada'); }
$controller->$a();
