<?php

namespace App\Controllers;

use App\Core\Controller;

class Logins extends Controller {

  public function store() {
    $loginUsuario = $this->getRequestBody();

    $profissionaisModel = $this->getModel('profissional');
    $profissional = $profissionaisModel->findByCredentials($loginUsuario->email, $loginUsuario->senha);

    if ($profissional) {
      echo json_encode($profissional);
      exit;
    }

    $clientesModel = $this->getModel('cliente');
    $cliente = $clientesModel->findByCredentials($loginUsuario->email, $loginUsuario->senha);

    if ($cliente) {
      echo json_encode($cliente);
      exit;
    }

    http_response_code(404); // Not found.
    echo json_encode(["erro" => "Email ou senha inválidos"]);
  }

}