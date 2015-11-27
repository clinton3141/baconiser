<?php

namespace iblamefish\baconiser\Exception;

class BaconiserException extends \Exception {
  public function __construct($exception) {
    parent::__construct($exception);
  }
}
