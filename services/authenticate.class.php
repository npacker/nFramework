<?php

class Authenticate extends ActionDecorator {

  public function execute(ActionContext $context) {
    $session = new Session();
    $session->start();

    if ($session->valid()) {
      $session->revalidate();

      return $this->action->execute($context);
    }

    throw new AccessDeniedException('You must be logged in to do that.');
  }

}