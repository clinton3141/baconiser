<?php

namespace iblamefish\baconiser\Router;

use iblamefish\baconiser\Exception\RouterException;

class Route {
  private $controller;
  private $method;
  private $path;

  public function __construct($path, $controller, $method) {
    $this->path = $path;

    $this->controller = $controller;

    $this->method = $method;
  }

  public function getPath() {
    return $this->path;
  }

  public function run(array $bindings = array()) {
    if (method_exists($this->controller, $this->method)) {
      $reflection = new \ReflectionMethod($this->controller, $this->method);

      $methodParameters = $reflection->getParameters();

      $arguments = array();

      foreach ($methodParameters as $parameter) {
        if (isset ($bindings[$parameter->name])) {
          $arguments[] = $bindings[$parameter->name];
        } else {
          $arguments[] = null;
        }
      }

      return call_user_func_array(array($this->controller, $this->method), $arguments);
    } else {
      throw new RouterException("Method {$this->method} does not exist for {$this->path}.");
    }
  }
}
