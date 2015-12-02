<?php

namespace iblamefish\baconiser\Logger;

class Log {
  private static $loggers;

  /**
   * Register a Logger instance with associated log levels.
   *
   * A logging method exists for each of the following levels:
   *   - debug
   *   - error
   *   - info
   *   - warn
   */
  public static function register(Logger $logger, $levels) {
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
  }

  /**
   * send $message to all loggers registered with debug level
   */
  public static function debug($message) {
    self::send($message, 'debug');
  }

  /**
   * send $message to all loggers registered with error level
   */
  public static function error($message) {
    self::send($message, 'error');
  }

  /**
   * send $message to all loggers registered with info level
   */
  public static function info($message) {
    self::send($message, 'info');
  }

  /**
   * send $message to all loggers registered with warn level
   */
  public static function warn($message) {
    self::send($message, 'warn');
  }

  /**
   * alias of Logger::info
   */
  public static function log($message) {
    self::info($message);
  }

  private static function send($message, $level) {
    $loggers = self::$loggers[$level];

    foreach ($loggers as $logger) {
      if(method_exists($logger, $level)) {
        $logger->$level($message);
      }
    }
  }
}
