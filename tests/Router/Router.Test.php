<?php

namespace iblamefish\baconiser\Tests\Router;

use iblamefish\baconiser\Router\Router;

use iblamefish\baconiser\Router\Route;

class RouterTest extends \PHPUnit_Framework_TestCase {
  private $registeredPath = "/registered/path/";

  private $unregisteredPath = "/unregistered/path/";

  private $parameterisedPath = "/post/{:id}/";

  private $parameterisedUri = "/post/12/";

  private $parsedParameters = array("id" => "12");

  private $route;

  private $anotherRoute;

  private $complexRoute;


  public function setUp() {
    $stubController = $this->getMockBuilder("\iblamefish\baconiser\Controller\Controller")
                           ->disableOriginalConstructor()
                           ->getMockForAbstractClass();

    $this->route = new Route($this->registeredPath, $stubController, "dummyMethod");

    $this->anotherRoute = new Route($this->registeredPath, $stubController, "dummyMethod2");

    $this->complexRoute = new Route($this->parameterisedPath, $stubController, "dummyMethod3");
  }

  /**
   * @expectedException \iblamefish\baconiser\Exception\RouterException
   */
   public function testShouldThrowForDuplicatePath() {
     $router = new Router();

     $router->add("GET", $this->route);

     $router->add("GET", $this->route);
   }

   public function testShouldNormaliseRequestMethod() {
     $router = new Router();

     $router->add("get", $this->route);

     $this->assertEquals($router->get("GET", $this->registeredPath)["route"], $this->route);
   }

   public function testShouldAllowDuplicatePathWithDifferentMethod() {
     $router = new Router();

     $getRoute = $this->route;

     $postRoute = $this->anotherRoute;

     $router->add("GET", $getRoute);

     $router->add("POST", $postRoute);

     $this->assertEquals($router->get("GET", $this->registeredPath)["route"], $getRoute);

     $this->assertEquals($router->get("POST", $this->registeredPath)["route"], $postRoute);
   }

   /**
    * @expectedException \iblamefish\baconiser\Exception\RouterException
    */
   public function testShouldThrowForInvalidRequestMethod() {
     $router = new Router();

     $router->add("SPURIOUS", $this->route);
   }

   public function shouldForceAddDuplicatePath() {
     $router = new Router();

     $router->add("GET", $this->route);

     $router->add("GET", $this->anotherRoute, true);

     $this->assertEquals($router->get("GET", $this->registeredPath), $this->anotherRoute);
   }

   /**
    * @expectedException \iblamefish\baconiser\Exception\RouterException
    */
   public function testShouldThrowIfGettingUnsupportedHttpMethod() {
     $router = new Router();

     $router->get("SPURIOUS", $this->unregisteredPath);
   }

   /**
    * @expectedException \iblamefish\baconiser\Exception\RouterException
    */
   public function testShouldThrowIfGettingUnregisteredRoute() {
     $router = new Router();

     $router->get("GET", $this->unregisteredPath);
   }

   /**
    * @expectedException \iblamefish\baconiser\Exception\RouterException
    */
   public function testShouldThrowIfGettingUnregisteredRequestMethod() {
     $router = new Router();

     $router->add("POST", $this->route);

     $router->get("GET", $this->registeredPath);
   }

   public function testShouldReturnRoute() {
     $router = new Router();

     $router->add("GET", $this->route);

     $returnedRoute = $router->get("GET", $this->registeredPath);

     $this->assertEquals($this->route, $returnedRoute["route"]);
   }

   public function testShouldParseUri() {
     $router = new Router();

     $router->add("GET", $this->complexRoute);

     $this->assertEquals($router->get("GET", $this->parameterisedUri)["route"], $this->complexRoute);

     $this->assertEquals($router->get("GET", $this->parameterisedUri)["params"], $this->parsedParameters);
   }
}
