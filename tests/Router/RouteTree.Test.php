<?php

namespace iblamefish\baconiser\Tests\Router;

use iblamefish\baconiser\Router\Route;

use iblamefish\baconiser\Router\RouteTree;

class RouteTreeTest extends \PHPUnit_Framework_TestCase {
  private $simpleRoute;

  private $simplePath;

  public function setUp() {
    $stubController = $this->getMockBuilder("\iblamefish\baconiser\Controller\Controller")
                           ->disableOriginalConstructor()
                           ->getMockForAbstractClass();

    $this->simpleRoute = new Route($this->simplePath, $stubController, "dummyMethod");
  }

  public function testShouldAddSimplePath () {
    $tree = new RouteTree();

    $tree->add($this->simpleRoute);

    $match = $tree->get("/");

    $this->assertEquals($match["route"], $this->simpleRoute);
  }
}
