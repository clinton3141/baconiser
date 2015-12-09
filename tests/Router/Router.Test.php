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

     $router->add($this->registeredPath, $this->route);

     $router->add($this->registeredPath, $this->route);
   }

   public function shouldForceAddDuplicatePath() {
     $router = new Router();

     $anotherRoute = new Route();

     $router->add($this->registeredPath, $this->route);

     $router->add($this->registeredPath, $anotherRoute, true);

     $this->assertEquals($router->get($this->registeredPath), $anotherRoute);
   }

   /**
    * @expectedException \iblamefish\baconiser\Exception\RouterException
    */
   public function testShouldThrowIfGettingUnregisteredRoute() {
     $router = new Router();

     $router->get($this->unregisteredPath);
   }

   public function testShouldReturnRoute() {
     $router = new Router();

     $router->add($this->registeredPath, $this->route);

     $returnedRoute = $router->get($this->registeredPath);

     $this->assertEquals($this->route, $returnedRoute);
   }

   public function testShouldNotThrowIfRemovingUnregisteredRoute() {
     $router = new Router();

     $router->remove($this->unregisteredPath);
   }

   /**
    * not asserting an expected exception here in case failures happen
    * elsewhere in the router. Instead set success flag to true in
    * the catch block to ensure exception is thrown in expected location
    */
   public function testShouldRemoveRoute() {
     $router = new Router();

     $router->add($this->registeredPath, $this->route);

     $router->remove($this->registeredPath);

     $success = false;

     try {
       $router->get($this->registeredPath);
     } catch (\iblamefish\baconiser\Exception\RouterException $e) {
       $success = true;
     }

     $this->assertEquals($success, true);
   }
}
