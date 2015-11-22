<?php

namespace Tests;
use iblamefish\baconiser\TI_Test;

class Test extends \PHPUnit_Framework_TestCase {
	public function testShouldFail() {
		$test = new TI_Test();
		$this->assertEquals($test->getValue(), true);
	}

	public function testShouldPass() {
		$test = new TI_Test();
		$this->assertEquals($test->getValue(), false);
	}
}
