<?php

namespace App\Controllers;

use App\Core\Controller;

class Profissionais extends Controller {

  public function index() {

    $profissionaisModel = $this->getModel('profissional');
    $profissionaisList = $profissionaisModel->findAll();

    echo json_encode($profissionaisList);
  }

  public function store() {
    $novoProfissional = $this->getRequestBody();

    $profissionaisModel = $this->getModel('profissional');
    $areasAtuacoesModel = $this->getModel('areaAtuacao');
    $areaAtuacaoNome = ucwords(strtolower($novoProfissional->areaAtuacao), ' ');

    $areasAtuacoesObj = $areasAtuacoesModel->findId($areaAtuacaoNome);

    if ($areasAtuacoesObj) {
      $novoProfissional->areaAtuacao = $areasAtuacoesObj->idAreaAtuacao;
      $profissional = $profissionaisModel->create($novoProfissional);

      if ($profissional) {
        http_response_code(201); // Created.
        echo json_encode(["success" => "Profissional inserido com sucesso"]);
      } else {
        http_response_code(500);
        echo json_encode(["erro" => "Problemas ao inserir profissional"]);
      }
    } else {
      http_response_code(500);
      echo json_encode(["erro" => "Problemas ao buscar área de atuação"]);
    }
  }

  public function show(int $id) {
    $profissionaisModel = $this->getModel('profissional');
    $profissional = $profissionaisModel->getId($id);

    if($profissional) {
      http_response_code(200);
      echo json_encode($profissional);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Profissional não encontrado']);
    }
  }

  public function update($id) {
    $atualizacaoProfissional = $this->getRequestBody();

    $profissionaisModel = $this->getModel('profissional');
    $profissional = $profissionaisModel->update($id, $atualizacaoProfissional);

    if ($profissional) {
      http_response_code(200);
      echo json_encode($profissional);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Profissional não encontrado ou não atualizado']);
    }
  }

  public function destroy($id) {
    $profissionaisModel = $this->getModel('profissional');
    $deleted = $profissionaisModel->delete($id);

    if($deleted) {
      http_response_code(200);
      echo json_encode(['success' => 'Profissional deletado com sucesso']);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Profissional não encontrado ou já deletado']);
    }
  }
}
