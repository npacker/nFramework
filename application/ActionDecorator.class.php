<?php

namespace nFramework;

abstract class ActionDecorator extends Action {

  protected $action;

  final public function __construct(Action $action) {
    $this->action = $action;
  }

}
