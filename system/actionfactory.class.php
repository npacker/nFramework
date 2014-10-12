<?php

class ActionFactory {

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