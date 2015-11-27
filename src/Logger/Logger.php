<?php

namespace iblamefish\baconiser\Logger;

class Logger {
	private static $loggers;

	public static function init(iLogger $logger, $levels) {
		if (self::$loggers == null) {
			self::$loggers = array(
				'debug' => array(),
				'error' => array(),
				'info' => array(),
				'warn' => array()
			);
		}

		if (is_array($levels)) {
			foreach ($levels as $level) {
				if (array_key_exists($level, self::$loggers)) {
					self::$loggers[$level][] = $logger;
				}
			}
		}

				print_r(self::$loggers);
	}

	public static function debug($message) {
		foreach (self::$loggers['debug'] as $logger) {
			$logger->debug($message);
		}
	}

	public static function error($message) {
		foreach (self::$loggers['error'] as $logger) {
			$logger->error($message);
		}
	}

	public static function info($message) {
		foreach (self::$loggers['info'] as $logger) {
			$logger->info($message);
		}
	}

	public static function warn($message) {
		foreach (self::$loggers['warn'] as $logger) {
			$logger->warn($message);
		}
	}

	public static function log($message) {
		self::info($message);
	}
}
