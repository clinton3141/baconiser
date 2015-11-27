<?php

namespace iblamefish\baconiser\Logger;

interface iLogger {
  public static function getInstance($config);

  public function debug($message);

  public function error($message);

  public function info($message);

  public function warn($message);
}
