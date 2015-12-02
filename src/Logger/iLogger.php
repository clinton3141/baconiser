<?php

namespace iblamefish\baconiser\Logger;

use iblamefish\baconiser\Config\Config;

interface iLogger {
  public static function getInstance(Config $config);

  public function debug($message);

  public function error($message);

  public function info($message);

  public function warn($message);
}
