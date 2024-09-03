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

  public function show(int $id) {
    $solicitacaoServicoModel = $this->getModel('solicitacaoServico');
    $solicitacao = $solicitacaoServicoModel->getId($id);

    if($solicitacao) {
      http_response_code(200);
      echo json_encode($solicitacao);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Solicitação não encontrado']);
    }
  }

  public function update($id) {
    $atualizacaoSolicitacaoServico = $this->getRequestBody();

    $solicitacaoServicoModel = $this->getModel('solicitacaoServico');
    $solicitacaoServico = $solicitacaoServicoModel->update($id, $atualizacaoSolicitacaoServico);

    if ($solicitacaoServico) {
      http_response_code(200);
      echo json_encode($solicitacaoServico);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Solicitação de serviço não encontrada ou não atualizada']);
    }
  }

  public function destroy($id) {
    $solicitacaoServicoModel = $this->getModel('solicitacaoServico');
    $deleted = $solicitacaoServicoModel->delete($id);

    if($deleted) {
      http_response_code(200);
      echo json_encode(['success' => 'Solicitação de serviço deletada com sucesso']);
    } else {
      http_response_code(404);
      echo json_encode(['erro' => 'Solicitação de serviço não encontrada ou já deletada']);
    }
  }
}
