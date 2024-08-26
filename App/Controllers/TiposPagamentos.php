<?php

namespace App\Controllers;

use App\Core\Controller;

class TiposPagamentos extends Controller {

  public function index() {
    $tipoPagamentoModel = $this->getModel('tipoPagamento');
    $tiposPagamentosList = $tipoPagamentoModel->findAll();

    echo json_encode($tiposPagamentosList);
  }

  public function store() {
    $novoTipoPagamento = $this->getRequestBody();

    $tipoPagamentoModel = $this->getModel('tipoPagamento');
    $tipoPagamentoObj = $tipoPagamentoModel->create($novoTipoPagamento->descricao);

    if ($tipoPagamentoObj) {
        http_response_code(201); // Created.
        echo json_encode($tipoPagamentoObj);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Problemas ao inserir Cep"]);
    }
  }

}