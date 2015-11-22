<?php

namespace iblamefish\baconiser\Logger;

class Logger {
	private static $logger;

	public static function init(iLogger $logger) {
		if (self::$logger == null) {
			self::$logger = $logger;
		}
	}

	public static function debug($message) {
		self::$logger->debug($message, 'message');
	}

	public static function error($message) {
		$logger = self::$logger;
		self::$logger->error($message);
	}

	public static function info($message) {
		self::$logger->info($message, 'info');
	}

	public static function warn($message) {
		self::$logger->warn($message, 'warn');
	}

	public static function log($message) {
		self::$logger->info($message);
	}
}
