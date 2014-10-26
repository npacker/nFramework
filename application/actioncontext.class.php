<?php

namespace nFramework\Application;

class ActionContext {

  protected $params = array();

  public function __construct(array $params = array()) {
    $this->params = $params;
  }

  function set($key, $value, $overwrite = true) {
    if ($overwrite || (!$overwrite && !array_key_exists($key, $this->params))) {
      $this->params[$key] = $value;
    }
  }

  function get($key) {
    return array_key_exists($key, $this->params) ? $this->params[$key] : null;
  }

}