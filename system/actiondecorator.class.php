<?php

abstract class ActionDecorator extends Action implements iAction {

  protected $action;

  public function __construct(Action $action) {
    $this->action = $action;
  }

  abstract public function execute(ActionContext $context);

}