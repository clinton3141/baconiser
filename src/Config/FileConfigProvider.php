<?php

namespace iblamefish\baconiser\Config;

use iblamefish\baconiser\Exception\FileNotFoundException;
use iblamefish\baconiser\Exception\ConfigKeyNotFoundException;

class FileConfigProvider extends Config {
  private $config;

  public function __construct($filename) {
    if (!file_exists($filename)) {
      throw new FileNotFoundException($filename);
    }

    $this->config = include($filename);
  }

  public function get($key) {
    $keyParts = explode('.', $key);

    $lookup = $this->config;

    foreach ($keyParts as $keyPart) {
      if(isset($lookup[$keyPart])) {
        $lookup = $lookup[$keyPart];
      } else {
        throw new ConfigKeyNotFoundException($key);
      }
    }

    return $lookup;
  }
}
