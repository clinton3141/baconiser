<?php

namespace iblamefish\baconiser\Exception;

class TemplateException extends BaconiserException {
  public function __construct($exception) {
    parent::__construct($exception);
  }
}
