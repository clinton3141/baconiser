<?php

namespace iblamefish\baconiser\Router;

use iblamefish\baconiser\Exception\RouterException;

use iblamefish\baconiser\Exception\DuplicateKeyException;

class Router {
  private $routes;

  public function __construct() {
    $this->routes = array(
      "GET" => new RouteTree(),
      "PUT" => new RouteTree(),
      "POST" => new RouteTree(),
      "DELETE" => new RouteTree()
    );
  }

  public function add($requestMethod, Route $route, $force = false) {
    $method = $this->normaliseRequestMethod($requestMethod);

    if (!isset($this->routes[$method])) {
      throw new RouterException("Cannot add routes for HTTP method $method");
    }

    try {
      $this->routes[$method]->add($route, $force);
    } catch (DuplicateKeyException $e) {
      throw new RouterException("Attempting to add duplicate route for path " . $route->getPath());
    }
  }

  public function get($requestMethod, $path) {
    $method = $this->normaliseRequestMethod($requestMethod);

    if (!isset($this->routes[$method])) {
      throw new RouterException("Cannot get route for unsupported HTTP method $method");
    }

    try {
      $route = $this->routes[$method]->get($path);
    } catch (\Exception $e) {
      throw new RouterException("Route not found for path $path");
    }

    return $route;
  }

  public function remove($requestMethod, $path) {
    $method = $this->normaliseRequestMethod($requestMethod);

    if(isset($this->routes[$method])) {
      $this->routes[$method]->remove($path);
    }
  }

  private function normaliseRequestMethod($method) {
    return strtoupper($method);
  }
}
