<?php

namespace iblamefish\baconiser\Tests\Router;

use iblamefish\baconiser\Router\Router;

use iblamefish\baconiser\Router\Route;

class RouterTest extends \PHPUnit_Framework_TestCase {
  private $registeredPath = "/registered/path/";

  private $unregisteredPath = "/unregistered/path/";

  private $route;

  public function setUp() {
    $this->route = new Route();
  }

  /**
   * @expectedException \iblamefish\baconiser\Exception\RouterException
   */
   public function testShouldThrowForDuplicatePath() {
     $router = new Router();

     $router->add("GET", $this->registeredPath, $this->route);

     $router->add("GET", $this->registeredPath, $this->route);
   }

   public function testShouldAllowDuplicatePathWithDifferentMethod() {
     $router = new Router();

     $getRoute = new Route();

     $postRoute = new Route();

     $router->add("GET", $this->registeredPath, $getRoute);

     $router->add("POST", $this->registeredPath, $postRoute);

     $this->assertEquals($router->get("GET", $this->registeredPath), $getRoute);

     $this->assertEquals($router->get("POST", $this->registeredPath), $postRoute);
   }

   /**
    * @expectedException \iblamefish\baconiser\Exception\RouterException
    */
   public function testShouldThrowForInvalidRequestMethod() {
     $router = new Router();

     $router->add("SPURIOUS", $this->registeredPath, $this->route);
   }

   public function shouldForceAddDuplicatePath() {
     $router = new Router();

     $anotherRoute = new Route();

     $router->add("GET", $this->registeredPath, $this->route);

     $router->add("GET", $this->registeredPath, $anotherRoute, true);

     $this->assertEquals($router->get("GET", $this->registeredPath), $anotherRoute);
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

     $router->add("POST", $this->registeredPath, new Route());

     $router->get("GET", $this->registeredPath);
   }

   public function testShouldReturnRoute() {
     $router = new Router();

     $router->add("GET", $this->registeredPath, $this->route);

     $returnedRoute = $router->get("GET", $this->registeredPath);

     $this->assertEquals($this->route, $returnedRoute);
   }

   public function testShouldNotThrowIfRemovingUnregisteredRoute() {
     $router = new Router();

     $router->remove("GET", $this->unregisteredPath);
   }

   /**
    * not asserting an expected exception here in case failures happen
    * elsewhere in the router. Instead set success flag to true in
    * the catch block to ensure exception is thrown in expected location
    */
   public function testShouldRemoveRoute() {
     $router = new Router();

     $router->add("GET", $this->registeredPath, $this->route);

     $router->remove("GET", $this->registeredPath);

     $success = false;

     try {
       $router->get("GET", $this->registeredPath);
     } catch (\iblamefish\baconiser\Exception\RouterException $e) {
       $success = true;
     }

     $this->assertEquals($success, true);
   }
}
