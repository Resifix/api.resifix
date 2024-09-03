<?php

namespace App\Models;

use App\Core\Model;

class Profissional {
  private int $idProfissional;
  private string $nome;
  private string $email;
  private string $celular;
  private string $senha;
  private int $idAreaAtuacao;

  public function create($data) {
    $this->nome = $data->nome;
    $this->email = $data->email;
    $this->celular = $data->celular;
    $this->senha = $data->senha;
    $this->idAreaAtuacao = $data->areaAtuacao;

    $query = 'INSERT INTO tbProfissionais (nome, email, celular, senha, idAreaAtuacao) VALUES (:nome, :email, :celular, :senha, :idAreaAtuacao)';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':celular', $this->celular);
    $stmt->bindParam(':senha', $this->senha);
    $stmt->bindParam(':idAreaAtuacao', $this->idAreaAtuacao);

    if ($stmt->execute()) {
      $lastInsertId = Model::getConn()->lastInsertId();
      $this->idProfissional = $lastInsertId;
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

  public function findAll(): array {
    $query = 'SELECT idProfissional, nome, email, celular, idAreaAtuacao FROM tbProfissionais';

    $stmt = Model::getConn()->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount()) {
      return $stmt->fetchAll();
    } else {
      return [];
    }
  }

  public function findByCredentials(string $email, string $senha): array {
    $query = 'SELECT idProfissional, nome, email, celular, idAreaAtuacao FROM tbProfissionais WHERE email = :email AND senha = :senha';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    if ($stmt->rowCount()) {
      return $stmt->fetch();
    } else {
      return [];
    }
  }

  public function getId(int $id) {
    $query = 'SELECT idProfissional, nome, email, celular, idAreaAtuacao FROM tbProfissionais WHERE idProfissional = ?';

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
    $sql = "UPDATE tbProfissionais SET nome = :nome, email = :email, celular = :celular WHERE idProfissional = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':nome', $data->nome);
      $stmt->bindParam(':email', $data->email);
      $stmt->bindParam(':celular', $data->celular);
      $stmt->bindParam(':id', $id);

      if($stmt->execute()) {
          return $this->getId($id);
      }
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao atualizar o profissional: ' . $e->getMessage()]);
    }

    return null;
  }

  public function delete($id): bool {
    $sql =  "DELETE FROM tbProfissionais WHERE idProfissional = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':id', $id);
      return $stmt->execute();
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao deletar o profissional: ' . $e->getMessage()]);
      return false;
    }
  }  
}
