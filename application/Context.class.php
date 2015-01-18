<?php

namespace nFramework;

class Context {

  private $params = array();

  public function __construct() {
    $args = func_get_args();

    foreach ($args as $arg) {
      $this->params = array_merge($this->params, $arg);
    }
  }

  public function set($key, $value, $overwrite = false) {
    if ($overwrite || (!$overwrite && !array_key_exists($key, $this->params))) {
      $this->params[$key] = $value;
    }

    return $this;
  }

  public function get($key) {
    return array_key_exists($key, $this->params) ? $this->params[$key] : null;
  }

}
