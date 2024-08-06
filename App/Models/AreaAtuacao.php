<?php

namespace App\Models;

use App\Core\Model;

class AreaAtuacao {

  private int $idAreaAtuacao;
  private string $descricao;

  public function __get($propriedade) {
    return $this->$propriedade;
  }

  public function findAll(): array {
    $query = 'SELECT * FROM tbAreasAtuacoes';

    $stmt = Model::getConn()->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount()) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
  }

  public function findId(string $descricao): ?AreaAtuacao {
    $query = 'SELECT * FROM tbAreasAtuacoes WHERE descricao = ?';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $descricao);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $areaAtuacao = $stmt->fetch(\PDO::FETCH_OBJ);

      if(!$areaAtuacao) {
          return NULL;
      }

      $this->idAreaAtuacao = $areaAtuacao->idAreaAtuacao;
      $this->descricao = $areaAtuacao->descricao;

      return $this;
    } else {
      $novaAreaAtuacao = $this->create($descricao);
      return $novaAreaAtuacao;
    }
  }

  public function create($data) {
    $this->descricao = ucwords(strtolower($data));

    $query = 'INSERT INTO tbAreasAtuacoes (descricao) VALUES (?)';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $this->descricao);

    if ($stmt->execute()) {
      $lastInsertId = Model::getConn()->lastInsertId();
      $this->idAreaAtuacao = intval($lastInsertId);
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

}