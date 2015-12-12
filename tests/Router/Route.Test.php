<?php

namespace iblamefish\baconiser\Tests\Router;

use iblamefish\baconiser\Router\Route;

use iblamefish\baconiser\Controller\Controller;

class RouteTest extends \PHPUnit_Framework_TestCase {
  private $controller;

  public function setUp () {
    $this->controllerMock = $this->getMockBuilder("iblamefish\baconiser\Tests\Router\TestController")
                             ->disableOriginalConstructor()
                             ->getMock();

  }

  public function testShouldPassParametersToController() {
    $controller = $this->controllerMock;

    $route = new Route("/", $controller, "returnFirst");

    $controller->expects($this->once())
               ->method("returnFirst")
               ->with("first", "second");

    $route->run(array("param1" => "first", "param2" => "second"));
  }

  public function testShouldBindParametersByName() {
    $templateMock = $this->getMockBuilder("iblamefish\baconiser\Template\Template")
                         ->getMockForAbstractClass();

    $controller = new TestController($templateMock);

    $route = new Route("/", $controller, "returnFirst");

    $route2 = new Route("/", $controller, "returnSecond");

    $params = array("param2" => "second", "param1" => "first");

    $value1 = $route->run($params);

    $value2 = $route2->run($params);

    $this->assertEquals($params["param1"], $value1);

    $this->assertEquals($params["param2"], $value2);
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
