<?php

namespace App\Controllers;

use App\Core\Controller;

class AreasAtuacoes extends Controller {

  public function index() {
    $areaAtuacaoModel = $this->getModel('areaAtuacao');
    $areasAtuacoesList = $areaAtuacaoModel->findAll();

    echo json_encode($areasAtuacoesList);
  }

  public function store() {
    $novaAreaAtuacao = $this->getRequestBody();

    $areaAtuacaoModel = $this->getModel('areaAtuacao');
    $areaAtuacaoObj = $areaAtuacaoModel->create($novaAreaAtuacao->descricao);

    if ($areaAtuacaoObj) {
        http_response_code(201); // Created.
        echo json_encode($areaAtuacaoObj);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Problemas ao inserir area de atuação"]);
    }
  }

}