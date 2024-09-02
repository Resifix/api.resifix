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
      'route' => '/areasatuacoes',
      'controller' => 'AreasAtuacoes'
    );

    $routes['cep'] = array (
        'route' => '/ceps',
        'controller' => 'Ceps'
    );

    $routes['cliente'] = array (
        'route' => '/clientes',
        'controller' => 'Clientes'
    );

    $routes['contato'] = array (
      'route' => '/contatos',
      'controller' => 'Contatos'
    );

    $routes['login'] = array (
      'route' => '/logins',
      'controller' => 'Logins'
    );

    $routes['profissional'] = array (
        'route' => '/profissionais',
        'controller' => 'Profissionais'
    );

    $routes['tiposPagamentos'] = array (
      'route' => '/tipospagamentos',
      'controller' => 'TiposPagamentos'
    );

    $routes['solicitacaoServico'] = array (
      'route' => '/solicitacoesservicos',
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

  private function run(array $urls) {
    foreach($this->getRoutes() as $key => $route) {
      if ("/$urls[0]" == $route['route']) {
        $class = 'App\\Controllers\\' . ucfirst($route['controller']);
        $controller = new $class;
        $action = '';

        switch ($_SERVER['REQUEST_METHOD']) {
          case 'DELETE':
            if (isset($urls[1])) {
              $action = 'destroy';
            } else {
              http_response_code(404);
              echo json_encode(['erro' => 'Id não fornecido']);
            }
            break;

          case 'GET':
            if (isset($urls[1])) {
              $action = 'show';
            } else {
              $action = 'index';
            }
            break;

          case 'POST':
            $action = 'store';
            break;

          case 'PUT':
            if (isset($urls[1])) {
              $action = 'update';
            } else {
              http_response_code(404);
              echo json_encode(['erro' => 'Id não fornecido']);
            }
            break;
          
          default:
            http_response_code(405);
            echo "Método não permitido";
            exit;
        }

        if (method_exists($controller, $action)) {
          if (isset($urls[1])) {
            $controller->$action($urls[1]);
          }
          else {
            $controller->$action();
          }
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

  private function getUrl(): array {
    $url = parse_url(strtolower($_SERVER['REQUEST_URI']), PHP_URL_PATH);
    $urls = explode('/', trim($url, '/'));
    return $urls;
  }

}