<?php

namespace iblamefish\baconiser\Template;

abstract class Template {
  public abstract function render($template, $bindings);
}
