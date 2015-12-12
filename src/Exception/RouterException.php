<?php

namespace iblamefish\baconiser\Exception;

class RouterException extends BaconiserException {
  public function __construct($exception) {
    parent::__construct($exception);
  }
}
