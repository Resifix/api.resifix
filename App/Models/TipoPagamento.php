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

  public function findId(string $descricao): ?Cep {
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

}