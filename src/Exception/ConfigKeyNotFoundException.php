<?php

namespace iblamefish\baconiser\Exception;

class ConfigKeyNotFoundException extends BaconiserException {
  public function __construct($exception) {
    parent::__construct($exception);
  }
}
