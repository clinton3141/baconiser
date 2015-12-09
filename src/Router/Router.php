<?php

namespace iblamefish\baconiser\Router;

use iblamefish\baconiser\Exception\RouterException;

class Router {
  private $routes;

  public function __construct() {
    $this->routes = array();
  }

  public function add($path, Route $route, $force = false) {
    if(!$force && isset($this->routes[$path])) {
      throw new RouterException("Attempting to add duplicate route for path $path");
    }

    $this->routes[$path] = $route;
  }

  public function get($path) {
    if (!isset($this->routes[$path])) {
      throw new RouterException("Route not found for path $path");
    }

    return $this->routes[$path];
  }

  public function remove($path) {
    if(isset($this->routes[$path])) {
      unset($this->routes[$path]);
    }
  }
}
