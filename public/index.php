<?php

use iblamefish\baconiser\Config\FileConfigProvider;
use iblamefish\baconiser\Exception\FileNotFoundException;

$app = require __DIR__ . '/../src/app.php';

try {
  $config = new FileConfigProvider('../config/production.php');
  $app->run($config);
} catch (FileNotFoundException $e) {
  die ('Fatal error. Could not load config file');
}
