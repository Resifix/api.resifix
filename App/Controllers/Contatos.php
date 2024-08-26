<?php

namespace App\Controllers;

use App\Core\Controller;

class Contatos extends Controller {

  public function store() {
    $novoContato = $this->getRequestBody();

    $contatoModel = $this->getModel('contato');

    try {
        $contatoModel->create($novoContato);
        echo json_encode(["success" => 'Mensagem enviada com sucesso']);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(["erro" => 'Erro ao enviar e-mail: ' . $e->getMessage()]);
    }
  }

}