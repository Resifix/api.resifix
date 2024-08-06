<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AreaAtuacao;
use App\Models\Profissional;

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

}