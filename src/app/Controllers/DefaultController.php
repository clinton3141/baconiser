<?php

namespace iblamefish\baconiser\app\Controllers;

use iblamefish\baconiser\Controller\Controller;
use iblamefish\baconiser\Config\Config;
use iblamefish\baconiser\Template\Template;

class DefaultController extends Controller {
  public function __construct(Template $renderer) {
    parent::__construct($renderer);
  }

  public function testAction($who) {
    echo $this->renderer->render("index.twig", array("person" => $who));
  }
}
