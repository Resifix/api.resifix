<?php

namespace App\Models;

use App\Core\Model;

class Cep {

  private int $idCep;
  private string $descricao;

  public function __get($propriedade) {
    return $this->$propriedade;
  }

  public function findAll(): array {
    $query = 'SELECT * FROM tbCeps';

    $stmt = Model::getConn()->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount()) {
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    } else {
        return [];
    }
  }

  public function findId(string $descricao): ?Cep {
    $query = 'SELECT * FROM tbCeps WHERE descricao = ?';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $descricao);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $cep = $stmt->fetch(\PDO::FETCH_OBJ);

      if(!$cep) {
          return NULL;
      }

      $this->idCep = $cep->idCep;
      $this->descricao = $cep->descricao;

      return $this;
    } else {
      return NULL;
    }
  }

  public function create($data) {
    $this->descricao = $data;

    $query = 'INSERT INTO tbCeps (descricao) VALUES (?)';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindValue(1, $this->descricao);

    if ($stmt->execute()) {
      $lastInsertId = Model::getConn()->lastInsertId();
      $this->idCep = intval($lastInsertId);
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

  public function getId(int $id) {
    $query = 'SELECT * FROM tbCeps WHERE idCep = ?';

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
    $sql = "UPDATE tbCeps SET descricao = :descricao WHERE idCep = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':descricao', $data->descricao);
      $stmt->bindParam(':id', $id);

      if($stmt->execute()) {
          return $this->getId($id);
      }
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao atualizar o cep: ' . $e->getMessage()]);
    }

    return null;
  }

  public function delete($id): bool {
    $sql =  "DELETE FROM tbCeps WHERE idCep = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':id', $id);
      return $stmt->execute();
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao deletar o cep: ' . $e->getMessage()]);
      return false;
    }
  }
}
