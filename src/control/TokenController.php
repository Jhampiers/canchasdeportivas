<?php
require_once __DIR__ . '/../model/Token.php';

class TokenController
{
  private function requireAuth(){
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (empty($_SESSION['user'])) {
      header('Location: ' . BASE_URL . '?c=auth&a=loginForm'); exit;
    }
  }

  private function requireAdmin(){
    $this->requireAuth();
    if (($_SESSION['user']['rol'] ?? '') !== 'admin') {
      http_response_code(403); echo 'Acceso restringido'; exit;
    }
  }

  /** Listado (solo admin) */
  public function index(){
    $this->requireAdmin();
    $tokens = Token::all();
    require __DIR__ . '/../view/tokens/index.php';
  }

  /** Nuevo (solo admin) */
  public function create(){
    $this->requireAdmin();
    $clients = Token::clients();
    $token   = ['id'=>null,'id_client_api'=>'','token'=>'','estado'=>'Activo'];
    $isEdit  = false;
    require __DIR__ . '/../view/tokens/form.php';
  }

  /** Guardar (solo admin) */
  public function store(){
    $this->requireAdmin();
    if (empty($_POST['id_client_api']) || empty($_POST['token'])) {
      if (session_status() !== PHP_SESSION_ACTIVE) session_start();
      $_SESSION['error'] = 'Cliente y Token son obligatorios';
      header('Location: ' . BASE_URL . '?c=token&a=create'); exit;
    }
    Token::create($_POST);
    header('Location: ' . BASE_URL . '?c=token&a=index');
  }

  /** Editar (solo admin) */
  public function edit(){
    $this->requireAdmin();
    $id = (int)($_GET['id'] ?? 0);
    $token = Token::find($id);
    if (!$token){ http_response_code(404); echo 'Token no encontrado'; exit; }
    $clients = Token::clients();
    $isEdit  = true;
    require __DIR__ . '/../view/tokens/form.php';
  }

  /** Actualizar (solo admin) */
  public function update(){
    $this->requireAdmin();
    $id = (int)($_POST['id'] ?? 0);
    if (empty($_POST['id_client_api']) || empty($_POST['token'])) {
      if (session_status() !== PHP_SESSION_ACTIVE) session_start();
      $_SESSION['error'] = 'Cliente y Token son obligatorios';
      header('Location: ' . BASE_URL . '?c=token&a=edit&id='.$id); exit;
    }
    Token::update($id, $_POST);
    header('Location: ' . BASE_URL . '?c=token&a=index');
  }

  /** Ver detalle (cualquier usuario logueado) */
  public function show(){
    $this->requireAuth();
    $id = (int)($_GET['id'] ?? 0);
    $token = Token::find($id);
    if (!$token){ http_response_code(404); echo 'Token no encontrado'; exit; }
    require __DIR__ . '/../view/tokens/show.php';
  }
}
