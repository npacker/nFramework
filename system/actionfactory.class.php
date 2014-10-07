<?php

class ActionFactory {

  private static $instance = null;

  final private function __construct() {}

  public static function instance() {
    if (is_null(self::$instance)) self::$instance = new self();

    return self::$instance;
  }

  public function get($action) {
    $class = null;

    if (!empty($action)) {
      $class = $action . 'Action';
    }

    if (!class_exists($class, true)) {
      throw new ActionNotFoundException("Action {$class} is undefined.");
    }

    return new $class();
  }
}