<?php

namespace App\Controllers;

use App\Core\Controller;

class AreasAtuacoes extends Controller {

  public function index() {
    $areaAtuacaoModel = $this->getModel('areaAtuacao');
    $areasAtuacoesList = $areaAtuacaoModel->findAll();

    http_response_code(200);
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

  public function show(int $id) {
    $areaAtuacaoModel = $this->getModel('areaAtuacao');
    $areaAtuacao = $areaAtuacaoModel->getId($id);

    if($areaAtuacao) {
      http_response_code(200);
      echo json_encode($areaAtuacao);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Area de Atuação não encontrada']);
    }
  }

  public function update($id) {
    $atualizacaoArea = $this->getRequestBody();

    $areaAtuacaoModel = $this->getModel('areaAtuacao');
    $areaAtuacao = $areaAtuacaoModel->update($id, $atualizacaoArea);

    if ($areaAtuacao) {
      http_response_code(200);
      echo json_encode($areaAtuacao);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Área de atuação não encontrada ou não atualizada']);
    }
  }

  public function destroy($id) {
    $areaAtuacaoModel = $this->getModel('areaAtuacao');
    $deleted = $areaAtuacaoModel->delete($id);

    if($deleted) {
      http_response_code(200);
      echo json_encode(['success' => 'Área de atuação deletada com sucesso']);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Área de atuação não encontrada ou já deletada']);
    }
  }
}
