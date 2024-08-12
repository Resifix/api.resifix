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

  public function update() {
    $reader = ReaderEntityFactory::createXLSXReader();
    $filePath = '../CEP_SANTANA_DE_PARNAIBA.xlsx';

    $reader->open($filePath);
    $primeiraLinha = true;

    foreach ($reader->getSheetIterator() as $sheet) {
      foreach ($sheet->getRowIterator() as $row) {
        
        if($primeiraLinha) {
          $primeiraLinha = false;
          continue;
        }

        $cells = $row->getCells();
        $cellPrimeiraColuna = isset($cells[0]) ? $cells[0]->getValue() : null;

        if ($cellPrimeiraColuna) {
          $cepModel = $this->getModel('cep');
          $cepObj = $cepModel->create($cellPrimeiraColuna);

          if ($cepObj) {
            http_response_code(201); // Created.
          } else {
              http_response_code(500);
              echo json_encode(["erro" => "Problemas ao inserir Cep"]);
          }
        }
      } 
    }

      $reader->close();
  }

}