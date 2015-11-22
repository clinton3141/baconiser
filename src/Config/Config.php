<?php

namespace iblamefish\baconiser\Config;

abstract class Config {
	public abstract function get($key);
}
