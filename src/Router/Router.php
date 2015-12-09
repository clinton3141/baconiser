<?php

namespace iblamefish\baconiser\Router;

use iblamefish\baconiser\Exception\RouterException;

class Router {
  private $routes;

  public function __construct() {
    $this->routes = array(
      "GET" => array(),
      "PUT" => array(),
      "POST" => array(),
      "DELETE" => array()
    );
  }

  public function add($requestMethod, $path, Route $route, $force = false) {
    $method = $this->normaliseRequestMethod($requestMethod);

    if (!isset($this->routes[$method])) {
      throw new RouterException("Cannot add routes for HTTP method $method");
    }

    if(!$force && isset($this->routes[$method][$path])) {
      throw new RouterException("Attempting to add duplicate route for path $path");
    }

    $this->routes[$method][$path] = $route;
  }

  public function get($requestMethod, $path) {
    $method = $this->normaliseRequestMethod($requestMethod);

    if (!isset($this->routes[$method])) {
      throw new RouterException("Cannot get route for unsupported HTTP method $method");
    }
    if (!isset($this->routes[$method][$path])) {
      throw new RouterException("Route not found for path $path");
    }

    return $this->routes[$method][$path];
  }

  public function remove($requestMethod, $path) {
    $method = $this->normaliseRequestMethod($requestMethod);

    if(isset($this->routes[$method]) && isset($this->routes[$method][$path])) {
      unset($this->routes[$method][$path]);
    }
  }

  private function normaliseRequestMethod($method) {
    return strtoupper(trim($method));
  }
}
