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
  }

  public static function debug($message) {
    self::send($message, 'debug');
  }

  public static function error($message) {
    self::send($message, 'error');
  }

  public static function info($message) {
    self::send($message, 'info');
  }

  public static function warn($message) {
    self::send($message, 'warn');
  }

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
