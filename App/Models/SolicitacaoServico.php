<?php

namespace App\Models;

use App\Core\Model;

class SolicitacaoServico {

    private int $idSolicitacaoServico;
    private int $idCliente;
    private int $idProfissional;
    private float $orcamento;
    private \DateTime $dataHoraOrcamento;

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
        $this->dataHoraOrcamento = new \DateTime($data->dataHoraOrcamento);

        $query = "INSERT INTO tbSolicitacoesServicos (idCliente, idProfissional, orcamento, dataHoraOrcamento) VALUES (:idCliente, :idProfissional, :orcamento, :dataHoraOrcamento)";

        $stmt = Model::getConn()->prepare($query);
        $stmt->bindParam(':idCliente', $this->idCliente);
        $stmt->bindParam(':idProfissional', $this->idProfissional);
        $stmt->bindParam(':orcamento', $this->orcamento);
        $stmt->bindParam(':dataHoraOrcamento', $this->dataHoraOrcamento->format('Y-m-d H:i:s'));

        if ($stmt->execute()) {
            $this->idSolicitacaoServico = Model::getLastId('idSolicitacaoServico', 'tbSolicitacoesServicos');
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return NULL;
        }
    }

}