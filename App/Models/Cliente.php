<?php

namespace App\Models;

use App\Core\Model;

class Cliente {
  private int $idCliente;
  private string $nome;
  private string $email;
  private string $celular;
  private string $senha;
  private int $idCep;
  private ?int $numeroResidencia;
  private string $complementoResidencia;

  public function create($data) {
    $this->nome = $data->nome;
    $this->email = $data->email;
    $this->celular = $data->celular;
    $this->senha = $data->senha;
    $this->idCep = $data->cep;
    $this->numeroResidencia = $data->numeroResidencia;
    $this->complementoResidencia = $data->complementoResidencia;

    $query = 'INSERT INTO tbClientes (nome, email, celular, senha, idCep, numeroResidencia, complementoResidencia) VALUES (:nome, :email, :celular, :senha, :idCep, :numeroResidencia, :complementoResidencia)';

    $stmt = Model::getConn()->prepare($query);
    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':celular', $this->celular);
    $stmt->bindParam(':senha', $this->senha);
    $stmt->bindParam(':idCep', $this->idCep);
    $stmt->bindParam(':numeroResidencia', $this->numeroResidencia);
    $stmt->bindParam(':complementoResidencia', $this->complementoResidencia);

    if ($stmt->execute()) {
      $lastInsertId = Model::getConn()->lastInsertId();
      $this->idCliente = intval($lastInsertId);
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

  public function findAll(): array {
    $query = 'SELECT idCliente, nome, email, celular, idCep, numeroResidencia, complementoResidencia FROM tbClientes';

    $stmt = Model::getConn()->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount()) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
  }

  public function findByCredentials(string $email, string $senha): array {
    $query = 'SELECT idCliente, nome, email, celular, idCep, numeroResidencia, complementoResidencia FROM tbClientes WHERE email = :email AND senha = :senha';

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
    $query = 'SELECT idCliente, nome, email, celular, idCep, numeroResidencia, complementoResidencia FROM tbClientes WHERE idCliente = ?';

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
    $sql = "UPDATE tbClientes SET nome = :nome, email = :email, celular = :celular, numeroResidencia = :numeroResidencia, complementoResidencia = :complementoResidencia WHERE idCliente = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':nome', $data->nome);
      $stmt->bindParam(':email', $data->email);
      $stmt->bindParam(':celular', $data->celular);
      $stmt->bindParam(':numeroResidencia', $data->numeroResidencia);
      $stmt->bindParam(':complementoResidencia', $data->complementoResidencia);
      $stmt->bindParam(':id', $id);

      if($stmt->execute()) {
          return $this->getId($id);
      }
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao atualizar o cliente: ' . $e->getMessage()]);
    }

    return null;
  }

  public function delete($id): bool {
    $sql =  "DELETE FROM tbClientes WHERE idCliente = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':id', $id);
      return $stmt->execute();
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao deletar o cliente: ' . $e->getMessage()]);
      return false;
    }
  }
}
