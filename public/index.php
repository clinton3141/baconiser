<?php

use iblamefish\baconiser\Config\FileConfigProvider;
use iblamefish\baconiser\Exception\FileNotFoundException;

$app = require __DIR__ . '/../src/app/app.php';

try {
  $config = new FileConfigProvider('../config/production.php');
} catch (Exception $e) {
  die ('Fatal error. Could not load site configuration');
}

$app->run($config);
