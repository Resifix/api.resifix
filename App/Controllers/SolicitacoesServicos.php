<?php

namespace App\Controllers;

use App\Core\Controller;

class SolicitacoesServicos extends Controller {

    public function index() {

        $solicitacaoServicoModel = $this->getModel('solicitacaoServico');
        $solicitacoesServicosList = $solicitacaoServicoModel->findAll();

        echo json_encode($solicitacoesServicosList);
    }

    public function store() {
        $novaSolicitacaoServico = $this->getRequestBody();

        $solicitacaoServicoModel = $this->getModel('solicitacaoServico');
        $solicitacoesServicosObj = $solicitacaoServicoModel->create($novaSolicitacaoServico);

        if ($solicitacoesServicosObj) {
            http_response_code(201); // Created.
            echo json_encode(["success" => "Solicitação realizada com sucesso"]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao realizar solicitação de serviço"]);
        }
    }
}