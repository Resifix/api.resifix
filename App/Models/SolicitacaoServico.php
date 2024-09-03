<?php

namespace App\Models;

use App\Core\Model;

class SolicitacaoServico {

  private int $idSolicitacaoServico;
  private int $idCliente;
  private int $idProfissional;
  private float $orcamento;
  private string $dataHoraOrcamento;

  public function findAll() {
    $query = "SELECT * FROM tbSolicitacoesServicos";

    $stmt = Model::getConn()->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount()) {
      return $stmt->fetchAll(\PDO::FETCH_OBJ);
    } else {
      return [];
    }
  }

  public function create($data) {
    $this->idCliente = (int)$data->idCliente;
    $this->idProfissional = (int)$data->idProfissional;
    $this->orcamento = (float)$data->orcamento;
    $this->dataHoraOrcamento = (new \DateTime($data->dataHoraOrcamento))->format('Y-m-d H:i:s');

    $query = "INSERT INTO tbSolicitacoesServicos (idCliente, idProfissional, orcamento, dataHoraOrcamento) VALUES (:idCliente, :idProfissional, :orcamento, :dataHoraOrcamento)";

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindParam(':idCliente', $this->idCliente);
    $stmt->bindParam(':idProfissional', $this->idProfissional);
    $stmt->bindParam(':orcamento', $this->orcamento);
    $stmt->bindParam(':dataHoraOrcamento', $this->dataHoraOrcamento);

    if ($stmt->execute()) {
      $this->idSolicitacaoServico = Model::getLastId('idSolicitacaoServico', 'tbSolicitacoesServicos');
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

  public function getId(int $id) {
    $query = 'SELECT * FROM tbSolicitacoesServicos WHERE idSolicitacaoServico = ?';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    if($stmt->rowCount()) {
      return $stmt->fetch(\PDO::FETCH_OBJ);
    } else {
      return [];
    }
  }

  public function update($id, $data) {
    $sql = "UPDATE tbSolicitacoesServicos SET orcamento = :orcamento  WHERE idSolicitacaoServico = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':orcamento', $data->orcamento);
      $stmt->bindParam(':id', $id);

      if($stmt->execute()) {
          return $this->getId($id);
      }
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao atualizar o solicitação de serviço: ' . $e->getMessage()]);
    }

    return null;
  }

  public function delete($id): bool {
    $sql =  "DELETE FROM tbSolicitacoesServicos WHERE idSolicitacaoServico = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':id', $id);
      return $stmt->execute();
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao deletar a solicitação de serviço: ' . $e->getMessage()]);
      return false;
    }
  }
}
