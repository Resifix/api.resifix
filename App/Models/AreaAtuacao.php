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
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
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
      $this->idAreaAtuacao = Model::getLastId('idAreaAtuacao', 'tbAreasAtuacoes');
      return $this;
    } else {
      print_r($stmt->errorInfo());
      return NULL;
    }
  }

  public function getId(int $id) {
    $query = 'SELECT * FROM tbAreasAtuacoes WHERE idAreaAtuacao = ?';

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
    $sql = "UPDATE tbAreasAtuacoes SET descricao = :descricao WHERE idAreaAtuacao = :id";

    try {
      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindParam(':descricao', $data->descricao);
      $stmt->bindParam(':id', $id);

      if($stmt->execute()) {
          return $this->getId($id);
      }
    } catch (\PDOException $e) {
      http_response_code(500);
      echo json_encode(['erro' => 'Erro ao atualizar o área de atuação: ' . $e->getMessage()]);
    }

    return null;
  }

  public function delete($id): bool {
    $sql =  "DELETE FROM tbAreasAtuacoes WHERE idAreaAtuacao = :id";

    try {
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (\PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao deletar o área de atuação: ' . $e->getMessage()]);
        return false;
    }
  }
}
