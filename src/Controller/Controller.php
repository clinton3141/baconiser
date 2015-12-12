<?php

namespace iblamefish\baconiser\Controller;

use iblamefish\baconiser\Template\Template;

abstract class Controller {
  protected $renderer;

  public function __construct(Template $renderer) {
    $this->renderer = $renderer;
  }
}
