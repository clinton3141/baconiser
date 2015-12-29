<?php

namespace iblamefish\baconiser\Router;

use iblamefish\baconiser\Exception\DuplicateKeyException;

class RouteTree {
  private $root;

  public function __construct() {
    $this->root = $this->createNode(null, array());
  }

  public function add(Route $route, $force = false) {
    $current =& $this->root;

    $steps = $this->splitPath($route->getPath());

    $parameterNames = array();

    foreach ($steps as $step) {
      $match = array();

      if (preg_match("/{:([a-zA-Z]+)}/", $step, $match)) {
        $parameterNames[] = $match[1];
        $step = "*";
      }

      if (!isset($current["nodes"][$step])) {
        $current["nodes"][$step] = $this->createNode();
      }
      $current =& $current["nodes"][$step];
    }

    if (!$force && $current["value"] !== null) {
      throw new DuplicateKeyException("Cannot add duplicate value for path " . $route->getPath() . ".");
    }

    $current["value"] = array(
      "route" => $route,
      "parameterNames" => $parameterNames
    );
  }

  public function get($path) {
    $current = $this->root;

    $params = array();

    $steps = $this->splitPath($path);

    foreach ($steps as $step) {
      if (!isset($current["nodes"][$step])) {
        if (isset($current["nodes"]["*"])) {
          $params[] = $step;
          $step = "*";
        } else {
          throw new \Exception("Path not found " . $path);
        }
      }

      $current = $current["nodes"][$step];
    }

    if ($current["value"] === null) {
      throw new \Exception("No Route found for path " . $path);
    }

    return array(
      "params" => array_combine($current["value"]["parameterNames"], $params),
      "route" => $current["value"]["route"]
    );
  }

  public function remove($path) {
    $current =& $this->root;

    $escaped = false;

    $steps = $this->splitPath($path);

    foreach ($steps as $step) {
      if (!isset($current["nodes"][$step])) {
        $escaped = true;
        break;
      }

      $current =& $current["nodes"][$step];
    }

    if (!$escaped) {
      $current["value"] = null;
    }
  }

  private function createNode($value = null, $children = array()) {
    $node = array();

    return array(
      "value" => $value,
      "nodes" => $children
    );
  }

  private function splitPath($path) {
    return explode("/", trim($path, "/"));
  }
}
