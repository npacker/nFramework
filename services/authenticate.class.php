<?php

class Authenticate extends ActionDecorator {

  public function execute(ActionContext $context) {
    if ($this->isLoggedIn($context)) {
      return $this->action->execute($context);
    }

    throw new AccessDeniedException('You must be logged in to do that.');
  }

  protected function isLoggedIn(ActionContext $context) {
    $status = $context->get('session');

    return !empty($status);
  }

}