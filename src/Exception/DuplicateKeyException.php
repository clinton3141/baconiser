<?php

namespace iblamefish\baconiser\Exception;

class DuplicateKeyException extends BaconiserException {
  public function __construct($exception) {
    parent::__construct($exception);
  }
}
