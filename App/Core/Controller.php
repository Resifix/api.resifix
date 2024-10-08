<?php

namespace App\Core;

class Controller {

  protected function getModel($model) {
    
    $class = '\\App\\Models\\' . ucfirst($model);

    return new $class;
  }

  protected function getRequestBody() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    return $obj ? $obj : NULL;
  }

}