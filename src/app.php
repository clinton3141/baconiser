<?php

namespace iblamefish\baconiser;

use iblamefish\baconiser\Config\Config;
use iblamefish\baconiser\Logger\Logger;
use iblamefish\baconiser\Logger\RollbarLogger;

use iblamefish\baconiser\Template\TwigTemplate;

require_once __DIR__ . '/../vendor/autoload.php';


class App {

  public function __construct() {
  }

  public function run(Config $config) {
    $this->config = $config;

    Logger::register(RollbarLogger::getInstance($config), array('warn', 'info', 'debug', 'error'));

    $template = new TwigTemplate($config);

    echo $template->render("index.twig", array("message" => "Hello world!"));
  }
}


return new App();
