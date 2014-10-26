<?php

use nFramework\Application\ActionDecorator;
use nFramework\Application\ActionContext;
use nFramework\Application\Exception\AccessDeniedException;

class Authenticate extends ActionDecorator {

  public function execute(ActionContext $context) {
    $session = new Session();
    $session->start();

    if (!$session->valid()) {
      throw new AccessDeniedException('You must be logged in to do that.');
    }

    $session->revalidate();

    return $this->action->execute($context);
  }

}
