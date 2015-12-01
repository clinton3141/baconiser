<?php

namespace iblamefish\baconiser\Template;

use iblamefish\baconiser\Config\Config;

class TwigTemplate extends Template {
  private $twig;

  public function __construct(Config $config) {
    $loader = new \Twig_Loader_Filesystem($config->get("templates.twig.path"));

    $this->twig = new \Twig_Environment($loader, array(
      'cache' => $config->get("templates.twig.cache")
    ));
  }

  public function render($template, $bindings) {
    $template = $this->twig->loadTemplate($template);

    return $template->render($bindings);
  }
}
