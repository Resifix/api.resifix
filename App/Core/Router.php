<?php

namespace App\Core;

class Router {
  private $routes;

  public function __construct() {
    $this->initRoutes();
    $this->run($this->getUrl());
  }

  private function initRoutes() {

    $routes['areaAtuacao'] = array (
      'route' => '/Areasatuacoes',
      'controller' => 'AreasAtuacoes'
    );

    $routes['cep'] = array (
        'route' => '/Ceps',
        'controller' => 'Ceps'
    );

    $routes['cliente'] = array (
        'route' => '/Clientes',
        'controller' => 'Clientes'
    );

    $routes['contato'] = array (
      'route' => '/Contatos',
      'controller' => 'Contatos'
    );

    $routes['login'] = array (
      'route' => '/Logins',
      'controller' => 'Logins'
    );

    $routes['profissional'] = array (
        'route' => '/Profissionais',
        'controller' => 'Profissionais'
    );

    $routes['tiposPagamentos'] = array (
      'route' => '/Tipospagamentos',
      'controller' => 'TiposPagamentos'
    );

    $routes['solicitacaoServico'] = array (
      'route' => '/Solicitacoesservicos',
      'controller' => 'SolicitacoesServicos'
    );

    $this->setRoutes($routes);
  }

  private function getRoutes(): array {
    return $this->routes;
  }

  private function setRoutes(array $routes) {
    $this->routes = $routes;
  }

  private function run(string $url) {
    foreach($this->getRoutes() as $key => $route) {
      if ($url == $route['route']) {
        $class = 'App\\Controllers\\' . ucfirst($route['controller']);
        $controller = new $class;
        $action = '';

        switch ($_SERVER['REQUEST_METHOD']) {
          case 'DELETE':
            $action = 'destroy';
            break;

          case 'GET':
            $action = 'index';
            break;

          case 'POST':
            $action = 'store';
            break;

          case 'PUT':
            $action = 'update';
            break;
          
          default:
            http_response_code(405);
            echo "Método não permitido";
            exit;
        }

        if (method_exists($controller, $action)) {
          $controller->$action();
        } else {
          http_response_code(404); // Not found.
          echo "Método não encontrado";
        }

        return;
      }
    }

    http_response_code(404); // Not found.
    echo "Rota não encontrada";
  }

  private function getUrl(): string {
    return parse_url(ucwords(strtolower($_SERVER['REQUEST_URI']), '/'), PHP_URL_PATH);
  }

}