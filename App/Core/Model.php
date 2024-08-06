<?php

namespace App\Core;

class Model {

  public static function getConn(): ?\PDO {

    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbName = $_ENV['DB_NAME'];
    $dbUser = $_ENV['DB_USER'];
    $dbPassword = $_ENV['DB_PASSWORD'];

    if (!$dbHost || !$dbName || !$dbUser || !$dbPassword) {
      echo json_encode(["erro" => 'Configuração de banco de dados inválida.']);
      exit;
    }

    try {
        $conn = new \PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (\PDOException $e) {
        echo json_encode(["erro" => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
        exit;
    }
  }

}