<?php

namespace iblamefish\baconiser\Tests\Template;

use iblamefish\baconiser\Template\TwigTemplate;

use iblamefish\baconiser\Template\Config;

use iblamefish\baconiser\Exception\ConfigKeyNotFoundException;

class TwigTemplateText extends \PHPUnit_Framework_TestCase {

  private $config;

  protected function setUp() {
    $this->config = $this->getMockBuilder("\iblamefish\baconiser\Config\Config")
                         ->getMockForAbstractClass();

    $this->config->method("get")
                 ->will($this->returnValueMap(array(
                    array("templates.twig.path", "./tests/assets/templates/"),
                    array("templates.twig.cache", "./build/tmp/")
                 )));
  }

  public function testShouldRenderWithNoBindings() {
    $template = new TwigTemplate($this->config);

    $content = $template->render("no-bindings.twig");

    $this->assertEquals(trim($content), "no bindings");
  }

  public function testShouldRenderTemplate() {
    $template = new TwigTemplate($this->config);

    $content = $template->render("hello-world.twig", array("item" => "world"));

    $this->assertEquals(trim($content), "Hello world");
  }

  /**
   * @expectedException iblamefish\baconiser\Exception\TemplateException
   */
  public function testShouldThrowIfTemplateNotFound() {
    $template = new TwigTemplate($this->config);

    $content = $template->render("file-not-found.twig", array());
  }

  /**
   * @expectedException iblamefish\baconiser\Exception\TemplateException
   */
  public function testShouldThrowIfInvlidConfig() {
    $invalidConfig = $this->getMockBuilder("\iblamefish\baconiser\Config\Config")
                         ->getMockForAbstractClass();

    $invalidConfig->method("get")
                  ->will($this->throwException(new ConfigKeyNotFoundException("Invalid key")));

    new TwigTemplate($invalidConfig);
  }

}
