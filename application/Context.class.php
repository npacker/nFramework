<?php

namespace nFramework;

class Context {

  protected $params = array();

  public function __construct(array $params = array()) {
    $this->params = $params;
  }

  function set($key, $value, $overwrite = false) {
    if ($overwrite || (!$overwrite && !array_key_exists($key, $this->params))) {
      $this->params[$key] = $value;
    }
  }

  function get($key) {
    return array_key_exists($key, $this->params) ? $this->params[$key] : null;
  }

}