<?php

namespace iblamefish\baconiser\Logger;

class Log {
  private static $loggers = array();

  /**
   * Register a Logger instance with associated log levels.
   *
   * A logging method exists for each of the following levels:
   *   - debug
   *   - error
   *   - info
   *   - warn
   */
  public static function register(Logger $logger, array $levels) {
    if (self::$loggers == array()) {
      self::$loggers = array(
        "debug" => array(),
        "error" => array(),
        "info" => array(),
        "warn" => array()
      );
    }

    foreach ($levels as $level) {
      if (is_string($level)) {
        if (array_key_exists($level, self::$loggers)) {
          self::$loggers[$level][] = $logger;
        }
      } else {
        throw new \InvalidArgumentException("Log::register must be called with Logger and array<String> of levels");
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

  /**
   * Remove all loggers for all levels
   */
  public static function unregisterAll() {
    self::$loggers = array();
  }

  /**
   * Remove specified logger
   */
  public static function unregister(Logger $logger, array $levels = array()) {
    foreach (self::$loggers as $level => $loggers) {
      if (in_array($level, $levels) || count($levels) === 0) {
        for ($i = 0; $i < count($loggers); $i++) {
          if ($loggers[$i] === $logger) {
            array_splice(self::$loggers[$level], $i, 1);
          }
        }
      }
    }
  }

  /**
   * Get loggers registered for $level
   */
  public static function getLoggers($level = false) {
    if ($level === false) {
      return self::$loggers;
    }

    if (isset(self::$loggers[$level])) {
      return self::$loggers[$level];
    }
    return array();
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
