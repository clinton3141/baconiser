<?php

namespace iblamefish\baconiser\Template;

use iblamefish\baconiser\Config\Config;

use iblamefish\baconiser\Exception\ConfigKeyNotFoundException;
use iblamefish\baconiser\Exception\FileNotFoundException;
use iblamefish\baconiser\Exception\TemplateException;

class TwigTemplate extends Template {
  private $twig;

  public function __construct(Config $config) {
    try {
      $loader = new \Twig_Loader_Filesystem($config->get("templates.twig.path"));

      $this->twig = new \Twig_Environment($loader, array(
        'cache' => $config->get("templates.twig.cache")
      ));
    } catch (ConfigKeyNotFoundException $exception) {
      throw new TemplateException("Template configuration is invalid.");
    }
  }

  public function render($template, array $bindings = array()) {
    try {
      $template = $this->twig->loadTemplate($template);
      return $template->render($bindings);
    } catch (\Twig_Error_Loader $error) {
      throw new TemplateException("Unable to load template: $template");
    }
  }
}
