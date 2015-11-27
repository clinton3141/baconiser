<?php

namespace iblamefish\baconiser;

use iblamefish\baconiser\Config\Config;
use iblamefish\baconiser\Logger\Logger;
use iblamefish\baconiser\Logger\RollbarLogger;

require_once __DIR__ . '/../vendor/autoload.php';


class App {

  public function __construct() {
  }

  public function run(Config $config) {
    $this->config = $config;

    Logger::init(RollbarLogger::getInstance($config), array('warn', 'info', 'debug', 'error'));

    Logger::warn('warning');

    Logger::debug('debug!');

    Logger::info('info');

    Logger::log('log');

    Logger::error('error');
  }
}


return new App();
