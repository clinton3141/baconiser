<?php

namespace iblamefish\baconiser\Tests\Log;

use iblamefish\baconiser\Logger\Log;

class LogTest extends \PHPUnit_Framework_TestCase {
  public function testLoggerRegisration() {
    $stub = $this->getMockBuilder('\iblamefish\baconiser\Logger\Logger')
                 ->getMock();

    Log::register($stub, array('warn'));

    $this->assertEquals(Log::getLoggers('warn'), array($stub));
  }
}
