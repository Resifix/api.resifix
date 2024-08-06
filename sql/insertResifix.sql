USE bdResifix;

-- Tabela CEPs
INSERT INTO tbCeps (descricao)
VALUES 
('06501-115'), 
('06501-125'), 
('06528-310'),
('06517-520'),
('06502-025');

-- Tabela Clientes
INSERT INTO tbClientes (nome, email, celular, senha, numeroResidencia, complementoResidencia, idCep)
VALUES
('Ana Clara Souza Martins', 'ana.souza777@gmail.com', '(11)92358-5390', 'admin', 100, 'A', 1),
('João Pedro Oliveira Santos', 'pedrojoaosantos23@outlook.com', '(11)93951-0574', 'admin', 4, NULL, 2),
('Maria Eduarda Costa Lima', 'dudaahlimaS2@gmail.com', '(11)92983-4746', 'admin', 2002, NULL, 3),
('Guilherme Henrique Ferreira Almeida', 'gui_ferreira45@outlook.com', '(11)92353-5811', 'admin', NULL, NULL, 4),
('Isabela Cristina da Silva', 'crissisa_@gmail.com', '(11)93215-8345', 'admin', NULL, NULL, 5);

-- Tabela Profissionais
INSERT INTO tbProfissionais (nome, email, celular, senha, idAreaAtuacao)
VALUES
('Lucas Oliveira da Silva', 'contatolucassilva@gmail.com', '(11)93756-4287', 'admin', 1),
('Ana Clara Ferreira Costa', 'anaclaracostaoficial@outlook.com', '(11)92766-6408', 'admin', 2),
('Gabriel Almeida Santos', 'santosssgabriel@gmail.com', '(11)92837-9677', 'admin', 3),
('Mariana Ribeiro Pereira', 'mariipereira@gmail.com', '(11)92479-3401', 'admin', 4),
('João Pedro Martins Sousa', 'martiiinspedro@outlook.com', '(11)92255-7503', 'admin', 5);

-- Tabela Áreas de Atuação
INSERT INTO tbAreasAtuacoes (descricao)
VALUES
('Construção Civil'),
('Elétrica'),
('Hidráulica'),
('Limpeza'),
('Paisagismo');
