<?php

namespace iblamefish\baconiser\Tests\Router;

use iblamefish\baconiser\Router\Route;

use iblamefish\baconiser\Controller\Controller;

class RouteTest extends \PHPUnit_Framework_TestCase {
  private $controllerMock;

  private $templateMock;

  public function setUp () {
    $this->controllerMock = $this->getMockBuilder("iblamefish\baconiser\Tests\Router\TestController")
                             ->disableOriginalConstructor()
                             ->getMock();

    $this->templateMock = $this->getMockBuilder("iblamefish\baconiser\Template\Template")
                               ->getMockForAbstractClass();

  }

  public function testShouldPassParametersToController() {
    $controller = $this->controllerMock;

    $route = new Route("/", $controller, "returnFirst");

    $controller->expects($this->once())
               ->method("returnFirst")
               ->with("first", "second");

    $route->run(array("param1" => "first", "param2" => "second"));
  }

  public function testShouldPassNullForUnspecifiedParameters() {
    $controller = $this->controllerMock;

    $route = new Route("/", $controller, "returnFirst");

    $controller->expects($this->once())
               ->method("returnFirst")
               ->with(null, "second");

    $route->run(array("param2" => "second"));
  }

  public function testShouldBindParametersByName() {
    $controller = new TestController($this->templateMock);

    $route = new Route("/", $controller, "returnFirst");

    $route2 = new Route("/", $controller, "returnSecond");

    $params = array("param2" => "second", "param1" => "first");

    $value1 = $route->run($params);

    $value2 = $route2->run($params);

    $this->assertEquals($params["param1"], $value1);

    $this->assertEquals($params["param2"], $value2);
  }

  /**
   * @expectedException \iblamefish\baconiser\Exception\RouterException
   */
  public function testShouldThrowIfMethodNotFound() {
    $controller = new TestController($this->templateMock);

    $route = new Route("/", $controller, "methodNotFound");

    $route->run(array());
  }
}

class TestController extends Controller {
  public function returnFirst($param1, $param2) {
    return $param1;
  }

  public function returnSecond($param1, $param2) {
    return $param2;
  }
}
