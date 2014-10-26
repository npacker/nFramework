<?php

namespace nFramework\Application;

abstract class ActionDecorator extends Action {

  protected $action;

  public function __construct(Action $action) {
    $this->action = $action;
  }

}