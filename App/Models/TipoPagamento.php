<?php

namespace App\Models;

use App\Core\Model;

class TipoPagamento {

  private int $idTipoPagamento;
  private string $descricao;

  public function __get($propriedade) {
    return $this->$propriedade;
  }

  public function findAll(): array {
    $query = 'SELECT * FROM tbTiposPagamentos';

    $stmt = Model::getConn()->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount()) {
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    } else {
        return [];
    }
  }

  public function findId(string $descricao): ?TipoPagamento {
    $query = 'SELECT * FROM tbTiposPagamentos WHERE descricao = ?';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $descricao);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $tipoPagamento = $stmt->fetch(\PDO::FETCH_OBJ);

      if(!$tipoPagamento) {
          return NULL;
      }

      $this->idTipoPagamento = $tipoPagamento->idTipoPagamento;
      $this->descricao = $tipoPagamento->descricao;

      return $this;
    } else {
      return NULL;
    }
  }

  public function create($data) {
    $this->descricao = $data;

    $query = 'INSERT INTO tbTiposPagamentos (descricao) VALUES (?)';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $this->descricao);

    if ($stmt->execute()) {
      $lastInsertId = Model::getConn()->lastInsertId();
      $this->idTipoPagamento = intval($lastInsertId);
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

  public function getId(int $id) {
    $query = 'SELECT * FROM tbTiposPagamentos WHERE idTipoPagamento = ?';

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
    $sql = "UPDATE tbTiposPagamentos SET descricao = :descricao WHERE idTipoPagamento = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':descricao', $data->descricao);
      $stmt->bindParam(':id', $id);

      if($stmt->execute()) {
          return $this->getId($id);
      }
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao atualizar o tipo de pagamento: ' . $e->getMessage()]);
    }

    return null;
  }

  public function delete($id): bool {
    $sql =  "DELETE FROM tbTiposPagamentos WHERE idTipoPagamento = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':id', $id);
      return $stmt->execute();
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao deletar o tipo de pagamento: ' . $e->getMessage()]);
      return false;
    }
  }
}
