<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cep;
use App\Models\Cliente;

class Clientes extends Controller {

  public function index() {

    $clientesModel = $this->getModel('cliente');
    $clientesList = $clientesModel->findAll();

    echo json_encode($clientesList);
  }

  public function store() {
    $novoCliente = $this->getRequestBody();

    $clientesModel = $this->getModel('cliente');
    $cepsModel = $this->getModel('cep');
    $cepsObj = $cepsModel->findId($novoCliente->cep);

    if ($cepsObj) {
      $novoCliente->cep = $cepsObj->idCep;
      $cliente = $clientesModel->create($novoCliente);

      if ($cliente) {
        http_response_code(201); // Created.
        echo json_encode(["success" => "Cliente inserido com sucesso"]);
      } else {
        http_response_code(500);
        echo json_encode(["erro" => "Problemas ao inserir cliente"]);
      }
    } else {
      http_response_code(400);
      echo json_encode(["erro" => "Cep não encontrado"]);
    }
  }

}