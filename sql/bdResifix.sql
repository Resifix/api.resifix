-- Criação do banco de dados de teste
CREATE DATABASE bdResifix DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;

-- Coloca o banco de dados em uso
USE bdResifix;

-- Tabela CEPs
CREATE TABLE tbCeps (
    idCep INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(10) NOT NULL
);

-- Tabela Clientes
CREATE TABLE tbClientes (
    idCliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(40) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    celular VARCHAR(20) NOT NULL,
    senha VARCHAR(128) NOT NULL,
    numeroResidencia INT,
    complementoResidencia VARCHAR(150),
    idCep INT NOT NULL,
    FOREIGN KEY (idCep) REFERENCES tbCeps(idCep)
);

-- Tabela Áreas de Atuação
CREATE TABLE tbAreasAtuacoes (
    idAreaAtuacao INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL
);

-- Tabela Profissionais
CREATE TABLE tbProfissionais (
    idProfissional INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(40) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    celular VARCHAR(20) NOT NULL,
    senha VARCHAR(128) NOT NULL,
    idAreaAtuacao INT NOT NULL,
    FOREIGN KEY (idAreaAtuacao) REFERENCES tbAreasAtuacoes(idAreaAtuacao)
);

-- Tabela Solicitações de Serviços
CREATE TABLE tbSolicitacoesServicos (
    idSolicitacaoServico INT AUTO_INCREMENT PRIMARY KEY,
    idCliente INT NOT NULL,
    idProfissional INT NOT NULL,
    orcamento DECIMAL(10,2) NOT NULL,
    dataHoraOrcamento DATETIME NOT NULL,
    FOREIGN KEY (idCliente) REFERENCES tbClientes(idCliente),
    FOREIGN KEY (idProfissional) REFERENCES tbProfissionais(idProfissional)
);

-- Tabela Tipos de Pagamentos
CREATE TABLE tbTiposPagamentos (
    idTipoPagamento INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL
);

-- Tabela Serviços
CREATE TABLE tbServicos (
    idServico INT AUTO_INCREMENT PRIMARY KEY,
    idSolicitacaoServico INT NOT NULL,
    dataHoraServico DATETIME NOT NULL,
    idTipoPagamento INT NOT NULL,
    FOREIGN KEY (idSolicitacaoServico) REFERENCES tbSolicitacoesServicos(idSolicitacaoServico),
    FOREIGN KEY (idTipoPagamento) REFERENCES tbTiposPagamentos(idTipoPagamento)
);

-- Tabela Pendências
CREATE TABLE tbPendencias (
    idPendencia INT AUTO_INCREMENT PRIMARY KEY,
    dataInicio DATE NOT NULL,
    dataVencimento DATE,
    statusPendencia VARCHAR(25),
    idServico INT NOT NULL,
    FOREIGN KEY (idServico) REFERENCES tbServicos(idServico)
);