<?php

namespace iblamefish\baconiser\Tests\Log;

use iblamefish\baconiser\Logger\Log;

class LogTest extends \PHPUnit_Framework_TestCase {
  private $logger;

  private $logger2;

  protected function setUp() {
    $this->logger = $this->getMockBuilder("\iblamefish\baconiser\Logger\Logger")
                         ->getMock();

    $this->logger2 = $this->getMockBuilder("\iblamefish\baconiser\Logger\Logger")
                         ->getMock();
  }

  protected function tearDown() {
    Log::unregisterAll();
  }

  public function testLoggerRegisration() {
    Log::register($this->logger, array("warn", "error"));

    $this->assertEquals(Log::getLoggers("warn"), array($this->logger));

    $this->assertEquals(Log::getLoggers("error"), array($this->logger));
  }

  public function testShouldReturnEmptyLoggerList() {
    $loggers = Log::getLoggers("unknownLevel");

    $this->assertEquals($loggers, array());
  }

  public function testShouldReturnRegisteredAllLoggers() {
    Log::register($this->logger, array("warn"));

    Log::register($this->logger2, array("info"));

    $expected = array(
      "debug" => array(),
      "error" => array(),
      "info" => array($this->logger2),
      "warn" => array($this->logger)
    );

    $actual = Log::getLoggers();

    foreach ($expected as $level => $loggers) {
      $this->assertEquals($actual[$level], $loggers);
    }
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testShouldThrowInvalidArgumentException() {
    $invalidLogType = 42;

    Log::register($this->logger, array($invalidLogType));
  }

  public function testShouldUnregisterAllLoggers() {
    Log::register($this->logger, array("warn"));

    Log::unregisterAll();

    $this->assertEquals(Log::getLoggers(), array());
  }

  public function testShouldUnregisterSpecifiedLogger() {
    Log::register($this->logger, array("warn", "info"));

    Log::unregister($this->logger, array("warn"));

    $actual = Log::getLoggers();

    $expected = array(
      "warn" => array(),
      "info" => array($this->logger),
      "debug" => array(),
      "error" => array()
    );

    foreach ($expected as $level => $loggers) {
      $this->assertEquals($actual[$level], $loggers);
    }
  }
}
