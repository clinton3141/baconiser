<?php

namespace iblamefish\baconiser;

class TI_Test {
	private $value;

	public function __construct() {
		$this->value = false;
	}


	public function getValue() {
		return $this->value;	
	}


	public function setValue($value) {
		$this->value = !!$value;
	}
}
