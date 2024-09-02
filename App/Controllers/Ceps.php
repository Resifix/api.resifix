<?php

namespace App\Controllers;

use App\Core\Controller;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Ceps extends Controller {

  public function index() {
    $cepModel = $this->getModel('cep');
    $cepsList = $cepModel->findAll();

    echo json_encode($cepsList);
  }

  public function store() {
    $novoCep = $this->getRequestBody();

    $cepModel = $this->getModel('cep');
    $cepObj = $cepModel->create($novoCep->descricao);

    if ($cepObj) {
        http_response_code(201); // Created.
        echo json_encode($cepObj);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Problemas ao inserir Cep"]);
    }
  }

  public function show(int $id) {
    $cepModel = $this->getModel('cep');
    $cep = $cepModel->getId($id);

    if($cep) {
      http_response_code(200);
      echo json_encode($cep);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Cep não encontrado']);
    }
  }

}