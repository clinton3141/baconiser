<?php

namespace iblamefish\baconiser;

use iblamefish\baconiser\Config\Config;
use iblamefish\baconiser\Logger\Log;
use iblamefish\baconiser\Logger\RollbarLogger;
use iblamefish\baconiser\Router\Router;
use iblamefish\baconiser\Router\Route;

use iblamefish\baconiser\app\Controllers\DefaultController;

use iblamefish\baconiser\Template\TwigTemplate;

require_once __DIR__ . '/../../vendor/autoload.php';


class App {

  public function __construct() {
  }

  public function run(Config $config) {
    $this->config = $config;

    Log::register(RollbarLogger::getInstance($config), array('warn', 'info', 'debug', 'error'));

    $template = new TwigTemplate($config);

    $router = new Router();

    $defaultRoute = new DefaultController($template);

    $route = new Route("/hello/{:who}/", $defaultRoute, "testAction");

    $router->add("GET", $route);

    // Route should pass the parameter :who when running
    $router->get("GET", "/hello/world/")->run(array("who" => "world"));
  }
}


return new App();
