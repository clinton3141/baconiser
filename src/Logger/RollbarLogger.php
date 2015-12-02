<?php

namespace iblamefish\baconiser\Logger;

use Rollbar;
use iblamefish\baconiser\Config\Config;

class RollbarLogger implements iLogger {
  private static $instance;

  private function __construct(Config $config) {
    $accessToken = $config->get('logging.rollbar.access_token');
    $logExceptions = $config->get('logging.rollbar.set_exception_handler');
    $logErrors = $config->get('logging.rollbar.set_error_handler');
    $logFatal = $config->get('logging.rollbar.report_fatal_errors');

    Rollbar::init(
      array( 'access_token' => $accessToken ),
      $logExceptions,
      $logErrors,
      $logFatal
    );
  }

  public static function getInstance(Config $config) {
    if (!self::$instance) {
      self::$instance = new RollbarLogger($config);
    }

    return self::$instance;
  }

  public function error($message) {
    Rollbar::report_message($message, 'critical');
  }

  public function info($message) {
    Rollbar::report_message($message, 'info');
  }

  public function debug($message) {
    Rollbar::report_message($message, 'debug');
  }

  public function warn($message) {
    Rollbar::report_message($message, 'warn');
  }
}
